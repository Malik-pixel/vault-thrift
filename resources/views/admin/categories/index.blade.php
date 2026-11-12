@extends('layouts.admin')

@section('title', 'Kelola Kategori — VAULT Admin')

@section('content')
<div class="p-space-md md:p-space-lg flex flex-col gap-space-lg">
    <div class="border-b border-outline-variant pb-space-sm">
        <span class="font-label-sm text-label-sm uppercase text-secondary font-bold">TAXONOMY MANAGEMENT</span>
        <h1 class="font-headline-lg text-headline-lg uppercase text-primary mt-1">KELOLA KATEGORI ARSIP</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Tambah, ubah, atau atur urutan kategori etalase publik.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
        <!-- Categories List -->
        <div class="lg:col-span-8 bg-surface-container-lowest border border-outline-variant overflow-hidden">
            <div class="px-space-md py-3 bg-surface-container-low border-b border-outline-variant font-label-md text-label-md uppercase font-bold text-primary">
                Daftar Kategori ({{ $categories->count() }})
            </div>
            <div class="divide-y divide-outline-variant/60">
                @foreach($categories as $cat)
                    <div class="p-space-md flex flex-col gap-3">
                        <form action="{{ route('admin.categories.update', $cat) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-2 items-center">
                            @csrf
                            @method('PUT')
                            <div class="md:col-span-3">
                                <label class="text-[10px] uppercase text-outline block">Nama</label>
                                <input name="name" value="{{ $cat->name }}" required class="w-full bg-surface border border-outline-variant px-2.5 py-1.5 text-body-sm font-bold focus:border-primary focus:outline-none"/>
                            </div>
                            <div class="md:col-span-3">
                                <label class="text-[10px] uppercase text-outline block">Slug URL</label>
                                <input name="slug" value="{{ $cat->slug }}" required class="w-full bg-surface border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                            </div>
                            <div class="md:col-span-4">
                                <label class="text-[10px] uppercase text-outline block">Deskripsi</label>
                                <input name="description" value="{{ $cat->description }}" class="w-full bg-surface border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-[10px] uppercase text-outline block">Urutan</label>
                                <input name="sort_order" type="number" value="{{ $cat->sort_order }}" class="w-full bg-surface border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                            </div>
                            <div class="md:col-span-12 flex items-center justify-between pt-1">
                                <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">
                                    Produk: <strong class="text-primary">{{ $cat->products_count }} total</strong> ({{ $cat->available_count }} tersedia)
                                </span>
                                <div class="flex items-center gap-2">
                                    <button type="submit" class="px-3 py-1 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-sm text-label-sm uppercase font-bold transition-colors">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if($cat->products_count === 0)
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')" class="self-end">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 border border-error text-error hover:bg-error hover:text-on-error font-label-sm text-label-sm uppercase font-bold transition-colors">
                                    Hapus Kategori
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add Category Card -->
        <div class="lg:col-span-4 bg-surface-container-lowest border border-primary p-space-md hard-shadow">
            <h2 class="font-headline-md text-headline-md uppercase font-bold text-primary mb-space-sm">+ Tambah Kategori Baru</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Nama Kategori <span class="text-error">*</span></label>
                    <input name="name" required placeholder="Contoh: Aksesoris" class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Slug (Opsional)</label>
                    <input name="slug" placeholder="otomatis-dari-nama" class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" class="w-full bg-surface border border-outline-variant p-2.5 text-body-sm focus:border-primary focus:outline-none resize-none" placeholder="Caps, Beanies, Archive Bags..."></textarea>
                </div>
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Urutan Tampil</label>
                    <input name="sort_order" type="number" value="{{ $categories->count() + 1 }}" class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <button type="submit" class="w-full py-2.5 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-md text-label-md uppercase font-bold transition-colors">
                    Tambah Kategori
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

