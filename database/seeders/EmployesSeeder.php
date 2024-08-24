<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmployesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'uuid' => Str::uuid(36),
            'name' => "Administrator",
            'DOB' => '1900-01-01',
            'tempat_lahir' => 'USA',
            'alamat' => 'New York',
            'jenis_kelamin' => '1',
        ];

        Employee::create($data);
    }
}
