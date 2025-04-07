<?php

namespace App\Http\Requests\Website;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'title' => 'sometimes|string|min:3|max:50',
            'content' => 'sometimes|string|min:10|max:255',
        ];
    }

    public function updatePost(): Post
    {
        $this->post->update([
            'title' => isset($this->title) ? $this->input('title') : $this->post->title,
            'content' => isset($this->content) ? $this->input('content') : $this->post->content,
        ]);
        return $this->post->refresh();
    }

    public function attributes(): array
    {
        return [
            'title' => __('posts.attributes.title'),
            'content' => __('posts.attributes.content'),
        ];
    }
}
