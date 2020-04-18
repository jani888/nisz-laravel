<?php

use App\User;
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
        // $this->call(UserSeeder::class);
        User::create(['email' => 'admin@test.hu', 'name' => 'teszt', 'password' => bcrypt('admin')]);

        \App\Models\Family::create(['id' => '123456789012', 'name' => 'Teszt család']);
    }
}
