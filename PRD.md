# PRD — VAULT Curated Thrift

**Product Requirements Document · v1.0 · 12 November 2026** Web katalog thrift & archive streetwear dengan order via WhatsApp · Stack: PHP + MySQL + Laragon · Konteks: tugas kuliah

## 1. Ringkasan Produk

**VAULT Curated Thrift** adalah website etalase untuk toko thrift/vintage streetwear yang menjual barang **1-of-1** (setiap artikel hanya ada 1 pcs). Pembeli menelusuri katalog, melihat grade kondisi dan ukuran terukur dalam cm, lalu memesan lewat **WhatsApp** tanpa registrasi dan tanpa keranjang. Admin tunggal (kurator) mengelola produk, stok, dan log pesanan lewat konsol admin.

**Masalah yang diselesaikan**

- Pembeli thrift online sering ragu soal keaslian, kondisi, dan ukuran barang bekas.
- Penjual mencatat stok 1-of-1 secara manual di Instagram/WhatsApp, sehingga rawan dobel jual dan sulit dilacak.

**Tujuan produk**

1. Menampilkan katalog yang transparan: grade 1–10, ukuran cm, catatan minus, status tersedia/habis.
2. Mempercepat order lewat tombol WhatsApp dengan pesan yang terisi otomatis.
3. Memberi admin satu tempat untuk mengelola produk dan melacak pesanan dari “menunggu” sampai “selesai”.
4. Menjaga aturan 1-of-1: barang yang sudah lunas otomatis berstatus **HABIS**.

**Tujuan akademik:** mendemonstrasikan aplikasi web full-stack (CRUD, autentikasi, upload file, relasi database, filter/pagination) yang berjalan di Laragon.

## 2. Keputusan Teknologi: PHP Native atau Laravel?

**Rekomendasi saya: Laravel**, dengan dua pengecualian di bawah. Alasannya, desain ini butuh banyak fitur “standar” yang di Laravel sudah tersedia: login admin, validasi form, proteksi CSRF, upload gambar, pagination, filter query, migration dan seeder. Di PHP native semuanya harus dibangun sendiri, dan di situlah biasanya muncul celah keamanan serta waktu pengerjaan yang membengkak.

| Aspek | PHP Native | Laravel |
| --- | --- | --- |
| Kurva belajar | Rendah di awal, tapi kode makin berantakan saat fitur bertambah | Lebih curam di awal (routing, Blade, Eloquent, artisan), lalu cepat |
| Auth & password | Manual: `password_hash`, session, middleware buatan sendiri | Bawaan: `Auth`, hashing bcrypt, middleware |
| Keamanan (SQL injection, CSRF, XSS) | Harus diingat dan dikerjakan sendiri | Query builder/Eloquent, `@csrf`, Blade auto-escape |
| Upload & validasi | Manual | `FormRequest`, `Storage`, aturan validasi siap pakai |
| Pagination & filter | Manual (hitung offset, bangun query) | `paginate()`, query scope |
| Database & data demo | File SQL manual | Migration + Seeder + Factory (48 produk dummy dalam satu perintah) |
| Setup di Laragon | Taruh folder di `www` | Laragon punya Quick App → Laravel, otomatis `.test` virtual host |
| Nilai di mata dosen | Menunjukkan pemahaman dasar PHP | Menunjukkan pemahaman framework & MVC modern |
| Nilai di dunia kerja | Rendah | Tinggi |

**Pilih PHP Native jika:**

- Dosen/mata kuliah mewajibkan native (misalnya “Pemrograman Web” dasar), atau
- Kamu belum pernah memakai Laravel dan sisa waktu kurang dari sekitar 3 minggu.

Jika native, tetap gunakan **PDO + prepared statement**, struktur MVC sederhana (folder `controllers`, `models`, `views`), dan satu front controller (`public/index.php`) agar rapi.

**Pilih Laravel jika:** deadline lebih dari 3–4 minggu dan kamu mau hasil yang lebih aman, rapi, dan mudah didemokan.

**Stack yang diusulkan (versi Laravel)**

