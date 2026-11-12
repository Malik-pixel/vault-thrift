@extends('layouts.admin')

@section('title', 'Tambah Produk Baru — VAULT Admin')

@section('content')
<div class="p-space-md md:p-space-lg flex flex-col gap-space-lg">
    <div class="flex items-center justify-between border-b border-outline-variant pb-space-sm">
        <div>
            <span class="font-label-sm text-label-sm uppercase text-secondary font-bold">FAST INGESTION // NEW ARCHIVE</span>
            <h1 class="font-headline-lg text-headline-lg uppercase text-primary mt-1">TAMBAH PRODUK BARU</h1>
        </div>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-primary font-label-md text-label-md uppercase hover:bg-surface-container inline-flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-surface-container-lowest border border-primary p-space-md md:p-space-lg">
        @include('admin.products._form', ['categories' => $categories, 'product' => null])
    </div>
</div>
@endsection

