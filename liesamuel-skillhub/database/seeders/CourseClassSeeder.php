<?php

namespace Database\Seeders;

use App\Models\CourseClass;
use Illuminate\Database\Seeder;

class CourseClassSeeder extends Seeder
{
    public function run(): void
    {
        CourseClass::factory()->count(5)->create();
    }
}

