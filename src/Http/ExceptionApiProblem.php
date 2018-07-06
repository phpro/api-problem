<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

use Phpro\ApiProblem\DebuggableApiProblemInterface;
use Throwable;

class ExceptionApiProblem extends HttpApiProblem implements DebuggableApiProblemInterface
{
    /**
     * @var Throwable
     */
    private $exception;

    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
        $exceptionCode = $exception->getCode();
        $statusCode = $exceptionCode >= 400 && $exceptionCode <= 599
            ? $exceptionCode
            : 500;

        parent::__construct($statusCode, [
            'detail' => $exception->getMessage(),
        ]);
    }

    public function toDebuggableArray(): array
    {
        $previousMessages = [];
        $previous = $this->exception;
        while ($previous = $previous->getPrevious()) {
            $previousMessages[] = $this->serializeException($previous);
        }

        return array_merge(
            $this->toArray(),
            [
                'exception' => array_merge(
                    $this->serializeException($this->exception),
                    [
                        'previous' => $previousMessages,
                    ]
                ),
            ]
        );
    }

    private function serializeException(Throwable $throwable): array
    {
        return [
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
            'trace' => $throwable->getTraceAsString(),
        ];
    }
}
