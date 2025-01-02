<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class BusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brandNameEn' => 'required|string|max:255',
            'brandNameAr' => 'required|string|max:255',
            'branType' => 'required|string|in:corp,ind',
            'isLicensed' => 'required|string|in:yes,no',
            'brandCountry' => 'required|string|size:2',

            'contact_person.name.title' => 'required|string|max:50',
            'contact_person.name.first' => 'required|string|max:50',
            'contact_person.name.middle' => 'nullable|string|max:50',
            'contact_person.name.last' => 'required|string|max:50',

            'contact_person.contact_info.primary.email' => 'required|email|max:255',
            'contact_person.contact_info.primary.phone' => 'required|array',
            'contact_person.contact_info.primary.phone.*' => 'required|string',

            'contact_person.nationality' => 'required|string|max:255',
            'contact_person.date_of_birth' => 'required|date|before:today',

            'contact_person.is_authorized' => 'required|string|in:yes,no',
            'contact_person.authorization.name.title' => 'required_if:contact_person.is_authorized,yes|string|max:50',
            'contact_person.authorization.name.first' => 'required_if:contact_person.is_authorized,yes|string|max:50',
            'contact_person.authorization.name.middle' => 'nullable|string|max:50',
            'contact_person.authorization.name.last' => 'required_if:contact_person.is_authorized,yes|string|max:50',
            'contact_person.authorization.type' => 'required_if:contact_person.is_authorized,yes|string|max:255',
            'contact_person.authorization.issuing_country' => 'required_if:contact_person.is_authorized,yes|string|max:255',
            'contact_person.authorization.issuing_date' => 'required_if:contact_person.is_authorized,yes|date',
            'contact_person.authorization.expiry_date' => 'required_if:contact_person.is_authorized,yes|date|after:contact_person.authorization.issuing_date',
            'contact_person.authorization.files' => 'required_if:contact_person.is_authorized,yes|array',

            'bank_account.iban' => 'required|string|max:255',
            'bank_account.swift_code' => 'required|string|max:255',
            'bank_account.account_number' => 'required|string|max:50',

            'billing_address.recipient_name' => 'required|string|max:255',
            'billing_address.address_1' => 'required|string|max:255',
            'billing_address.address_2' => 'nullable|string|max:255',
            'billing_address.po_box' => 'nullable|string|max:50',
            'billing_address.district' => 'nullable|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'nullable|string|max:255',
            'billing_address.zip_code' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:255',
        ];
    }

        /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '_token.required' => 'The CSRF token is required.',
            'brandNameEn.required' => 'The brand name in English is required.',
            'brandNameAr.required' => 'The brand name in Arabic is required.',
            'branType.in' => 'The brand type must be either corp or ind.',
            'isLicensed.in' => 'The licensing status must be either yes or no.',
            'contact_person.date_of_birth.before' => 'The date of birth must be before today.',
            'contact_person.authorization.expiry_date.after' => 'The expiry date must be after the issuing date.',
        ];
    }
}
