<?php

namespace App\Http\Requests\Search;

use App\Http\Requests\Search\Interface\FilterRequestInterface;
use App\Http\Requests\Search\Interface\PaginateRequestInterface;
use App\Http\Requests\Search\Interface\SearchRequestInterface;
use App\Http\Requests\Search\Interface\SortRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest implements
    SearchRequestInterface,
    FilterRequestInterface,
    SortRequestInterface,
    PaginateRequestInterface
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string',
            'sort' => 'nullable|array',
            'sort.column' => 'nullable|string', //we can update this that is allowed to the table
            'sort.direction' => 'nullable|string',
        ];
    }

    /**
     * The fields that we want to filter
     **/
    public function getFilters(): array
    {
        return  [];
    }

    public function getColumn(): string
    {
        return $this->input('sort.column') ?? 'updated_at';
    }

    public function getDirection(): string
    {
        return $this->input('sort.direction') ?? 'desc';
    }

    public function getSearchValue(): ?string
    {
        return $this->input('search');
    }

    public function getPage(): ?string
    {
        return $this->input('per_page');
    }
}
