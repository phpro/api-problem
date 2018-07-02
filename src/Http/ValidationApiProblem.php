<?php

declare(strict_types=1);

namespace Phpro\ApiProblem\Http;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationApiProblem extends HttpApiProblem
{
    public const TYPE_SYMFONY_VIOLATIONS = 'https://symfony.com/errors/validation';

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        parent::__construct(
            400,
            [
                'type' => self::TYPE_SYMFONY_VIOLATIONS,
                'title' => 'Validation Failed',
                'detail' => $this->parseMessages($violationList) ?: 'Input validation failed',
                'violations' => $this->serializeViolations($violationList),
            ]
        );
    }

    private function parseMessages(ConstraintViolationListInterface $violationList): string
    {
        $messages = [];
        foreach ($violationList as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $prefix = $propertyPath ? sprintf('%s: ', $propertyPath) : '';
            $messages[] = $prefix.$violation->getMessage();
        }

        return implode("\n", $messages);
    }

    private function serializeViolations(ConstraintViolationListInterface $violationList): array
    {
        $violations = [];
        foreach ($violationList as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $violationEntry = [
                'propertyPath' => $propertyPath,
                'title' => $violation->getMessage(),
            ];

            if (null !== $code = $violation->getCode()) {
                $violationEntry['type'] = sprintf('urn:uuid:%s', $code);
            }

            $violations[] = $violationEntry;
        }

        return $violations;
    }
}
