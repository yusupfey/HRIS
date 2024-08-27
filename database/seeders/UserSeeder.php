<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'uuid'=> Str::uuid(36),
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $getuuid=User::latest()->first();
        $data = [
            'uuid' => $getuuid->uuid,
            'name' => "Administrator",
            'DOB' => '1900-01-01',
            'tempat_lahir' => 'USA',
            'alamat' => 'New York',
            'jenis_kelamin' => '1',
            'no_telp' => '00010101',
            'id_unit' => '1'
        ];

        Employee::create($data);
    }
}
