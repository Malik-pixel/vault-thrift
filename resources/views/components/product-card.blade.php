@props(['product'])

@php
    $isSold = $product->isSold();
@endphp

<article class="group flex flex-col bg-surface-container-lowest border border-outline-variant hover:border-primary transition-colors {{ $isSold ? 'opacity-85' : '' }}">
    <div class="relative w-full aspect-[3/4] overflow-hidden bg-surface-container border-b border-outline-variant">
        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
            <img
                src="{{ $product->primary_image_url }}"
                alt="{{ $product->name }}"
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-300 {{ $isSold ? 'grayscale contrast-125' : 'group-hover:scale-105' }}"
            />
        </a>

        <!-- Top-Left Badges (Grade & Category/Tag) -->
        <div class="absolute top-2 left-2 flex flex-col gap-1 items-start z-10 pointer-events-none">
            <span class="bg-primary text-on-primary font-label-sm text-label-sm px-1.5 py-0.5 uppercase tracking-wider">
                {{ $product->category?->name ?? 'ARSIP' }}
            </span>
            <span class="bg-surface-container-lowest border border-primary text-primary font-label-sm text-label-sm px-1.5 py-0.5 uppercase tracking-wider font-bold">
                GRADE {{ number_format($product->condition_grade, 1) }}/10
            </span>
        </div>

        <!-- Top-Right Availability Status Badge -->
        <div class="absolute top-2 right-2 z-10 pointer-events-none">
            @if($isSold)
                <span class="bg-tertiary text-on-primary font-label-sm text-label-sm px-2 py-0.5 uppercase tracking-widest font-bold">
                    HABIS TERJUAL
                </span>
            @else
                <span class="bg-secondary-container text-primary border border-primary font-label-sm text-label-sm px-2 py-0.5 uppercase tracking-widest font-bold">
                    TERSEDIA
                </span>
            @endif
        </div>

        <!-- Sold Out Overlay -->
        @if($isSold)
            <div class="absolute inset-0 bg-primary/35 flex items-center justify-center pointer-events-none">
                <span class="border-2 border-surface text-surface font-headline-md text-headline-md uppercase tracking-widest px-3 py-1 -rotate-12 bg-primary/85 font-bold">
                    [ SOLD OUT ]
                </span>
            </div>
        @endif

        <!-- Bookmark Button -->
        <button
            type="button"
            data-bookmark-id="{{ $product->id }}"
            onclick="toggleSaveProduct({{ $product->id }}, this)"
            class="absolute bottom-2 right-2 w-8 h-8 bg-surface-container-lowest border border-primary hover:bg-secondary-container text-primary flex items-center justify-center transition-colors z-10"
            title="Simpan ke Favorit"
        >
            <span class="material-symbols-outlined text-[18px]">bookmark_border</span>
        </button>
    </div>

    <!-- Card Metadata -->
    <div class="p-space-sm md:p-space-md flex flex-col flex-1 justify-between gap-space-sm">
        <div>
            <div class="flex items-center justify-between gap-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">
                <span class="truncate">{{ $product->brand ?: 'VAULT ARCHIVE' }}{{ $product->era ? ' • ' . $product->era : '' }}</span>
                <span class="text-primary font-bold shrink-0">{{ $product->sku }}</span>
            </div>
            <a href="{{ route('product.show', $product->slug) }}" class="block mt-1">
                <h3 class="font-headline-md text-[15px] md:text-[17px] leading-snug uppercase font-bold tracking-tight line-clamp-2 {{ $isSold ? 'text-outline line-through' : 'text-primary group-hover:underline' }}">
                    {{ $product->name }}
                </h3>
            </a>
            <div class="mt-1.5 flex flex-wrap items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant">
                <span class="bg-surface-container border border-outline-variant px-1.5 py-0.5 font-bold text-primary">SIZE {{ $product->size_label }}</span>
                @if($product->short_measurement_summary)
                    <span>•</span>
                    <span>{{ $product->short_measurement_summary }}</span>
                @endif
            </div>
        </div>

        <div class="pt-space-xs border-t border-outline-variant/60 flex flex-col gap-2">
            <div class="flex items-baseline justify-between gap-2">
                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                    {{ $isSold ? 'Terjual:' : 'Harga Pas:' }}
                </span>
                <span class="font-headline-md text-headline-md font-bold tabular-nums {{ $isSold ? 'text-outline line-through' : 'text-primary' }}">
                    {{ $product->formatted_price }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-1.5">
                <a href="{{ route('product.show', $product->slug) }}"
                   class="w-full text-center border border-primary bg-transparent hover:bg-surface-container text-primary font-label-sm text-label-sm uppercase tracking-wider py-2 font-bold transition-colors">
                    {{ $isSold ? 'Arsip Detail' : 'Detail' }}
                </a>

                @if($isSold)
                    <button type="button" disabled
                            class="w-full bg-surface-container text-outline border border-outline-variant font-label-sm text-label-sm uppercase tracking-wider py-2 cursor-not-allowed">
                        Habis
                    </button>
                @else
                    <button
                        type="button"
                        onclick="openOrderModal(this)"
                        data-product-id="{{ $product->id }}"
                        data-product-sku="{{ $product->sku }}"
                        data-product-name="{{ $product->name }}"
                        data-product-size="{{ $product->size_label }}"
                        data-product-price="{{ $product->formatted_price }}"
                        class="w-full flex items-center justify-center gap-1 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-sm text-label-sm uppercase tracking-wider py-2 transition-colors font-bold"
                    >
                        <span class="material-symbols-outlined text-[15px]">chat</span>
                        <span>Order WA</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</article>

