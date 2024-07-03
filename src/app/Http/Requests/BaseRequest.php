<?php

namespace Riobet\AccessKey\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function messages(): array
    {
        return parent::messages() + [
            'required' => 'Необходимое поле :attribute отсутствует',
            'same' => 'Поля :attribute и :other должны совпадать.',
            'size' => 'Поле :attribute должно быть размером :size.',
            'between' => 'Значение :attribute поля :input не между :min - :max.',
            'in' => 'Поле :attribute должно быть одним из следующих типов: :values',
        ];
    }

    public function validate(array $rules, ...$params)
    {
        if (!$params) {
            parent::validate($rules, $this->messages());
            return;
        }

        parent::validate($rules, ...$params);
    }
}
