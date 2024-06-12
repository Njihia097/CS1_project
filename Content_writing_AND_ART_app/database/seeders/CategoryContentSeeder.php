<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['categoryName' => 'Fiction'],
            ['CategoryName' => 'Non-Fiction'],
            ['CategoryName' => 'Science Fiction'],
            ['CategoryName' => 'Fantasy'],
            ['CategoryName' => 'Mystery'],
            ['CategoryName' => 'Thriller'],
            ['CategoryName' => 'Romance'],
            ['CategoryName' => 'Historical'],
            ['CategoryName' => 'Biography'],
            ['CategoryName' => 'Self-Help'],
            ['CategoryName' => 'Poetry'],
            ['CategoryName' => 'Children\'s Books'],
            ['CategoryName' => 'Other']
        ];

        /**
         * The & symbol is used to update the original array inside the foreach loop.
         */
        foreach ($categories as &$category) { 
            $category['created_at'] = Carbon::now();
            $category['updated_at'] = Carbon::now();
        }

        DB::table('category_content')->insert($categories);


    }
}
