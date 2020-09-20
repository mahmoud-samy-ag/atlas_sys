<?php

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
        $this->call(LaratrustSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(Areas::class);
        $this->call(Addresses::class);
        $this->call(Products::class);
        $this->call(Doctors::class);
        $this->call(DailyReportSeeder::class);
    }
}
