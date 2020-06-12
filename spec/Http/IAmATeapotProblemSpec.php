<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\HttpApiProblem;
use Phpro\ApiProblem\Http\IAmATeapotProblem;
use PhpSpec\ObjectBehavior;

class IAmATeapotProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('i am a teapot');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(IAmATeapotProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 418,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(418),
            'detail' => 'i am a teapot',
        ]);
    }
}
