<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        \App\Models\BlogPost::factory(100)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(AttributeGroupsSeeder::class);
        $this->call(AttributeProductsSeeder::class);
        $this->call(AttributeValuesSeeder::class);
        $this->call(BrandsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(GalleriesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(RelatedProductsSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(AdminOrderProductsSeeder::class);
    }
}
