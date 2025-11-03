<?php
// database/migrations/2024_01_01_000005_create_campaigns_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->string('name');
            
            // Meta Campaign Details
            $table->string('meta_campaign_id')->nullable();
            $table->string('meta_adset_id')->nullable();
            $table->string('meta_ad_id')->nullable();
            
            // Campaign Settings
            $table->enum('status', ['active', 'paused', 'completed', 'draft'])->default('active');
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('objective')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Stats (can be cached)
            $table->integer('leads_count')->default(0);
            $table->decimal('spent', 10, 2)->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->index(['organization_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};