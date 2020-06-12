<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class LockedProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(423, [
            'detail' => $detail,
        ]);
    }
}
