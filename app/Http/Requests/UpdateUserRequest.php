<?php

namespace App\Http\Requests;

use App\Role;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => '',
            'role' => [Rule::in(Role::getList())],
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
                Rule::in(['active', 'inactive']),
            ]
        ];
    }

    public function updateUser(User $user)
    {
        $user->fill([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role ?? 'user',
            'state' => $this->state,
        ]);

        if ($this->password != null) {
            $user->password = bcrypt($this->password);
        }

        $user->save();

        $user->profile->update([
            'bio' => $this->bio,
            'twitter' => $this->twitter,
            'profession_id' => $this->profession_id
        ]);

        $user->skills()->sync($this->skills ?: []);
    }
}
