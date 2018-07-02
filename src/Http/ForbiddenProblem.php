<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class ForbiddenProblem extends HttpApiProblem
{
    public function __construct(string $reason)
    {
        parent::__construct(403, [
            'detail' => $reason,
        ]);
    }
}
