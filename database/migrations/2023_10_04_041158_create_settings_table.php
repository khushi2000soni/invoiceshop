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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 191)->default(null)->nullable();
            $table->text('value')->default(null)->nullable();
            $table->string('type',191)->default(null)->nullable();
            $table->string('display_name',191)->default(null)->nullable();
            $table->text('details')->default(null)->nullable();
            $table->enum('group', ['web','app','payment','mail'])->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=> inactive, 1=> active');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->default(null)->nullable();
            $table->timestamp('updated_at')->default(Null)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
