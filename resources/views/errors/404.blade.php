@extends('layouts.app')

@section('title', '404 Arsip Tidak Ditemukan — VAULT Curated Thrift')

@section('content')
<section class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop py-space-xl">
    <div class="bg-surface-container-lowest border border-primary hard-shadow p-space-xl max-w-2xl mx-auto text-center flex flex-col items-center gap-space-md">
        <span class="bg-tertiary text-on-primary font-label-sm text-label-sm uppercase tracking-widest px-3 py-1 font-bold">
            ERROR 404 // ARCHIVE NOT FOUND
        </span>
        <h1 class="font-display-lg text-display-lg uppercase text-primary leading-none">404</h1>
        <p class="font-headline-md text-headline-md uppercase text-primary font-bold">
            Artikel Arsip Tidak Ditemukan atau Telah Dihapus
        </p>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Karena setiap koleksi VAULT bersifat 1-of-1, tautan yang Anda cari mungkin sudah dipindahkan atau tidak tersedia dalam indeks arsip.
        </p>
        <div class="flex flex-wrap justify-center gap-3 pt-2">
            <a href="{{ route('catalog') }}" class="bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary px-6 py-3 font-label-md text-label-md uppercase tracking-wider font-bold transition-colors">
                Jelajahi Katalog Lengkap
            </a>
            <a href="{{ route('home') }}" class="border border-primary text-primary hover:bg-surface-container px-6 py-3 font-label-md text-label-md uppercase tracking-wider font-bold transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection

