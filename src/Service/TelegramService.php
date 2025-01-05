<?php

namespace App\Service;

use TelegramBot\Api\BotApi;
use Exception;

class TelegramService
{
    private BotApi $api;
    private string $telegramChatId;

    public function __construct()
    {
        $telegramBotApi = $_ENV['TELEGRAM_BOT_API_KEY'];

        $this->api = new BotApi($telegramBotApi);

        $this->telegramChatId = $_ENV['TELEGRAM_CHAT_ID'];
    }
    public function sendOrderNotification(
        string $userName,
        int $orderNumber,
        array $basketItems,
        float $totalPrice
    ): void {
        $message = "🛒 Новый заказ от пользователя: $userName\n";
        $message .= "📅 Дата заказа: " . (new \DateTime())->format('d-m-Y H:i:s') . "\n";
        $message .= "🧾 Номер заказа: $orderNumber\n";
        $message .= "---------------------------------\n";
        $message .= "Товары в заказе:\n";

        foreach ($basketItems as $basketItem) {
            $quantity = $basketItem['quantity'];
            $product = $basketItem['product'];

            if ($product) {
                $message .= "🔹" . $product->getName() . "\n";
                $message .= "   Количество: $quantity\n";
                $message .= "   Цена: " . $product->getAmount() . " руб.\n";
                $message .= "   Сумма: " . ($product->getAmount() * $quantity) . " руб.\n";
                $message .= "---------------------------------\n";
            }
        }

        $message .= "💰 *Общая сумма:* $totalPrice руб.\n";


        try {
            $this->api->sendMessage($this->telegramChatId, $message, 'Markdown');
        } catch (Exception $e) {
            error_log("Telegram notification failed: " . $e->getMessage());
        }
    }

    public function sendError(Exception $exception): void
    {
        $message = "⚠️ Произошла ошибка на сайте\n\n";
        $message .= "🔴 *Сообщение:* {$exception->getMessage()}\n";
        $message .= "📂 *Файл:* {$exception->getFile()}\n";
        $message .= "📍 *Строка:* {$exception->getLine()}\n";

        try {
            $this->api->sendMessage($this->telegramChatId, $message, 'Markdown');
        } catch (Exception $e) {
            error_log("Telegram notification failed: " . $e->getMessage());
        }
    }
}
