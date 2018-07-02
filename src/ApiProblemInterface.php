<?php

declare(strict_types=1);

namespace Phpro\ApiProblem;

interface ApiProblemInterface
{
    public function toArray(): array;
}
