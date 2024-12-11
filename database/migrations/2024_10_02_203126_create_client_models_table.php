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
        Schema::create('client_models', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('othername');
            $table->string('gender');
            $table->string('DateOfBirth');
            $table->string('phone');
            $table->string('email');
            $table->string('passport')->nullable();
            $table->string('policynumber')->nullable();
            $table->string('status');
            $table->string('StartDate');
            $table->string('EndDate');
            $table->string('clienttype');
            $table->string('plantype');
            $table->string('user_id');
            $table->string('policytype');
            $table->string('enrolleetype');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_models');
    }
};