<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

use Phpro\ApiProblem\ApiProblemInterface;

class HttpApiProblem implements ApiProblemInterface
{
    public const TYPE_HTTP_RFC = 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html';

    private static $statusTitles = [
        // CLIENT ERROR
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        // SERVER ERROR
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    /**
     * @var array
     */
    private $data;

    public function __construct(int $statusCode, array $data)
    {
        $this->data = array_merge(
            [
                'status' => $statusCode,
                'type' => self::TYPE_HTTP_RFC,
                'title' => self::getTitleForStatusCode($statusCode),
                'detail' => '',
            ],
            $data
        );
    }

    public static function getTitleForStatusCode(int $statusCode): string
    {
        return self::$statusTitles[$statusCode] ?? 'Unknown';
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
