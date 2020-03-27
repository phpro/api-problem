<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class UnprocessableEntityProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(422, [
            'detail' => $detail,
        ]);
    }
}
