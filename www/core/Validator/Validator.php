<?php

namespace Core\Validator;

class Validator implements ValidatorInterface
{
    private array $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        foreach ($rules as $key => $ruleSet) {
            foreach ($ruleSet as $rule) {
                $rule = explode(':', $rule);

                $ruleName = $rule[0];
                $ruleValue = $rule[1] ?? null;

                $error = $this->validateRule($data, $key, $ruleName, $ruleValue);

                if ($error) {
                    $this->errors[] = $error;
                }
            }
        }
        return empty($this->errors);
    }

    private function validateRule(array $data, string $key, string $ruleName, string $ruleValue = null): string|false
    {
        $value = $data[$key];

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    return "Поле $key является обязательным";
                }
                break;

            case 'min':
                if (strlen($value) < $ruleValue) {
                    return "Поле $key должно быть больше или равно $ruleValue";
                }
                break;

            case 'max':
                if (strlen($value) > $ruleValue) {
                    return "Поле $key должно быть меньше или равно $ruleValue";
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "Email $value не валидный";
                }
                break;
        }

        return false;
    }
}
