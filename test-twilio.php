<?php

use Illuminate\Contracts\Console\Kernel;
use Twilio\Rest\Client;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$sid = env('TWILIO_ACCOUNT_SID');
$token = env('TWILIO_AUTH_TOKEN');
$twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

$twilio = new Client($sid, $token);
$templateSid = env('TWILIO_WHATSAPP_TEMPLATE_SID', 'HX669abffc47f8e40515248108fed98ad8');

try {
    $message = $twilio->messages->create(
        'whatsapp:+916292237202', // user's own number to test
        [
            'from' => $twilioNumber,
            'contentSid' => $templateSid,
            'contentVariables' => json_encode(['1' => '1234']),
        ]
    );
    echo 'Success! Message SID: '.$message->sid;
} catch (Exception $e) {
    echo 'Error: '.$e->getMessage();
}
