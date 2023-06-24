<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $query = AdminUser::query();

        if ($query->count() == 0){
            $query->insert([
                [
                    'uuid' => Str::uuid(),
                    'name'     => 'Admin',
                    'email'    => 'admin@mail.com',
                    'password' => bcrypt('swt@137#'),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name'     => 'system',
                    'email'    => 'sys@mail.com',
                    'password' => bcrypt('345#23'),
                ]
            ]);
        }

    }
}
