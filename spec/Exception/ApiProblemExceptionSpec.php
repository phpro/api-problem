<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Exception;

use Exception;
use Phpro\ApiProblem\ApiProblemInterface;
use Phpro\ApiProblem\Exception\ApiProblemException;
use PhpSpec\ObjectBehavior;

class ApiProblemExceptionSpec extends ObjectBehavior
{
    public function let(ApiProblemInterface $apiProblem): void
    {
        $this->beConstructedWith($apiProblem);
        $apiProblem->toArray()->willReturn([]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ApiProblemException::class);
    }

    public function it_is_an_excpetion(): void
    {
        $this->shouldHaveType(Exception::class);
    }

    public function it_contains_an_api_problem(ApiProblemInterface $apiProblem): void
    {
        $this->getApiProblem()->shouldBe($apiProblem);
    }

    public function it_uses_details_as_message(ApiProblemInterface $apiProblem): void
    {
        $apiProblem->toArray()->willReturn(['detail' => 'detail']);
        $this->getMessage()->shouldBe('detail');
    }

    public function it_falls_back_to_title_as_message(ApiProblemInterface $apiProblem): void
    {
        $apiProblem->toArray()->willReturn(['title' => 'title']);
        $this->getMessage()->shouldBe('title');
    }

    public function it_uses_empty_message_when_no_title_and_details_are_set(): void
    {
        $this->getMessage()->shouldBe('');
    }

    public function it_uses_status_as_error_code(ApiProblemInterface $apiProblem): void
    {
        $apiProblem->toArray()->willReturn(['status' => 100]);
        $this->getCode()->shouldBe(100);
    }

    public function it_falls_back_to_empty_code(): void
    {
        $this->getCode()->shouldBe(0);
    }
}
