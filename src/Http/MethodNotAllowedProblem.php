<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class MethodNotAllowedProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(405, [
            'detail' => $detail,
        ]);
    }
}
