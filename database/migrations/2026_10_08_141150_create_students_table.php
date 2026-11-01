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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('admission_no')->unique();
            $table->string('roll_no')->nullable();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();

            $table->date('date_of_birth')->nullable();

            $table->enum('gender', [
                'male',
                'female',
                'other'
            ])->nullable();

            $table->string('blood_group')->nullable();

            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();

            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            $table->date('admission_date')->nullable();

            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('section')->nullable();

            $table->boolean('status')->default(true);
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            $table->foreign('class_id')
                ->references('id')
                ->on('school_classes')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