| Lapisan | Pilihan |
| --- | --- |
| Server lokal | Laragon (Apache/Nginx + MySQL + PHP + Composer + Node) |
| Backend | PHP 8.2+ dan Laravel versi stabil terbaru (sesuaikan dengan PHP di Laragon) |
| Database | MySQL |
| Frontend | Blade + Tailwind CSS (desain Stitch sudah memakai Tailwind, font Space Grotesk & Inter, ikon Material Symbols) |
| Interaktivitas | JavaScript biasa / Alpine.js untuk accordion, galeri, drawer |
| Cetak/ekspor | CSV bawaan PHP; PDF invoice opsional (dompdf) |

> Catatan: layar login admin pada desain menyebut “PHP Native REST API”. Itu hanya teks mockup dan bisa diganti sesuai stack yang kamu pilih. Fungsi PRD ini sama untuk kedua pilihan.

## 3. Pengguna

| Peran | Deskripsi | Kebutuhan utama |
| --- | --- | --- |
| **Pengunjung / Pembeli** | Anak muda 17–30 tahun, kolektor thrift, mengakses lewat HP | Cari barang cepat, lihat kondisi jujur, order tanpa ribet |
| **Admin (Super Admin / Kurator)** | 1 akun saja | Tambah/ubah produk, tandai terjual, pantau pesanan, balas lewat WhatsApp |

Tidak ada registrasi pembeli. Seluruh transaksi (negosiasi, pembayaran, resi) terjadi **di luar sistem**, lewat WhatsApp dan transfer bank. Sistem hanya mencatatnya.

## 4. Ruang Lingkup

### 4.1 Prioritas fitur (MoSCoW)

| Prioritas | Fitur |
| --- | --- |
| **Must** | Beranda, katalog + search + filter + sort + pagination, detail produk, tombol order WhatsApp, halaman Tentang Kami, login admin, CRUD produk + upload foto, tandai terjual, log pesanan + ubah status, aturan 1-of-1 otomatis, responsif mobile |
| **Should** | Tabel admin dengan filter dan aksi massal, statistik ringkas (kartu angka), kategori CRUD, pengaturan (nomor WA, rekening), ekspor CSV, produk terkait (“Padukan dengan koleksi ini”), seed data 48 produk |
| **Could** | Bookmark/wishlist (tersimpan di `localStorage`), cetak invoice PDF, label pengiriman cetak, polling status pesanan tiap 5 detik, jadwal drop, booking private fitting (arahkan ke WA), 2FA/TOTP admin |
| **Won’t (di luar tugas ini)** | WhatsApp Business API/webhook, payment gateway, keranjang & checkout, registrasi pembeli, notifikasi real-time, auto-backup, video inspeksi 360°, multi-admin, integrasi kurir otomatis |

### 4.2 Hal pada desain yang disederhanakan

- **WA Webhook & balasan otomatis** diganti tautan `https://wa.me/<nomor>?text=<pesan>`. Admin mencatat status secara manual.
- **MFA 6 digit & “1 seat exact”** dijadikan opsional. MVP cukup 1 akun admin dengan email + password (bcrypt).
- **Menu admin yang belum ada layarnya** (Dashboard Ringkasan, Kelola Stok & Drop, Kategori, Pengaturan & Bank) dibuat versi sederhana atau digabung. Lihat bagian 6.4.

## 5. Inventaris Halaman (dari Desain)

### 5.1 Halaman publik

| Halaman | Route | Isi utama sesuai desain |
| --- | --- | --- |
| Beranda | `/` | Ticker promo atas, navbar sticky (logo, search, menu, tombol “Tanya Admin”), hero “Curated Thrift & Archive Streetwear” + kotak pencarian + tag cepat, kartu highlight produk, 3 statistik, 4 kategori utama, “Koleksi Pilihan Kurator” (6 kartu), Manifesto 3 protokol, “Mengapa Kolektor Memilih VAULT”, CTA hotline WhatsApp, footer |
| Katalog Produk | `/katalog` | Judul + jumlah item, search, tab kategori, filter ukuran, status (Semua/Tersedia/Habis), rentang harga, urutan, reset, grid 4 kolom, pagination, banner “Asisten Ukuran & Arsip”, footer |
| Detail Produk | `/produk/{slug}` | Breadcrumb, galeri utama + thumbnail berlabel (Depan, Belakang, dst.), badge status, nama, harga, catatan 1-of-1, tombol “Pesan Cepat via WhatsApp”, kartu Kondisi & Grading, tabel ukuran, material, catatan minus, sanitasi, info pembayaran & pengiriman, “Padukan dengan koleksi ini”, bar CTA sticky di mobile |
| Tentang Kami | `/tentang-kami` | Manifesto, data operasional, 4 protokol kurasi, tim kurator, studio fisik + peta, FAQ accordion, CTA akhir |

