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
        Schema::create('application_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("group_id")->nullable(false);
            $table->unsignedBigInteger("application_id")->nullable(false);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('application_id')->references('id')->on('applications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_group');
    }
};
