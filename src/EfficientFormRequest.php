<?php

namespace Mitoop\LaravelEfficientFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class EfficientFormRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    protected static bool $applyGlobalBail = false;

    protected function validationRules(): array
    {
        $rules = parent::validationRules();

        return self::$applyGlobalBail ? $this->applyBailToRules($rules) : $rules;
    }

    public static function applyGlobalBail(bool $value): void
    {
        self::$applyGlobalBail = $value;
    }

    protected function applyBailToRules(array $rules): array
    {
        foreach ($rules as &$rule) {
            if (is_array($rule)) {
                if (! in_array('bail', $rule)) {
                    array_unshift($rule, 'bail');
                }
            } elseif (! str_contains($rule, 'bail')) {
                $rule = 'bail|'.$rule;
            }
        }

        return $rules;
    }
}