### 5.2 Halaman admin

| Halaman | Route | Isi utama sesuai desain |
| --- | --- | --- |
| Login Admin | `/admin/login` | Email + password (+ opsional kode TOTP), “ingat sesi”, tombol masuk, tautan ke toko |
| Manajemen Produk & Inventaris | `/admin/produk` | 4 kartu statistik, search, tab kategori, filter status & urutan, tabel produk, aksi massal, form “Tambah Produk Baru” (upload foto, nama, kategori, harga, ukuran, grade, deskripsi, toggle status) |
| Pesanan & WA Log | `/admin/pesanan` | 3–4 kartu ringkasan, search, tab status, tabel pesanan, panel “Live Inspector” (detail pembeli, pesan WA, aksi cepat), bar aksi pesanan terpilih |

## 6. Kebutuhan Fungsional

### 6.1 Navigasi & elemen global

| ID | Kebutuhan |
| --- | --- |
| FR-01 | Ticker promo di bagian paling atas berisi teks statis dari pengaturan. |
| FR-02 | Navbar sticky (efek frosted glass): Beranda, Katalog Produk, Kategori (dropdown), Tentang Kami, tombol “Tanya Admin” yang membuka WhatsApp. |
| FR-03 | Kolom search di navbar mengirim kata kunci ke `/katalog?q=`. |
| FR-04 | Footer memuat kategori populer, bantuan, info pembayaran, jam operasional, dan alamat studio, diambil dari pengaturan. |
| FR-05 | Tampilan responsif: 2 kolom di mobile, 6 kolom di tablet, 12 kolom (maks 1440 px) di desktop. |

### 6.2 Beranda

| ID | Kebutuhan |
| --- | --- |
| FR-10 | Kotak pencarian hero + tag cepat (Semua, Vintage Tees, Workwear Jacket, Baggy Denim, Retro Sneakers) mengarah ke katalog dengan filter yang sesuai. |
| FR-11 | Kartu kategori menampilkan jumlah produk **tersedia** per kategori (dihitung dari database). |
| FR-12 | “Koleksi Pilihan Kurator” menampilkan 6 produk bertanda *featured* atau terbaru. Produk habis tampil abu-abu dengan label “HABIS TERJUAL” dan tautan “Cari Serupa di Katalog”. |
| FR-13 | Angka statistik (misal total pakaian) diambil dari database atau pengaturan. |

### 6.3 Katalog & detail produk

| ID | Kebutuhan |
| --- | --- |
| FR-20 | Katalog menampilkan 12 produk per halaman dengan pagination. |
| FR-21 | Filter: kata kunci (nama, brand, SKU), kategori, ukuran, status (Semua/Tersedia/Habis), rentang harga, dan urutan (Terbaru, Harga naik, Harga turun, Grade tertinggi). Filter bisa digabung dan tersimpan di query string. |
| FR-22 | Tombol “Reset” mengembalikan semua filter ke awal. |
| FR-23 | Kartu produk (rasio 3:4) menampilkan: badge kategori, grade, status, brand/era, nama, ukuran + ukuran cm singkat, harga, tombol “Detail” dan “Order WA”. Produk habis menampilkan harga dicoret dan tombol nonaktif. |
| FR-24 | Detail produk menampilkan galeri multi-foto (klik thumbnail mengganti foto utama), badge “Tersedia (hanya 1 pcs)” atau “Habis”, harga tetap (“Bett / Fixed Price”), dan catatan 1-of-1. |
| FR-25 | Tabel “Kondisi & Grading” memuat grade (angka desimal, contoh 9.2/10), ukuran tag asli, serta ukuran terukur (Panjang Badan, Lebar Dada/P2P, Panjang Lengan, Lebar Bahu, Pinggang, dst., menyesuaikan kategori). |
| FR-26 | Bagian material, catatan minus/karakter vintage, dan sanitasi tampil sebagai blok teks terpisah. |
| FR-27 | “Padukan dengan koleksi ini” menampilkan 4 produk lain dari kategori berbeda yang masih tersedia. |
| FR-28 | Slug produk unik. Produk yang tidak ditemukan menampilkan halaman 404 bergaya desain. |

