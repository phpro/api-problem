<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class ConflictProblem extends HttpApiProblem
{
    public function __construct(string $reason)
    {
        parent::__construct(409, [
            'detail' => $reason,
        ]);
    }
}
