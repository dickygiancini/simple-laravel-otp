<?php

namespace Database\Seeders;

use App\Models\Master\MstRolesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MstRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        MstRolesModel::create([
            'name' => 'Developer',
            'level' => 1
        ]);

        MstRolesModel::create([
            'name' => 'Owner',
            'level' => 2
        ]);

        MstRolesModel::create([
            'name' => 'General Manager',
            'level' => 3
        ]);

        MstRolesModel::create([
            'name' => 'Manager',
            'level' => 4
        ]);

        MstRolesModel::create([
            'name' => 'Supervisor',
            'level' => 5
        ]);

        MstRolesModel::create([
            'name' => 'Employee',
            'level' => 6
        ]);
    }
}
