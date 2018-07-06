<?php

declare(strict_types=1);

namespace Phpro\ApiProblem;

interface DebuggableApiProblemInterface extends ApiProblemInterface
{
    public function toDebuggableArray(): array;
}
