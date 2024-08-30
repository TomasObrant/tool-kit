<?php

namespace App\Shared\Domain\Validator;

interface RequestValidatorInterface
{
    public function validate(mixed $dto): ?array;
}
