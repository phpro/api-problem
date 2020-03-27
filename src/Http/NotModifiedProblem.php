<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class NotModifiedProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(304, [
            'detail' => $detail,
        ]);
    }
}
