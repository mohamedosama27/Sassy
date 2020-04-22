<?php

use Illuminate\Database\Seeder;
use App\item;
use App\image;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //factory(item::class,9)->create();
        factory(User::class,1)->create();
    }
}
