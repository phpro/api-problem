<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\HttpApiProblem;
use Phpro\ApiProblem\Http\ValidationApiProblem;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationApiProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new ConstraintViolationList([
            new ConstraintViolation('message1', 'b', [], 'c', 'path1', 'e', null, 'f'),
            new ConstraintViolation('message2', '2', [], '3', 'path2', '5', null, '6'),
        ]));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ValidationApiProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 400,
            'type' => ValidationApiProblem::TYPE_SYMFONY_VIOLATIONS,
            'title' => 'Validation Failed',
            'detail' => 'path1: message1'."\n".'path2: message2',
            'violations' => [
                [
                    'propertyPath' => 'path1',
                    'title' => 'message1',
                    'type' => 'urn:uuid:f',
                ],
                [
                    'propertyPath' => 'path2',
                    'title' => 'message2',
                    'type' => 'urn:uuid:6',
                ],
            ],
        ]);
    }
}
