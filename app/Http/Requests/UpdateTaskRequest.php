<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool {
    return true;
  }

  // public function prepareForValidation() {
  //   $this->headers->set('Content-Type', 'application/x-www-form-urlencoded');
  // }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array {
    return [
      'title' => ['sometimes', 'required'],
      'is_done' => ['sometimes', 'boolean', 'nullable'],
      'project_id' => [
        'nullable',
        Rule::in(Auth::user()->memberships->pluck('id'))
      ]
    ];
  }
}
