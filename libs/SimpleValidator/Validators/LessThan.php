<?php

namespace SimpleValidator\Validators;

class LessThan extends Base
{
    private $max;

    public function __construct($field, $error_message, $max)
    {
        parent::__construct($field, $error_message);
        $this->max = $max;
    }

    public function execute(array $data)
    {
        if ($this->isFieldNotEmpty($data)) {
            return $data[$this->field] < $this->max;
        }

        return true;
    }
}
