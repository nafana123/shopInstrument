<?php

namespace App\Service;

use TelegramBot\Api\BotApi;

class TelegramService
{
    private BotApi $api;

    public function __construct()
    {
        $telegramBotApi = $_ENV['TELEGRAM_BOT_API_KEY'];

        $this->api = new BotApi($telegramBotApi);
    }

    /**
     * Отправить сообщение о заказе в Telegram.
     *
     * @param string $userName
     * @param int $orderNumber
     * @param array $basketItems
     * @param float $totalPrice
     * @return void
     */
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

        $message .= "💰 Общая сумма: $totalPrice руб.\n";

        $telegramChatId = $_ENV['TELEGRAM_CHAT_ID'];
        try {
            $this->api->sendMessage($telegramChatId, $message, 'Markdown');
        } catch (\Exception $e){

        }
    }
}
