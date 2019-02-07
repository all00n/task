<?php

use Illuminate\Database\Seeder;

class RolesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['name' => 'Директор']);
        DB::table('roles')->insert(['name' => 'Бухгалтер']);
        DB::table('roles')->insert(['name' => 'Оператор']);
        DB::table('roles')->insert(['name' => 'Программист']);
        DB::table('roles')->insert(['name' => 'Халоп']);
    }
}
