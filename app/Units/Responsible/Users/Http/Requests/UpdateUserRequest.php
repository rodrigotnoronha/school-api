<?php

namespace Emtudo\Units\Responsible\Users\Http\Requests;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Request;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends Request
{
    public function rules()
    {
        return User::rules()->updating(function ($rules) {
            $id = decode_id($this->route('user'));
            if (!$id || 'me' === $id) {
                $id = auth()->user()->id;
            }

            return array_merge($rules, [
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    'email',
                    Rule::unique('users')
                        ->ignore($id),
                ],
                
            ]);
        });
    }
}
