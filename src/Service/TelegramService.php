<?php

namespace App\Service;

use TelegramBot\Api\BotApi;

class TelegramService
{
    private BotApi $api;

    public function __construct(string $token)
    {
        $this->api = new BotApi($token);
    }

    /**
     * Отправить сообщение в Telegram.
     *
     * @param int|string $chatId
     * @param string $message
     * @return void
     */
    public function sendMessage($chatId, string $message): void
    {
        $this->api->sendMessage($chatId, $message);
    }
}