<?php 
use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 認証が必要な場合は適宜変更
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => 'nullable|in:pending,done',
            'sort_by' => 'nullable|in:due_date,title,status,created_at',
            'order' => 'nullable|in:asc,desc',
        ];
    }
}