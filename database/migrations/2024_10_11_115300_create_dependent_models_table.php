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
        Schema::create('dependent_models', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('othername');
            $table->string('gender');
            $table->string('DateOfBirth');
            $table->string('phone');
            $table->string('email');
            $table->string('passport')->nullable();
            $table->string('policynumber')->nullable();
            $table->string('status')->nullable();
            $table->string('StartDate')->nullable();
            $table->string('EndDate')->nullable();
            $table->string('clienttype')->nullable();
            $table->string('plantype')->nullable();
            $table->string('policytype')->nullable();
            $table->string('enrolleetype')->nullable();
            $table->string('relationship');
            $table->string('principal')->nullable();
            $table->string('principal_ID')->nullable();
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependent_models');
    }
};
