<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->data['categories'] = ['Roti', 'Kue', 'Kue Tart', 'Kue Kering', 'Camilan', 'Lain-lain'];
        foreach ($this->data['categories'] as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category, '-')
            ]);
        }
    }
}
