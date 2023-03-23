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
        Schema::create('address_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->index('address_user_user_id_foreign');
            $table->unsignedBigInteger('address_id')->index('address_user_address_id_foreign');
            $table->unsignedBigInteger('address_type_id')->index('address_user_address_type_id_foreign');
            $table->boolean('preferred_contact_address');
            $table->foreign(['address_id'])->references(['id'])->on('addresses')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['address_type_id'])->references(['id'])->on('address_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_user');
    }
};
