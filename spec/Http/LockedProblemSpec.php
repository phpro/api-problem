<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\HttpApiProblem;
use Phpro\ApiProblem\Http\LockedProblem;
use PhpSpec\ObjectBehavior;

class LockedProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('locked');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(LockedProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 423,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(423),
            'detail' => 'locked',
        ]);
    }
}
