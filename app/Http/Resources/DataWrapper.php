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
class DataWrapper
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
    public $paymentType;

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

        // Set the payment type from the request.
        $this->paymentType = $request->customerPaymentType;

        // Prepare the payload based on the payment type.
        switch ($this->paymentType) {
            case 'first_payment':
                $this->payload = $this->GenerateCustomerInitiatedPayload($request);
                break;

            case 'recurring':
                $this->payload = $this->GenerateMerchantInitiatedPayload($request);
                break;
        }
    }

    /**
     * Generate the payload for customer-initiated payment.
     *
     * @param mixed $request The payment request data.
     * @return array<string, mixed> The customer-initiated payload.
     */
    public function GenerateCustomerInitiatedPayload($request)
    {

        // Generate and return the customer-initiated payload array.
        $payload = [
            "amount" => $request->amount,
            "currency" => env('STORE_CURRENCY'),
            "customer_initiated" => true,
            "threeDSecure" => true,
            "save_card" => $request->formIsSelected == "false" ? false : true,
            "description" => $request->description,
            "metadata" => $this->GenerateUserDefined($request),
            "merchant" => [
                "id" => env('TAP_MERCHANT_ID')
            ],
            "source" => [
                "id" => $request->id
            ],
            "post" => [
                "url" => "https://webhook.site/12d7c6b6-5c40-4b9f-ac5c-c7cca08fff03"
            ],
            "redirect" => [
                "url" => url('/payment/response')
            ],
            "receipt" => [
                "email" => true,
                "sms" => true
            ],
            "customer" => $this->GenerateCustomerDetails($request)
        ];

        return $payload;
    }

    /**
     * Generate the payload for merchant-initiated payment.
     *
     * @param mixed $request The payment request data.
     * @return array<string, mixed> The merchant-initiated payload.
     */
    public function GenerateMerchantInitiatedPayload($request)
    {
        $customer = Customer::where('email', $request->customerEmail)->first();

        // Generate and return the merchant-initiated payload array.
        $payload = [
            "amount" => $request->amount,
            "currency" => env('STORE_CURRENCY'),
            "customer_initiated" => false,
            "description" => $request->description,
            "metadata" => $this->GenerateUserDefined($request),
            "merchant" => [
                "id" => env('TAP_MERCHANT_ID')
            ],
            "source" => [
                "id" => $this->generateCustomerToken($request->card_id, $customer->customer_id)
            ],
            "post" => [
                "url" => "https://webhook.site/12d7c6b6-5c40-4b9f-ac5c-c7cca08fff03"
            ],
            "redirect" => [
                "url" => url('/payment/response')
            ],
            "receipt" => [
                "email" => true,
                "sms" => true
            ],
            "customer" => [
                'id' => $customer->customer_id
            ],
            "payment_agreement" => $this->generateAgreementDetails($customer->email)
        ];

        return $payload;
    }

    /**
     * Generate a customer token for payment.
     *
     * @param mixed $card_id The ID of the saved card.
     * @param mixed $customer_id The ID of the customer.
     * @return mixed The generated token ID.
     */
    public function generateCustomerToken($card_id, $customer_id)
    {
        $payload = [
            "saved_card" => [
                "card_id" => $card_id,
                "customer_id" => $customer_id
            ],
            "client_ip" => "127.0.0.1"
        ];

        $endpoint = Config::get('PaymentEndpoints.tokens');
        $token = $this->sendPaymentRequest($payload, $endpoint);

        return $token->id;
    }

    /**
     * Generate agreement details for a customer.
     *
     * @param string $customer_email The email of the customer.
     * @return array<string, mixed> The agreement details.
     */
    public function generateAgreementDetails($customer_email)
    {
        $agreement = CustomerAgreements::where('customer_email', $customer_email)->first();

        // Generate and return the agreement details array.
        $payload = [
            "contract" => [
                "id" => $agreement->contract_id
            ],
            "id" => $agreement->agreement_id
        ];

        return $payload;
    }

    /**
     * Generate customer details based on the given request.
     *
     * @param mixed $request The payment request data.
     * @return array<string, mixed> The customer details.
     */
    public function GenerateCustomerDetails($request)
    {
        // Generate and return the customer details array.
        $customerDetails = [
            "first_name" => $request->customer_first_name,
            "middle_name" => $request->customer_middle_name,
            "last_name" => $request->customer_last_name,
            "email" => $request->customer_email,
            "phone" => [
                "country_code" => $request->customer_country_code,
                "number" => $request->customer_phone_number
            ]
        ];

        return $customerDetails;
    }

    /**
     * Generate user-defined data based on the given request.
     *
     * @param mixed $request The payment request data.
     * @return array<string, mixed> The user-defined data.
     */
    public function GenerateUserDefined($request)
    {
        // Generate and return the user-defined data array.
        $userDefined = [
            'UDF1' => "this is my customer type",
            // Additional user-defined fields can be uncommented as needed.
            // 'UDF2' => $request->udf2,
            // 'UDF3' => $request->udf3,
            // 'UDF4' => $request->udf4,
            // 'UDF5' => $request->udf5,
            // 'UDF6' => $request->udf6,
            // 'UDF7' => $request->udf7,
            // 'UDF8' => $request->udf8,
            // 'UDF9' => $request->udf9,
        ];

        return $userDefined;
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
