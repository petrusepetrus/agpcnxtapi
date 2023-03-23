<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->dateTime('enquiry_date')->nullable();
            $table->string('enquiry', 256)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('international_dialling_code')->nullable();
            $table->string('country')->nullable();
            $table->string('phone_type')->nullable();
            $table->unsignedBigInteger('enquiry_type_id')->nullable()->index('enquiries_enquiry_type_id_foreign');
            $table->unsignedBigInteger('enquiry_status_id')->nullable()->index('enquiries_enquiry_status_id_foreign');
            $table->unsignedBigInteger('phone_type_id')->nullable()->index('enquiries_phone_type_id_foreign');
            $table->string('enquiry_type')->nullable();
            $table->boolean('mailing_list')->nullable();
            $table->boolean('terms_and_conditions');
            $table->unsignedBigInteger('country_id')->nullable()->index('enquiries_country_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enquiries');
    }
};
