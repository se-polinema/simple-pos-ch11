@php $u = $user ?? null; @endphp
<div>
    <label class="block text-sm font-medium mb-1">Nama</label>
    <input type="text" name="name" value="{{ old('name', $u?->name) }}" required
           class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
</div>
<div>
    <label class="block text-sm font-medium mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email', $u?->email) }}" required
           class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
</div>
<div>
    <label class="block text-sm font-medium mb-1">{{ $u ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi' }}</label>
    <input type="password" name="password" {{ $u ? '' : 'required' }}
           placeholder="{{ $u ? 'Kosongkan jika tidak diubah' : '' }}"
           class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
</div>
<div>
    <label class="block text-sm font-medium mb-1">Peran</label>
    <select name="role" class="w-full border border-ink/15 rounded-md px-3 py-2 text-sm bg-surface-raised focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
        <option value="kasir" @selected(old('role', $u?->role) === 'kasir')>Kasir</option>
        <option value="admin" @selected(old('role', $u?->role) === 'admin')>Admin</option>
    </select>
</div>
