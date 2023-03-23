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
        Schema::create('phone_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->index('phone_user_user_id_foreign');
            $table->unsignedBigInteger('phone_id')->index('phone_user_phone_id_foreign');
            $table->unsignedBigInteger('phone_type_id')->index('phone_user_phone_type_id_foreign');
            $table->boolean('preferred_contact_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_user');
    }
};
