<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Exception;
use InvalidArgumentException;
use Phpro\ApiProblem\DebuggableApiProblemInterface;
use Phpro\ApiProblem\Http\ExceptionApiProblem;
use Phpro\ApiProblem\Http\HttpApiProblem;
use PhpSpec\ObjectBehavior;

class ExceptionApiProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new Exception('message', 500));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ExceptionApiProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_is_debuggable(): void
    {
        $this->shouldHaveType(DebuggableApiProblemInterface::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 500,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(500),
            'detail' => 'message',
        ]);
    }

    public function it_uses_internal_error_as_general_status_code(): void
    {
        $this->beConstructedWith(new Exception('message'));

        $this->toArray()->shouldBe([
            'status' => 500,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(500),
            'detail' => 'message',
        ]);
    }

    public function it_can_parse_to_debuggable_array(): void
    {
        $exception = new Exception('message', 500);
        $this->beConstructedWith($exception);

        $this->toDebuggableArray()->shouldBe([
            'status' => 500,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(500),
            'detail' => 'message',
            'exception' => [
                'type' => Exception::class,
                'message' => 'message',
                'code' => 500,
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'trace' => explode("\n", $exception->getTraceAsString()),
                'previous' => [],
            ],
        ]);
    }

    public function it_contains_flattened_previous_exceptions_in_debuggable_output(): void
    {
        $first = new Exception('first', 1);
        $previous = new Exception('previous', 2, $first);
        $exception = new Exception('message', 0, $previous);
        $this->beConstructedWith($exception);

        $this->toDebuggableArray()->shouldBe([
            'status' => 500,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(500),
            'detail' => 'message',
            'exception' => [
                'type' => Exception::class,
                'message' => 'message',
                'code' => 0,
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'trace' => explode("\n", $exception->getTraceAsString()),
                'previous' => [
                    [
                        'type' => Exception::class,
                        'message' => 'previous',
                        'code' => 2,
                        'line' => $previous->getLine(),
                        'file' => $previous->getFile(),
                        'trace' => explode("\n", $previous->getTraceAsString()),
                    ],
                    [
                        'type' => Exception::class,
                        'message' => 'first',
                        'code' => 1,
                        'line' => $first->getLine(),
                        'file' => $first->getFile(),
                        'trace' => explode("\n", $first->getTraceAsString()),
                    ],
                ],
            ],
        ]);
    }

    public function it_uses_the_class_of_the_exception_when_no_message_exists(): void
    {
        $exception = new Exception();
        $this->beConstructedWith($exception);

        $this->toArray()->shouldBe([
            'status' => 500,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(500),
            'detail' => Exception::class,
        ]);
    }

    public function it_should_deal_with_string_exception_codes(): void
    {
        $exception = new class($message = 'hell no') extends Exception {
            protected $code = 'nope';
        };
        $this->beConstructedWith($exception);

        $this->toArray()->shouldBe([
            'status' => 500,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(500),
            'detail' => $message,
        ]);
    }

    public function it_should_use_code_as_status_code_when_valid_http_status_code_error(): void
    {
        $message = 'an honest error';
        $this->beConstructedWith(new InvalidArgumentException($message, 400));

        $this->toArray()->shouldBe([
            'status' => 400,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(400),
            'detail' => $message,
        ]);
    }
}
