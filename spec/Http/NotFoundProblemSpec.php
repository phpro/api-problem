<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\HttpApiProblem;
use Phpro\ApiProblem\Http\NotFoundProblem;
use PhpSpec\ObjectBehavior;

class NotFoundProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('entity not found');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(NotFoundProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 404,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(404),
            'detail' => 'entity not found',
        ]);
    }
}
