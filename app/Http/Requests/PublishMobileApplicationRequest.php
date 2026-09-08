<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublishMobileApplicationRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (is_string($this->input('version'))) {
            $this->merge(['version' => trim($this->input('version'))]);
        }
    }

    public function authorize()
    {
        return $this->user() && $this->user()->can('website_controll');
    }

    public function rules()
    {
        return [
            'application_key' => [
                'required',
                Rule::in(array_keys(config('mobile_applications.applications', []))),
            ],
            'version' => ['bail', 'required', 'string', 'max:50', 'regex:/^[A-Za-z0-9]+(?:[._-][A-Za-z0-9]+)*$/'],
            'apk' => [
                'bail',
                'required',
                'file',
                'max:'.config('mobile_applications.max_upload_kb', 102400),
                function ($attribute, $value, $fail) {
                    if (!$value || strtolower($value->getClientOriginalExtension()) !== 'apk') {
                        $fail(__('mobile_apps.validation.apk_extension'));
                    }
                },
            ],
            'release_notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            'application_key.required' => __('mobile_apps.validation.application_required'),
            'application_key.in' => __('mobile_apps.validation.application_invalid'),
            'version.required' => __('mobile_apps.validation.version_required'),
            'version.string' => __('mobile_apps.validation.version_format'),
            'version.max' => __('mobile_apps.validation.version_max'),
            'version.regex' => __('mobile_apps.validation.version_format'),
            'apk.required' => __('mobile_apps.validation.apk_required'),
            'apk.file' => __('mobile_apps.validation.apk_invalid'),
            'apk.max' => __('mobile_apps.validation.apk_too_large', ['size' => config('mobile_applications.max_upload_kb', 102400) / 1024]),
            'apk.uploaded' => __('mobile_apps.validation.apk_invalid'),
            'release_notes.max' => __('mobile_apps.validation.notes_max'),
        ];
    }
}
