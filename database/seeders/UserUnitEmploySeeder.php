<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\shift;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserUnitEmploySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    protected $unit = [
        ['name'=>'Direktur', 'kepala_unit'=>'b3437a35-e127-4d44-809d-6a776f7ac504', 'id_head_unit'=>null],
        ['name'=>'HRD', 'kepala_unit'=>'b3437a35-e127-4d44-809d-6a776f7ac504', 'id_head_unit'=>1],
        ['name'=>'Manager Keperawatan', 'kepala_unit'=>'b3437a35-e127-4d44-809d-6a776f7ac510', 'id_head_unit'=>2],
        ['name'=>'Instalasi Rawat Jalan', 'kepala_unit'=>'b3437a35-e127-4d44-809d-6a776f7ac505', 'id_head_unit'=>3]
    ];
    public function run(): void
    {
        User::factory()->create([
            'uuid'=> 'b3437a35-e127-4d44-809d-6a776f7ac504',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        

        $data = [
            'uuid' => 'b3437a35-e127-4d44-809d-6a776f7ac504',
            'name' => "Administrator",
            'DOB' => '1900-01-01',
            'tempat_lahir' => 'USA',
            'alamat' => 'New York',
            'jenis_kelamin' => '1',
            'no_telp' => '00010101',
            'id_unit' => '1'
        ];

        Employee::create($data);

        User::factory()->create([
            'uuid'=> 'b3437a35-e127-4d44-809d-6a776f7ac505',
            'name' => 'Jane doe',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $data = [
            'uuid' => 'b3437a35-e127-4d44-809d-6a776f7ac505',
            'name' => "Jane Doe",
            'DOB' => '1900-01-01',
            'tempat_lahir' => 'USA',
            'alamat' => 'New York',
            'jenis_kelamin' => '0',
            'no_telp' => '00010101',
            'id_unit' => '4'
        ];

        Employee::create($data);

        User::factory()->create([
            'uuid'=> 'b3437a35-e127-4d44-809d-6a776f7ac510',
            'name' => 'Waskita wasi',
            'email' => 'wasi@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $data = [
            'uuid' => 'b3437a35-e127-4d44-809d-6a776f7ac510',
            'name' => "Waskita wasi",
            'DOB' => '1900-01-01',
            'tempat_lahir' => 'USA',
            'alamat' => 'New York',
            'jenis_kelamin' => '0',
            'no_telp' => '00010101',
            'id_unit' => '2'
        ];

        Employee::create($data);

        User::factory()->create([
            'uuid'=> 'b3437a35-e127-4d44-809d-6a776f7ac501',
            'name' => 'Jhon doe',
            'email' => 'John@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        
        $data = [
            'uuid' => 'b3437a35-e127-4d44-809d-6a776f7ac501',
            'name' => "Jhon Doe",
            'DOB' => '1900-01-01',
            'tempat_lahir' => 'USA',
            'alamat' => 'New York',
            'jenis_kelamin' => '1',
            'no_telp' => '00010101',
            'id_unit' => '4'
        ];

        Employee::create($data);

        // 3
        User::factory()->create([
            'uuid'=> 'b3437a35-e127-4d44-809d-6a776f7ac500',
            'name' => 'Steve',
            'email' => 'steve@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    
        
        $data = [
            'uuid' => 'b3437a35-e127-4d44-809d-6a776f7ac500',
            'name' => "Steveie",
            'DOB' => '1900-01-01',
            'tempat_lahir' => 'USA',
            'alamat' => 'New York',
            'jenis_kelamin' => '1',
            'no_telp' => '00010101',
            'id_unit' => '4'
        ];
    
        Employee::create($data);

        Unit::insert($this->unit);

    }
}
