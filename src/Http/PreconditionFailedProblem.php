<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class PreconditionFailedProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(412, [
            'detail' => $detail,
        ]);
    }
}
