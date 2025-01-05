<?php

namespace App\EventListener;

use App\Service\TelegramService;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ExceptionListener
{
    private Environment $twig;
    private TelegramService $telegramService;

    public function __construct(Environment $twig, TelegramService $telegramService)
    {
        $this->twig = $twig;
        $this->telegramService = $telegramService;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($exception instanceof \Exception) {
            $this->telegramService->sendError($exception);
        } else {
            $this->telegramService->sendError(new \Exception("Non-Exception type error"));
        }

        $response = new Response(
            $this->twig->render('error.html.twig', [
                'exception' => $exception,
                'status_code' => $statusCode,
            ]),
            $statusCode
        );

        $event->setResponse($response);
    }
}
