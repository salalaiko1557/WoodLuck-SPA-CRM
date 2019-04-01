<?php

use Illuminate\Database\Seeder;
use App\MenuItem;

class Menu_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->insert(['name' => 'Головна',     'slug' => 'home']);
        DB::table('menu_items')->insert(['name' => 'Замовлення',  'slug' => 'orders']);
        DB::table('menu_items')->insert(['name' => 'Клієнти',     'slug' => 'customers']);
        DB::table('menu_items')->insert(['name' => 'Склад',       'slug' => 'stock']);
        DB::table('menu_items')->insert(['name' => 'Звiти',       'slug' => 'reports']);
        DB::table('menu_items')->insert(['name' => 'Користувачi', 'slug' => 'users']);
    }
}
