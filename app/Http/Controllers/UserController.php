<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $sort = in_array($request->string('sort')->value(), ['name', 'email', 'role'], true)
            ? $request->string('sort')->value()
            : 'name';
        $direction = $request->string('direction')->value() === 'desc' ? 'desc' : 'asc';

        $users = User::orderBy($sort, $direction)->paginate(10)->withQueryString();

        return view('users.index', compact('users', 'sort', 'direction'));
    }

    /**
     * Bulk activate/deactivate — same last-active-admin guard as the single toggle,
     * applied to the whole batch: reject entirely rather than partially apply it.
     */
    public function bulkStatus(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:users,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $ids = $validated['ids'];
        $isActive = $validated['is_active'];

        if (! $isActive && in_array(Auth::id(), $ids, true)) {
            return back()->with('error', 'Anda tidak bisa menonaktifkan akun sendiri lewat aksi massal.');
        }

        if (! $isActive) {
            $remainingActiveAdmins = User::where('role', 'admin')
                ->where('is_active', true)
                ->whereNotIn('id', $ids)
                ->count();

            if ($remainingActiveAdmins === 0) {
                return back()->with('error', 'Aksi massal ini akan menonaktifkan seluruh admin aktif — dibatalkan.');
            }
        }

        $users = User::whereIn('id', $ids)->get();
        $users->each(fn (User $u) => $u->update(['is_active' => $isActive]));

        if (! $isActive) {
            $users->each(fn (User $u) => $u->tokens()->delete());
        }

        return back()->with('status', 'Status pengguna terpilih berhasil diperbarui.');
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('status', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(StoreUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($user->role === 'admin' && $data['role'] !== 'admin' && $this->isLastActiveAdmin($user)) {
            return back()->withErrors([
                'role' => 'Tidak bisa mengubah peran admin terakhir yang aktif.',
            ])->withInput();
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Pengguna tidak pernah dihapus (riwayat transaksi merujuk padanya via FK
     * cascade) — hanya dinonaktifkan/diaktifkan kembali, dengan pengaman agar
     * admin tidak mengunci akses dirinya sendiri atau seluruh tim admin.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menonaktifkan akun sendiri.');
        }

        if ($user->is_active && $this->isLastActiveAdmin($user)) {
            return back()->with('error', 'Tidak bisa menonaktifkan admin terakhir yang aktif.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        if (! $user->is_active) {
            $user->tokens()->delete();
        }

        return back()->with('status', $user->is_active
            ? 'Pengguna diaktifkan kembali.'
            : 'Pengguna dinonaktifkan.');
    }

    private function isLastActiveAdmin(User $user): bool
    {
        return $user->role === 'admin'
            && User::active()->where('role', 'admin')->count() <= 1;
    }
}
