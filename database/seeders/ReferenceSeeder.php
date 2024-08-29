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

        Reference::create($data);


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


        $data = [
            'reference'=> 'Jenis Permohonan'
        ];

        Reference::create($data);

        $data = Reference::latest()->first();
        $detail = [
            [
                'reference_id' => $data->id,
                'val_name' => 'Cuti',
                'val' => 1,
            ],
            [
                'reference_id' => $data->id,
                'val_name' => 'Izin',
                'val' => 2,
            ],

        ];
        DB::table('d_references')->insert($detail);
    }
}
