<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\HttpApiProblem;
use Phpro\ApiProblem\Http\PreconditionFailedProblem;
use PhpSpec\ObjectBehavior;

class PreconditionFailedProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('precondition failed');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PreconditionFailedProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 412,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(412),
            'detail' => 'precondition failed',
        ]);
    }
}
