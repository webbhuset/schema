<?php

namespace Webbhuset\Schema;

class ValidationResult
{
    protected $errors = [];


    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorsAsString(): string
    {
        return json_encode($this->getErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
