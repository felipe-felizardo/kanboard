<?php

namespace Kanboard\Validator;

use SimpleValidator\Validator;
use SimpleValidator\Validators;

/**
 * Subtask Validator
 *
 * @package  Kanboard\Validator
 * @author   Frederic Guillot
 */
class SubtaskStatusValidator extends BaseValidator
{
    /**
     * Validate creation
     *
     * @access public
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    public function validateEndIteration(array $values)
    {
        $rules = array(
            new Validators\Required('status', t('The new status is required')),
            new Validators\Required('comment', t('The comment is required')),
            new Validators\MaxLength('comment', t('The maximum length is %d characters', 65535), 65535),
        );

        $v = new Validator($values, array_merge($rules, $this->commonValidationRules()));

        return array(
            $v->execute(),
            $v->getErrors()
        );
    }

    /**
     * Common validation rules
     *
     * @access private
     * @return array
     */
    private function commonValidationRules()
    {
        return array(
            new Validators\Integer('id', t('The subtask id must be an integer')),
            new Validators\Integer('task_id', t('The task id must be an integer')),
            new Validators\Integer('status', t('The status must be an integer')),
        );
    }
}