### 6.4 Alur order via WhatsApp (inti produk)

| ID | Kebutuhan |
| --- | --- |
| FR-30 | Tombol “Pesan Cepat via WhatsApp” (dan “Order WA” di kartu) membuka form singkat: **nama, nomor WhatsApp, alamat pengiriman**. Tombol hanya aktif jika produk berstatus tersedia. |
| FR-31 | Setelah form dikirim, sistem menyimpan pesanan dengan status **Menunggu Konfirmasi** dan nomor unik (contoh `ORD-2026-0001`), lalu mengarahkan pembeli ke `wa.me` dengan pesan terisi otomatis. |
| FR-32 | Format pesan: sapaan, nama artikel, SKU, nama, alamat, serta permintaan info ketersediaan dan nomor rekening. |
| FR-33 | Membuat pesanan **tidak** mengunci stok. Beberapa orang boleh memesan produk yang sama. Pemenangnya ditentukan saat admin mengonfirmasi lunas (FR-52). |
| FR-34 | Pada tampilan mobile, detail produk memiliki bar sticky di bawah: harga di kiri, tombol WhatsApp di kanan. |

### 6.5 Tentang Kami

| ID | Kebutuhan |
| --- | --- |
| FR-40 | Konten (manifesto, protokol, tim, studio, jam buka) berupa konten statis di template Blade/PHP. |
| FR-41 | FAQ berbentuk accordion (buka-tutup tanpa reload). |
| FR-42 | Peta studio berupa embed Google Maps atau gambar statis, dan tombol “Jadwalkan Private Fitting” membuka WhatsApp. |

### 6.6 Admin: autentikasi

| ID | Kebutuhan |
| --- | --- |
| FR-50 | Login dengan email + password. Password disimpan dalam bentuk hash bcrypt. Semua route `/admin/*` (kecuali login) wajib terautentikasi. |
| FR-50a | Pembatasan percobaan login (misalnya 5 kali per menit) dan pesan error yang tidak membocorkan apakah email atau password yang salah. |
| FR-50b | Opsi “Ingat sesi”, dan tombol keluar di sidebar. *(Could: kode TOTP 6 digit.)* |

### 6.7 Admin: manajemen produk

| ID | Kebutuhan |
| --- | --- |
| FR-60 | Kartu statistik: total produk, stok tersedia, terjual/archived, estimasi nilai inventaris (jumlah harga produk tersedia). |
| FR-61 | Tabel produk: checkbox, thumbnail + badge grade, SKU + brand + nama + tanggal ditambah + drop, kategori, harga, ukuran + kondisi singkat, status, aksi (ubah, hapus, tandai terjual). Mendukung search, filter kategori/status, urutan, dan pagination. |
| FR-62 | Aksi massal pada baris terpilih: Tandai Terjual, Ubah Kategori, Hapus (dengan konfirmasi). |
| FR-63 | Form tambah/ubah produk: foto (minimal 1, JPG/PNG/WEBP, maks 5 MB per file untuk tugas ini, urutan dan label foto bisa diatur), nama, brand, era, kategori, harga, ukuran tag, ukuran terukur, grade (1–10, boleh desimal), material, deskripsi, catatan minus, status awal (toggle Tersedia). |
| FR-64 | SKU dibuat otomatis (format `VLT-0001`), tidak bisa diubah. Slug dibuat dari nama. |
| FR-65 | Ekspor daftar produk ke CSV. *(Could: JSON.)* |
| FR-66 | Hapus produk memakai *soft delete* bila produk sudah punya pesanan, agar riwayat tidak rusak. |

### 6.8 Admin: pesanan & log WhatsApp

