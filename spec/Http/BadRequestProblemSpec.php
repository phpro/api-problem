<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\BadRequestProblem;
use Phpro\ApiProblem\Http\HttpApiProblem;
use PhpSpec\ObjectBehavior;

class BadRequestProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('a reason');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BadRequestProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 400,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(400),
            'detail' => 'a reason',
        ]);
    }
}
