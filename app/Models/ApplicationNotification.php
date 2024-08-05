<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class ApplicationNotification extends Model
{
    public static function sendOneSignalNotificationSchedule($notificationData) {

        $appId = $notificationData['notification_id'];
        $apiKey = $notificationData['notification_key'];
        $notification_title = $notificationData['notification_title'];
        // $notification_url = $notificationData['notification_url'];
        $notification_url = 'https://play.google.com/store/apps/details?id=com.translator.hindi.english'; // Your application's Google Play Store URL
        $notification_image = $notificationData['notification_image'];
        $notification_message = $notificationData['notification_description'];
        // $notification_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notificationData['notification_time']) ;

        $client = new Client();

        $response = $client->post("https://onesignal.com/api/v1/notifications", [
            'headers' => [
                'Authorization' => 'Basic ' . $apiKey,
            ],
            'json' => [
                'app_id' => $appId,
                'contents' => ['en' => $notification_message],
                'headings' => ['en' => $notification_title],
                'url' => $notification_url,
                'big_picture' => $notification_image,
                'large_icon' => $notification_image,
                'chrome_web_image' => $notification_image,
                // 'send_after' => $notification_time,
                'included_segments' => ['All'],
            ],
        ]);
        return $response;
    }


}
