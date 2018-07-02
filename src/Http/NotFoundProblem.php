<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class NotFoundProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(404, [
            'detail' => $detail,
        ]);
    }
}
