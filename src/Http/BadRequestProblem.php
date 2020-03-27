<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class BadRequestProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(400, [
            'detail' => $detail,
        ]);
    }
}
