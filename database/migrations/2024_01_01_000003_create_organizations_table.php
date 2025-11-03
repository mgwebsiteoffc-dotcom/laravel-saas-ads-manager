<?php
// database/migrations/2024_01_01_000003_create_organizations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('industry_id')->nullable();
            
            // Onboarding
            $table->enum('onboarding_status', [
                'pending',
                'industry_selected', 
                'meta_connected',
                'campaign_created',
                'completed'
            ])->default('pending');
            $table->timestamp('onboarding_completed_at')->nullable();
            
            // Meta Integration
            $table->text('meta_access_token')->nullable();
            $table->string('meta_ad_account_id')->nullable();
            $table->string('meta_pixel_id')->nullable();
            $table->string('meta_business_id')->nullable();
            
            // Settings
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key
            $table->foreign('industry_id')->references('id')->on('industries')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};