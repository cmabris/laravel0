<?php

namespace App\Http\Requests;

use App\Role;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => [
                'nullable',
                Rule::in(Role::getList())
            ],
            'bio' => 'required',
            'twitter' => 'nullable|present|url',
            'profession_id' => [
                'nullable', 'present',
                Rule::exists('professions','id')->whereNull('deleted_at')
            ],
            'skills' => [
                'array',
                Rule::exists('skills', 'id'),
            ],
            'state' => [
                Rule::in(['active', 'inactive'])
            ]
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El campo nombre es obligatorio',
            'last_name.required' => 'El campo apellidos es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
            'email.unique' => 'Ese email ya existe en la BD',
        ];
    }

    public function createUser()
    {
        DB::transaction(function () {
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'role' => $this->role ?? 'user',
                'state' => $this->state,
            ]);

            $user->profile()->create([
                'bio' => $this->bio,
                'twitter' => $this->twitter,
                'profession_id' => $this->profession_id
            ]);

            $user->skills()->attach($this->skills ?? []);
        });
    }
}
