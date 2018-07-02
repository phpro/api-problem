<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class UnauthorizedProblem extends HttpApiProblem
{
    public function __construct(string $reason)
    {
        parent::__construct(401, [
            'detail' => $reason,
        ]);
    }
}