| ID | Kebutuhan |
| --- | --- |
| FR-70 | Kartu ringkasan: total pesanan bulan ini, menunggu konfirmasi (jumlah + nominal), siap kirim (jumlah + nominal), selesai (jumlah + nominal). |
| FR-71 | Tabel pesanan: nomor + waktu relatif, pembeli + kontak + kota, artikel (thumbnail, SKU, nama, grade, ukuran), nominal + metode bayar, status. Dapat dicari (nomor, nama, no. WA, SKU) dan difilter per status. |
| FR-72 | Status pesanan: **Menunggu Konfirmasi → Lunas / Siap Kirim → Dalam Pengiriman → Selesai**, ditambah **Batal**. Setiap perubahan dicatat waktunya. |
| FR-73 | Panel “Live Inspector” menampilkan detail pembeli, ringkasan artikel, dan isi pesan WhatsApp yang dikirim, plus tombol “Buka WA” ke chat pembeli. |
| FR-74 | Aksi cepat: Konfirmasi Lunas (tandai produk terjual), isi kurir + nomor resi, “Kirim template resi via WA” (membuka `wa.me` dengan teks resi), dan *(Could)* cetak invoice PDF/label. |
| FR-75 | Ekspor rekap pesanan ke CSV. |
| FR-76 | *(Could)* Daftar pesanan memperbarui diri tiap 5 detik lewat polling AJAX. |

### 6.9 Admin: menu pendukung (belum ada layar desain)

| Menu | Versi sederhana yang diusulkan | Prioritas |
| --- | --- | --- |
| Dashboard Ringkasan | Menggabungkan kartu statistik produk dan pesanan dalam satu halaman | Should |
| Kategori | CRUD nama dan slug kategori | Should |
| Pengaturan & Bank | Nomor WA admin, alamat studio, jam operasional, teks ticker, daftar bank/QRIS | Should |
| Kelola Stok & Drop | Penanda “Drop #” pada produk dan jadwal drop berikutnya | Could |

## 7. Aturan Bisnis

1. **Aturan 1-of-1:** satu produk = 1 stok. Saat admin menekan “Konfirmasi Lunas”, status produk berubah menjadi **Habis/Terjual**, `sold_at` terisi, dan harga jual tersimpan. Produk langsung tampil sebagai HABIS di katalog.
2. Saat produk menjadi terjual, pesanan lain yang masih “Menunggu Konfirmasi” untuk produk itu otomatis berubah menjadi **Batal (item sudah terjual)**. Proses ini memakai transaksi database agar tidak ada dua pesanan lunas untuk satu produk.
3. Produk **Habis** tidak bisa dipesan, tetapi detailnya tetap bisa dilihat sebagai arsip.
4. Harga tetap (*fixed price*). Negosiasi terjadi di WhatsApp dan tidak dicatat di sistem.
5. Grade kondisi berskala 1–10 dengan satu angka desimal.
6. Format harga selalu `Rp 2.850.000` (pemisah titik, angka tabular, tebal).
7. Hanya ada satu akun admin (dibuat lewat seeder atau skrip), tidak ada pendaftaran publik.

## 8. Model Data

| Tabel | Kolom utama |
| --- | --- |
| `users` | id, name, email (unik), password (hash), remember_token, timestamps |
| `categories` | id, name, slug (unik), sort_order |
| `products` | id, sku (unik), slug (unik), name, brand, era, category_id (FK), price (int), size_label, measurements (JSON: p2p, panjang, bahu, lengan, pinggang, dll.), condition_grade (decimal 3,1), material, description, flaws, is_featured, status (`available`/`sold`), drop_batch, sold_at, sold_price, deleted_at, timestamps |
| `product_images` | id, product_id (FK), path, label (Depan/Belakang/…), sort_order |
| `orders` | id, order_no (unik), product_id (FK), buyer_name, buyer_phone, buyer_address, buyer_city, price_snapshot, payment_method (BCA/Mandiri/BNI/QRIS), status, courier, tracking_no, wa_message (text), timestamps |
| `order_status_logs` | id, order_id (FK), status, note, created_at |
| `settings` | key (unik), value (nomor WA, alamat, jam buka, ticker, rekening) |

**Relasi:** satu kategori memiliki banyak produk; satu produk memiliki banyak foto dan banyak pesanan; satu pesanan memiliki banyak log status.

Indeks yang disarankan: `products(status, category_id)`, `products(price)`, `orders(status, created_at)`.

## 9. Alur Utama

**Alur pembeli:** Beranda/Katalog → cari & filter → Detail Produk → tekan “Pesan via WhatsApp” → isi nama, no. WA, alamat → sistem simpan pesanan *Menunggu Konfirmasi* → buka WhatsApp dengan pesan otomatis → pembeli dan admin berbincang, bayar via transfer/QRIS.

