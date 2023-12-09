<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendMessageTele($chat_id, $message)
    {
        $client = new Client([
            'base_uri' => 'https://api.telegram.org/bot' . config('services.telegram-bot-api.token') . '/',
        ]);

        $response = $client->request('POST', 'sendMessage', [
            'json' => [
                'chat_id' => $chat_id,
                'text' => $message,
            ],
        ]);

        $status = $response->getStatusCode();

        if ($status == 200) {
            return response()->json(['message' => 'Telegram message sent successfully.']);
        } else {
            return response()->json(['error' => 'Failed to send Telegram message.']);
        }
    }
}
