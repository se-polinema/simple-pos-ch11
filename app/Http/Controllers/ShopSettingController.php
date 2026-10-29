<?php

namespace App\Http\Controllers;

use App\Models\ShopSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ShopSettingController extends Controller
{
    /**
     * Singleton resource — only edit()/update(), no index/create/delete, since
     * there's exactly one settings row (seeded by its migration).
     */
    public function edit(): View
    {
        return view('settings.edit', ['setting' => ShopSetting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'tax_percent' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $setting = ShopSetting::current();

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('branding', 'public');
        } else {
            unset($data['logo']);
        }

        if ($setting->exists) {
            $setting->update($data);
        } else {
            ShopSetting::create($data);
        }

        return back()->with('status', 'Pengaturan toko diperbarui.');
    }
}
