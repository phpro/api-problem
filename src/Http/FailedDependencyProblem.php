<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class FailedDependencyProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(424, [
            'detail' => $detail,
        ]);
    }
}
