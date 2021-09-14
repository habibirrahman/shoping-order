<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->data['products'] = [
            [
                'name' => 'Roti Coklat',
                'description' => 'Roti isi coklat',
                'price' => 6500,
                'category_id' => '1'
            ],
            [
                'name' => 'Roti Keju',
                'description' => 'Roti isi keju',
                'price' => 6500,
                'category_id' => '1'
            ],
            [
                'name' => 'Pillow Coklat',
                'description' => 'Kue manis berlapis rasa coklat',
                'price' => 24000,
                'category_id' => '2'
            ],
            [
                'name' => 'Pillow Keju',
                'description' => 'Kue manis berlapis rasa keju',
                'price' => 26000,
                'category_id' => '2'
            ],
            [
                'name' => 'Kue Tart Besar',
                'description' => 'Kue tart semua varian berdiameter 16cm',
                'price' => 180000,
                'category_id' => '3'
            ],
            [
                'name' => 'Nastar Keju',
                'description' => 'Kue nastar dengan taburan keju',
                'price' => 30000,
                'category_id' => '4'
            ],
            [
                'name' => 'Brownies Kering',
                'description' => 'Brownies kering rasa coklat',
                'price' => 24000,
                'category_id' => '4'
            ]
        ];
        foreach ($this->data['products'] as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'slug' => time() . '-' . Str::slug($product['name'], '-'),
                'description' => $product['description'],
                'file_path' => 'cup-oreo.jpg',
                'price' => $product['price'],
                'category_id' => $product['category_id'],
            ]);
        }
    }
}