**Alur admin:** Login → buka Pesanan & WA Log → pilih pesanan → cek pembayaran → **Konfirmasi Lunas** (produk jadi Habis, pesanan lain batal) → isi kurir + resi → status **Dalam Pengiriman** → setelah diterima, **Selesai**.

**Alur stok:** Admin Tambah Produk → upload foto + isi spesifikasi → toggle Tersedia → produk muncul di katalog.

## 10. Kebutuhan Non-Fungsional

| Kategori | Kebutuhan |
| --- | --- |
| Keamanan | Hash bcrypt, query berparameter (PDO/Eloquent), token CSRF di semua form POST, escape output (cegah XSS), validasi upload (tipe MIME, ekstensi, ukuran, nama file diacak), cookie sesi `HttpOnly` + `SameSite`, rate limit login |
| Performa | Halaman katalog termuat di bawah 2 detik pada jaringan lokal; gambar produk dikompres/diubah ukurannya; atribut `loading="lazy"` pada gambar |
| Responsif | Mobile-first; diuji di lebar 360 px, 768 px, dan 1280 px |
| Aksesibilitas | Kontras teks memadai, `alt` pada gambar, fokus input terlihat |
| SEO dasar | `<title>` dan meta description per halaman, URL ramah (slug) |
| Kompatibilitas | Chrome, Firefox, Edge, Safari versi terbaru |
| Keterpeliharaan | Struktur MVC, komponen tampilan dapat dipakai ulang (navbar, footer, product card), data demo lewat seeder |

## 11. Panduan Desain (Ringkasan DESIGN.md)

**Gaya:** *Kinetic Brutalist Editorial*. Kontras tinggi, garis hairline 1 px, sudut tajam, bernuansa katalog arsip.

| Elemen | Aturan |
| --- | --- |
| Warna | Primary `#0F0F11` (tombol utama, tipografi), Secondary `#E6FD52` acid lime (badge “Tersedia”, aksen, hover), Tertiary `#F97316` oranye (Habis, peringatan), Neutral `#71717A` (metadata), kanvas `#FFFFFF` dan `#F4F4F5` |
| Font | **Space Grotesk** untuk judul, label, harga, badge (sering huruf kapital); **Inter** untuk isi dan ukuran |
| Harga | Space Grotesk tebal 700, `font-variant-numeric: tabular-nums` |
| Bentuk | Radius **0 px** untuk semua tombol, badge, input, kartu. Lingkaran hanya untuk titik indikator stok |
| Elevasi | Tanpa bayangan lembut; kartu memakai border 1 px `#E4E4E7`. Elemen melayang memakai border hitam + bayangan keras `0 4px 0 #0F0F11` |
| Tombol utama | Latar hitam, teks putih kapital 12 px, hover menjadi lime dengan teks hitam |
| Tombol sekunder | Transparan, border 1 px hitam, hover `#F4F4F5` |
| Status Habis | Latar `#F4F4F5`, teks `#A1A1AA`, harga dicoret |
| Input | Border 1 px `#E4E4E7`; saat fokus berubah menjadi 1,5 px `#0F0F11` tanpa glow |
| Kartu produk | Rasio gambar 3:4, latar gambar `#F4F4F5`, badge grade di kiri atas |

Kode HTML dari Stitch (`code.html` tiap halaman) bisa dipakai langsung sebagai dasar template. Pecah menjadi layout dan komponen, lalu ganti data statis dengan data dari database.

## 12. Struktur Proyek & Setup Laragon

**Setup umum**

1. Install Laragon (Full), pastikan PHP 8.2+, MySQL, dan Composer aktif.
2. Buat database `vault_thrift` (HeidiSQL atau phpMyAdmin bawaan Laragon).
3. Atur `.env`/konfigurasi database, jalankan migration dan seeder (akun admin + kategori + 48 produk demo).
4. Akses lewat virtual host otomatis Laragon, misalnya `http://vault-thrift.test`.

**Jika Laravel:** Laragon → *Quick app* → Laravel, lalu `php artisan storage:link`. Struktur: `routes/web.php`, `app/Http/Controllers` (Home, Catalog, Product, Order, Admin/\*), `app/Models`, `resources/views` (layouts, components, pages, admin), `database/migrations` dan `seeders`.

