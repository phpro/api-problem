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

    public static function invalidContentEncoding(array $allowedEncodings, array $providedEncodings): self
    {
        $allowedEncodings[] = implode(' or ', array_splice($allowedEncodings, -2));
        $providedEncodings[] = implode(' and ', array_splice($providedEncodings, -2));

        $detail = implode(', ', $providedEncodings).' not allowed. Should be: '.implode(', ', $allowedEncodings);

        return new self($detail);
    }

    public static function invalidContentType(array $allowedTypes, string $providedType): self
    {
        $allowedTypes[] = implode(' or ', array_splice($allowedTypes, -2));

        $detail = $providedType.' not allowed. Should be: '.implode(', ', $allowedTypes);

        return new self($detail);
    }
}
