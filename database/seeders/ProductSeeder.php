<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->count(200)->create();
        // DB::table('products')->insert([
        //     [
        //         'kodeproduk' => 'SMN01',
        //         'name' => 'Semen',
        //         'description'=> '1 Sak',
        //         'price' => 12000,
        //         'quantity' => '10',
        //         'status' => '1',
        //     ],
        // ]);
    }
}
