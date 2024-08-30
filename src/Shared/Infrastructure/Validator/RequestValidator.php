<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use App\Shared\Domain\Validator\RequestValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class RequestValidator implements RequestValidatorInterface
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    public function validate(mixed $dto): array
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $path = $error->getPropertyPath();
                $errorMessage = $error->getMessage();

                $errorMessages[$path] = $errorMessage;
            }

            return $errorMessages;
        }

        return [];
    }
}
