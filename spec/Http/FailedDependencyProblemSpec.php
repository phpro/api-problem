<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\FailedDependencyProblem;
use Phpro\ApiProblem\Http\HttpApiProblem;
use PhpSpec\ObjectBehavior;

class FailedDependencyProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('failed dependency');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FailedDependencyProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 424,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(424),
            'detail' => 'failed dependency',
        ]);
    }
}
