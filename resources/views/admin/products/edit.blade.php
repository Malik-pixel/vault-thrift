@extends('layouts.admin')

@section('title', 'Edit ' . $product->sku . ' — VAULT Admin')

@section('content')
<div class="p-space-md md:p-space-lg flex flex-col gap-space-lg">
    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-outline-variant pb-space-sm">
        <div>
            <span class="font-label-sm text-label-sm uppercase text-secondary font-bold">EDIT ARCHIVE // {{ $product->sku }}</span>
            <h1 class="font-headline-lg text-headline-lg uppercase text-primary mt-1">{{ $product->name }}</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="px-4 py-2 border border-outline-variant bg-surface-container-lowest font-label-md text-label-md uppercase hover:border-primary inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                Pratinjau Publik
            </a>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-primary font-label-md text-label-md uppercase hover:bg-surface-container inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-primary p-space-md md:p-space-lg">
        @include('admin.products._form', ['categories' => $categories, 'product' => $product])
    </div>
</div>
@endsection

