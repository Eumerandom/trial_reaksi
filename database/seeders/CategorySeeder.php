<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function generateUniqueSlug($name)
{
    $slug = Str::slug($name);
    $originalSlug = $slug;
    $count = 1;

    while (Category::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    return $slug;
}
    public function run(): void
    {
        $makeupSkincare = Category::create([
            'name' => 'Make Up & Skin Care',
            'slug' => Str::slug('Make Up & Skin Care'),
        ]);

        $bodycare = Category::create([
            'name' => 'Body Care',
            'slug' => Str::slug('Body Care'),
        ]);

        $haircare = Category::create([
            'name' => 'Hair Care',
            'slug' => Str::slug('Hair Care'),
        ]);

        $babycare = Category::create([
            'name' => 'Baby Care',
            'slug' => Str::slug('Baby Care'),
        ]);

        $pakaian = Category::create([
            'name' => 'Pakaian',
            'slug' => Str::slug('Pakaian'),
        ]);

        $alatTulisKantor = Category::create([
            'name' => 'Alat Tulis Kantor',
            'slug' => Str::slug('Alat Tulis Kantor'),
        ]);

        $tas = Category::create([
            'name' => 'Tas',
            'slug' => Str::slug('Tas'),
        ]);

        $dompet = Category::create([
            'name' => 'Dompet',
            'slug' => Str::slug('Dompet'),
        ]);

        $alatKebersihan = Category::create([
            'name' => 'Alat Kebersihan',
            'slug' => Str::slug('Alat Kebersihan'),
        ]);

        $alatMasak = Category::create([
            'name' => 'Alat Masak',
            'slug' => Str::slug('Alat Masak'),
        ]);

        $elektronik = Category::create([
            'name' => 'Elektronik',
            'slug' => Str::slug('Elektronik'),
        ]);

        // Create main categories
        $sembako = Category::create([
            'name' => 'Sembako',
            'slug' => Str::slug('Sembako'),
        ]);

        $bahanKue = Category::create([
            'name' => 'Bahan Kue',
            'slug' => Str::slug('Bahan Kue'),
        ]);

        $bumbu = Category::create([
            'name' => 'Bumbu',
            'slug' => Str::slug('Bumbu'),
        ]);

        $minuman = Category::create([
            'name' => 'Minuman',
            'slug' => Str::slug('Minuman'),
        ]);

        $makanan = Category::create([
            'name' => 'Makanan',
            'slug' => Str::slug('Makanan'),
        ]);

        $kuliner = Category::create([
            'name' => 'Kuliner',
            'slug' => Str::slug('Kuliner'),
        ]);

        $obatAlkes = Category::create([
            'name' => 'Obat & Alat Kesehatan',
            'slug' => Str::slug('Obat & Alat Kesehatan'),
        ]);

        $pembalutPopok = Category::create([
            'name' => 'Pembalut',
            'slug' => Str::slug('Pembalut'),
        ]);

        $tisu = Category::create([
            'name' => 'Tisu',
            'slug' => Str::slug('Tisu'),
        ]);

        $petfood = Category::create([
            'name' => 'Pet Food',
            'slug' => Str::slug('Pet Food'),
        ]);

        $lembaga = Category::create([
            'name' => 'Lembaga Kemanusiaan',
            'slug' => Str::slug('Lembaga Kemanusiaan'),
        ]);

        $makeupSkincareSubs = [
            'Wewangian',
        ];
        
        $sunscreen = Category::create([
            'name' => 'Sunscreen',
            'slug' => Str::slug('Sunscreen'),
            'parent_id' => $makeupSkincare->id
        ]);
        
        $balm = Category::create([
            'name' => 'Balm',
            'slug' => Str::slug('Balm'),
            'parent_id' => $makeupSkincare->id
        ]);
        
        $firstCleanser = Category::create([
            'name' => 'First Cleanser',
            'slug' => Str::slug('First Cleanser'),
            'parent_id' => $makeupSkincare->id
        ]);

        foreach ($makeupSkincareSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $makeupSkincare->id
            ]);
        }

        $sunscreenSubs = [
            'Physical & Tone Up Sunscreen',
            'Chemical Sunscreen',
            'Hybrid Sunscreen',
            'Tinted Sunscreen',
            'Sunscreen Ramah di Kantong',
            'Face & Body Sunscreen',
            'Water Resistant Baby & Kids Sunscreen',
            'Physical Baby & Kids Sunscreen',
            'Hybrid Baby & Kids Sunscreen',
            'Chemical Baby & Kids Sunscreen',
            'Hybrid Kids & Teens Sunscreen',
        ];

        foreach ($sunscreenSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $sunscreen->id
            ]);
        }

        $balmSubs = [
            'Multipurpose Balm',
            'Healing Salve Balm',
            'Lip Balm',
            'Ointment Balm'
        ];

        foreach ($balmSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $balm->id
            ]);
        }

        $deodoran = Category::create([
            'name' => 'Deodoran',
            'slug' => Str::slug('Deodoran'),
            'parent_id' => $bodycare->id
        ]);

        $babycareSubs = [
            'Baby Stuff',
            'Popok Bayi',
            'Sabun Lerak'
        ];

        foreach ($babycareSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $babycare->id
            ]);
        }

        $sepatu = Category::create([
            'name' => $sub,
            'slug' => $this->generateUniqueSlug($sub),
            'parent_id' => $pakaian->id
        ]);

        $cuciPiring = Category::create([
            'name' => 'Sabun Cuci Piring',
            'slug' => Str::slug('Sabun Cuci Piring'),
            'parent_id' => $alatKebersihan->id
        ]);

        $cuciPiringSubs = [
            'Sabun Cuci Piring',
            'Sabun Cuci Baby Safe',
            'Sabun Pencuci Sayur & Buah',
            'Sabun Lerak'
        ];

        foreach ($cuciPiringSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $cuciPiring->id
            ]);
        }

        $detergen = Category::create([
            'name' => 'Detergen',
            'slug' => Str::slug('Detergen'),
            'parent_id' => $alatKebersihan->id
        ]);

        $dentalCare = Category::create([
            'name' => 'Dental Care',
            'slug' => Str::slug('Dental Care'),
            'parent_id' => $alatKebersihan->id
        ]);

        $detergenSubs = [
            'Detergen Bubuk',
            'Detergen Cair',
            'Detergen Baby Safe',
            'Pelembut Pakaian Bayi',
            'Pewangi Pakaian',
            'Detergen Krim',
            'Detergen Underwear',
            'Pelicin Pakaian',
            'Pemutih Pakaian',
            'Oxy Powder',
        ];

        foreach ($detergenSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $detergen->id
            ]);
        }

        $detergenSubs = [
            'Pasta Gigi Anak',
            'Sikat Gigi Anak',
            'Pasta Gigi Dewasa',
            'Sikat Gigi Dewasa',
            'Sikat Gigi Elektrik',
            'Sikat Gigi Bambu',
            'Mouthwash',
            'Dental Floss',
        ];

        foreach ($detergenSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $detergen->id
            ]);
        }

        $alatMasakSubs = [
            'Stainless Steel',
            'Steamer, Panci, Wajan',
        ];

        foreach ($alatMasakSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $alatMasak->id
            ]);
        }

        $elektronikSubs = [
            'Magic Com, Rice & Slow Cooker',
            'Air Fryer, Chopper, Blender',
            'Kipas Angin, AC, Air Purifier',
            'Slow Juicer, Blender',
            'AC, Mesin Cuci, Kompor',
            'Dishwasher, Outdoor Kitchen, Kompor',
            'Dishwasher, Vacuum Cleaner, Air Purifier',
            'Water Heater, Vacuum Cleaner, Air Purifier',
            'Water Heater, Vacuum Cleaner, Setrika',
            'Water Heater, Vacuum Cleaner, Dispenser',
            'Blender, Vacuum Cleaner, Kitchen'
        ];

        foreach ($elektronikSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $elektronik->id
            ]);
        }

        $bahanKueSubs = [
            'Keju',
            'Butter',
            'Margarin',
            'Ghee',
            'Whipped Cream',
            'Flavor & Essence',
            'Pasta & Pewarna Makanan',
            'Pengembang Kue',
            'Bread Improver',
            'Santan',
            'Gula Halus',
            'Cream Cheese',
            'Butter Cream',
            'Gelatin',
        ];

        $tepung = Category::create([
            'name' => 'Tepung',
            'slug' => Str::slug('Tepung'),
            'parent_id' => $bahanKue->id
        ]);

        $cokelat = Category::create([
            'name' => 'Cokelat',
            'slug' => Str::slug('Cokelat'),
            'parent_id' => $bahanKue->id
        ]);

        foreach ($bahanKueSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $bahanKue->id
            ]);
        }

        $tepungSubs = [
            'Tepung Terigu',
            'Tepung Gluten Free',
            'Tepung Tapioka',
            'Tepung Maizena',
            'Tepung Beras & Ketan',
            'Tepung Premix'
        ];

        foreach ($tepungSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $tepung->id
            ]);
        }

        $cokelatSubs = [
            'Cokelat Bar',
            'Cokelat Meises',
            'Cokelat Dubai',
            'Cokelat Drinks',
            'Cokelat Glaze',
            'Cokelat Filling',
            'Cokelat Spread'
        ];

        foreach ($cokelatSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $cokelat->id
            ]);
        }

        $bumbuSubs = [
            'Kecap Manis',
            'Kecap Sehat',
            'Kecap Set',
            'Kecap Asin',
            'Kecap Inggris',
            'Kecap Ikan',
            'Saus Tomat',
            'Saus Sambal',
            'Sambal Nusantara',
        ];

        foreach ($bumbuSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $bumbu->id
            ]);
        }

        $minyak = Category::create([
            'name' => 'Minyak',
            'slug' => Str::slug('Minyak'),
            'parent_id' => $sembako->id,
        ]);

        $minyakSubs = [
            'Minyak Goreng Sawit',
            'Minyak Goreng Kelapa',
        ];

        foreach ($minyakSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $minyak->id
            ]);
        }

        $beras = Category::create([
            'name' => 'Beras',
            'slug' => Str::slug('Beras'),
            'parent_id' => $sembako->id
        ]);

        $minumanSubs = [
            'Air Mineral',
            'Kopi',
            'Kopi Kemasan',
            'Teh',
            'Teh Kemasan',
            'Teh Tarik',
            'Yoghurt',
            'Sirop',
            'Sirop Flavour',
            'Minuman Kaleng',
            'Isotonik',
            'Air Kelapa',
            'Minuman Rasa Buah',
            'Larutan Penyegar',
            'Minuman Soda',
            'Minuman Olahan Kurma'
        ];

        foreach ($minumanSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $minuman->id
            ]);
        }

        $susu = Category::create([
            'name' => 'Susu',
            'slug' => Str::slug('Susu'),
            'parent_id' => $minuman->id
        ]);

        $susuSubs = [
            'Susu Bubuk Kue',
            'Susu Bubuk Anak',
            'Susu Ibu Hamil & Menyusui',
            'Susu Whey',
            'Susu Formula Batita',
            'Susu Sereal',
            'Susu UHT',
            'Susu Pasteurisasi',
            'Raw Milk',
            'Susu Kalsium',
            'Susu Tambah BB Anak',
            'Susu Tambah BB Dewasa',
            'Susu Diabetes',
            'Susu Lansia',
            'Susu Low Fat',
            'Susu Kesehatan',
            'Susu Non Dairy',
            'Foaming Milk',
            'Krimer',
            'Susu Evaporasi',
            'Kental Manis',
            'Susu Kambing Bubuk',
        ];

        foreach ($susuSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $susu->id
            ]);
        }

        $makananSubs = [
            'Es Krim',
            'Gelato',
            'Es Krim & Gelato Bubuk',
            'Ice Cup & Stick',
            'Permen',
            'Bakery, Cake, & Pastry',
            'Frozen Food',
            'Frozen Seafood',
            'Frozen Food Kids Friendly',
            'Kurma'
        ];

        $mie = Category::create([
            'name' => 'Mie',
            'slug' => Str::slug('Mie'),
            'parent_id' => $makanan->id
        ]);

        $snack = Category::create([
            'name' => 'Snack',
            'slug' => Str::slug('Snack'),
            'parent_id' => $makanan->id
        ]);

        foreach ($makananSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $makanan->id
            ]);
        }

        $mieSubs = [
            'Mie Instan',
            'Mie Sehat',
            'Bihun',
            'Sohun',
            'Mie Telor & Mie Kering'
        ];

        foreach ($mieSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $mie->id
            ]);
        }

        $snackSubs = [
            'Kue Kaleng',
            'Kue Basah',
            'Crackers',
            'Cookies',
            'Sandwich Cookies',
            'Choco Cookies',
            'Wafer',
            'Wafer Roll',
            'Snack Bola & Jaring',
            'Snack Kentang',
            'Snack Jagung',
            'Keripik Singkong',
            'Malkist',
            'Biskuit',
            'Biskuit Colek',
            'Cokleat Batang',
            'Cokleat Pasta',
            'Cokleat Telur',
            'Jelly',
        ];

        foreach ($snackSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $snack->id
            ]);
        }

        $kulinerSubs = [
            'Coffee Shop',
            'Tea House',
            'Boba Drink',
            'Halal Manufactured Coffee Shop',
            'Halal Manufactured Tea House',
            'Restoran Nusantara',
            'Restoran Sushi',
            'Restoran Ramen',
            'Restoran Chinese',
            'Restoran Bakmi',
            'Restoran Steak',
            'Restoran AYCE',
            'Restoran Ayam',
            'Restoran Bebek',
            'Restoran Asia & Western',
            'Restoran Bakso',
            'Restoran Fast Food',
            'Restoran Middle East Cuisine'
            ,
            'Kuliner Lainnya'
        ];

        foreach ($kulinerSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $kuliner->id
            ]);
        }

        $obatSubs = [
            'Obat Flu',
            'Obat Lambung',
            'Obat Nyeri & Demam',
            'Obat Demam Anak',
            'Obat Batuk',
            'Obat Batuk Anak',
            'Balsem & Koyo',
            'Pereda Masuk Angin',
            'Plester Luka',
            'Obat Area Perut',
            'Obat Alergi',
            'Obat Asma',
            'Minyak Balur',
            'Minyak Telon',
            'Tetes Mata',
            'Bedak Gatal',
            'Vitamin Anak',
            'Multivitamin', 
            'Vitamin Tulang',
            'Vitamin Saraf & Kulit',
            'Vitamin Ibu Hamil & Menyusui',
            'Sanitizer',
            'Masker Medis',
            'Kotak P3K',
        ];

        foreach ($obatSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $obatAlkes->id
            ]);
        }

         $pembalutPopokSubs = [
            'Pembalut Sekali Pakai',
            'Pembalut Organik',
            'Pembalut Bersalin',
            'Pembalut Celana',
            'Breast Pad',
            'Pembalut Kain',
            'Clodi',
            'Popok Dewasa',
            'Underpad',
        ];

        foreach ($pembalutPopokSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => $this->generateUniqueSlug($sub),
                'parent_id' => $pembalutPopok->id
            ]);
        }

        $tisuSubs = [
            'Tisu Kering',
            'Tisu Basah',
            'Tisu Bambu',
            'Kapas Bola',
            'Wash Glove'
        ];

        foreach ($tisuSubs as $sub) {
            Category::create([
                'name' => $sub,
                'slug' => Str::slug( $sub),
                'parent_id' => $tisu->id
            ]);
        }

    }
}
