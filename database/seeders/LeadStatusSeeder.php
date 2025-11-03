<?php
// database/seeders/LeadStatusSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'New', 'slug' => 'new', 'color' => '#3B82F6', 'order' => 1],
            ['name' => 'Contacted', 'slug' => 'contacted', 'color' => '#F59E0B', 'order' => 2],
            ['name' => 'Qualified', 'slug' => 'qualified', 'color' => '#8B5CF6', 'order' => 3],
            ['name' => 'Proposal Sent', 'slug' => 'proposal-sent', 'color' => '#06B6D4', 'order' => 4],
            ['name' => 'Negotiation', 'slug' => 'negotiation', 'color' => '#F97316', 'order' => 5],
            ['name' => 'Converted', 'slug' => 'converted', 'color' => '#10B981', 'order' => 6],
            ['name' => 'Lost', 'slug' => 'lost', 'color' => '#EF4444', 'order' => 7],
        ];

        foreach ($statuses as $status) {
            DB::table('lead_statuses')->insert(array_merge($status, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}