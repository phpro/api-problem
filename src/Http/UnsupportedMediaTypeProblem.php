<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class UnsupportedMediaTypeProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(415, [
            'detail' => $detail,
        ]);
    }
}
