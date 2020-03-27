<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class InternalServerErrorProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(500, [
            'detail' => $detail,
        ]);
    }
}
