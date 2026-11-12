@extends('layouts.app')

@section('title', 'Item Tersimpan — VAULT Curated Thrift')

@section('content')
<div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop py-space-xl">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-space-md pb-space-md border-b border-outline-variant mb-space-lg">
        <div>
            <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary font-bold">[ BOOKMARK ARCHIVE ]</span>
            <h1 class="font-headline-lg text-headline-lg uppercase text-primary mt-1">ITEM TERSIMPAN (WISHLIST)</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Disimpan di peramban lokal Anda. Stok tetap bersifat 1-of-1 siapa cepat dia dapat.</p>
        </div>
        <button type="button" onclick="clearSaved()" class="self-start sm:self-auto border border-primary px-4 py-2 font-label-sm text-label-sm uppercase hover:bg-error hover:text-on-error hover:border-error transition-colors">
            Bersihkan Daftar
        </button>
    </div>

    <div id="saved-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-space-sm md:gap-space-md"></div>

    <div id="saved-empty" class="hidden bg-surface-container-low border border-outline-variant p-space-xl text-center flex-col items-center gap-space-sm">
        <span class="material-symbols-outlined text-[48px] text-outline">bookmark_border</span>
        <h2 class="font-headline-md text-headline-md uppercase text-primary font-bold">Belum Ada Item Tersimpan</h2>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-md">Klik ikon bookmark pada kartu produk di katalog untuk menyimpan artikel arsip incaran Anda.</p>
        <a href="{{ route('catalog') }}" class="mt-2 bg-primary text-on-primary px-6 py-2.5 font-label-md text-label-md uppercase tracking-wider hover:bg-secondary-container hover:text-primary transition-colors">
            Jelajahi Katalog
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function renderSavedItems() {
        const ids = getSavedIds();
        const grid = document.getElementById('saved-grid');
        const empty = document.getElementById('saved-empty');

        if (!ids.length) {
            grid.innerHTML = '';
            empty.classList.remove('hidden');
            empty.classList.add('flex');
            return;
        }

        const res = await fetch('{{ route("saved.lookup") }}?ids=' + ids.join(','));
        const data = await res.json();
        const products = data.products || [];

        if (!products.length) {
            grid.innerHTML = '';
            empty.classList.remove('hidden');
            empty.classList.add('flex');
            return;
        }

        empty.classList.add('hidden');
        empty.classList.remove('flex');

        grid.innerHTML = products.map(p => {
            const isSold = p.status === 'sold';
            return `
                <article class="flex flex-col bg-surface-container-lowest border border-outline-variant hover:border-primary transition-colors ${isSold ? 'opacity-80' : ''}">
                    <div class="relative aspect-[3/4] bg-surface-container border-b border-outline-variant overflow-hidden">
                        <a href="${p.url}" class="block w-full h-full">
                            <img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover ${isSold ? 'grayscale' : ''}"/>
                        </a>
                        <span class="absolute top-2 left-2 bg-primary text-on-primary font-label-sm text-label-sm px-1.5 py-0.5 uppercase">${p.category}</span>
                        <span class="absolute top-2 right-2 ${isSold ? 'bg-tertiary text-on-primary' : 'bg-secondary-container text-primary border border-primary'} font-label-sm text-label-sm px-2 py-0.5 uppercase font-bold">
                            ${isSold ? 'HABIS' : 'TERSEDIA'}
                        </span>
                        <button type="button" onclick="toggleSaveProduct(${p.id}, this); renderSavedItems();" class="absolute bottom-2 right-2 w-8 h-8 bg-secondary-container border border-primary text-primary flex items-center justify-center" title="Hapus dari Tersimpan">
                            <span class="material-symbols-outlined text-[18px]">bookmark</span>
                        </button>
                    </div>
                    <div class="p-space-sm flex flex-col flex-1 justify-between gap-2">
                        <div>
                            <span class="font-label-sm text-label-sm text-outline uppercase">${p.sku} • GRADE ${p.condition_grade}/10</span>
                            <a href="${p.url}" class="block mt-1 font-headline-md text-[15px] font-bold uppercase text-primary line-clamp-2 ${isSold ? 'line-through text-outline' : ''}">${p.name}</a>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">SIZE ${p.size_label}</span>
                        </div>
                        <div class="pt-2 border-t border-outline-variant/60 flex items-center justify-between gap-2">
                            <span class="font-headline-md text-headline-md font-bold tabular-nums ${isSold ? 'line-through text-outline' : 'text-primary'}">${p.formatted_price}</span>
                            <a href="${p.url}" class="bg-primary text-on-primary px-3 py-1.5 font-label-sm text-label-sm uppercase hover:bg-secondary-container hover:text-primary transition-colors">Detail</a>
                        </div>
                    </div>
                </article>
            `;
        }).join('');
    }

    function clearSaved() {
        setSavedIds([]);
        renderSavedItems();
    }

    document.addEventListener('DOMContentLoaded', renderSavedItems);
</script>
@endpush

