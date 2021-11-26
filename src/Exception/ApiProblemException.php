<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Exception;

use Exception;
use Phpro\ApiProblem\ApiProblemInterface;

class ApiProblemException extends Exception
{
    /**
     * @var ApiProblemInterface
     */
    private $apiProblem;

    public function __construct(ApiProblemInterface $apiProblem)
    {
        $data = $apiProblem->toArray();
        $message = $data['detail'] ?? ($data['title'] ?? '');
        $code = (int) ($data['status'] ?? 0);

        parent::__construct($message, $code);
        $this->apiProblem = $apiProblem;
    }

    public function getApiProblem(): ApiProblemInterface
    {
        return $this->apiProblem;
    }
}
