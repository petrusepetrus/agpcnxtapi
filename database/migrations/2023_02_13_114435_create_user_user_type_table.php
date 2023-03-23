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
        Schema::create('user_user_type', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->index('user_user_type_user_id_foreign');
            $table->unsignedBigInteger('user_type_id')->index('user_user_type_user_type_id_foreign');
            $table->unsignedBigInteger('user_type_status_id')->index('user_user_type_user_type_status_id_foreign');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['user_type_status_id'])->references(['id'])->on('user_type_statuses');
            $table->foreign(['user_type_id'])->references(['id'])->on('user_types')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_user_type');
    }
};
