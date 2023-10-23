<?php

namespace App\Http\Requests;

use App\Enums\ThirdParty\RandomUserCustomFieldsEnum;
use App\Enums\ThirdParty\RandomUserFieldsEnum;
use App\Enums\ThirdParty\RandomUserVersionEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class GetRandomUserDataRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'version' => [new Enum(RandomUserVersionEnum::class)],
            'inc.*' => ['sometimes', Rule::in(RandomUserFieldsEnum::cases())],
            'exc.*' => ['sometimes', Rule::in(RandomUserFieldsEnum::cases())],
            'custom_fields.*' => ['sometimes', Rule::in(RandomUserCustomFieldsEnum::cases())],
            'results' => 'sometimes|integer',
            'order_by' => 'required|string',
            'output_format' => 'required|string',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
                         'order_by' => (!$this?->order_by) ? 'ASC' : $this?->order_by,
                         'output_format' => (!$this?->output_format) ? 'xml' : $this?->output_format,
                     ]);
    }

}
