<?php

use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

trait SendPushNotification
{

    /**
     * @param string $title
     * @param array $tokens
     * @param $payload
     * @return mixed
     */
    public function sendNotificationToAdmin(string $title, array $tokens, $payload)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder();

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($payload);

        $notificationBuilder->setTitle($title);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstream_response = FCM::sendTo($tokens, $option, $notification, $data);
        return $downstream_response;
    }


}
