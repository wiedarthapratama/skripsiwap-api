<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function test()
    {
        $token = ["eyn3KdP2RTKgE_p5xxdKz6:APA91bHYv26XkFs8t06vwayzX_1RRluVvsppGQw3IfKfsUjvsZ79RumQbQR_vEyNSnL6gK9o1pLEBcEpwSIu8MEp1sxUa1VeX-D9XiJoX2Vw8B2c0OQ0H6hDLY0CdtfZuRNzXwVu8IV3"];
        return $this->api->send_notification($token, false, 'Pemberitahuan!', 'Segera Checkout pesananmu, ada produk yang sudah habis batas waktu booked');
    }
}
