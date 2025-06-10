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
            $table->string("fname", 128);
            $table->string("lname", 128);
            $table->string("email", 128);
            $table->string("contact_number", 50)->nullable();
            $table->enum("gender", ["Male", "Female"])->nullable();
            $table->date("birthdate")->nullable();
            $table->string("complete_address")->nullable();
            $table->text("bio")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
