<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::allMap();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => ['required', 'string', 'max:30'],
            'ticker_text' => ['required', 'string', 'max:300'],
            'studio_address' => ['required', 'string', 'max:300'],
            'operating_hours' => ['required', 'string', 'max:120'],
            'drop_schedule' => ['required', 'string', 'max:120'],
            'bank_accounts' => ['required', 'string', 'max:1000'],
            'instagram_handle' => ['nullable', 'string', 'max:60'],
            'total_archived_stat' => ['nullable', 'string', 'max:30'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return back()->with('success', 'Pengaturan toko, nomor WhatsApp, dan rekening bank berhasil diperbarui.');
    }
}

