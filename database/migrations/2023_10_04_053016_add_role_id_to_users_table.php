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
        Schema::table('users', function (Blueprint $table) {
            //

            // $table->unsignedBigInteger('role_id')->after('id')->nullable();
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            // $table->unsignedBigInteger('role_id'); // The foreign key column
            // $table->foreign('role_id')->references('id')->on('roles');
            $table->unsignedBigInteger('role_id')->nullable(); // The foreign key column
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            // $table->dropForeign('role_id');
            $table->dropColumn('role_id');
        });
    }
};
