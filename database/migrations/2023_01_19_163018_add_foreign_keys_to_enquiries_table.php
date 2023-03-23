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
        Schema::table('enquiries', function (Blueprint $table) {
            $table->foreign(['country_id'])->references(['id'])->on('countries');
            $table->foreign(['enquiry_status_id'])->references(['id'])->on('enquiry_statuses');
            $table->foreign(['enquiry_type_id'])->references(['id'])->on('enquiry_types');
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
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropForeign('enquiries_country_id_foreign');
            $table->dropForeign('enquiries_enquiry_status_id_foreign');
            $table->dropForeign('enquiries_enquiry_type_id_foreign');
            $table->dropForeign('enquiries_phone_type_id_foreign');
        });
    }
};
