<?php

namespace Core\Validator;

interface ValidatorInterface {
    public function getErrors(): array;
    public function validate(array $data, array $rules): bool;
}
