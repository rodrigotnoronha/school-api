<?php

namespace Emtudo\Units\School\Users\Http\Requests\Responsibles;

use Emtudo\Domains\Responsibles\Responsible;
use Emtudo\Support\Http\Request;
use Illuminate\Validation\Rule;

class UpdateResponsibleRequest extends Request
{
    public function rules()
    {
        return Responsible::rules()->updating(function ($rules) {
            $id = decode_id($this->route('responsible'));

            return array_merge($rules, [
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    'email',
                    Rule::unique('users')
                        ->ignore($id),
                ],
                'country_register' => [
                    'cpf',
                    Rule::unique('users')
                        ->ignore($id),
                ],
            ]);
        });
    }
}
