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
        Schema::create('queue_models', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('othername');
            $table->string('DateOfBirth');
            $table->string('gender');
            $table->string('phone');
            $table->string('email');
            $table->string('check_in_by');
            $table->string('policynumber');
            $table->string('StartDate');
            $table->string('EndDate');
            $table->string('status');
            $table->string('clienttype');
            $table->string('plantype');
            $table->string('policytype');
            $table->string('enrolleetype');
            $table->string('passport');
            $table->timestamps();
            $table->string('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_models');
    }
};
