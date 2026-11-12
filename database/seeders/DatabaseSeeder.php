<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Single Super Admin Account
        User::updateOrCreate(
            ['email' => 'rian.kurator@vault.archive'],
            [
                'name' => 'Rian Kurator',
                'password' => Hash::make('vault2025'),
            ]
        );

        // 2. Store Settings
        $settings = [
            'ticker_text' => 'DROP BARU SETIAP JUMAT 19.00 WIB • 100% AUTHENTIC & SANITIZED • PENGIRIMAN KE SELURUH INDONESIA • ORDER CEPAT VIA WHATSAPP',
            'whatsapp_number' => '6281234567890',
            'studio_address' => 'Jl. Kemang Timur No. 42, Mampang Prapatan, Jakarta Selatan 12730',
            'operating_hours' => 'Senin - Minggu: 10:00 - 22:00 WIB',
            'drop_schedule' => 'Jumat 19:00 WIB',
            'bank_accounts' => "BCA 801-0982-119 a/n VAULT ARCHIVE INDONESIA\nMandiri 126-0091-8821 a/n VAULT ARCHIVE\nBNI 0892-1120-44 a/n VAULT ARCHIVE\nQRIS All-Pay Official Store",
            'instagram_handle' => '@vault.thrift',
            'total_archived_stat' => '1,200+',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 3. 4 Main Categories
        $categoriesData = [
            [
                'name' => 'Baju',
                'slug' => 'baju',
                'description' => 'Vintage Band Tees, Graphic T-Shirts, Retro Boxy Polos & Heavyweight Cotton.',
                'image_path' => 'images/stitch/cat-baju.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Celana',
                'slug' => 'celana',
                'description' => "Double Knee Carhartt, Tactical Cargo Pants, Levi's 501 & SilverTab Baggy.",
                'image_path' => 'images/stitch/cat-celana.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Sepatu',
                'slug' => 'sepatu',
                'description' => 'Retro Dunks, OG Sambas, Gorpcore Runners & Vintage Military Leather Boots.',
                'image_path' => 'images/stitch/cat-sepatu.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Jaket / Hoodie',
                'slug' => 'jaket-hoodie',
                'description' => 'Vintage Bomber, Harrington Classic, Heavyweight Zip Hoodie & Retro Tracktop.',
                'image_path' => 'images/stitch/cat-jaket.jpg',
                'sort_order' => 4,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. 48 Curated Products (18 Baju, 12 Celana, 8 Sepatu, 10 Jaket / Hoodie)
        $productsCatalog = [
            // --- FEATURED & HERO HIGHLIGHTS (6 items) ---
            [
                'sku' => 'VLT-0001',
                'name' => 'Carhartt Detroit Work Jacket J97 Vintage Moss Green',
                'brand' => 'Carhartt WIP Archive',
                'era' => '2000s USA',
                'cat' => 'jaket-hoodie',
                'price' => 2850000,
                'size' => 'M',
                'm' => ['panjang' => 66, 'lebar_dada' => 58, 'lengan' => 61, 'bahu' => 50],
                'grade' => 9.2,
                'tag' => 'NATURAL DISTRESS',
                'material' => '100% Heavyweight Cotton Duck Canvas (12 oz) dengan kerah corduroy cokelat gelap & blanket striped lining.',
                'desc' => 'Colorway langka Moss Green (MOS), blanket lined interior hangat, brass YKK zipper original lancar.',
                'flaws' => 'Fading alami halus di lipatan siku kanan-kiri khas pemakaian workwear, tanpa sobek atau lubang tembus.',
                'featured' => true,
                'status' => 'available',
                'drop' => 'Drop #14',
                'imgs' => ['images/stitch/carhartt-j97-main.jpg', 'images/stitch/carhartt-j97-front.jpg', 'images/stitch/carhartt-j97-back.jpg', 'images/stitch/carhartt-j97-collar.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                'img_labels' => ['Depan', 'Full View', 'Belakang', 'Corduroy', 'Tag Label'],
            ],
            [
                'sku' => 'VLT-0002',
                'name' => 'Vintage 1994 Nirvana In Utero Tour Tee',
                'brand' => 'Giant by Anvil',
                'era' => '1994 Vintage',
                'cat' => 'baju',
                'price' => 1450000,
                'size' => 'L',
                'm' => ['panjang' => 74, 'lebar_dada' => 56, 'bahu' => 52],
                'grade' => 9.2,
                'tag' => 'FADED WASH',
                'material' => '100% Heavyweight US Combed Cotton, Single Stitch lengan & kelim bawah.',
                'desc' => 'Single stitch original era 90-an, sablon plastisol cracking alami dengan wash charcoal merata.',
                'flaws' => 'Micro pinhole halus 2mm di area ketiak kiri belakang, tidak tembus pandang.',
                'featured' => true,
                'status' => 'available',
                'drop' => 'Drop #14',
                'imgs' => ['images/stitch/nirvana-tee.jpg', 'images/stitch/nirvana-tee-2.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
            [
                'sku' => 'VLT-0003',
                'name' => 'Nike Dunk Low Retro White Black Panda (2021)',
                'brand' => 'Nike Sportswear',
                'era' => '2021 Release',
                'cat' => 'sepatu',
                'price' => 1250000,
                'size' => '42',
                'm' => ['insole' => '26.5', 'outsole' => '28.5'],
                'grade' => 9.5,
                'tag' => 'VNDS LIKE NEW',
                'material' => 'Full-grain tumbled leather upper dengan sol karet cupsole klasik.',
                'desc' => 'Lengkap dengan replacement box, insole mulus tanpa tapak, bintang outsole tebal 98%.',
                'flaws' => 'Creasing ringan wajar pada area toebox sebelah kiri.',
                'featured' => true,
                'status' => 'available',
                'drop' => 'Drop #14',
                'imgs' => ['images/stitch/dunk-panda.jpg', 'images/stitch/cat-sepatu.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
            [
                'sku' => 'VLT-0004',
                'name' => "Levi's SilverTab Loose Fit Baggy Denim 90s",
                'brand' => "Levi's Vintage",
                'era' => '1990s Archive',
                'cat' => 'celana',
                'price' => 850000,
                'size' => '32',
                'm' => ['panjang' => 104, 'pinggang' => 84, 'open_leg' => 23],
                'grade' => 9.3,
                'tag' => 'ORIGINAL HEM',
                'material' => '100% Heavyweight Non-Stretch Stone-Washed Cotton Denim (14 oz).',
                'desc' => 'Potongan skate loose 90s otentik, light stone wash dengan hem asli belum dipotong.',
                'flaws' => 'Heel drag sangat tipis di bagian tumit bawah, tidak robek.',
                'featured' => true,
                'status' => 'available',
                'drop' => 'Drop #13',
                'imgs' => ['images/stitch/levis-silvertab.jpg', 'images/stitch/levis-501.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
            [
                'sku' => 'VLT-0005',
                'name' => 'Stussy 8 Ball Heavyweight Mohair Knit Sweater',
                'brand' => 'Stüssy Worldwide',
                'era' => 'Archive Knit',
                'cat' => 'jaket-hoodie',
                'price' => 1950000,
                'size' => 'L',
                'm' => ['panjang' => 70, 'lebar_dada' => 60, 'lengan' => 63, 'bahu' => 54],
                'grade' => 9.8,
                'tag' => 'WITH TAG',
                'material' => 'Mohair wool blend brushed knit, tekstur lembut tidak gatal.',
                'desc' => 'Grafis 8-Ball jacquard di punggung ikonik, kondisi mint lengkap price tag asli.',
                'flaws' => 'Tidak ada minus berarti (mendekati baru / unworn condition).',
                'featured' => true,
                'status' => 'available',
                'drop' => 'Drop #13',
                'imgs' => ['images/stitch/stussy-mohair.jpg', 'images/stitch/stussy-mohair-2.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
            [
                'sku' => 'VLT-0006',
                'name' => "Arc'teryx Beta LT GORE-TEX Mountain Jacket Black",
                'brand' => "Arc'teryx Technical",
                'era' => 'Gorpcore Archive',
                'cat' => 'jaket-hoodie',
                'price' => 3900000,
                'size' => 'XL',
                'm' => ['panjang' => 76, 'lebar_dada' => 64, 'lengan' => 66, 'bahu' => 53],
                'grade' => 9.0,
                'tag' => 'GORE-TEX 3L',
                'material' => 'N40d 3L GORE-TEX fabric dengan DWR waterproof treatment & WaterTight zippers.',
                'desc' => 'Waterproof membrane aktif, seam sealed utuh tanpa delaminasi.',
                'flaws' => 'Sedikit tanda pemakaian di dalam kerah dagu, sudah dibersihkan menyeluruh.',
                'featured' => true,
                'status' => 'sold',
                'drop' => 'Drop #12',
                'imgs' => ['images/stitch/arcteryx-black.jpg', 'images/stitch/arcteryx-beta-2.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],

            // --- ADDITIONAL BAJU (17 more -> total 18 Baju) ---
            ['sku' => 'VLT-0007', 'name' => 'Vintage 1994 Metallica Master of Puppets Tee', 'brand' => 'Brockum Worldwide', 'era' => '1994 Tour', 'cat' => 'baju', 'price' => 1250000, 'size' => 'L', 'm' => ['panjang' => 74, 'lebar_dada' => 57, 'bahu' => 53], 'grade' => 9.5, 'tag' => 'SINGLE STITCH', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0008', 'name' => 'Vintage 1996 Oasis Knebworth Park Tour Tee', 'brand' => 'Screen Stars', 'era' => '1996 UK', 'cat' => 'baju', 'price' => 1100000, 'size' => 'M', 'm' => ['panjang' => 71, 'lebar_dada' => 53, 'bahu' => 49], 'grade' => 8.9, 'tag' => 'SUN FADED', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0009', 'name' => 'Stussy World Tour 90s Boxy Heavyweight Tee', 'brand' => 'Stüssy USA', 'era' => 'Late 90s', 'cat' => 'baju', 'price' => 650000, 'size' => 'L', 'm' => ['panjang' => 73, 'lebar_dada' => 58, 'bahu' => 52], 'grade' => 9.0, 'tag' => 'MADE IN USA', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0010', 'name' => 'Akira Tetsuo Manga Bootleg Print Archive Tee', 'brand' => 'Anarchic Adjustment', 'era' => '2000s Archive', 'cat' => 'baju', 'price' => 1650000, 'size' => 'XL', 'm' => ['panjang' => 76, 'lebar_dada' => 61, 'bahu' => 55], 'grade' => 9.1, 'tag' => 'RARE GRAPHIC', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0011', 'name' => 'Harley Davidson Flame Eagle 1998 Double Sided Tee', 'brand' => 'Hanes Beefy-T', 'era' => '1998 USA', 'cat' => 'baju', 'price' => 780000, 'size' => 'XL', 'm' => ['panjang' => 75, 'lebar_dada' => 60, 'bahu' => 56], 'grade' => 8.8, 'tag' => 'DOUBLE SIDED', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0012', 'name' => 'A Bathing Ape BAPE OG Ape Head Camo Tee', 'brand' => 'Nigo Era BAPE', 'era' => '2004 Japan', 'cat' => 'baju', 'price' => 920000, 'size' => 'M', 'm' => ['panjang' => 70, 'lebar_dada' => 52, 'bahu' => 48], 'grade' => 9.3, 'tag' => 'JAPAN ARCHIVE', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0013', 'name' => 'Nike ACG Vintage 1999 Trail Graphic Pocket Tee', 'brand' => 'Nike ACG', 'era' => '1999 OG', 'cat' => 'baju', 'price' => 480000, 'size' => 'L', 'm' => ['panjang' => 72, 'lebar_dada' => 56, 'bahu' => 51], 'grade' => 9.0, 'tag' => 'GORPCORE', 'status' => 'available', 'drop' => 'Drop #12'],
            ['sku' => 'VLT-0014', 'name' => 'Number (N)ine School of Visual Comedy Tee', 'brand' => 'Number (N)ine', 'era' => 'A/W 2002', 'cat' => 'baju', 'price' => 2100000, 'size' => 'M', 'm' => ['panjang' => 68, 'lebar_dada' => 52, 'bahu' => 47], 'grade' => 9.4, 'tag' => 'JAPAN ARCHIVE', 'status' => 'available', 'drop' => 'Drop #12'],
            ['sku' => 'VLT-0015', 'name' => 'Radiohead OK Computer 1997 Tour Charcoal Tee', 'brand' => 'W.A.S.T.E.', 'era' => '1997 UK', 'cat' => 'baju', 'price' => 1750000, 'size' => 'L', 'm' => ['panjang' => 73, 'lebar_dada' => 55, 'bahu' => 50], 'grade' => 8.7, 'tag' => 'SINGLE STITCH', 'status' => 'available', 'drop' => 'Drop #12'],
            ['sku' => 'VLT-0016', 'name' => 'Ralph Lauren Polo Bear 90s Vintage Knit Polo', 'brand' => 'Polo Ralph Lauren', 'era' => '1990s', 'cat' => 'baju', 'price' => 890000, 'size' => 'L', 'm' => ['panjang' => 74, 'lebar_dada' => 57, 'bahu' => 50], 'grade' => 9.4, 'tag' => 'VINTAGE MINT', 'status' => 'available', 'drop' => 'Drop #11'],
            ['sku' => 'VLT-0017', 'name' => 'Supreme Motion Logo Boxy Tee Heather Ash', 'brand' => 'Supreme NYC', 'era' => 'SS16', 'cat' => 'baju', 'price' => 1150000, 'size' => 'M', 'm' => ['panjang' => 71, 'lebar_dada' => 54, 'bahu' => 48], 'grade' => 9.2, 'tag' => 'CLEAN PRINT', 'status' => 'available', 'drop' => 'Drop #11'],
            ['sku' => 'VLT-0018', 'name' => 'Carhartt K87 Heavyweight Pocket Tee Burnt Olive', 'brand' => 'Carhartt', 'era' => '2000s', 'cat' => 'baju', 'price' => 380000, 'size' => 'XL', 'm' => ['panjang' => 78, 'lebar_dada' => 63, 'bahu' => 56], 'grade' => 9.1, 'tag' => 'WORKWEAR', 'status' => 'available', 'drop' => 'Drop #11'],
            ['sku' => 'VLT-0019', 'name' => 'Vintage 1992 Soundgarden Badmotorfinger Tee', 'brand' => 'Brockum', 'era' => '1992 USA', 'cat' => 'baju', 'price' => 1550000, 'size' => 'L', 'm' => ['panjang' => 73, 'lebar_dada' => 56, 'bahu' => 52], 'grade' => 8.6, 'tag' => 'GRUNGE ERA', 'status' => 'sold', 'drop' => 'Drop #10'],
            ['sku' => 'VLT-0020', 'name' => 'Stone Island Shadow Project Patch Tee Black', 'brand' => 'Stone Island', 'era' => '2018', 'cat' => 'baju', 'price' => 1350000, 'size' => 'M', 'm' => ['panjang' => 70, 'lebar_dada' => 53, 'bahu' => 47], 'grade' => 9.5, 'tag' => 'CERTILOGO OK', 'status' => 'available', 'drop' => 'Drop #10'],
            ['sku' => 'VLT-0021', 'name' => 'Palace Skateboards Tri-Ferg 2015 White Tee', 'brand' => 'Palace London', 'era' => '2015 OG', 'cat' => 'baju', 'price' => 680000, 'size' => 'S', 'm' => ['panjang' => 68, 'lebar_dada' => 49, 'bahu' => 45], 'grade' => 9.0, 'tag' => 'SKATE ARCHIVE', 'status' => 'available', 'drop' => 'Drop #10'],
            ['sku' => 'VLT-0022', 'name' => 'Champion Reverse Weave 90s Script Tee Navy', 'brand' => 'Champion USA', 'era' => '1990s', 'cat' => 'baju', 'price' => 420000, 'size' => 'L', 'm' => ['panjang' => 72, 'lebar_dada' => 57, 'bahu' => 52], 'grade' => 9.3, 'tag' => 'HEAVY COTTON', 'status' => 'available', 'drop' => 'Drop #09'],
            ['sku' => 'VLT-0023', 'name' => 'Undercoverism Giz Pattern Longsleeve Archive', 'brand' => 'Undercover', 'era' => 'AW05', 'cat' => 'baju', 'price' => 1850000, 'size' => 'M', 'm' => ['panjang' => 69, 'lebar_dada' => 52, 'bahu' => 46], 'grade' => 9.1, 'tag' => 'JUN TAKAHASHI', 'status' => 'sold', 'drop' => 'Drop #09'],

            // --- ADDITIONAL CELANA (11 more -> total 12 Celana) ---
            ['sku' => 'VLT-0024', 'name' => 'Carhartt Double Knee Carpenter Pant Tan Duck', 'brand' => 'Carhartt WIP', 'era' => '2000s', 'cat' => 'celana', 'price' => 950000, 'size' => '32', 'm' => ['panjang' => 104, 'pinggang' => 84, 'open_leg' => 22], 'grade' => 9.0, 'tag' => 'PAINT PATINA', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0025', 'name' => "Levi's 501 Made in USA 1996 Light Indigo", 'brand' => "Levi's USA", 'era' => '1996', 'cat' => 'celana', 'price' => 980000, 'size' => '31', 'm' => ['panjang' => 102, 'pinggang' => 80, 'open_leg' => 20], 'grade' => 9.1, 'tag' => 'MADE IN USA', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0026', 'name' => 'Dickies 874 Original Work Pant Charcoal 90s', 'brand' => 'Dickies USA', 'era' => '1990s', 'cat' => 'celana', 'price' => 450000, 'size' => '32', 'm' => ['panjang' => 103, 'pinggang' => 83, 'open_leg' => 22], 'grade' => 9.4, 'tag' => 'DEADSTOCK', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0027', 'name' => 'US Army M65 Field Cargo Trousers Olive Drab', 'brand' => 'US Military Issue', 'era' => '1970s', 'cat' => 'celana', 'price' => 1350000, 'size' => '30', 'm' => ['panjang' => 101, 'pinggang' => 78, 'open_leg' => 24], 'grade' => 8.9, 'tag' => 'MILITARY SPEC', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0028', 'name' => 'Polar Skate Co. Big Boy Jeans Washed Black', 'brand' => 'Polar Skate', 'era' => '2020', 'cat' => 'celana', 'price' => 1100000, 'size' => '34', 'm' => ['panjang' => 106, 'pinggang' => 88, 'open_leg' => 24], 'grade' => 9.5, 'tag' => 'BAGGY SKATE', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0029', 'name' => 'Evisu Lot 2000 No. 2 Raw Selvedge Daicock', 'brand' => 'Evisu Japan', 'era' => '2000s', 'cat' => 'celana', 'price' => 1650000, 'size' => '32', 'm' => ['panjang' => 105, 'pinggang' => 84, 'open_leg' => 21], 'grade' => 9.2, 'tag' => 'SELVEDGE', 'status' => 'available', 'drop' => 'Drop #12'],
            ['sku' => 'VLT-0030', 'name' => 'Nike ACG Smith Summit Convertible Cargo Pant', 'brand' => 'Nike ACG', 'era' => '2021', 'cat' => 'celana', 'price' => 1250000, 'size' => '30', 'm' => ['panjang' => 100, 'pinggang' => 78, 'open_leg' => 21], 'grade' => 9.6, 'tag' => '2-IN-1 CARGO', 'status' => 'available', 'drop' => 'Drop #12'],
            ['sku' => 'VLT-0031', 'name' => 'Stone Island Cargo Trousers Garment Dyed', 'brand' => 'Stone Island', 'era' => '2019', 'cat' => 'celana', 'price' => 2450000, 'size' => '32', 'm' => ['panjang' => 102, 'pinggang' => 84, 'open_leg' => 18], 'grade' => 9.3, 'tag' => 'COMPASS BADGE', 'status' => 'sold', 'drop' => 'Drop #11'],
            ['sku' => 'VLT-0032', 'name' => 'Carhartt B01 Double Front Black Washed Duck', 'brand' => 'Carhartt USA', 'era' => '2000s', 'cat' => 'celana', 'price' => 980000, 'size' => '34', 'm' => ['panjang' => 106, 'pinggang' => 89, 'open_leg' => 23], 'grade' => 8.8, 'tag' => 'FADED BLACK', 'status' => 'available', 'drop' => 'Drop #11'],
            ['sku' => 'VLT-0033', 'name' => 'Undercoverism Arts & Crafts Multi-Zip Cargo', 'brand' => 'Undercover', 'era' => 'AW05', 'cat' => 'celana', 'price' => 4200000, 'size' => '30', 'm' => ['panjang' => 103, 'pinggang' => 78, 'open_leg' => 19], 'grade' => 9.4, 'tag' => 'GRAIL ARCHIVE', 'status' => 'sold', 'drop' => 'Drop #10'],
            ['sku' => 'VLT-0034', 'name' => "Levi's 550 Relaxed Tapered 90s Acid Wash", 'brand' => "Levi's", 'era' => '1993', 'cat' => 'celana', 'price' => 620000, 'size' => '36', 'm' => ['panjang' => 107, 'pinggang' => 92, 'open_leg' => 21], 'grade' => 9.0, 'tag' => '90S RELAXED', 'status' => 'available', 'drop' => 'Drop #09'],

            // --- ADDITIONAL SEPATU (7 more -> total 8 Sepatu) ---
            ['sku' => 'VLT-0035', 'name' => 'Adidas Samba OG White Black Gum Classic', 'brand' => 'Adidas Originals', 'era' => 'OG Release', 'cat' => 'sepatu', 'price' => 1150000, 'size' => '42', 'm' => ['insole' => '26.5', 'outsole' => '28.0'], 'grade' => 9.8, 'tag' => 'BOX ASLI', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0036', 'name' => 'New Balance 990v3 Made in USA Heritage Grey', 'brand' => 'New Balance', 'era' => 'Made in USA', 'cat' => 'sepatu', 'price' => 1750000, 'size' => '43', 'm' => ['insole' => '27.5', 'outsole' => '29.5'], 'grade' => 9.0, 'tag' => 'USA SUEDE', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0037', 'name' => 'Nike Dunk Low Vintage Olive Sail (2022)', 'brand' => 'Nike', 'era' => '2022', 'cat' => 'sepatu', 'price' => 1850000, 'size' => '42.5', 'm' => ['insole' => '27.0', 'outsole' => '29.0'], 'grade' => 9.4, 'tag' => 'CLEAN PAIR', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0038', 'name' => 'Salomon XT-6 Gore-Tex Lunar Rock Black', 'brand' => 'Salomon Advanced', 'era' => '2023', 'cat' => 'sepatu', 'price' => 2350000, 'size' => '41', 'm' => ['insole' => '26.0', 'outsole' => '28.5'], 'grade' => 9.5, 'tag' => 'GORPCORE', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0039', 'name' => 'Asics Gel-Kayano 14 Cream Metallic Plum', 'brand' => 'Asics SportStyle', 'era' => '2023', 'cat' => 'sepatu', 'price' => 1950000, 'size' => '44', 'm' => ['insole' => '28.0', 'outsole' => '30.5'], 'grade' => 9.6, 'tag' => 'Y2K RUNNER', 'status' => 'available', 'drop' => 'Drop #12'],
            ['sku' => 'VLT-0040', 'name' => 'Dr. Martens 1461 Made in England Vintage Oxblood', 'brand' => 'Dr. Martens MIE', 'era' => '1990s UK', 'cat' => 'sepatu', 'price' => 1450000, 'size' => '42', 'm' => ['insole' => '26.8', 'outsole' => '29.2'], 'grade' => 8.9, 'tag' => 'MADE IN UK', 'status' => 'sold', 'drop' => 'Drop #11'],
            ['sku' => 'VLT-0041', 'name' => 'Adidas Gazelle Indoor Collegiate Green Gum', 'brand' => 'Adidas Originals', 'era' => '2023', 'cat' => 'sepatu', 'price' => 1050000, 'size' => '40', 'm' => ['insole' => '25.0', 'outsole' => '27.0'], 'grade' => 9.3, 'tag' => 'SUEDE MINT', 'status' => 'available', 'drop' => 'Drop #10'],

            // --- ADDITIONAL JAKET / HOODIE (7 more -> total 10 Jaket / Hoodie) ---
            ['sku' => 'VLT-0042', 'name' => 'Supreme Box Logo Crewneck Heather Grey FW18', 'brand' => 'Supreme NYC', 'era' => 'FW18', 'cat' => 'jaket-hoodie', 'price' => 3800000, 'size' => 'M', 'm' => ['panjang' => 69, 'lebar_dada' => 58, 'lengan' => 62, 'bahu' => 49], 'grade' => 9.0, 'tag' => 'CROSSGRAIN', 'status' => 'sold', 'drop' => 'Drop #12'],
            ['sku' => 'VLT-0043', 'name' => 'Ralph Lauren Polo Harrington Jacket Navy', 'brand' => 'Polo Ralph Lauren', 'era' => '1990s', 'cat' => 'jaket-hoodie', 'price' => 1150000, 'size' => 'L', 'm' => ['panjang' => 67, 'lebar_dada' => 60, 'lengan' => 63, 'bahu' => 51], 'grade' => 9.4, 'tag' => 'TARTAN LINING', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0044', 'name' => 'Carhartt Active Jacket J130 Washed Black', 'brand' => 'Carhartt USA', 'era' => '2000s', 'cat' => 'jaket-hoodie', 'price' => 1950000, 'size' => 'L', 'm' => ['panjang' => 70, 'lebar_dada' => 63, 'lengan' => 64, 'bahu' => 53], 'grade' => 9.1, 'tag' => 'QUILTED LINED', 'status' => 'available', 'drop' => 'Drop #14'],
            ['sku' => 'VLT-0045', 'name' => 'The North Face 1996 Retro Nuptse 700 Black', 'brand' => 'The North Face', 'era' => 'Archive 700', 'cat' => 'jaket-hoodie', 'price' => 2650000, 'size' => 'M', 'm' => ['panjang' => 66, 'lebar_dada' => 59, 'lengan' => 62, 'bahu' => 50], 'grade' => 9.3, 'tag' => 'PUFFER 700', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0046', 'name' => 'Champion Reverse Weave 90s Crimson Hoodie', 'brand' => 'Champion USA', 'era' => '1990s', 'cat' => 'jaket-hoodie', 'price' => 790000, 'size' => 'XL', 'm' => ['panjang' => 72, 'lebar_dada' => 64, 'lengan' => 64, 'bahu' => 54], 'grade' => 8.9, 'tag' => 'USA TAG', 'status' => 'available', 'drop' => 'Drop #13'],
            ['sku' => 'VLT-0047', 'name' => 'Alpha Industries MA-1 Flight Bomber Sage Green', 'brand' => 'Alpha Industries', 'era' => '1990s USA', 'cat' => 'jaket-hoodie', 'price' => 1350000, 'size' => 'L', 'm' => ['panjang' => 65, 'lebar_dada' => 61, 'lengan' => 63, 'bahu' => 50], 'grade' => 9.2, 'tag' => 'REVERSIBLE', 'status' => 'sold', 'drop' => 'Drop #11'],
            ['sku' => 'VLT-0048', 'name' => 'Stone Island Garment Dyed Crinkle Reps Overshirt', 'brand' => 'Stone Island', 'era' => '2020', 'cat' => 'jaket-hoodie', 'price' => 3450000, 'size' => 'L', 'm' => ['panjang' => 73, 'lebar_dada' => 58, 'lengan' => 64, 'bahu' => 49], 'grade' => 9.5, 'tag' => 'COMPASS BADGE', 'status' => 'sold', 'drop' => 'Drop #10'],
        ];

        $defaultImgsByCat = [
            'baju' => [
                ['images/stitch/metallica-tee.jpg', 'images/stitch/nirvana-tee.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/bape-tee.jpg', 'images/stitch/cat-baju.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/nirvana-tee-2.jpg', 'images/stitch/metallica-tee.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
            'celana' => [
                ['images/stitch/carhartt-doubleknee.jpg', 'images/stitch/levis-501.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/levis-501.jpg', 'images/stitch/levis-silvertab.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/undercover-cargo.jpg', 'images/stitch/cat-celana.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
            'sepatu' => [
                ['images/stitch/adidas-samba.jpg', 'images/stitch/cat-sepatu.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/nb-990v3.jpg', 'images/stitch/dunk-olive.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/jordan-shadow.jpg', 'images/stitch/dunk-panda.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
            'jaket-hoodie' => [
                ['images/stitch/ralph-harrington.jpg', 'images/stitch/cat-jaket.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/supreme-bogo.jpg', 'images/stitch/stussy-mohair-2.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
                ['images/stitch/arcteryx-beta-2.jpg', 'images/stitch/carhartt-j97-main.jpg', 'images/stitch/carhartt-j97-tag.jpg'],
            ],
        ];

        $createdProducts = [];
        foreach ($productsCatalog as $idx => $item) {
            $category = $categories[$item['cat']];
            $isSold = ($item['status'] ?? 'available') === 'sold';

            $product = Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'slug' => Str::slug($item['name']),
                    'name' => $item['name'],
                    'brand' => $item['brand'],
                    'era' => $item['era'],
                    'category_id' => $category->id,
                    'price' => $item['price'],
                    'size_label' => $item['size'],
                    'measurements' => $item['m'],
                    'condition_grade' => $item['grade'],
                    'condition_tag' => $item['tag'],
                    'material' => $item['material'] ?? 'Material arsip original era terkait, konstruksi jahitan kokoh dan terverifikasi.',
                    'description' => $item['desc'] ?? "Artikel kurasi 1-of-1 dari {$item['brand']} ({$item['era']}). Telah melewati autentikasi fisik & pengukuran presisi.",
                    'flaws' => $item['flaws'] ?? 'Kondisi sangat baik dengan patina alami usia vintage tanpa cacat struktural.',
                    'sanitation_note' => 'Telah melalui dry-cleaning ramah serat kain & sterilisasi uap ozone suhu tinggi 100°C (higienis & siap pakai).',
                    'is_featured' => $item['featured'] ?? false,
                    'status' => $isSold ? Product::STATUS_SOLD : Product::STATUS_AVAILABLE,
                    'drop_batch' => $item['drop'],
                    'sold_at' => $isSold ? now()->subDays(rand(1, 14)) : null,
                    'sold_price' => $isSold ? $item['price'] : null,
                ]
            );

            $createdProducts[$item['sku']] = $product;

            if ($product->images()->count() === 0) {
                $catPool = $defaultImgsByCat[$item['cat']];
                $imgs = $item['imgs'] ?? $catPool[$idx % count($catPool)];
                $labels = $item['img_labels'] ?? ['Depan', 'Detail', 'Tag Label', 'Patina'];
                foreach ($imgs as $imgIndex => $imgPath) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $imgPath,
                        'label' => $labels[$imgIndex] ?? 'Detail',
                        'sort_order' => $imgIndex,
                    ]);
                }
            }
        }

        // 5. Sample Orders & Status Logs
        if (Order::count() === 0) {
            $sampleOrders = [
                [
                    'order_no' => 'ORD-2026-0001',
                    'sku' => 'VLT-0001',
                    'buyer_name' => 'Dimas Aditya',
                    'buyer_phone' => '081288992101',
                    'buyer_address' => 'Jl. Gandaria 1 No. 12, Kebayoran Baru',
                    'buyer_city' => 'Jakarta Selatan',
                    'payment_method' => 'BCA',
                    'status' => Order::STATUS_PENDING,
                    'courier' => null,
                    'tracking_no' => null,
                    'hours_ago' => 1,
                ],
                [
                    'order_no' => 'ORD-2026-0002',
                    'sku' => 'VLT-0037',
                    'buyer_name' => 'Bagus Prakoso',
                    'buyer_phone' => '087811229011',
                    'buyer_address' => 'Perum Citraland Blok F2 No. 8',
                    'buyer_city' => 'Surabaya Barat',
                    'payment_method' => 'QRIS',
                    'status' => Order::STATUS_PENDING,
                    'courier' => null,
                    'tracking_no' => null,
                    'hours_ago' => 3,
                ],
                [
                    'order_no' => 'ORD-2026-0003',
                    'sku' => 'VLT-0006',
                    'buyer_name' => 'Jessica Tan',
                    'buyer_phone' => '081192334011',
                    'buyer_address' => 'Jl. Riau No. 45, Citarum',
                    'buyer_city' => 'Bandung Kota',
                    'payment_method' => 'Mandiri',
                    'status' => Order::STATUS_PAID,
                    'courier' => 'JNE YES',
                    'tracking_no' => null,
                    'hours_ago' => 8,
                ],
                [
                    'order_no' => 'ORD-2026-0004',
                    'sku' => 'VLT-0033',
                    'buyer_name' => 'Reza Gunawan',
                    'buyer_phone' => '082144332211',
                    'buyer_address' => 'Bintaro Jaya Sektor 9 Jl. Maleo',
                    'buyer_city' => 'Tangerang Selatan',
                    'payment_method' => 'BCA',
                    'status' => Order::STATUS_DONE,
                    'courier' => 'SiCepat Best',
                    'tracking_no' => 'SCP-0029182734',
                    'hours_ago' => 48,
                ],
                [
                    'order_no' => 'ORD-2026-0005',
                    'sku' => 'VLT-0042',
                    'buyer_name' => 'Naufal Hakim',
                    'buyer_phone' => '085299103344',
                    'buyer_address' => 'Jl. Kaliurang KM 6.5 No. 19',
                    'buyer_city' => 'Yogyakarta',
                    'payment_method' => 'BNI',
                    'status' => Order::STATUS_SHIPPING,
                    'courier' => 'JNE YES',
                    'tracking_no' => 'JNE-019928381920',
                    'hours_ago' => 22,
                ],
                [
                    'order_no' => 'ORD-2026-0006',
                    'sku' => 'VLT-0006',
                    'buyer_name' => 'Kevin Wijaya',
                    'buyer_phone' => '081377665544',
                    'buyer_address' => 'Jl. Thamrin Residence Tower B',
                    'buyer_city' => 'Jakarta Pusat',
                    'payment_method' => 'BCA',
                    'status' => Order::STATUS_CANCELLED,
                    'courier' => null,
                    'tracking_no' => null,
                    'hours_ago' => 9,
                ],
            ];

            foreach ($sampleOrders as $so) {
                $prod = $createdProducts[$so['sku']] ?? null;
                if (!$prod) {
                    continue;
                }

                $waMsg = implode("\n", [
                    'Halo Admin VAULT Curated Thrift!',
                    'Saya ingin memesan artikel archive 1-of-1:',
                    "• No. Order: {$so['order_no']}",
                    "• Artikel: {$prod->name} ({$prod->size_label})",
                    "• SKU: {$prod->sku}",
                    "• Harga: {$prod->formatted_price}",
                    "• Nama: {$so['buyer_name']}",
                    "• No. WA: {$so['buyer_phone']}",
                    "• Alamat: {$so['buyer_address']}, {$so['buyer_city']}",
                    '',
                    'Mohon info ketersediaan & nomor rekening transfer. Terima kasih!',
                ]);

                $createdAt = now()->subHours($so['hours_ago']);
                $order = Order::create([
                    'order_no' => $so['order_no'],
                    'product_id' => $prod->id,
                    'buyer_name' => $so['buyer_name'],
                    'buyer_phone' => $so['buyer_phone'],
                    'buyer_address' => $so['buyer_address'],
                    'buyer_city' => $so['buyer_city'],
                    'price_snapshot' => $prod->price,
                    'payment_method' => $so['payment_method'],
                    'status' => $so['status'],
                    'courier' => $so['courier'],
                    'tracking_no' => $so['tracking_no'],
                    'wa_message' => $waMsg,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'status' => Order::STATUS_PENDING,
                    'note' => 'Pesanan dibuat via form order WhatsApp.',
                    'created_at' => $createdAt,
                ]);

                if ($so['status'] !== Order::STATUS_PENDING) {
                    OrderStatusLog::create([
                        'order_id' => $order->id,
                        'status' => $so['status'],
                        'note' => $so['status'] === Order::STATUS_CANCELLED
                            ? 'Batal (item sudah terjual)'
                            : ('Status diperbarui: ' . (Order::STATUS_LABELS[$so['status']] ?? $so['status'])),
                        'created_at' => $createdAt->copy()->addMinutes(30),
                    ]);
                }
            }
        }
    }
}
