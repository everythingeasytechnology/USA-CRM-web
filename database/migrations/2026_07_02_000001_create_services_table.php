<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->index();
            $table->integer('display_order')->default(1);
            $table->text('short_description');
            $table->longText('long_description')->nullable();
            
            // Programmatic SEO Targeting
            $table->boolean('pseo_enabled')->default(false);
            $table->text('target_countries')->nullable();
            $table->text('target_states')->nullable();
            $table->text('target_cities')->nullable();
            $table->string('pseo_slug_template')->nullable();
            $table->string('pseo_title_template')->nullable();
            $table->text('pseo_desc_template')->nullable();
            
            // SEO & Schemas
            $table->string('seo_title')->nullable();
            $table->string('canonical')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->longText('schema_custom')->nullable();
            
            // Statuses & Medias
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('cover_image')->nullable();
            $table->json('gallery_images')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
