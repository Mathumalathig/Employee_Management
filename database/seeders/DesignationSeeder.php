<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('designations')->insert([
            ['name' => 'Marketing Manager', 'department_id' => 1],
            ['name' => 'Promoter', 'department_id' => 1],
            ['name' => 'Marketing Assistant', 'department_id' => 1],
            ['name' => 'Brand Manager', 'department_id' => 1],
            
            ['name' => 'Sales Manager', 'department_id' => 2],
            ['name' => 'Sales Representative', 'department_id' => 2],
            ['name' => 'Account Executive', 'department_id' => 2],
            ['name' => 'Sales Associate', 'department_id' => 2],
            
            ['name' => 'Software Engineer', 'department_id' => 3],
            ['name' => 'System Analyst', 'department_id' => 3],
            ['name' => 'IT Support', 'department_id' => 3],
            ['name' => 'Network Administrator', 'department_id' => 3],
            
            ['name' => 'HR Manager', 'department_id' => 4],
            ['name' => 'HR Assistant', 'department_id' => 4],
            ['name' => 'Recruiter', 'department_id' => 4],
            ['name' => 'HR Coordinator', 'department_id' => 4],

            ['name' => 'Accountant', 'department_id' => 5],
            ['name' => 'Financial Analyst', 'department_id' => 5],
            ['name' => 'Auditor', 'department_id' => 5],
            ['name' => 'Finance Manager', 'department_id' => 5],

            ['name' => 'Operations Manager', 'department_id' => 6],
            ['name' => 'Operations Analyst', 'department_id' => 6],
            ['name' => 'Operations Coordinator', 'department_id' => 6],

            ['name' => 'Administrative Assistant', 'department_id' => 7],
            ['name' => 'Office Manager', 'department_id' => 7],
            ['name' => 'Receptionist', 'department_id' => 7],

            ['name' => 'Customer Service Representative', 'department_id' => 8],
            ['name' => 'Support Specialist', 'department_id' => 8],
            ['name' => 'Call Center Agent', 'department_id' => 8],
        ]);
    }
}
