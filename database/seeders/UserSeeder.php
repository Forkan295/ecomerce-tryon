<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modelQuery = User::query();

        if ($modelQuery->count() == 0) {
            $data = [
                'uuid'     => Str::uuid(),
                'name'     => 'Client',
                'email'    => 'client@gmail.com',
                'password' => bcrypt('swt@137#'),
            ];

            $user = $modelQuery->create($data);

            $tenant = Tenant::create([
                'name'   => data_get($user, 'name'),
                'domain' => 'softwind',
            ]);

            $user->tenants()->attach(['tenant_id' => data_get($tenant, 'id')]);

            $user->update(['tenant_id' => data_get($tenant, 'id')]);
        }

//        $query = User::query();
//
//        if ($query->count() == 0){
//            $query->insert([
//                [
//                    'uuid' => Str::uuid(),
//                    'name'     => 'Admin',
//                    'email'    => 'admin@mail.com',
//                    'password' => bcrypt('swt@137#'),
//                ],
//                [
//                    'uuid' => Str::uuid(),
//                    'name'     => 'system',
//                    'email'    => 'sys@mail.com',
//                    'password' => bcrypt('345#23'),
//                ]
//            ]);
//        }

    }
}
