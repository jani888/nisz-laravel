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
        $family = factory(\App\Models\Family::class)->create();
        // $this->call(UserSeeder::class);
        $user = User::create(['email' => 'admin@test.hu', 'name' => 'teszt', 'family_id' => $family->id, 'password' => bcrypt('admin')]);

        factory(\App\User::class)->times(10)->create(['family_id' => $family->id]);

        \App\Models\Family::create(['id' => '123456789012', 'name' => 'Teszt család']);

        factory(\App\Models\Todo::class)->times(10)->create()->each(function ($todo) use ($user){
            $todo->users()->attach($user);
        });
    }
}
