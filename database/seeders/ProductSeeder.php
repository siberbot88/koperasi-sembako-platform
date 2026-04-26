<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::first();
        if (!$store) {
            $this->command->error('No store found. Run DatabaseSeeder first.');
            return;
        }
        $storeId = (string) $store->_id;

        // Build category map slug -> id
        $categoryMap = Category::all()->mapWithKeys(fn($c) => [$c->slug => (string) $c->_id])->toArray();

        $products = [
            // ── Beras & Serealia ──
            ['name'=>'Beras Premium Pandan Wangi 5kg','slug'=>'beras-premium-pandan-wangi-5kg','sku'=>'BRS-001','cat'=>'beras-serealia','price'=>72000,'stock'=>150,'unit'=>'pack','weight'=>5000,'sold'=>320,'img'=>'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=600&q=80'],
            ['name'=>'Beras Cap Jago Medium 5kg','slug'=>'beras-cap-jago-5kg','sku'=>'BRS-002','cat'=>'beras-serealia','price'=>58000,'stock'=>200,'unit'=>'pack','weight'=>5000,'sold'=>480,'img'=>'https://images.unsplash.com/photo-1536304929831-ee1ca9d44906?w=600&q=80'],
            ['name'=>'Beras Merah Organik 1kg','slug'=>'beras-merah-organik-1kg','sku'=>'BRS-003','cat'=>'beras-serealia','price'=>28000,'stock'=>45,'unit'=>'pack','weight'=>1000,'sold'=>67,'img'=>'https://images.unsplash.com/photo-1515542622106-78bda8ba0e5b?w=600&q=80'],
            ['name'=>'Quaker Oatmeal Original 400g','slug'=>'quaker-oatmeal-400g','sku'=>'BRS-004','cat'=>'beras-serealia','price'=>32000,'stock'=>80,'unit'=>'pack','weight'=>400,'sold'=>145,'img'=>'https://images.unsplash.com/photo-1571748982800-fa51082c2224?w=600&q=80'],
            ['name'=>'Beras Ketan Putih 1kg','slug'=>'beras-ketan-putih-1kg','sku'=>'BRS-005','cat'=>'beras-serealia','price'=>18000,'stock'=>60,'unit'=>'pack','weight'=>1000,'sold'=>95,'img'=>'https://images.unsplash.com/photo-1626200926197-b2a9df7c5c62?w=600&q=80'],

            // ── Minyak Goreng ──
            ['name'=>'Bimoli Minyak Goreng Spesial 2L','slug'=>'bimoli-2l','sku'=>'MNY-001','cat'=>'minyak-goreng','price'=>36000,'stock'=>120,'unit'=>'botol','weight'=>1800,'sold'=>290,'img'=>'https://images.unsplash.com/photo-1620706857370-e1b9770e8bb1?w=600&q=80'],
            ['name'=>'Tropical Minyak Goreng 1L','slug'=>'tropical-1l','sku'=>'MNY-002','cat'=>'minyak-goreng','price'=>19500,'stock'=>180,'unit'=>'botol','weight'=>900,'sold'=>410,'img'=>'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=600&q=80'],
            ['name'=>'Fortune Minyak Goreng 2L','slug'=>'fortune-2l','sku'=>'MNY-003','cat'=>'minyak-goreng','price'=>34000,'stock'=>100,'unit'=>'botol','weight'=>1800,'sold'=>200,'img'=>'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600&q=80','disc'=>30000],
            ['name'=>'Sania Minyak Goreng 1L','slug'=>'sania-1l','sku'=>'MNY-004','cat'=>'minyak-goreng','price'=>18500,'stock'=>140,'unit'=>'botol','weight'=>900,'sold'=>320,'img'=>'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80'],
            ['name'=>'VCO Minyak Kelapa Virgin 250ml','slug'=>'vco-kelapa-250ml','sku'=>'MNY-005','cat'=>'minyak-goreng','price'=>45000,'stock'=>30,'unit'=>'botol','weight'=>250,'sold'=>55,'img'=>'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600&q=80'],

            // ── Gula & Pemanis ──
            ['name'=>'Gulaku Gula Pasir Putih 1kg','slug'=>'gulaku-1kg','sku'=>'GLA-001','cat'=>'gula-pemanis','price'=>16500,'stock'=>250,'unit'=>'pack','weight'=>1000,'sold'=>550,'img'=>'https://images.unsplash.com/photo-1609167830220-7164aa360951?w=600&q=80'],
            ['name'=>'Gula Merah Aren Organik 500g','slug'=>'gula-aren-500g','sku'=>'GLA-002','cat'=>'gula-pemanis','price'=>14000,'stock'=>80,'unit'=>'pack','weight'=>500,'sold'=>130,'img'=>'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=600&q=80'],
            ['name'=>'Madu Pramuka Murni 350g','slug'=>'madu-pramuka-350g','sku'=>'GLA-003','cat'=>'gula-pemanis','price'=>55000,'stock'=>40,'unit'=>'botol','weight'=>350,'sold'=>88,'img'=>'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=600&q=80'],
            ['name'=>'Tropicana Slim Stevia 250g','slug'=>'tropicana-slim-250g','sku'=>'GLA-004','cat'=>'gula-pemanis','price'=>38000,'stock'=>35,'unit'=>'pack','weight'=>250,'sold'=>62,'img'=>'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&q=80'],

            // ── Telur ──
            ['name'=>'Telur Ayam Negeri 1kg','slug'=>'telur-ayam-negeri-1kg','sku'=>'TLR-001','cat'=>'telur','price'=>28000,'stock'=>100,'unit'=>'kg','weight'=>1000,'sold'=>890,'img'=>'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=600&q=80'],
            ['name'=>'Telur Ayam Kampung 10 Butir','slug'=>'telur-kampung-10butir','sku'=>'TLR-002','cat'=>'telur','price'=>35000,'stock'=>40,'unit'=>'pack','weight'=>600,'sold'=>120,'img'=>'https://images.unsplash.com/photo-1598965402089-897ce52e8355?w=600&q=80'],
            ['name'=>'Telur Bebek 10 Butir','slug'=>'telur-bebek-10butir','sku'=>'TLR-003','cat'=>'telur','price'=>38000,'stock'=>25,'unit'=>'pack','weight'=>700,'sold'=>75,'img'=>'https://images.unsplash.com/photo-1607305387299-a3d9611cd469?w=600&q=80'],
            ['name'=>'Telur Puyuh 30 Butir','slug'=>'telur-puyuh-30butir','sku'=>'TLR-004','cat'=>'telur','price'=>18000,'stock'=>50,'unit'=>'pack','weight'=>300,'sold'=>95,'img'=>'https://images.unsplash.com/photo-1569690573004-dc94ca5e4e19?w=600&q=80'],

            // ── Tepung ──
            ['name'=>'Segitiga Biru Tepung Terigu 1kg','slug'=>'segitiga-biru-1kg','sku'=>'TPG-001','cat'=>'tepung','price'=>12500,'stock'=>200,'unit'=>'pack','weight'=>1000,'sold'=>340,'img'=>'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=600&q=80'],
            ['name'=>'Rose Brand Tepung Beras 500g','slug'=>'rose-brand-500g','sku'=>'TPG-002','cat'=>'tepung','price'=>8500,'stock'=>90,'unit'=>'pack','weight'=>500,'sold'=>75,'img'=>'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&q=80'],
            ['name'=>'Maizenaku Tepung Maizena 250g','slug'=>'maizena-250g','sku'=>'TPG-003','cat'=>'tepung','price'=>7000,'stock'=>75,'unit'=>'pack','weight'=>250,'sold'=>120,'img'=>'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?w=600&q=80'],
            ['name'=>'Kobe Tepung Bumbu Serbaguna 200g','slug'=>'kobe-bumbu-200g','sku'=>'TPG-004','cat'=>'tepung','price'=>9500,'stock'=>60,'unit'=>'pack','weight'=>200,'sold'=>185,'img'=>'https://images.unsplash.com/photo-1596466900690-9cdf62ff4ca6?w=600&q=80'],

            // ── Mie & Pasta ──
            ['name'=>'Indomie Mi Goreng (5 pcs)','slug'=>'indomie-goreng-5pcs','sku'=>'MIE-001','cat'=>'mie-pasta','price'=>15000,'stock'=>500,'unit'=>'pack','weight'=>425,'sold'=>1200,'img'=>'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=600&q=80'],
            ['name'=>'Indomie Soto Ayam (5 pcs)','slug'=>'indomie-soto-5pcs','sku'=>'MIE-002','cat'=>'mie-pasta','price'=>14500,'stock'=>400,'unit'=>'pack','weight'=>375,'sold'=>980,'img'=>'https://images.unsplash.com/photo-1555126634-323283e090fa?w=600&q=80'],
            ['name'=>'Mie Sedaap Goreng (5 pcs)','slug'=>'mie-sedaap-goreng-5pcs','sku'=>'MIE-003','cat'=>'mie-pasta','price'=>14000,'stock'=>350,'unit'=>'pack','weight'=>455,'sold'=>760,'img'=>'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?w=600&q=80'],
            ['name'=>'Supermi Soto (5 pcs)','slug'=>'supermi-soto-5pcs','sku'=>'MIE-004','cat'=>'mie-pasta','price'=>13500,'stock'=>250,'unit'=>'pack','weight'=>375,'sold'=>480,'img'=>'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=600&q=80'],
            ['name'=>'Sarimi Ayam Bawang (5 pcs)','slug'=>'sarimi-ayam-5pcs','sku'=>'MIE-005','cat'=>'mie-pasta','price'=>11000,'stock'=>300,'unit'=>'pack','weight'=>300,'sold'=>390,'img'=>'https://images.unsplash.com/photo-1547592180-85f173990554?w=600&q=80'],

            // ── Minuman ──
            ['name'=>'Aqua Air Mineral 600ml','slug'=>'aqua-600ml','sku'=>'MNM-001','cat'=>'minuman','price'=>4500,'stock'=>800,'unit'=>'botol','weight'=>620,'sold'=>2100,'img'=>'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=600&q=80'],
            ['name'=>'Teh Botol Sosro 250ml','slug'=>'teh-botol-sosro-250ml','sku'=>'MNM-002','cat'=>'minuman','price'=>5000,'stock'=>500,'unit'=>'botol','weight'=>270,'sold'=>1500,'img'=>'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&q=80'],
            ['name'=>'Kapal Api Special Kopi 165g','slug'=>'kapal-api-165g','sku'=>'MNM-003','cat'=>'minuman','price'=>13000,'stock'=>150,'unit'=>'pack','weight'=>165,'sold'=>230,'img'=>'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=600&q=80'],
            ['name'=>'Ultra Milk Full Cream 1L','slug'=>'ultra-milk-1l','sku'=>'MNM-004','cat'=>'minuman','price'=>20000,'stock'=>120,'unit'=>'karton','weight'=>1000,'sold'=>340,'img'=>'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600&q=80'],
            ['name'=>'Pocari Sweat 500ml','slug'=>'pocari-sweat-500ml','sku'=>'MNM-005','cat'=>'minuman','price'=>8000,'stock'=>300,'unit'=>'botol','weight'=>520,'sold'=>650,'img'=>'https://images.unsplash.com/photo-1625772452859-1c03d884dcd7?w=600&q=80'],
            ['name'=>'Good Day Cappuccino 200ml','slug'=>'good-day-cappuccino-200ml','sku'=>'MNM-006','cat'=>'minuman','price'=>5500,'stock'=>250,'unit'=>'kaleng','weight'=>220,'sold'=>420,'img'=>'https://images.unsplash.com/photo-1502462041640-20a6e6e4a7de?w=600&q=80'],

            // ── Bumbu Dapur ──
            ['name'=>'Bawang Merah Lokal 250g','slug'=>'bawang-merah-250g','sku'=>'BMB-001','cat'=>'bumbu-dapur','price'=>10000,'stock'=>100,'unit'=>'pack','weight'=>250,'sold'=>450,'img'=>'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=600&q=80'],
            ['name'=>'Bawang Putih Lokal 250g','slug'=>'bawang-putih-250g','sku'=>'BMB-002','cat'=>'bumbu-dapur','price'=>9000,'stock'=>100,'unit'=>'pack','weight'=>250,'sold'=>380,'img'=>'https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=600&q=80'],
            ['name'=>'Kecap Manis ABC 275ml','slug'=>'kecap-manis-abc-275ml','sku'=>'BMB-003','cat'=>'bumbu-dapur','price'=>12500,'stock'=>120,'unit'=>'botol','weight'=>300,'sold'=>290,'img'=>'https://images.unsplash.com/photo-1590739225287-bd31519780c3?w=600&q=80'],
            ['name'=>'Royco Penyedap Ayam 230g','slug'=>'royco-ayam-230g','sku'=>'BMB-004','cat'=>'bumbu-dapur','price'=>11000,'stock'=>90,'unit'=>'pack','weight'=>230,'sold'=>310,'img'=>'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&q=80'],
            ['name'=>'Indofood Sambal Oelek 140ml','slug'=>'sambal-oelek-140ml','sku'=>'BMB-005','cat'=>'bumbu-dapur','price'=>9500,'stock'=>80,'unit'=>'botol','weight'=>160,'sold'=>220,'img'=>'https://images.unsplash.com/photo-1599484777882-6e5d68dab5ca?w=600&q=80'],
            ['name'=>'Sasa Santan Kelapa 65ml','slug'=>'sasa-santan-65ml','sku'=>'BMB-006','cat'=>'bumbu-dapur','price'=>4500,'stock'=>200,'unit'=>'sachet','weight'=>65,'sold'=>410,'img'=>'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600&q=80'],

            // ── Kebutuhan Rumah ──
            ['name'=>'Sunlight Sabun Cuci Piring 400ml','slug'=>'sunlight-400ml','sku'=>'RMH-001','cat'=>'kebutuhan-rumah','price'=>9500,'stock'=>200,'unit'=>'botol','weight'=>420,'sold'=>510,'img'=>'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=600&q=80'],
            ['name'=>'Rinso Anti Noda 800g','slug'=>'rinso-800g','sku'=>'RMH-002','cat'=>'kebutuhan-rumah','price'=>18000,'stock'=>150,'unit'=>'pack','weight'=>800,'sold'=>280,'img'=>'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=600&q=80'],
            ['name'=>'Soklin Softener Violet 900ml','slug'=>'soklin-violet-900ml','sku'=>'RMH-003','cat'=>'kebutuhan-rumah','price'=>22000,'stock'=>90,'unit'=>'botol','weight'=>950,'sold'=>195,'img'=>'https://images.unsplash.com/photo-1585676623595-1db5c1e39f9b?w=600&q=80'],
            ['name'=>'Lifebuoy Sabun Mandi 85g','slug'=>'lifebuoy-85g','sku'=>'RMH-004','cat'=>'kebutuhan-rumah','price'=>5000,'stock'=>300,'unit'=>'pcs','weight'=>85,'sold'=>750,'img'=>'https://images.unsplash.com/photo-1584515933487-779824d29309?w=600&q=80'],
            ['name'=>'Paseo Tisu 250 Lembar','slug'=>'paseo-tisu-250','sku'=>'RMH-005','cat'=>'kebutuhan-rumah','price'=>15000,'stock'=>180,'unit'=>'pack','weight'=>250,'sold'=>430,'img'=>'https://images.unsplash.com/photo-1587467512961-120760940315?w=600&q=80'],
            ['name'=>'Wipol Karbol Wangi 1L','slug'=>'wipol-1l','sku'=>'RMH-006','cat'=>'kebutuhan-rumah','price'=>16500,'stock'=>70,'unit'=>'botol','weight'=>1000,'sold'=>160,'img'=>'https://images.unsplash.com/photo-1600881333168-2ef49b341f30?w=600&q=80'],
        ];

        // Clear existing products
        Product::truncate();

        foreach ($products as $p) {
            Product::create([
                'name'           => $p['name'],
                'slug'           => $p['slug'],
                'sku'            => $p['sku'],
                'category_id'    => $categoryMap[$p['cat']] ?? null,
                'store_id'       => $storeId,
                'description'    => 'Produk berkualitas dari brand terpercaya. Harga terjangkau, tersedia untuk anggota dan umum.',
                'unit'           => $p['unit'],
                'weight_grams'   => $p['weight'],
                'base_price'     => $p['price'],
                'discount_price' => $p['disc'] ?? null,
                'discount_start' => isset($p['disc']) ? now()->subDay() : null,
                'discount_end'   => isset($p['disc']) ? now()->addDays(30) : null,
                'stock'          => $p['stock'],
                'min_order'      => 1,
                'max_order'      => 50,
                'thumbnail'      => $p['img'],
                'images'         => [$p['img']],
                'specifications' => [],
                'tags'           => $p['sold'] > 500 ? ['best-seller'] : [],
                'status'         => 'active',
                'sold_count'     => $p['sold'],
                'view_count'     => $p['sold'] * 3,
            ]);
        }

        $this->command->info('✅ ' . count($products) . ' products seeded with brand images!');
    }
}
