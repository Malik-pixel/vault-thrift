@extends('layouts.admin')

@section('title', 'Manajemen Produk & Inventaris — VAULT Admin')

@section('content')
<div class="flex flex-col w-full pb-space-xl">
    <!-- Top Telemetry Bar -->
    <div class="w-full bg-surface-container-high border-b border-outline-variant px-space-md md:px-space-lg py-2 flex flex-wrap items-center justify-between gap-2 text-on-surface">
        <div class="flex items-center gap-space-sm">
            <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
            <span class="font-label-sm text-label-sm uppercase tracking-wider">DATABASE SINKRONISASI: MySQL LIVE • VAULT ARCHIVE ENGINE</span>
        </div>
        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">ATURAN 1-OF-1 AKTIF</span>
    </div>

    <div class="p-space-md md:p-space-lg flex flex-col gap-space-lg">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-space-md">
            <div class="flex flex-col gap-1 max-w-3xl">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 bg-primary text-on-primary font-label-sm text-label-sm uppercase tracking-widest">INVENTORY CONTROL</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">DROP SCHEDULE: {{ strtoupper($storeSettings['drop_schedule']) }}</span>
                </div>
                <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight uppercase">MANAJEMEN PRODUK &amp; INVENTARIS ARSIP</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">Kelola katalog 1-of-1, pembaruan status stok, harga rupiah, aksi massal, dan unggah artikel baru.</p>
            </div>

            <div class="flex flex-wrap items-center gap-space-sm">
                <button type="button" onclick="document.getElementById('fast-upload-card').scrollIntoView({behavior: 'smooth'})" class="inline-flex items-center gap-1.5 px-space-md py-2.5 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary transition-colors font-label-md text-label-md uppercase font-bold">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Tambah Produk Baru</span>
                </button>
                <a href="{{ route('admin.products.export') }}" class="inline-flex items-center gap-1.5 px-space-md py-2.5 bg-surface-container-lowest border border-primary text-on-surface hover:bg-surface-container font-label-md text-label-md uppercase font-bold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">file_download</span>
                    <span>Export CSV</span>
                </a>
            </div>
        </div>

        <!-- 4 KPI Cards (FR-60) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">TOTAL PRODUK TERDAFTAR</span>
                    <span class="material-symbols-outlined text-[18px] text-on-surface-variant">archive</span>
                </div>
                <div class="mt-space-sm flex items-baseline justify-between">
                    <span class="font-display-lg text-headline-lg text-primary font-bold tabular-nums">{{ $totalProducts }}</span>
                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-surface-container border border-outline-variant text-on-surface uppercase">{{ $categories->count() }} Kategori</span>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Item aktif terindeks di sistem</span>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">STOK TERSEDIA (READY)</span>
                    <span class="material-symbols-outlined text-[18px] text-secondary">check_circle</span>
                </div>
                <div class="mt-space-sm flex items-baseline justify-between">
                    <span class="font-display-lg text-headline-lg text-primary font-bold tabular-nums">{{ $availableProducts }}</span>
                    <span class="font-label-sm text-label-sm px-2 py-0.5 bg-secondary-container border border-primary text-primary uppercase font-bold">Siap Kirim</span>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Siap dipesan via WhatsApp</span>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">TERJUAL / ARCHIVED</span>
                    <span class="material-symbols-outlined text-[18px] text-tertiary">remove_shopping_cart</span>
                </div>
                <div class="mt-space-sm flex items-baseline justify-between">
                    <span class="font-display-lg text-headline-lg text-primary font-bold tabular-nums">{{ $soldProducts }}</span>
                    <span class="font-label-sm text-label-sm px-2 py-0.5 bg-surface-container-high text-on-surface-variant uppercase">Sold Out</span>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Koleksi terarsip &amp; terkirim</span>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">ESTIMASI NILAI INVENTARIS</span>
                    <span class="material-symbols-outlined text-[18px] text-on-surface">payments</span>
                </div>
                <div class="mt-space-sm flex items-baseline justify-between">
                    <span class="font-headline-md text-[22px] font-bold text-primary tracking-tight tabular-nums">{{ \App\Models\Product::formatRupiah($inventoryValue) }}</span>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Total nilai stok tersedia</span>
            </div>
        </div>

        <!-- Filter & Toolbar Controls (FR-61) -->
        <form action="{{ route('admin.products.index') }}" method="GET" class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col gap-space-md">
            <input type="hidden" name="kategori" id="admin-filter-kategori" value="{{ $kategori }}"/>
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-md">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                    <input name="q" value="{{ $q }}" class="w-full bg-surface border border-outline-variant focus:border-primary text-on-surface font-body-sm text-body-sm pl-9 pr-4 py-2.5 focus:outline-none placeholder:text-on-surface-variant" placeholder="Cari berdasarkan nama produk, SKU (#VLT-), atau brand..." type="text"/>
                </div>

                <div class="flex items-center gap-1 overflow-x-auto pb-1 lg:pb-0">
                    <button type="button" onclick="document.getElementById('admin-filter-kategori').value=''; this.form.submit();" class="px-3 py-1.5 border font-label-md text-label-md uppercase whitespace-nowrap {{ $kategori === '' ? 'bg-primary text-on-primary border-primary font-bold' : 'bg-surface-container border-outline-variant text-on-surface hover:border-primary' }}">
                        Semua ({{ $totalProducts }})
                    </button>
                    @foreach($categories as $cat)
                        <button type="button" onclick="document.getElementById('admin-filter-kategori').value='{{ $cat->slug }}'; this.form.submit();" class="px-3 py-1.5 border font-label-md text-label-md uppercase whitespace-nowrap {{ $kategori === $cat->slug ? 'bg-primary text-on-primary border-primary font-bold' : 'bg-surface-container border-outline-variant text-on-surface hover:border-primary' }}">
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-space-sm pt-space-xs border-t border-outline-variant/60">
                <div class="flex flex-wrap items-center gap-space-sm">
                    <div class="flex items-center gap-2">
                        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">Status:</span>
                        <select name="status" onchange="this.form.submit()" class="bg-surface border border-outline-variant font-label-md text-label-md uppercase text-on-surface px-2.5 py-1.5 focus:outline-none cursor-pointer">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Hanya Tersedia</option>
                            <option value="sold" {{ $status === 'sold' ? 'selected' : '' }}>Habis Terjual</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">Drop:</span>
                        <select name="drop" onchange="this.form.submit()" class="bg-surface border border-outline-variant font-label-md text-label-md uppercase text-on-surface px-2.5 py-1.5 focus:outline-none cursor-pointer">
                            <option value="">Semua Drop</option>
                            @foreach($dropBatches as $batch)
                                <option value="{{ $batch }}" {{ $drop === $batch ? 'selected' : '' }}>{{ $batch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">Urutkan:</span>
                        <select name="urut" onchange="this.form.submit()" class="bg-surface border border-outline-variant font-label-md text-label-md uppercase text-on-surface px-2.5 py-1.5 focus:outline-none cursor-pointer">
                            <option value="newest" {{ $urut === 'newest' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                            <option value="price_desc" {{ $urut === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="price_asc" {{ $urut === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="grade_desc" {{ $urut === 'grade_desc' ? 'selected' : '' }}>Grade Kondisi</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-space-md py-1.5 bg-secondary-container border border-primary text-primary hover:bg-primary hover:text-secondary-container transition-colors font-label-md text-label-md uppercase font-bold">Terapkan</button>
                    <a href="{{ route('admin.products.index') }}" class="px-space-md py-1.5 bg-surface border border-outline-variant text-on-surface-variant hover:text-primary font-label-md text-label-md uppercase">Reset</a>
                </div>
            </div>
        </form>

        <!-- Main Data Table + Bulk Actions (FR-61, FR-62) -->
        <div class="bg-surface-container-lowest border border-outline-variant overflow-hidden flex flex-col">
            <div class="px-space-md py-3 bg-surface-container-low border-b border-outline-variant flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <input class="w-4 h-4 accent-primary cursor-pointer" id="check-all" type="checkbox"/>
                    <span class="font-label-md text-label-md uppercase tracking-wider text-primary font-bold">KATALOG ARSIP (TABEL REPOSITORY)</span>
                </div>
                <div class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                    MENAMPILKAN {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} DARI {{ $products->total() }} PRODUK
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-lowest border-b border-outline-variant text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                            <th class="py-3 px-space-md w-10 text-center">Pilih</th>
                            <th class="py-3 px-space-md w-20">Foto</th>
                            <th class="py-3 px-space-md min-w-[260px]">SKU &amp; Nama Artikel</th>
                            <th class="py-3 px-space-md">Kategori</th>
                            <th class="py-3 px-space-md">Harga (IDR)</th>
                            <th class="py-3 px-space-md min-w-[200px]">Ukuran &amp; Kondisi</th>
                            <th class="py-3 px-space-md">Status Stok</th>
                            <th class="py-3 px-space-md text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/60 font-body-sm text-body-sm text-on-surface">
                        @forelse($products as $product)
                            @php $isSold = $product->isSold(); @endphp
                            <tr class="hover:bg-surface-container-low transition-colors {{ $isSold ? 'bg-surface-container-low/50' : '' }}">
                                <td class="py-3 px-space-md text-center">
                                    <input form="bulk-action-form" name="product_ids[]" value="{{ $product->id }}" class="row-checkbox w-4 h-4 accent-primary cursor-pointer" type="checkbox"/>
                                </td>
                                <td class="py-3 px-space-md">
                                    <div class="w-14 h-16 bg-surface-container border border-outline-variant overflow-hidden relative">
                                        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover {{ $isSold ? 'grayscale' : '' }}"/>
                                        <span class="absolute top-0 left-0 bg-primary text-on-primary font-label-sm text-[9px] px-1">{{ number_format($product->condition_grade, 1) }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-space-md">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant uppercase">
                                            <span class="font-bold text-primary">#{{ $product->sku }}</span>
                                            <span>•</span>
                                            <span>{{ $product->brand ?: 'VAULT' }}</span>
                                        </div>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="font-headline-md text-[14px] leading-tight font-bold text-primary hover:underline mt-0.5 {{ $isSold ? 'line-through text-outline' : '' }}">
                                            {{ $product->name }}
                                        </a>
                                        <span class="font-label-sm text-[10px] text-on-surface-variant mt-0.5">
                                            {{ $product->created_at?->format('d M Y') }} • {{ $product->drop_batch ?: 'Archive' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-space-md">
                                    <span class="px-2 py-0.5 bg-surface-container-high border border-outline-variant text-on-surface font-label-sm text-label-sm uppercase whitespace-nowrap">
                                        {{ $product->category?->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-space-md whitespace-nowrap">
                                    <span class="font-headline-md text-[15px] font-bold tabular-nums {{ $isSold ? 'text-outline line-through' : 'text-primary' }}">
                                        {{ $product->formatted_price }}
                                    </span>
                                </td>
                                <td class="py-3 px-space-md">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="font-label-sm text-label-sm font-bold uppercase text-primary">
                                            Size {{ $product->size_label }}
                                            @if($product->short_measurement_summary)
                                                ({{ $product->short_measurement_summary }})
                                            @endif
                                        </span>
                                        <span class="font-body-sm text-[11px] text-on-surface-variant">
                                            Grade {{ number_format($product->condition_grade, 1) }}/10 {{ $product->condition_tag ? '• ' . $product->condition_tag : '' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-space-md">
                                    <div class="flex items-center gap-1.5">
                                        @if($isSold)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-tertiary text-on-primary font-label-sm text-label-sm uppercase font-bold whitespace-nowrap">
                                                Habis Terjual
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-secondary-container border border-primary text-primary font-label-sm text-label-sm uppercase font-bold whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                                Tersedia
                                            </span>
                                        @endif

                                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-1 border border-outline-variant hover:border-primary hover:bg-surface-container text-on-surface-variant hover:text-primary transition-colors" title="{{ $isSold ? 'Kembalikan ke Tersedia' : 'Tandai Terjual' }}">
                                                <span class="material-symbols-outlined text-[16px]">{{ $isSold ? 'replay' : 'swap_horiz' }}</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-3 px-space-md text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 bg-surface border border-outline-variant hover:border-primary text-on-surface transition-colors" title="Edit Produk">
                                            <span class="material-symbols-outlined text-[16px]">edit</span>
                                        </a>
                                        <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="p-1.5 bg-surface border border-outline-variant hover:border-primary text-on-surface transition-colors" title="Pratinjau di Toko">
                                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->sku }}? Produk yang memiliki riwayat pesanan akan di-soft delete.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-surface border border-outline-variant hover:bg-error hover:text-on-error hover:border-error text-error transition-colors" title="Hapus Produk">
                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-10 text-center text-on-surface-variant">Belum ada produk yang cocok dengan filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions & Pagination Footer -->
            <div class="p-space-md bg-surface-container-low border-t border-outline-variant flex flex-col lg:flex-row items-start lg:items-center justify-between gap-space-md">
                <form id="bulk-action-form" action="{{ route('admin.products.bulk') }}" method="POST" class="flex flex-wrap items-center gap-2">
                    @csrf
                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-bold">Aksi Massal (<span id="selected-count">0</span>):</span>
                    <button type="submit" name="action" value="mark_sold" class="px-2.5 py-1.5 bg-surface-container-lowest border border-outline-variant hover:bg-primary hover:text-on-primary transition-colors font-label-sm text-label-sm uppercase font-bold">
                        Tandai Terjual
                    </button>
                    <button type="submit" name="action" value="mark_available" class="px-2.5 py-1.5 bg-surface-container-lowest border border-outline-variant hover:bg-secondary-container transition-colors font-label-sm text-label-sm uppercase font-bold">
                        Tandai Tersedia
                    </button>
                    <div class="flex items-center gap-1">
                        <select name="target_category_id" class="bg-surface-container-lowest border border-outline-variant px-2 py-1.5 font-label-sm text-label-sm uppercase">
                            <option value="">Pindah Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" name="action" value="change_category" class="px-2.5 py-1.5 bg-surface-container-lowest border border-outline-variant hover:bg-primary hover:text-on-primary transition-colors font-label-sm text-label-sm uppercase font-bold">
                            Ubah
                        </button>
                    </div>
                    <button type="submit" name="action" value="delete" onclick="return confirm('Yakin ingin menghapus semua produk terpilih?')" class="px-2.5 py-1.5 bg-surface-container-lowest border border-error text-error hover:bg-error hover:text-on-error transition-colors font-label-sm text-label-sm uppercase font-bold">
                        Hapus Terpilih
                    </button>
                </form>

                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>

        <!-- Integrated Fast Upload / New Product Form Card (FR-63) -->
        <div class="bg-surface-container-lowest border border-primary p-space-md md:p-space-lg flex flex-col gap-space-md" id="fast-upload-card">
            <div class="flex items-start justify-between border-b border-outline-variant pb-space-sm">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="font-label-sm text-label-sm uppercase px-2 py-0.5 bg-secondary-container border border-primary text-primary font-bold">FAST INGESTION</span>
                        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">MODUL UNGGAH KATALOG BARU</span>
                    </div>
                    <h2 class="font-headline-md text-headline-md text-primary tracking-tight uppercase mt-1 font-bold">Tambah Produk Baru ke Arsip (Auto SKU)</h2>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">SKU (format VLT-XXXX) dibuat otomatis oleh sistem dan bersifat permanen.</p>
                </div>
                <span class="material-symbols-outlined text-primary text-[28px]">post_add</span>
            </div>

            @include('admin.products._form', ['categories' => $categories, 'product' => null])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const checkAll = document.getElementById('check-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectedCount = document.getElementById('selected-count');

    function updateSelectedCount() {
        const count = document.querySelectorAll('.row-checkbox:checked').length;
        if (selectedCount) selectedCount.textContent = count;
    }

    if (checkAll) {
        checkAll.addEventListener('change', (e) => {
            rowCheckboxes.forEach(cb => cb.checked = e.target.checked);
            updateSelectedCount();
        });
    }

    rowCheckboxes.forEach(cb => cb.addEventListener('change', updateSelectedCount));
</script>
@endpush

