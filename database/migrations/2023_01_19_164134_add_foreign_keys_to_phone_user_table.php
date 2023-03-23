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
        Schema::table('phone_user', function (Blueprint $table) {
            $table->foreign(['phone_id'])->references(['id'])->on('phones')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['phone_type_id'])->references(['id'])->on('phone_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phone_user', function (Blueprint $table) {
            $table->dropForeign('phone_user_phone_id_foreign');
            $table->dropForeign('phone_user_user_id_foreign');
            $table->dropForeign('phone_user_phone_type_id_foreign');
        });
    }
};
