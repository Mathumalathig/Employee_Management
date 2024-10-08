<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DepartmentSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'Marketing', 'description' => 'Marketing Department'],
            ['name' => 'Sales', 'description' => 'Sales Department'],
            ['name' => 'IT', 'description' => 'IT Department'],
            ['name' => 'HR', 'description' => 'Human Resources Department'],
            ['name' => 'Finance', 'description' => 'Finance Department'],
            ['name' => 'Operations', 'description' => 'Operations Department'],
            ['name' => 'Administration', 'description' => 'Administration Department'],
            ['name' => 'Customer Support', 'description' => 'Customer Support Department'],
        ]);
    }
}
