<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomepageHeroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * You might want to add authorization logic here if needed.
     * @return bool
     */
    public function authorize(): bool
    {
        // Assuming any authenticated admin can do this
        return auth()->check() && auth()->user()->isAdmin(); // Adjust if you have roles/permissions
        // Or simply: return true; if authorization is handled elsewhere (e.g., middleware)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hp_hero_headline'      => 'nullable|string|max:255',
            'hp_hero_subheadline'   => 'nullable|string|max:1000',
            'hp_hero_button_text'   => 'nullable|string|max:50',
            'hp_hero_button_url'    => 'nullable|string|max:255',
            'hp_hero_image'         => [
                'nullable', // Allow not uploading a new image
                'image',    // Must be an image file
                'mimes:jpeg,png,jpg,gif,svg,webp', // Allowed extensions
                'max:2048'  // Max size in kilobytes (e.g., 2MB)
            ],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'hp_hero_image.image' => 'The hero background must be a valid image file.',
            'hp_hero_image.mimes' => 'Only JPG, PNG, GIF, SVG, and WEBP images are allowed.',
            'hp_hero_image.max'   => 'The hero image may not be larger than 2MB.',
        ];
    }
}