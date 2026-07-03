<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->string('badge')->nullable()->after('slug');
            $table->boolean('status')->default(true)->after('cta_url');
            $table->integer('display_order')->default(0)->after('status');
            $table->boolean('is_featured')->default(false)->after('display_order');
            $table->string('support_duration')->nullable()->after('is_featured');
            $table->string('tech_stack')->nullable()->after('support_duration');
            $table->string('suitable_for')->nullable()->after('tech_stack');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'badge', 'status', 'display_order',
                'is_featured', 'support_duration', 'tech_stack', 'suitable_for',
            ]);
        });
    }
};
