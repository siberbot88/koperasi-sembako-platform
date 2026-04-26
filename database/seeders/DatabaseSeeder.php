<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Models\Banner;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Create Seller User ──
        $seller = User::create([
            'name' => 'Koperasi Makmur Jaya',
            'email' => 'admin@koperasisembako.id',
            'password' => bcrypt('password'),
            'phone' => '081234567890',
            'role' => 'seller',
            'is_active' => true,
            'addresses' => [],
        ]);

        // ── 2. Create Store ──
        $store = Store::create([
            'seller_id' => (string) $seller->_id,
            'name' => 'Koperasi Sembako Makmur Jaya',
            'slug' => 'koperasi-makmur-jaya',
            'description' => 'Menyediakan kebutuhan pokok harian dengan harga koperasi yang terjangkau dan kualitas terjamin.',
            'phone' => '081234567890',
            'address' => 'Jl. Koperasi No. 17, Kelurahan Makmur, Kec. Sejahtera',
            'city' => 'Surabaya',
            'operational_hours' => ['open' => '07:00', 'close' => '21:00'],
            'is_active' => true,
        ]);

        // ── 3. Create Customer User ──
        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'password' => bcrypt('password'),
            'phone' => '081298765432',
            'role' => 'customer',
            'is_active' => true,
            'addresses' => [
                [
                    'label' => 'Rumah',
                    'recipient' => 'Siti Rahayu',
                    'phone' => '081298765432',
                    'address' => 'Jl. Melati No. 5, RT 03/RW 02',
                    'city' => 'Surabaya',
                    'postal_code' => '60221',
                    'is_default' => true,
                ],
            ],
        ]);

        // ── 4. Create Categories ──
        $categories = [
            ['name' => 'Beras & Serealia',   'slug' => 'beras-serealia',   'icon' => 'grain',          'sort_order' => 1],
            ['name' => 'Minyak Goreng',       'slug' => 'minyak-goreng',    'icon' => 'beaker',         'sort_order' => 2],
            ['name' => 'Gula & Pemanis',      'slug' => 'gula-pemanis',     'icon' => 'cube',           'sort_order' => 3],
            ['name' => 'Telur',               'slug' => 'telur',            'icon' => 'sun',            'sort_order' => 4],
            ['name' => 'Tepung',              'slug' => 'tepung',           'icon' => 'cake',           'sort_order' => 5],
            ['name' => 'Mie & Pasta',         'slug' => 'mie-pasta',        'icon' => 'fire',           'sort_order' => 6],
            ['name' => 'Minuman',             'slug' => 'minuman',          'icon' => 'beaker',         'sort_order' => 7],
            ['name' => 'Bumbu Dapur',         'slug' => 'bumbu-dapur',      'icon' => 'sparkles',       'sort_order' => 8],
            ['name' => 'Kebutuhan Rumah',     'slug' => 'kebutuhan-rumah',  'icon' => 'home',           'sort_order' => 9],
        ];

        $categoryMap = [];
        foreach ($categories as $cat) {
            $created = Category::create(array_merge($cat, ['is_active' => true]));
            $categoryMap[$cat['slug']] = (string) $created->_id;
        }

        // ── 5. Create Products ──
        $storeId = (string) $store->_id;
        $products = [
            // Beras
            ['name' => 'Beras Premium Pandan Wangi 5kg',       'slug' => 'beras-premium-pandan-wangi-5kg',      'category' => 'beras-serealia',   'sku' => 'BRS-001', 'base_price' => 72000,  'stock' => 150, 'unit' => 'pack',  'weight_grams' => 5000, 'sold_count' => 320],
            ['name' => 'Beras Medium IR-64 5kg',                'slug' => 'beras-medium-ir64-5kg',               'category' => 'beras-serealia',   'sku' => 'BRS-002', 'base_price' => 58000,  'stock' => 200, 'unit' => 'pack',  'weight_grams' => 5000, 'sold_count' => 480],
            ['name' => 'Beras Merah Organik 1kg',               'slug' => 'beras-merah-organik-1kg',             'category' => 'beras-serealia',   'sku' => 'BRS-003', 'base_price' => 28000,  'stock' => 45,  'unit' => 'pack',  'weight_grams' => 1000, 'sold_count' => 67],

            // Minyak Goreng
            ['name' => 'Minyak Goreng Bimoli 2L',              'slug' => 'minyak-goreng-bimoli-2l',             'category' => 'minyak-goreng',    'sku' => 'MNY-001', 'base_price' => 36000,  'stock' => 120, 'unit' => 'botol', 'weight_grams' => 1800, 'sold_count' => 290],
            ['name' => 'Minyak Goreng Tropical 1L',             'slug' => 'minyak-goreng-tropical-1l',           'category' => 'minyak-goreng',    'sku' => 'MNY-002', 'base_price' => 19500,  'stock' => 180, 'unit' => 'botol', 'weight_grams' => 900,  'sold_count' => 410],
            ['name' => 'Minyak Goreng Curah 1L',                'slug' => 'minyak-goreng-curah-1l',              'category' => 'minyak-goreng',    'sku' => 'MNY-003', 'base_price' => 14000,  'stock' => 300, 'unit' => 'liter', 'weight_grams' => 900,  'sold_count' => 620, 'discount_price' => 12500],

            // Gula
            ['name' => 'Gula Pasir Putih Gulaku 1kg',          'slug' => 'gula-pasir-putih-gulaku-1kg',         'category' => 'gula-pemanis',     'sku' => 'GLA-001', 'base_price' => 16500,  'stock' => 250, 'unit' => 'pack',  'weight_grams' => 1000, 'sold_count' => 550],
            ['name' => 'Gula Merah Jawa 500g',                  'slug' => 'gula-merah-jawa-500g',                'category' => 'gula-pemanis',     'sku' => 'GLA-002', 'base_price' => 12000,  'stock' => 80,  'unit' => 'pack',  'weight_grams' => 500,  'sold_count' => 130],

            // Telur
            ['name' => 'Telur Ayam Negeri 1kg',                 'slug' => 'telur-ayam-negeri-1kg',               'category' => 'telur',            'sku' => 'TLR-001', 'base_price' => 28000,  'stock' => 100, 'unit' => 'kg',    'weight_grams' => 1000, 'sold_count' => 890],
            ['name' => 'Telur Ayam Kampung 10 Butir',           'slug' => 'telur-ayam-kampung-10-butir',         'category' => 'telur',            'sku' => 'TLR-002', 'base_price' => 35000,  'stock' => 40,  'unit' => 'pack',  'weight_grams' => 600,  'sold_count' => 120],

            // Tepung
            ['name' => 'Tepung Terigu Segitiga Biru 1kg',      'slug' => 'tepung-terigu-segitiga-biru-1kg',     'category' => 'tepung',           'sku' => 'TPG-001', 'base_price' => 12500,  'stock' => 200, 'unit' => 'pack',  'weight_grams' => 1000, 'sold_count' => 340],
            ['name' => 'Tepung Beras Rose Brand 500g',          'slug' => 'tepung-beras-rose-brand-500g',        'category' => 'tepung',           'sku' => 'TPG-002', 'base_price' => 8500,   'stock' => 90,  'unit' => 'pack',  'weight_grams' => 500,  'sold_count' => 75],

            // Mie & Pasta
            ['name' => 'Indomie Goreng (5 pcs)',                'slug' => 'indomie-goreng-5pcs',                 'category' => 'mie-pasta',        'sku' => 'MIE-001', 'base_price' => 15000,  'stock' => 500, 'unit' => 'pack',  'weight_grams' => 425,  'sold_count' => 1200],
            ['name' => 'Indomie Soto Ayam (5 pcs)',             'slug' => 'indomie-soto-ayam-5pcs',              'category' => 'mie-pasta',        'sku' => 'MIE-002', 'base_price' => 14500,  'stock' => 400, 'unit' => 'pack',  'weight_grams' => 375,  'sold_count' => 980],
            ['name' => 'Mie Sedaap Goreng (5 pcs)',             'slug' => 'mie-sedaap-goreng-5pcs',              'category' => 'mie-pasta',        'sku' => 'MIE-003', 'base_price' => 14000,  'stock' => 350, 'unit' => 'pack',  'weight_grams' => 455,  'sold_count' => 760],

            // Minuman
            ['name' => 'Teh Pucuk Harum 350ml',                 'slug' => 'teh-pucuk-harum-350ml',               'category' => 'minuman',          'sku' => 'MNM-001', 'base_price' => 4000,   'stock' => 600, 'unit' => 'botol', 'weight_grams' => 370,  'sold_count' => 1500],
            ['name' => 'Aqua Botol 600ml',                      'slug' => 'aqua-botol-600ml',                    'category' => 'minuman',          'sku' => 'MNM-002', 'base_price' => 4500,   'stock' => 800, 'unit' => 'botol', 'weight_grams' => 620,  'sold_count' => 2100],
            ['name' => 'Kopi Kapal Api Special 165g',           'slug' => 'kopi-kapal-api-special-165g',         'category' => 'minuman',          'sku' => 'MNM-003', 'base_price' => 13000,  'stock' => 150, 'unit' => 'pack',  'weight_grams' => 165,  'sold_count' => 230],

            // Bumbu Dapur
            ['name' => 'Bawang Merah 250g',                     'slug' => 'bawang-merah-250g',                   'category' => 'bumbu-dapur',      'sku' => 'BMB-001', 'base_price' => 10000,  'stock' => 100, 'unit' => 'pack',  'weight_grams' => 250,  'sold_count' => 450],
            ['name' => 'Bawang Putih 250g',                     'slug' => 'bawang-putih-250g',                   'category' => 'bumbu-dapur',      'sku' => 'BMB-002', 'base_price' => 9000,   'stock' => 100, 'unit' => 'pack',  'weight_grams' => 250,  'sold_count' => 380],
            ['name' => 'Kecap Manis ABC 275ml',                 'slug' => 'kecap-manis-abc-275ml',               'category' => 'bumbu-dapur',      'sku' => 'BMB-003', 'base_price' => 12500,  'stock' => 120, 'unit' => 'botol', 'weight_grams' => 300,  'sold_count' => 290],

            // Kebutuhan Rumah
            ['name' => 'Sabun Cuci Piring Sunlight 400ml',     'slug' => 'sunlight-400ml',                      'category' => 'kebutuhan-rumah',  'sku' => 'RMH-001', 'base_price' => 9500,   'stock' => 200, 'unit' => 'botol', 'weight_grams' => 420,  'sold_count' => 510],
            ['name' => 'Deterjen Rinso Anti Noda 800g',         'slug' => 'rinso-anti-noda-800g',                'category' => 'kebutuhan-rumah',  'sku' => 'RMH-002', 'base_price' => 18000,  'stock' => 150, 'unit' => 'pack',  'weight_grams' => 800,  'sold_count' => 280],
        ];

        foreach ($products as $p) {
            $data = [
                'name' => $p['name'],
                'slug' => $p['slug'],
                'sku' => $p['sku'],
                'category_id' => $categoryMap[$p['category']],
                'store_id' => $storeId,
                'description' => 'Produk kebutuhan pokok berkualitas dengan harga koperasi yang terjangkau.',
                'unit' => $p['unit'],
                'weight_grams' => $p['weight_grams'],
                'base_price' => $p['base_price'],
                'discount_price' => $p['discount_price'] ?? null,
                'discount_start' => isset($p['discount_price']) ? now()->subDay() : null,
                'discount_end' => isset($p['discount_price']) ? now()->addDays(30) : null,
                'stock' => $p['stock'],
                'min_order' => 1,
                'max_order' => 50,
                'images' => [],
                'thumbnail' => null,
                'specifications' => [],
                'tags' => $p['sold_count'] > 500 ? ['best-seller'] : [],
                'status' => 'active',
                'sold_count' => $p['sold_count'],
                'view_count' => $p['sold_count'] * 3,
            ];
            Product::create($data);
        }

        // ── 6. Create Banners ──
        Banner::create([
            'store_id' => $storeId,
            'title' => 'Belanja Hemat Harian',
            'subtitle' => 'Harga koperasi asli, tersedia untuk anggota dan umum.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'store_id' => $storeId,
            'title' => 'Promo Minyak Goreng',
            'subtitle' => 'Harga spesial minyak goreng curah hanya Rp 12.500/liter!',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // ── 7. Create a Coupon ──
        Coupon::create([
            'store_id' => $storeId,
            'code' => 'HEMAT10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 50000,
            'max_discount' => 15000,
            'usage_limit' => 100,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(1),
            'is_active' => true,
        ]);
    }
}
