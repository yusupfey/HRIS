<?php

namespace Database\Seeders;

use App\Models\Reference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $data = [
            'reference'=> 'Jenis Cuti'
        ];

        $data = Reference::latest()->first();
        $detail = [
            [
                'reference_id' => $data->id,
                'val_name' => 'Tahunan',
                'val' => 1,
            ],
            [
                'reference_id' => $data->id,
                'val_name' => 'Khusus',
                'val' => 2,
            ],
            [
                'reference_id' => $data->id,
                'val_name' => 'Melahirkan',
                'val' => 3,
            ]
        ];
        DB::table('d_references')->insert($detail);
    }
}
