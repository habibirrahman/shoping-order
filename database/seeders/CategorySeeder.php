<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
        DB::table('users')->insert([
            'name' => 'Admin DA',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123!'),
            'role' => 1
        ]);
    }
}
