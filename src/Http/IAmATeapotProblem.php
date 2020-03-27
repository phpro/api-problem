<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class IAmATeapotProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(418, [
            'detail' => $detail,
        ]);
    }
}
