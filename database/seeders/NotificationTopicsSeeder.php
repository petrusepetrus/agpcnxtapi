<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notification_topics=[
            ['notification_topic'=>'Support Notices','notification_topic_description'=>'Status updates on reported problems'],
            ['notification_topic'=>'Blog Notification','notification_topic_description'=>'New blog entry announcements'],
            ['notification_topic'=>'Service Updates','notification_topic_description'=>'Notification of changes to services, planned outages and so forth'],
            ['notification_topic'=>'New Features','notification_topic_description'=>'Announcements on new services or feature upgrades'],
        ];
        DB::table('notification_topics')->insert($notification_topics);
    }
}
