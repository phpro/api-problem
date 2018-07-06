<?php

declare(strict_types=1);

namespace spec\Phpro\ApiProblem\Http;

use Phpro\ApiProblem\ApiProblemInterface;
use Phpro\ApiProblem\Http\HttpApiProblem;
use PhpSpec\ObjectBehavior;

class HttpApiProblemSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(400, []);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(HttpApiProblem::class);
    }

    public function it_is_an_api_problem(): void
    {
        $this->shouldHaveType(ApiProblemInterface::class);
    }

    public function it_can_parse_to_array(): void
    {
        $this->toArray()->shouldBe([
            'status' => 400,
            'type' => HttpApiProblem::TYPE_HTTP_RFC,
            'title' => HttpApiProblem::getTitleForStatusCode(400),
            'detail' => '',
        ]);
    }

    public function it_can_get_titles_for_http_codes(): void
    {
        $this->getTitleForStatusCode(0)->shouldBe('Unknown');
        $this->getTitleForStatusCode(400)->shouldBe('Bad Request');
        $this->getTitleForStatusCode(401)->shouldBe('Unauthorized');
        $this->getTitleForStatusCode(402)->shouldBe('Payment Required');
        $this->getTitleForStatusCode(403)->shouldBe('Forbidden');
        $this->getTitleForStatusCode(404)->shouldBe('Not Found');
        $this->getTitleForStatusCode(405)->shouldBe('Method Not Allowed');
        $this->getTitleForStatusCode(406)->shouldBe('Not Acceptable');
        $this->getTitleForStatusCode(407)->shouldBe('Proxy Authentication Required');
        $this->getTitleForStatusCode(408)->shouldBe('Request Time-out');
        $this->getTitleForStatusCode(409)->shouldBe('Conflict');
        $this->getTitleForStatusCode(410)->shouldBe('Gone');
        $this->getTitleForStatusCode(411)->shouldBe('Length Required');
        $this->getTitleForStatusCode(412)->shouldBe('Precondition Failed');
        $this->getTitleForStatusCode(413)->shouldBe('Request Entity Too Large');
        $this->getTitleForStatusCode(414)->shouldBe('Request-URI Too Large');
        $this->getTitleForStatusCode(415)->shouldBe('Unsupported Media Type');
        $this->getTitleForStatusCode(416)->shouldBe('Requested range not satisfiable');
        $this->getTitleForStatusCode(417)->shouldBe('Expectation Failed');
        $this->getTitleForStatusCode(418)->shouldBe('I\'m a teapot');
        $this->getTitleForStatusCode(422)->shouldBe('Unprocessable Entity');
        $this->getTitleForStatusCode(423)->shouldBe('Locked');
        $this->getTitleForStatusCode(424)->shouldBe('Failed Dependency');
        $this->getTitleForStatusCode(425)->shouldBe('Unordered Collection');
        $this->getTitleForStatusCode(426)->shouldBe('Upgrade Required');
        $this->getTitleForStatusCode(428)->shouldBe('Precondition Required');
        $this->getTitleForStatusCode(429)->shouldBe('Too Many Requests');
        $this->getTitleForStatusCode(431)->shouldBe('Request Header Fields Too Large');
        $this->getTitleForStatusCode(500)->shouldBe('Internal Server Error');
        $this->getTitleForStatusCode(501)->shouldBe('Not Implemented');
        $this->getTitleForStatusCode(502)->shouldBe('Bad Gateway');
        $this->getTitleForStatusCode(503)->shouldBe('Service Unavailable');
        $this->getTitleForStatusCode(504)->shouldBe('Gateway Time-out');
        $this->getTitleForStatusCode(505)->shouldBe('HTTP Version not supported');
        $this->getTitleForStatusCode(506)->shouldBe('Variant Also Negotiates');
        $this->getTitleForStatusCode(507)->shouldBe('Insufficient Storage');
        $this->getTitleForStatusCode(508)->shouldBe('Loop Detected');
        $this->getTitleForStatusCode(511)->shouldBe('Network Authentication Required');
    }
}
