<?php

namespace Webbhuset\Schema;

class ValidationException extends \InvalidArgumentException
{
    protected $validationErrors;


    public function __construct(
        array $validationErrors,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct('Validation failed', $code, $previous);

        $this->validationErrors = $validationErrors;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function getValidationErrorsAsString(): string
    {
        return json_encode($this->getValidationErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function __toString(): string
    {
        return implode("\n", [
            sprintf(
                '%s: %s in %s:%s',
                __CLASS__,
                $this->getMessage(),
                $this->getFile(),
                $this->getLine()
            ),
            'Validation errors:',
            $this->getValidationErrorsAsString(),
            'Stack trace:',
            $this->getTraceAsString(),
        ]);
    }
}
