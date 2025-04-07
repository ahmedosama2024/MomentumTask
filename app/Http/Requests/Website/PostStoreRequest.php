<?php

namespace App\Http\Requests\Website;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:50',
            'content' => 'required|string|min:10|max:255',
        ];
    }

    public function storePost(): Post
    {
        return Post::create([
            'user_id' => auth()->id(),
            'title' => $this->input('title'),
            'content' => $this->input('content'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'title' => __('posts.attributes.title'),
            'content' => __('posts.attributes.content'),
        ];
    }
}
