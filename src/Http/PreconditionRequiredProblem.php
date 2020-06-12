<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class PreconditionRequiredProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(428, [
            'detail' => $detail,
        ]);
    }
}
