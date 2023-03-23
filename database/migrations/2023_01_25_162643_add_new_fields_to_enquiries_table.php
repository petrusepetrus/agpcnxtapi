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
            $table->string('business_name')->nullable();
            $table->string('business_url')->nullable();;
            $table->string('other_social_media') ->nullable();

            $table->boolean('marketing_chk')->nullable();
            $table->boolean('ecommerce_chk')->nullable();
            $table->boolean('blog_chk')->nullable();
            $table->boolean('portfolio_chk')->nullable();
            $table->boolean('membership_chk')->nullable();
            $table->boolean('personal_chk')->nullable();
            $table->boolean('nonprofit_chk')->nullable();

            $table->boolean('google_chk')->nullable();
            $table->boolean('you_tube_chk')->nullable();
            $table->boolean('facebook_chk')->nullable();
            $table->boolean('twitter_chk')->nullable();
            $table->boolean('tik_tok_chk')->nullable();
            $table->boolean('linked_in_chk')->nullable();
            $table->boolean('snapchat_chk')->nullable();
            $table->boolean('other_chk') ->nullable();
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
            $table->dropColumn('business_name');
            $table->dropColumn('business_url');
            $table->dropColumn('other_social_media') ;

            $table->dropColumn('marketing_chk');
            $table->dropColumn('ecommerce_chk');
            $table->dropColumn('blog_chk');
            $table->dropColumn('portfolio_chk');
            $table->dropColumn('membership_chk');
            $table->dropColumn('personal_chk');
            $table->dropColumn('nonprofit_chk');

            $table->dropColumn('google_chk');
            $table->dropColumn('you_tube_chk');
            $table->dropColumn('facebook_chk');
            $table->dropColumn('twitter_chk');
            $table->dropColumn('tik_tok_chk');
            $table->dropColumn('linked_in_chk');
            $table->dropColumn('snapchat_chk');
            $table->dropColumn('other_chk') ;
        });
    }
};
