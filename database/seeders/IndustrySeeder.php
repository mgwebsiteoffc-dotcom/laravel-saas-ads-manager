<?php
// database/seeders/IndustrySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            ['name' => 'Real Estate', 'slug' => 'real-estate', 'icon' => '🏠', 'color' => '#3B82F6', 'order' => 1],
            ['name' => 'Automotive', 'slug' => 'automotive', 'icon' => '🚗', 'color' => '#EF4444', 'order' => 2],
            ['name' => 'E-Commerce', 'slug' => 'ecommerce', 'icon' => '🛒', 'color' => '#8B5CF6', 'order' => 3],
            ['name' => 'Healthcare', 'slug' => 'healthcare', 'icon' => '⚕️', 'color' => '#10B981', 'order' => 4],
            ['name' => 'Education', 'slug' => 'education', 'icon' => '📚', 'color' => '#F59E0B', 'order' => 5],
            ['name' => 'Restaurant', 'slug' => 'restaurant', 'icon' => '🍽️', 'color' => '#F97316', 'order' => 6],
            ['name' => 'Fitness', 'slug' => 'fitness', 'icon' => '💪', 'color' => '#EC4899', 'order' => 7],
            ['name' => 'Technology', 'slug' => 'technology', 'icon' => '💻', 'color' => '#6366F1', 'order' => 8],
            ['name' => 'Finance', 'slug' => 'finance', 'icon' => '💰', 'color' => '#14B8A6', 'order' => 9],
            ['name' => 'Other', 'slug' => 'other', 'icon' => '✨', 'color' => '#6B7280', 'order' => 10],
        ];

        foreach ($industries as $industry) {
            DB::table('industries')->insert(array_merge($industry, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}