<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Field::create([
            'name' => 'KSPHP',
            'budget' => 999999999
        ]);
        Field::create([
            'name' => 'Standardisasi dan Pengujian',
            'budget' => 888888888
        ]);
        Field::create([
            'name' => 'Tata Usaha',
            'budget' => 777777777
        ]);
        Field::create([
            'name' => 'Program dan Evaluasi',
            'budget' => 666666666
        ]);
    }
}
