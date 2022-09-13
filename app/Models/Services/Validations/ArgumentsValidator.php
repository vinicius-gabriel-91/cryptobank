<?php

declare(strict_types=1);

namespace App\Models\Services\Validations;

use InvalidArgumentException;

class ArgumentsValidator
{
    /**
     * Validates arguments
     *
     * @param array $requiredArguments
     * @param array $data
     * @throws InvalidArgumentException
     * @return void
     */
    public function validateArguments(array $requiredArguments, array $data): void
    {
        foreach ($requiredArguments as $requiredField) {
            if (!array_key_exists($requiredField, $data) || !isset($data[$requiredField])) {
                throw new InvalidArgumentException(
                    "The following parameter is required: $requiredField"
                );
            }
        }
    }
}
