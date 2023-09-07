<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use \Carbon\Carbon;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUser();
        $this->createAdmin();
    }

    public function createUser() {
        $user = User::create([
            'id' => Uuid::uuid4()->toString(),
            'first_name' => 'Customer',
            "last_name" => 'Example',
            "email" => 'customer@example.com',
            "password" => bcrypt('test1234'),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        $user->assignRole('user');
    }

    public function createAdmin() {
        $admin = User::create([
            'id' => Uuid::uuid4()->toString(),
            "first_name" => 'Admin',
            "last_name" => 'Example',
            "email" => 'admin@example.com',
            "password" => bcrypt('test1234'),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        $admin->assignRole('admin');
    }
}
