@php
    $isEdit = isset($product) && $product !== null;
    $actionUrl = $isEdit ? route('admin.products.update', $product) : route('admin.products.store');
    $m = old('measurements', $isEdit ? ($product->measurements ?? []) : []);
@endphp

<form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
    @csrf
    @if($isEdit)
        @method('PUT')
    @else
        <input type="hidden" name="status_toggle_present" value="1"/>
    @endif

    <!-- Left Column: Multi-Image Upload & Existing Gallery -->
    <div class="lg:col-span-5 flex flex-col gap-space-md">
        @if($isEdit)
            <div class="bg-surface-container-low border border-outline-variant p-space-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Foto Saat Ini ({{ $product->images->count() }})</span>
                    <span class="font-label-sm text-[10px] text-on-surface-variant">Minimal 1 foto dipertahankan</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($product->images as $img)
                        <div class="bg-surface-container-lowest border border-outline-variant p-2 flex flex-col gap-1.5">
                            <div class="aspect-square bg-surface-container overflow-hidden border border-outline-variant">
                                <img src="{{ $img->url }}" alt="{{ $img->label }}" class="w-full h-full object-cover"/>
                            </div>
                            <input type="text" name="existing_labels[{{ $img->id }}]" value="{{ $img->label }}" placeholder="Label foto" class="w-full bg-surface border border-outline-variant px-2 py-1 text-[11px] font-label-sm uppercase focus:outline-none focus:border-primary"/>
                            <div class="flex items-center justify-between gap-1 text-[10px]">
                                <label class="flex items-center gap-1">
                                    <span>Urutan:</span>
                                    <input type="number" name="existing_orders[{{ $img->id }}]" value="{{ $img->sort_order }}" class="w-12 bg-surface border border-outline-variant px-1 py-0.5 text-center"/>
                                </label>
                                <label class="flex items-center gap-1 text-error cursor-pointer">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="accent-error"/>
                                    <span>Hapus</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-space-sm">
            <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">
                {{ $isEdit ? 'Tambah Foto Baru (Opsional)' : 'Upload Foto Produk (Wajib Min. 1 Foto)' }}
                @if(!$isEdit)<span class="text-error">*</span>@endif
            </label>

            <label class="border-2 border-dashed border-outline-variant hover:border-primary transition-colors bg-surface-container-low p-space-lg flex flex-col items-center justify-center text-center cursor-pointer min-h-[200px] group">
                <input
                    type="file"
                    name="images[]"
                    id="product-images-input"
                    multiple
                    accept="image/jpeg,image/png,image/webp"
                    {{ $isEdit ? '' : 'required' }}
                    class="hidden"
                    onchange="previewSelectedImages(this)"
                />
                <div class="w-12 h-12 bg-surface-container-lowest border border-outline-variant flex items-center justify-center mb-3 group-hover:bg-secondary-container group-hover:border-primary transition-colors">
                    <span class="material-symbols-outlined text-primary text-[24px]">cloud_upload</span>
                </div>
                <span class="font-label-md text-label-md uppercase text-primary font-bold">Klik untuk Pilih Foto (Bisa Multi-File)</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Format JPG, PNG, WEBP • Maks. 5 MB per file</span>
                <span class="mt-3 px-2.5 py-1 bg-surface-container-lowest border border-outline-variant text-on-surface font-label-sm text-label-sm uppercase">Rasio 3:4 Direkomendasikan</span>
            </label>

            <div id="image-preview-list" class="grid grid-cols-2 gap-2"></div>
        </div>
    </div>

    <!-- Right Column: Specs & Details -->
    <div class="lg:col-span-7 flex flex-col gap-space-md">
        @if($isEdit)
            <div class="bg-surface-container-low border border-outline-variant p-2.5 flex items-center justify-between">
                <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">SKU Permanen (Immutable):</span>
                <span class="font-label-md text-label-md font-bold text-primary bg-secondary-container border border-primary px-2 py-0.5">{{ $product->sku }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Nama Produk / Artikel <span class="text-error">*</span></label>
                <input name="name" required value="{{ old('name', $product?->name) }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3.5 py-2.5 text-body-sm focus:outline-none" placeholder="Cth: Vintage 1996 Oasis Knebworth Tee" type="text"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Kategori Utama <span class="text-error">*</span></label>
                <select name="category_id" required class="w-full bg-surface border border-outline-variant focus:border-primary px-3.5 py-2.5 text-body-sm focus:outline-none cursor-pointer">
                    <option value="">Pilih Kategori...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (string) old('category_id', $product?->category_id) === (string) $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Brand / Tag</label>
                <input name="brand" value="{{ old('brand', $product?->brand) }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none" placeholder="Cth: Carhartt WIP / Brockum" type="text"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Era / Tahun</label>
                <input name="era" value="{{ old('era', $product?->era) }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none" placeholder="Cth: 1994 Vintage" type="text"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Drop Batch</label>
                <input name="drop_batch" value="{{ old('drop_batch', $product?->drop_batch ?? 'Drop #14') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm focus:outline-none" placeholder="Drop #14" type="text"/>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Harga Jual (IDR) <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 font-label-sm text-label-sm text-on-surface-variant font-bold">Rp</span>
                    <input name="price" required value="{{ old('price', $product?->price) }}" class="w-full bg-surface border border-outline-variant focus:border-primary pl-9 pr-3 py-2.5 text-body-sm tabular-nums focus:outline-none" placeholder="1250000" type="text"/>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Ukuran Tag <span class="text-error">*</span></label>
                <input name="size_label" required value="{{ old('size_label', $product?->size_label) }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm uppercase focus:outline-none" placeholder="L / 32 / 42" type="text"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Grade Kondisi (1–10) <span class="text-error">*</span></label>
                <input name="condition_grade" required type="number" step="0.1" min="1" max="10" value="{{ old('condition_grade', $product?->condition_grade ?? '9.2') }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2.5 text-body-sm tabular-nums focus:outline-none"/>
            </div>
        </div>

        <!-- Measurements Grid -->
        <div class="bg-surface-container-low border border-outline-variant p-space-sm">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold block mb-2">Ukuran Terukur Manual (cm) — Isi sesuai kategori</span>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                <div>
                    <label class="text-[11px] text-on-surface-variant block">Panjang (cm)</label>
                    <input name="measurements[panjang]" value="{{ $m['panjang'] ?? '' }}" type="text" placeholder="72" class="w-full bg-surface-container-lowest border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <div>
                    <label class="text-[11px] text-on-surface-variant block">Lebar Dada / P2P (cm)</label>
                    <input name="measurements[lebar_dada]" value="{{ $m['lebar_dada'] ?? '' }}" type="text" placeholder="56" class="w-full bg-surface-container-lowest border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <div>
                    <label class="text-[11px] text-on-surface-variant block">Lebar Bahu (cm)</label>
                    <input name="measurements[bahu]" value="{{ $m['bahu'] ?? '' }}" type="text" placeholder="50" class="w-full bg-surface-container-lowest border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <div>
                    <label class="text-[11px] text-on-surface-variant block">Panjang Lengan (cm)</label>
                    <input name="measurements[lengan]" value="{{ $m['lengan'] ?? '' }}" type="text" placeholder="61" class="w-full bg-surface-container-lowest border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <div>
                    <label class="text-[11px] text-on-surface-variant block">Lingkar Pinggang (cm)</label>
                    <input name="measurements[pinggang]" value="{{ $m['pinggang'] ?? '' }}" type="text" placeholder="84" class="w-full bg-surface-container-lowest border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
                <div>
                    <label class="text-[11px] text-on-surface-variant block">Insole Sepatu (cm)</label>
                    <input name="measurements[insole]" value="{{ $m['insole'] ?? '' }}" type="text" placeholder="26.5" class="w-full bg-surface-container-lowest border border-outline-variant px-2.5 py-1.5 text-body-sm focus:border-primary focus:outline-none"/>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Tag Kondisi Singkat</label>
                <input name="condition_tag" value="{{ old('condition_tag', $product?->condition_tag) }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2 text-body-sm focus:outline-none" placeholder="Cth: SINGLE STITCH / FADED WASH" type="text"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Detail Material</label>
                <input name="material" value="{{ old('material', $product?->material) }}" class="w-full bg-surface border border-outline-variant focus:border-primary px-3 py-2 text-body-sm focus:outline-none" placeholder="Cth: 100% Heavyweight Cotton Duck 12oz" type="text"/>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Deskripsi Artikel</label>
            <textarea name="description" rows="2" class="w-full bg-surface border border-outline-variant focus:border-primary p-3 text-body-sm focus:outline-none resize-none" placeholder="Jelaskan detail konstruksi, jahitan, tag, dan keunikan arsip...">{{ old('description', $product?->description) }}</textarea>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-bold">Catatan Minus (Flaws)</label>
            <textarea name="flaws" rows="2" class="w-full bg-surface border border-outline-variant focus:border-primary p-3 text-body-sm focus:outline-none resize-none" placeholder="Catat fading, pinhole, atau minus pemakaian secara jujur...">{{ old('flaws', $product?->flaws) }}</textarea>
        </div>

        <!-- Status & Featured Row -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-md pt-2 border-t border-outline-variant">
            <div class="flex flex-wrap items-center gap-space-md">
                @if($isEdit)
                    <div class="flex items-center gap-2">
                        <span class="font-label-sm text-label-sm uppercase font-bold">Status:</span>
                        <select name="status" class="bg-surface border border-primary px-3 py-1.5 font-label-md text-label-md uppercase font-bold">
                            <option value="available" {{ old('status', $product->status) === 'available' ? 'selected' : '' }}>Tersedia (Ready)</option>
                            <option value="sold" {{ old('status', $product->status) === 'sold' ? 'selected' : '' }}>Habis Terjual</option>
                        </select>
                    </div>
                @else
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" checked class="w-4 h-4 accent-primary"/>
                        <span class="font-label-md text-label-md uppercase text-primary font-bold">Status Awal: Tersedia</span>
                    </label>
                @endif

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product?->is_featured) ? 'checked' : '' }} class="w-4 h-4 accent-primary"/>
                    <span class="font-label-md text-label-md uppercase text-on-surface">Tampilkan di Pilihan Kurator (Beranda)</span>
                </label>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                @if($isEdit)
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 border border-primary text-primary font-label-md text-label-md uppercase hover:bg-surface-container">
                        Batal
                    </a>
                @else
                    <button type="reset" class="px-4 py-2.5 border border-outline-variant text-on-surface-variant font-label-md text-label-md uppercase hover:bg-surface-container">
                        Reset
                    </button>
                @endif
                <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-md text-label-md uppercase font-bold transition-colors">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan & Publikasikan' }}
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    function previewSelectedImages(input) {
        const container = document.getElementById('image-preview-list');
        if (!container) return;
        container.innerHTML = '';

        const defaultLabels = ['Depan', 'Belakang', 'Tag Label', 'Patina/Detail'];
        const fieldName = {{ $isEdit ? "'new_image_labels[]'" : "'image_labels[]'" }};

        Array.from(input.files).forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const card = document.createElement('div');
                card.className = 'bg-surface-container-lowest border border-outline-variant p-2 flex flex-col gap-1';
                card.innerHTML = `
                    <div class="aspect-square bg-surface-container overflow-hidden border border-outline-variant">
                        <img src="${e.target.result}" class="w-full h-full object-cover"/>
                    </div>
                    <input type="text" name="${fieldName}" value="${defaultLabels[idx] || 'Detail'}" placeholder="Label foto" class="w-full bg-surface border border-outline-variant px-2 py-1 text-[11px] uppercase"/>
                `;
                container.appendChild(card);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush

