<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\Http\HttpApiProblem;
use Phpro\ApiProblem\Http\UnsupportedMediaTypeProblem;
use PhpSpec\ObjectBehavior;

class UnsupportedMediaTypeProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('unsupported media type');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UnsupportedMediaTypeProblem::class);
    }

    public function it_is_an_http_api_problem(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 415,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(415),
            'detail' => 'unsupported media type',
        ]);
    }

    public function it_should_be_a_media_type_with_allowed_content_encodings(): void
    {
        $allowedEncodings = ['gzip', 'identity'];
        $currentEncoding = ['compress', 'none'];

        $this->beConstructedThrough('invalidContentEncoding', [$allowedEncodings, $currentEncoding]);
        $this->toArray()->shouldBe([
            'status' => 415,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(415),
            'detail' => 'compress and none not allowed. Should be: gzip or identity',
        ]);
    }

    public function it_should_be_a_media_type_with_allowed_content_types(): void
    {
        $allowedEncodings = ['text/html', 'multipart/form-data'];
        $currentEncoding = 'application/json';

        $this->beConstructedThrough('invalidContentType', [$allowedEncodings, $currentEncoding]);
        $this->toArray()->shouldBe([
            'status' => 415,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(415),
            'detail' => 'application/json not allowed. Should be: text/html or multipart/form-data',
        ]);
    }
}
