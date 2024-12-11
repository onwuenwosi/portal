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
        Schema::create('parequest_models', function (Blueprint $table) {
            $table->id();
            $table->string('Diagnosis');
            $table->string('Procedure');
            $table->string('Qty');
            $table->string('comment');
            $table->string('client_id')->nullable();
            $table->string('user')->nullable();
            $table->string('UnitPrice');
            $table->string('Total');
            $table->string('Remark')->default('Pending');
            $table->string('HMO_comment')->nullable();
            $table->string('batch_id')->nullable();
            $table->string('approvedBy')->nullable();
            $table->string('code')->default('Pending');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parequest_models');
    }
};