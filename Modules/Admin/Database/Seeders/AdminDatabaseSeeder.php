<?php

namespace Modules\Admin\Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $hashedPassword = Hash::make(12345678);
        $faker = App::make(Faker::class);
        DB::table('admins')->insert([
            'uuid' => Str::uuid(),
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'phone_number' =>  $faker->phoneNumber,
            'password' => $hashedPassword,
        ]);

        // $this->call("OthersTableSeeder");
    }
}
