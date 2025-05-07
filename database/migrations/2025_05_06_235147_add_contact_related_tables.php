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
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('iUserId')->unsigned();
            $table->string('name', 150);
            $table->string('email', 150);
            $table->bigInteger('phone')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('profile_image', 255);
            $table->string('additional_file', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contact_additional_field', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('iContactId')->unsigned();
            $table->string('type', 100);
            $table->string('value', 150);
            $table->bigInteger('iChildContactId')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contact_custom_field', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('iContactId')->unsigned();
            $table->bigInteger('iCustomFieldId')->unsigned();
            $table->text('data')->nullable();
            $table->enum('isMerged', ['yes', 'no'])->default('no');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contact_merge', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('iMasterContactId')->unsigned();
            $table->bigInteger('iChildContactId')->unsigned();
            $table->timestamps();
        });

        Schema::create('custom_field', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('type', ['text', 'date', 'number', 'email']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
        Schema::dropIfExists('contact_additional_field');
        Schema::dropIfExists('contact_custom_field');
        Schema::dropIfExists('contact_merge');
        Schema::dropIfExists('custom_field');
    }
};