**Jika native:** `public/` (index.php, aset, uploads), `app/Core` (Router, DB, Auth), `app/Controllers`, `app/Models`, `app/Views`, `config/`, `database/schema.sql` dan `seed.sql`, dengan `.htaccess` untuk URL ramah.

## 13. Rencana Pengerjaan (Saran 5 Minggu)

| Minggu | Target | Hasil |
| --- | --- | --- |
| 1 | Setup Laragon + proyek, ERD, migration/skema, seeder, layout dasar (navbar, footer, token desain) | Proyek berjalan, data demo terisi |
| 2 | Beranda, Katalog (search, filter, sort, pagination), Detail Produk | Sisi publik lengkap kecuali order |
| 3 | Login admin, CRUD produk + upload foto, tabel admin + aksi massal | Admin bisa mengelola produk |
| 4 | Alur order WhatsApp, Pesanan & WA Log, aturan 1-of-1, ekspor CSV | Alur bisnis inti selesai |
| 5 | Tentang Kami, pengaturan, perapian responsif, pengujian, dokumentasi, laporan | Siap demo dan dikumpulkan |

Jika waktu mepet, kerjakan semua **Must** dulu, lalu **Should**. **Could** hanya jika ada sisa waktu.

## 14. Kriteria Penerimaan (Contoh)

| Fitur | Kriteria |
| --- | --- |
| Filter katalog | Memilih kategori “Sepatu” + status “Tersedia” + urutan “Harga naik” hanya menampilkan sepatu tersedia dengan harga terurut naik, dan URL memuat parameter filter |
| Order WA | Mengisi form lalu menekan kirim menyimpan 1 pesanan berstatus Menunggu Konfirmasi dan membuka WhatsApp dengan nama artikel, SKU, nama, dan alamat pada teks |
| Aturan 1-of-1 | Setelah “Konfirmasi Lunas”, produk tampil HABIS di katalog dalam muat ulang berikutnya dan pesanan menunggu lain untuk produk itu menjadi Batal |
| Produk habis | Tombol order nonaktif dan harga tampil dicoret |
| Keamanan admin | Membuka `/admin/produk` tanpa login diarahkan ke `/admin/login`; 5 kali salah password memicu pembatasan sementara |
| Upload | File non-gambar atau lebih dari batas ukuran ditolak dengan pesan error jelas |
| Responsif | Katalog tampil 2 kolom di 360 px dan 4 kolom di 1280 px tanpa scroll horizontal |

**Pengujian:** uji manual berdasarkan tabel di atas (cukup untuk tugas kuliah). Nilai tambah: beberapa feature test untuk alur order dan aturan 1-of-1 jika memakai Laravel.

## 15. Risiko & Asumsi

| Risiko / asumsi | Mitigasi |
| --- | --- |
| Dua pembeli memesan barang yang sama | Pesanan tidak mengunci stok; keputusan di “Konfirmasi Lunas” memakai transaksi DB (aturan bisnis 2) |
| Scope terlalu besar untuk waktu kuliah | Patuhi MoSCoW; fitur Could boleh dibuang |
| Foto produk desain bersifat contoh dan memiliki hak cipta pihak lain | Untuk laporan dan demo, pakai foto sendiri atau gambar placeholder |
| Merek (Carhartt, Nike, dll.) pada data demo | Gunakan hanya sebagai contoh data fiktif untuk tugas akademik dan jangan dipublikasikan sebagai toko sungguhan |
| Nomor WhatsApp dan alamat pada desain adalah dummy | Ganti dengan nomor sendiri lewat halaman Pengaturan |
| Laragon dan versi PHP tidak cocok dengan versi Laravel | Cek persyaratan versi PHP Laravel sebelum membuat proyek, lalu ganti versi PHP lewat menu Laragon |

## 16. Deliverables Tugas Kuliah (Saran)

1. Source code + file database (dump SQL atau migration + seeder).
2. PRD ini (sebagai dokumen kebutuhan).
3. ERD dan diagram alur (use case/activity) bila diminta dosen.
4. Screenshot tiap halaman dan buku panduan singkat instalasi di Laragon.
5. Demo langsung: alur pembeli memesan → admin konfirmasi lunas → produk menjadi Habis.

