<?php

namespace App\Http\Requests;

use App\Enum\Status;
use App\Models\User;
use App\Services\CreateTaskService\CreateTaskInterface;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest implements CreateTaskInterface
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:'.Status::commaSeparated(),
            'assigned_user_id' => 'required|exists:'.User::class.',id',
        ];
    }

    public function getTitle(): string
    {
        return $this->input('title');
    }

    public function getDescription(): ?string
    {
        return $this->input('description');
    }

    public function getStatus(): string
    {
        return $this->input('status');
    }

    public function getUserId(): string
    {
        return $this->input('assigned_user_id');
    }
}
