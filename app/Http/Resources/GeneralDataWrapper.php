<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\CustomerAgreements;
use Illuminate\Http\Request;
use App\Repositories\PaymentRepository;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SendRequestTrait;
use Illuminate\Support\Facades\Config;

/**
 * Class DataWrapper
 *
 * This class serves as a wrapper for preparing the payment request payload.
 */
class GeneralDataWrapper
{
    use SendRequestTrait;

    /**
     * The customer details associated with the payment data.
     *
     * @var mixed
     */
    public $customerDetails;


    /**
     * User-defined data associated with the payment.
     *
     * @var FormRequest
     */
    public $userDefined;



    /**
     * The type of payment (e.g., hosted or invoice).
     *
     * @var string
     */
    public $requestType;

    /**
     * The payload data for the payment request.
     *
     * @var FormRequest
     */
    public $payload;

    /**
     * The instance of the Payment Repository.
     *
     * @var FormRequest
     */
    protected $PaymentRepository;

    /**
     * DataWrapper constructor.
     *
     * @param FormRequest $request The payment request data.
     */
    public function __construct($request)
    {
        $this->PaymentRepository = new PaymentRepository;

        // // Set the payment type from the request
        $this->requestType = $request->requestType;

        // Prepare the payload based on the payment type.
        switch ($this->requestType) {
            case 'createBusiness':
                $this->payload = $this->GenerateCreateBusinessPayload($request);
                break;
        }
    }



    /**
     * Generate the payload for customer-initiated payment.
     *
     * @param mixed $request The payment request data.
     * @return array<string, mixed> The customer-initiated payload.
     */
    public function GenerateCreateBusinessPayload($request)
    {

        $payload = [
            'name' => [
                'en' => $request->input('name.en'),
                'ar' => $request->input('name.ar'),
            ],
            'type' => $request->input('type'),
            'entity' => [
                'legal_name' => [
                    'en' => $request->input('entity.legal_name.en'),
                    'ar' => $request->input('entity.legal_name.ar'),
                ],
                'is_licensed' => $request->input('entity.is_licensed'),
                'license' => [
                    'type' => $request->input('entity.license.type'),
                    'number' => $request->input('entity.license.number'),
                ],
                'not_for_profit' => $request->input('entity.not_for_profit'),
                'country' => $request->input('entity.country'),
                'tax_number' => $request->input('entity.tax_number'),
                'bank_account' => [
                    'iban' => $request->input('entity.bank_account.iban'),
                    'swift_code' => $request->input('entity.bank_account.swift_code'),
                    'account_number' => $request->input('entity.bank_account.account_number'),
                ],
                'billing_address' => [
                    'recipient_name' => $request->input('entity.billing_address.recipient_name'),
                    'address_1' => $request->input('entity.billing_address.address_1'),
                    'address_2' => $request->input('entity.billing_address.address_2'),
                    'po_box' => $request->input('entity.billing_address.po_box'),
                    'district' => $request->input('entity.billing_address.district'),
                    'city' => $request->input('entity.billing_address.city'),
                    'state' => $request->input('entity.billing_address.state'),
                    'zip_code' => $request->input('entity.billing_address.zip_code'),
                    'country' => $request->input('entity.billing_address.country'),
                ],
            ],
            'contact_person' => [
                'name' => [
                    'title' => $request->input('contact_person.name.title'),
                    'first' => $request->input('contact_person.name.first'),
                    'middle' => $request->input('contact_person.name.middle'),
                    'last' => $request->input('contact_person.name.last'),
                ],
                'contact_info' => [
                    'primary' => [
                        'email' => $request->input('contact_person.contact_info.primary.email'),
                        'phone' => [
                            'country_code' => $request->input('contact_person.contact_info.primary.phone.country_code'),
                            'number' => $request->input('contact_person.contact_info.primary.phone.number'),
                        ],
                    ],
                ],
                'nationality' => $request->input('contact_person.nationality'),
                'date_of_birth' => $request->input('contact_person.date_of_birth'),
                'is_authorized' => $request->input('contact_person.is_authorized'),
                'authorization' => [
                    'name' => [
                        'title' => $request->input('contact_person.authorization.name.title'),
                        'first' => $request->input('contact_person.authorization.name.first'),
                        'middle' => $request->input('contact_person.authorization.name.middle'),
                        'last' => $request->input('contact_person.authorization.name.last'),
                    ],
                    'type' => $request->input('contact_person.authorization.type'),
                    'issuing_country' => $request->input('contact_person.authorization.issuing_country'),
                    'issuing_date' => $request->input('contact_person.authorization.issuing_date'),
                    'expiry_date' => $request->input('contact_person.authorization.expiry_date'),
                    'files' => $request->input('contact_person.authorization.files'),
                ],
            ],
            'post' => [
                'url' => $request->input('post.url'),
            ],
            'metadata' => [
                'mtd' => $request->input('metadata.mtd'),
            ],
        ];

        return $payload;
    }





    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed> The payload data.
     */
    public function toArray()
    {
        return $this->payload;
    }
}
