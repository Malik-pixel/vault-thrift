@extends('layouts.admin')

@section('title', 'Pengaturan Toko & Bank — VAULT Admin')

@section('content')
<div class="p-space-md md:p-space-lg flex flex-col gap-space-lg max-w-4xl">
    <div class="border-b border-outline-variant pb-space-sm">
        <span class="font-label-sm text-label-sm uppercase text-secondary font-bold">SYSTEM CONFIGURATION</span>
        <h1 class="font-headline-lg text-headline-lg uppercase text-primary mt-1">PENGATURAN TOKO, WHATSAPP &amp; REKENING</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Perubahan langsung diterapkan ke ticker promo, tombol WhatsApp, dan footer situs publik.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-surface-container-lowest border border-primary p-space-md md:p-space-lg flex flex-col gap-space-md">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
            <div>
                <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Nomor WhatsApp Admin (Format 628...) <span class="text-error">*</span></label>
                <input name="whatsapp_number" required value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '6281234567890') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none"/>
            </div>
            <div>
                <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Handle Instagram</label>
                <input name="instagram_handle" value="{{ old('instagram_handle', $settings['instagram_handle'] ?? '@vault.thrift') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none"/>
            </div>
        </div>

        <div>
            <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Teks Ticker Promo Atas <span class="text-error">*</span></label>
            <input name="ticker_text" required value="{{ old('ticker_text', $settings['ticker_text'] ?? '') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none"/>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
            <div>
                <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Jadwal Drop <span class="text-error">*</span></label>
                <input name="drop_schedule" required value="{{ old('drop_schedule', $settings['drop_schedule'] ?? '') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none"/>
            </div>
            <div>
                <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Jam Operasional <span class="text-error">*</span></label>
                <input name="operating_hours" required value="{{ old('operating_hours', $settings['operating_hours'] ?? '') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none"/>
            </div>
            <div>
                <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Statistik Total Arsip</label>
                <input name="total_archived_stat" value="{{ old('total_archived_stat', $settings['total_archived_stat'] ?? '1,200+') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none"/>
            </div>
        </div>

        <div>
            <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Alamat Studio Fisik <span class="text-error">*</span></label>
            <input name="studio_address" required value="{{ old('studio_address', $settings['studio_address'] ?? '') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none"/>
        </div>

        <div>
            <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Daftar Rekening Bank &amp; QRIS <span class="text-error">*</span></label>
            <textarea name="bank_accounts" required rows="4" class="w-full bg-surface border border-outline-variant focus:border-primary p-3 text-body-sm focus:outline-none">{{ old('bank_accounts', $settings['bank_accounts'] ?? '') }}</textarea>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-md text-label-md uppercase font-bold transition-colors">
                Simpan Pengaturan Toko
            </button>
        </div>
    </form>
</div>
@endsection

