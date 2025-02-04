<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = ($exception instanceof HttpExceptionInterface) ? $exception->getStatusCode() : 500;

        // Логируем ошибку
        $this->logger->error($exception->getMessage());

        $response = new JsonResponse([
            'error' => $exception->getMessage(),
            'status' => $statusCode
        ], $statusCode);

        $event->setResponse($response);
    }
}
