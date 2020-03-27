<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\HttpApiProblem;
use Phpro\ApiProblem\Http\PreconditionRequiredProblem;
use PhpSpec\ObjectBehavior;

class PreconditionRequiredProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('precondition required');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PreconditionRequiredProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 428,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(428),
            'detail' => 'precondition required',
        ]);
    }
}
