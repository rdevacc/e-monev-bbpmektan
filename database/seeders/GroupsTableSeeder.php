<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'field_id' => 1,
            'name' => 'PHP',
            'spv' => 'Tri S'
        ]);
        Group::create([
            'field_id' => 1,
            'name' => 'Kerja Sama',
            'spv' => 'Armadu'
        ]);
        Group::create([
            'field_id' => 2,
            'name' => 'Standardisasi',
            'spv' => 'Shinta R'
        ]);
        Group::create([
            'field_id' => 2,
            'name' => 'Pengujian',
            'spv' => 'Anggit'
        ]);
        Group::create([
            'field_id' => 3,
            'name' => 'Rumah Tangga',
            'spv' => 'Yuni'
        ]);
        Group::create([
            'field_id' => 3,
            'name' => 'Kepegawaian',
            'spv' => 'Kartini'
        ]);
        Group::create([
            'field_id' => 3,
            'name' => 'Keuangan',
            'spv' => 'Sigid H'
        ]);
        Group::create([
            'field_id' => 4,
            'name' => 'Program',
            'spv' => 'Fero'
        ]);
        Group::create([
            'field_id' => 4,
            'name' => 'Evaluasi',
            'spv' => 'Utami'
        ]);
    }
}
