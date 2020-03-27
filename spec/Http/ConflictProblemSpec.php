<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\ConflictProblem;
use Phpro\ApiProblem\Http\HttpApiProblem;
use PhpSpec\ObjectBehavior;

class ConflictProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('conflict');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ConflictProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 409,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(409),
            'detail' => 'conflict',
        ]);
    }
}
