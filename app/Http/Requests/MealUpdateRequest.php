<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MealUpdateRequest
 * @package App\Http\Requests
 */
class MealUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'category_id' => ['required'],
            'is_active' => ['required', 'boolean'],
            'is_ordered' => ['required', 'boolean'],
            'is_favorite' => ['required', 'boolean'],
            'is_unsuitable' => ['required', 'boolean'],
        ];
    }
}
