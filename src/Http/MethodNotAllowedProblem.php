<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

class MethodNotAllowedProblem extends HttpApiProblem
{
    public function __construct(string $detail)
    {
        parent::__construct(405, [
            'detail' => $detail,
        ]);
    }

    public static function invalidMethod(array $allowMethods, string $currentMethod): self
    {
        $allowMethods[] = implode(' or ', array_splice($allowMethods, -2));
        $detail = $currentMethod.' not allowed. Should be: '.implode(', ', $allowMethods);

        return new self($detail);
    }
}
