@extends('layouts.app')

@section('title', 'Tentang Kami & Manifesto Kurasi — VAULT Curated Thrift')

@section('content')
<div class="flex flex-col w-full">
    <!-- Top Breadcrumb -->
    <div class="w-full bg-surface-container-low border-b border-outline-variant py-space-sm px-margin md:px-margin-tablet lg:px-margin-desktop">
        <div class="max-w-[1440px] mx-auto flex flex-wrap items-center justify-between gap-space-sm">
            <nav class="flex items-center gap-space-xs font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">
                <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Beranda</a>
                <span class="text-outline">/</span>
                <span class="text-primary font-bold">Tentang Kami &amp; Manifesto Kurasi</span>
            </nav>
            <div class="flex items-center gap-space-sm font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">
                <span class="inline-flex items-center gap-1.5 bg-secondary-container border border-primary text-primary px-space-xs py-0.5 font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                    OFFICIAL DOSSIER
                </span>
                <span class="hidden sm:inline">ARCHIVE PROTOCOL REV. {{ date('Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Editorial Headline -->
    <section class="w-full px-margin md:px-margin-tablet lg:px-margin-desktop py-space-xl">
        <div class="max-w-[1440px] mx-auto flex flex-col gap-space-lg">
            <div class="flex items-center gap-space-sm">
                <span class="bg-primary text-on-primary px-space-xs py-0.5 font-label-sm text-label-sm uppercase tracking-widest">DOSSIER // 001</span>
                <span class="text-outline font-label-sm text-label-sm uppercase tracking-widest">JAKARTA SELATAN, ID</span>
            </div>
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-space-lg">
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg uppercase tracking-tight text-primary max-w-4xl">
                    TENTANG VAULT <span class="text-outline font-normal">//</span> MANIFESTO &amp; PROTOKOL KURASI ARSIP
                </h1>
                <div class="flex lg:flex-col items-center lg:items-end gap-space-xs text-right">
                    <span class="font-label-lg text-label-lg uppercase tracking-wider text-secondary">EST. 2021</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">100% INDEPENDENT ARCHIVE</span>
                </div>
            </div>
            <div class="p-space-lg bg-surface-container-high border border-primary max-w-4xl hard-shadow">
                <p class="font-headline-md text-headline-md text-primary leading-snug">
                    “Bukan sekadar pakaian bekas biasa. Kami merawat sejarah garmen, menguji otentisitas tanpa kompromi, dan mendefinisikan ulang kultur pre-loved streetwear di Indonesia.”
                </p>
            </div>
        </div>
    </section>

    <!-- Bento Grid Origin -->
    <section class="w-full px-margin md:px-margin-tablet lg:px-margin-desktop pb-space-xl">
        <div class="max-w-[1440px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-space-md">
            <div class="lg:col-span-7 relative bg-surface-container border border-primary overflow-hidden min-h-[420px] flex flex-col justify-end p-space-lg">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/stitch/studio-rack.jpg') }}')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/45 to-transparent"></div>
                <div class="relative z-10 flex flex-col gap-space-xs text-on-primary">
                    <div class="flex items-center gap-space-xs">
                        <span class="bg-secondary-container text-primary px-space-xs py-0.5 font-label-sm text-label-sm uppercase tracking-wider font-bold">ARCHIVE ROOM 01</span>
                        <span class="font-label-sm text-label-sm uppercase text-surface-variant">KEMANG TIMUR VAULT</span>
                    </div>
                    <h2 class="font-headline-lg text-headline-lg uppercase tracking-tight text-on-primary">
                        LAHIR DARI OBSESI DETAIL &amp; SUBKULTUR OTENTIK
                    </h2>
                    <p class="font-body-md text-body-md text-surface-container-highest max-w-xl">
                        Diinisiasi pada 2021 di sudut Kemang, Jakarta Selatan. VAULT lahir dari rasa skeptis atas pasar thrifting massal yang dipenuhi produk repro tidak terverifikasi. Kami hadir sebagai filter ketat bagi para penikmat streetwear berkelas.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col gap-space-md">
                <div class="bg-surface-container border border-outline-variant p-space-lg flex flex-col gap-space-sm flex-1 justify-center">
                    <div class="flex items-center justify-between">
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary font-bold">ERA GOLDEN AGE SUBKULTUR</span>
                        <span class="material-symbols-outlined text-outline">history_edu</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md uppercase text-primary font-bold">90's Single Stitch &amp; Archive Heavyweight</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Spesialisasi kami berakar pada kaos band vintage era 90-an berjahitan tunggal (single-stitch), workwear tahan banting Carhartt Detroit &amp; Double Knee, siluet gorpcore teknikal, hingga arsip legendaris desainer Tokyo Harajuku.
                    </p>
                </div>
                <div class="bg-primary text-on-primary border border-primary p-space-lg flex flex-col gap-space-sm flex-1 justify-center">
                    <div class="flex items-center justify-between">
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container font-bold">1-OF-1 SUSTAINABLE LEGACY</span>
                        <span class="material-symbols-outlined text-secondary-container">eco</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md uppercase text-on-primary font-bold">Karakter Abadi Tanpa Jejak Karbon Baru</h3>
                    <p class="font-body-md text-body-md text-surface-variant leading-relaxed">
                        Setiap helai pakaian di VAULT adalah arsip satu-satunya di dunia. Memilih pre-loved terkurasi menekan limbah tekstil sekaligus memberi identitas autentik yang mustahil ditiru fast-fashion.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Operational Metrics -->
    <section class="w-full bg-surface-container-high border-y border-outline-variant py-space-xl px-margin md:px-margin-tablet lg:px-margin-desktop">
        <div class="max-w-[1440px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mb-space-lg">
                <div>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary font-bold">METRIK &amp; REPUTASI</span>
                    <h2 class="font-headline-lg text-headline-lg uppercase tracking-tight text-primary mt-space-xs">
                        DATA OPERASIONAL &amp; REKAM JEJAK
                    </h2>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant max-w-md">
                    Standar verifikasi ketat yang konsisten menghadirkan kepuasan bagi kolektor streetwear di seluruh penjuru Indonesia.
                </p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md">
                <div class="bg-surface-container-lowest border border-outline-variant p-space-lg flex flex-col justify-between">
                    <span class="font-label-sm text-label-sm uppercase text-outline">TOTAL ARSIP</span>
                    <div class="my-space-sm">
                        <span class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary tracking-tight font-bold tabular-nums">{{ $storeSettings['total_archived_stat'] }}</span>
                    </div>
                    <div class="flex items-center gap-space-xs text-secondary font-label-md text-label-md uppercase font-bold">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>{{ $totalCatalog }} Artikel Aktif DB</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant p-space-lg flex flex-col justify-between">
                    <span class="font-label-sm text-label-sm uppercase text-outline">AUTHENTICITY</span>
                    <div class="my-space-sm">
                        <span class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary tracking-tight font-bold tabular-nums">100%</span>
                    </div>
                    <div class="flex items-center gap-space-xs text-on-tertiary-container font-label-md text-label-md uppercase font-bold">
                        <span class="material-symbols-outlined text-[16px]">gavel</span>
                        <span>Full Money Back Guarantee</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant p-space-lg flex flex-col justify-between">
                    <span class="font-label-sm text-label-sm uppercase text-outline">RATA-RATA KONDISI</span>
                    <div class="my-space-sm">
                        <span class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary tracking-tight font-bold tabular-nums">{{ $averageGrade }}<span class="text-body-lg text-outline font-normal">/10</span></span>
                    </div>
                    <div class="flex items-center gap-space-xs text-secondary font-label-md text-label-md uppercase font-bold">
                        <span class="material-symbols-outlined text-[16px]">hotel_class</span>
                        <span>Skor Fisik Presisi</span>
                    </div>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant p-space-lg flex flex-col justify-between">
                    <span class="font-label-sm text-label-sm uppercase text-outline">KEPUASAN KOLEKTOR</span>
                    <div class="my-space-sm">
                        <span class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary tracking-tight font-bold tabular-nums">4.9<span class="text-body-lg text-outline font-normal">/5.0</span></span>
                    </div>
                    <div class="flex items-center gap-space-xs text-primary font-label-md text-label-md uppercase font-bold">
                        <span class="material-symbols-outlined text-[16px]">thumb_up</span>
                        <span>Ulasan Pelanggan Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4 Curation Protocols -->
    <section id="protokol" class="w-full px-margin md:px-margin-tablet lg:px-margin-desktop py-space-xl">
        <div class="max-w-[1440px] mx-auto flex flex-col gap-space-xl">
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-space-sm">
                    <span class="bg-secondary-container border border-primary text-primary px-space-xs py-0.5 font-label-sm text-label-sm uppercase font-bold">
                        THE VAULT 4-STEP STANDARD
                    </span>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-outline">NO SHORTCUTS</span>
                </div>
                <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg uppercase tracking-tight text-primary">
                    PROTOKOL KURASI &amp; AUTENTIKASI
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                    Setiap rilisan pakaian yang masuk ke rak VAULT melewati serangkaian proses inspeksi mikroskopis dan perawatan restorasi tanpa toleransi cacat sembunyi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                @foreach([
                    ['01', 'VERIFIKASI FISIK', 'Physical Authentication & Verification', 'Pembedahan detail necktag, serial wash tag benang tenun, jahitan kelim single stitch vs double stitch, ritsleting otentik (YKK, Talon, Ideal, Scovill), dan font sablon plastisol era terkait.', ['Micro-inspection tag', 'Zipper hardware verify', 'Stitch era chronology']],
                    ['02', 'GRADING TRANSPARAN', 'Grading Presisi Tanpa Filter', 'Skala penilaian objektif 1 hingga 10 yang terstandarisasi. Karakteristik usia seperti sun-faded alami, distressing, atau pinhole didokumentasikan transparan tanpa manipulasi.', ['10-Point scale grading', 'High-res raw photography', 'Flaw honesty disclosure']],
                    ['03', 'HIGIENIS SIAP PAKAI', 'Sanitasi Medis 3 Tahap & Deep Cleansing', 'Dry-cleaning khusus material vintage, sterilisasi uap ozone 100°C untuk melenyapkan tungau dan bakteri, serta deodorisasi aroma netral sehingga langsung siap dipakai.', ['100°C Ozone Steam', 'Anti-allergen wash', 'Odorless clean finish']],
                    ['04', 'PENGUKURAN MANUAL', 'Pengukuran Manual Presisi (P x L cm)', 'Ukuran tag vintage sering mengalami penyusutan. Kami mengukur manual centimeter pada setiap item: Lebar Dada (P2P), Panjang Badan, Bahu, Lengan, dan Lingkar Pinggang.', ['Exact Pit-to-Pit (P2P)', 'True Length measurement', 'Zero sizing confusion']],
                ] as [$num, $badge, $title, $desc, $bullets])
                    <div class="bg-surface-container border border-outline-variant p-space-lg flex flex-col gap-space-md hover:border-primary transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="font-display-lg text-headline-lg text-secondary font-bold">{{ $num }}</span>
                            <span class="bg-primary text-on-primary px-space-sm py-space-xs font-label-sm text-label-sm uppercase">{{ $badge }}</span>
                        </div>
                        <div class="flex flex-col gap-space-xs">
                            <h3 class="font-headline-lg text-headline-md md:text-headline-lg uppercase text-primary">{{ $title }}</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $desc }}</p>
                        </div>
                        <div class="mt-auto pt-space-sm bg-surface-container-lowest border border-outline-variant p-space-sm font-label-sm text-label-sm uppercase text-on-surface-variant flex flex-wrap gap-x-space-md gap-y-space-xs">
                            @foreach($bullets as $b)
                                <span>• {{ $b }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Team Archivists -->
    <section class="w-full bg-surface-container-low border-y border-outline-variant py-space-xl px-margin md:px-margin-tablet lg:px-margin-desktop">
        <div class="max-w-[1440px] mx-auto flex flex-col gap-space-lg">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
                <div>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary font-bold">THE SPECIALISTS</span>
                    <h2 class="font-headline-lg text-headline-lg uppercase tracking-tight text-primary mt-space-xs">
                        MEET THE VAULT ARCHIVISTS
                    </h2>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant max-w-md">
                    Individu di balik meja kurasi yang mengkaji benang garmen, katalog klasik, dan arsip streetwear dunia.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                @foreach([
                    ['team-1.jpg', 'HEAD ARCHIVIST', 'Rian ‘Kuro’ Pratama', 'EXP. 11 YRS', 'Band Tees & Japanese Archive Specialist', 'Kolektor arsip musik 90-an dengan spesialisasi verifikasi sablon plastisol tua dan tag Brockum / Giant / Anvil.'],
                    ['team-2.jpg', 'GARMENT RESTORER', 'Dinda Saraswati', 'EXP. 8 YRS', 'Workwear & Denim Preservation Lead', 'Ahli tekstil yang mengepalai laboratorium sterilisasi 3 tahap dan preservasi garmen canvas serta denim selvedge.'],
                    ['team-3.jpg', 'SOURCING CURATOR', 'Arga Mahendra', 'EXP. 9 YRS', 'Gorpcore & 2000s Streetwear Curator', 'Terhubung dengan jejaring kolektor Tokyo, London, dan Los Angeles untuk pengadaan artikel arsip langka.'],
                ] as [$img, $roleBadge, $name, $exp, $title, $bio])
                    <div class="bg-surface-container-lowest border border-outline-variant flex flex-col">
                        <div class="h-72 w-full overflow-hidden relative border-b border-outline-variant bg-surface-container">
                            <img src="{{ asset('images/stitch/' . $img) }}" alt="{{ $name }}" class="w-full h-full object-cover"/>
                            <div class="absolute top-3 left-3 bg-primary text-secondary-container font-label-sm text-label-sm uppercase px-2 py-0.5 font-bold">
                                {{ $roleBadge }}
                            </div>
                        </div>
                        <div class="p-space-md flex flex-col gap-space-xs flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline-md text-headline-md uppercase text-primary font-bold">{{ $name }}</h3>
                                <span class="font-label-sm text-label-sm text-outline">{{ $exp }}</span>
                            </div>
                            <span class="font-label-md text-label-md uppercase text-secondary font-bold">{{ $title }}</span>
                            <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mt-space-xs">{{ $bio }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Physical Studio & Map (FR-42) -->
    <section id="studio" class="w-full px-margin md:px-margin-tablet lg:px-margin-desktop py-space-xl">
        <div class="max-w-[1440px] mx-auto flex flex-col gap-space-lg">
            <div class="flex flex-col gap-space-xs">
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary font-bold">OFFLINE VAULT SPACE</span>
                <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg uppercase tracking-tight text-primary">
                    STUDIO FISIK &amp; RUANG FITTING
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                    Sentuh langsung tekstur material, periksa keaslian garmen di bawah cahaya studio, dan coba fitting ukuran favorit Anda secara privat.
                </p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
                <div class="lg:col-span-7 border border-primary overflow-hidden bg-surface-container flex flex-col">
                    <div class="w-full h-80 lg:h-full min-h-[360px] bg-cover bg-center relative" style="background-image: url('{{ asset('images/stitch/studio-map.jpg') }}')">
                        <div class="absolute top-4 left-4 bg-primary text-on-primary px-space-md py-space-xs font-label-md text-label-md uppercase flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px] text-secondary-container">pin_drop</span>
                            <span>VAULT STUDIO KEMANG</span>
                        </div>
                        <a href="https://maps.google.com/?q={{ urlencode($storeSettings['studio_address']) }}" target="_blank" rel="noopener noreferrer"
                           class="absolute bottom-4 right-4 bg-surface-container-lowest border border-primary px-3 py-1.5 font-label-sm text-label-sm uppercase font-bold hover:bg-secondary-container transition-colors flex items-center gap-1">
                            <span>Buka di Google Maps</span>
                            <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-5 bg-surface-container border border-outline-variant p-space-lg flex flex-col justify-between gap-space-md">
                    <div class="flex flex-col gap-space-md">
                        <div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">LOKASI KAMI:</span>
                            <p class="font-headline-md text-headline-md uppercase text-primary mt-1 font-bold">
                                {{ $storeSettings['studio_address'] }}
                            </p>
                        </div>
                        <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col gap-space-xs">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">JAM OPERASIONAL &amp; KUNJUNGAN:</span>
                            <div class="flex justify-between items-center font-body-md text-body-md text-primary font-bold">
                                <span>{{ $storeSettings['operating_hours'] }}</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                Tersedia untuk Walk-in langsung atau Private Fitting Reservation via WhatsApp.
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-space-sm font-label-sm text-label-sm uppercase">
                            <div class="bg-surface-container-lowest border border-outline-variant p-space-sm flex items-center gap-2 text-on-surface">
                                <span class="material-symbols-outlined text-secondary text-[20px]">local_parking</span>
                                <span>Area Parkir Luas</span>
                            </div>
                            <div class="bg-surface-container-lowest border border-outline-variant p-space-sm flex items-center gap-2 text-on-surface">
                                <span class="material-symbols-outlined text-secondary text-[20px]">checkroom</span>
                                <span>Private Fitting</span>
                            </div>
                            <div class="bg-surface-container-lowest border border-outline-variant p-space-sm flex items-center gap-2 text-on-surface">
                                <span class="material-symbols-outlined text-secondary text-[20px]">coffee</span>
                                <span>Archive Lounge</span>
                            </div>
                            <div class="bg-surface-container-lowest border border-outline-variant p-space-sm flex items-center gap-2 text-on-surface">
                                <span class="material-symbols-outlined text-secondary text-[20px]">qr_code_scanner</span>
                                <span>QRIS &amp; Transfer</span>
                            </div>
                        </div>
                    </div>
                    @php
                        $fittingUrl = 'https://wa.me/' . $storeSettings['whatsapp_clean'] . '?text=' . rawurlencode('Halo Admin VAULT, saya ingin menjadwalkan Private Fitting di Studio Kemang.');
                    @endphp
                    <a class="w-full bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary transition-colors py-space-md px-space-md text-center font-label-lg text-label-lg uppercase tracking-wider flex items-center justify-center gap-space-xs font-bold" href="{{ $fittingUrl }}" target="_blank" rel="noopener noreferrer">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        <span>JADWALKAN PRIVATE FITTING</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion (FR-41) -->
    <section id="faq" class="w-full bg-surface-container-low border-t border-outline-variant py-space-xl px-margin md:px-margin-tablet lg:px-margin-desktop">
        <div class="max-w-[1024px] mx-auto flex flex-col gap-space-lg">
            <div class="text-center flex flex-col items-center gap-space-xs">
                <span class="bg-secondary-container border border-primary text-primary px-space-xs py-0.5 font-label-sm text-label-sm uppercase font-bold">FAQ PROTOKOL</span>
                <h2 class="font-headline-lg text-headline-lg uppercase tracking-tight text-primary">
                    PERTANYAAN SEPUTAR KURASI &amp; TRANSAKSI
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                    Transparansi penuh mengenai keaslian pakaian, aturan 1-of-1, dan jaminan keamanan pembelian Anda di VAULT.
                </p>
            </div>

            <div class="flex flex-col gap-space-sm w-full" id="faq-accordion-container">
                @foreach([
                    ['Bagaimana cara memastikan barang di VAULT asli 100%?', 'Setiap pakaian melalui verifikasi fisik multi-level: pengujian serat kain, jahitan kelim benang single stitch era lampau, ritsleting brand-specific (YKK, Scovill, Talon), kode serial wash tag, dan perbandingan arsip fisik. Kami menolak lebih dari 40% barang masuk bila ada keraguan sedikitpun.', true],
                    ['Bagaimana aturan 1-of-1 bekerja saat saya memesan lewat WhatsApp?', 'Setiap artikel di VAULT hanya tersedia 1 potong. Mengirim form order WhatsApp mencatat pesanan Anda sebagai Menunggu Konfirmasi, namun stok baru resmi terkunci menjadi HABIS ketika pembayaran Anda telah diverifikasi oleh admin.', false],
                    ['Apakah pakaian bisa langsung dipakai setelah paket sampai?', 'Pasti. Setiap artikel telah melalui sanitasi 3 tahap: dry cleaning ramah garmen vintage, ozone steaming uap panas 100°C untuk membasmi tungau dan bakteri, serta deodorisasi aroma netral.', false],
                    ['Bagaimana mekanisme garansi uang kembali jika barang terbukti fake?', 'Kami memberlakukan 100% Money Back Guarantee. Jika barang terbukti tiruan/bootleg modern tanpa keterangan otentik, dana dikembalikan 100% beserta ongkos kirim.', false],
                ] as [$question, $answer, $open])
                    <div class="bg-surface-container-lowest border border-outline-variant overflow-hidden">
                        <button aria-expanded="{{ $open ? 'true' : 'false' }}" class="faq-toggle w-full p-space-md md:p-space-lg text-left flex items-center justify-between gap-space-md focus:outline-none hover:bg-surface-container-low transition-colors" type="button">
                            <span class="font-headline-md text-[16px] md:text-headline-md uppercase text-primary font-bold">{{ $question }}</span>
                            <span class="material-symbols-outlined text-primary faq-icon transition-transform duration-300 {{ $open ? '' : 'rotate-180' }}">expand_circle_up</span>
                        </button>
                        <div class="faq-content {{ $open ? '' : 'hidden' }} px-space-md md:px-space-lg pb-space-lg font-body-md text-body-md text-on-surface-variant leading-relaxed border-t border-outline-variant/40 pt-space-sm">
                            {{ $answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="w-full bg-primary text-on-primary py-space-xl px-margin md:px-margin-tablet lg:px-margin-desktop">
        <div class="max-w-[1440px] mx-auto flex flex-col lg:flex-row items-center justify-between gap-space-xl">
            <div class="flex flex-col gap-space-xs text-center lg:text-left">
                <span class="font-label-md text-label-md uppercase tracking-widest text-secondary-container">THE VAULT ARCHIVES</span>
                <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg uppercase tracking-tight text-on-primary">
                    TEMUKAN ARSIP VINTAGE BERIKUTNYA
                </h2>
                <p class="font-body-lg text-body-lg text-surface-container max-w-xl">
                    Drop katalog baru setiap {{ $storeSettings['drop_schedule'] }}. Setiap artikel hanya tersedia 1 potong di dunia (1-of-1).
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-space-md w-full lg:w-auto">
                <a class="w-full sm:w-auto bg-surface-container-lowest text-primary hover:bg-secondary-container transition-colors py-space-md px-space-xl text-center font-label-lg text-label-lg uppercase tracking-wider font-bold" href="{{ route('catalog') }}">
                    JELAJAHI KATALOG TERBARU
                </a>
                <a class="w-full sm:w-auto bg-secondary-container text-primary hover:bg-surface-container-lowest transition-colors py-space-md px-space-xl text-center font-label-lg text-label-lg uppercase tracking-wider font-bold flex items-center justify-center gap-space-xs" href="https://wa.me/{{ $storeSettings['whatsapp_clean'] }}" target="_blank" rel="noopener noreferrer">
                    <span class="material-symbols-outlined text-[20px]">chat</span>
                    <span>TANYA KURATOR VIA WA</span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    (function initVaultAccordion() {
        const container = document.getElementById('faq-accordion-container');
        if (!container) return;
        const toggles = container.querySelectorAll('.faq-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                const content = toggle.nextElementSibling;
                const icon = toggle.querySelector('.faq-icon');

                toggles.forEach(other => {
                    if (other !== toggle) {
                        other.setAttribute('aria-expanded', 'false');
                        other.nextElementSibling?.classList.add('hidden');
                        other.querySelector('.faq-icon')?.classList.add('rotate-180');
                    }
                });

                toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                if (content) content.classList.toggle('hidden', isExpanded);
                if (icon) icon.classList.toggle('rotate-180', isExpanded);
            });
        });
    })();
</script>
@endpush

