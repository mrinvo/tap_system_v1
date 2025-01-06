<?php

namespace App\Repositories;

use App\Traits\SendRequestTrait;
use App\Http\Resources\DataWrapper;
use App\Http\Resources\GeneralDataWrapper;
use App\Models\Customer;
// use App\Models\CustomerAgreements;
// use App\Models\CustomerCards;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

/**
 * Class PaymentRepository
 *
 * This class provides methods for processing payment-related data and interactions with the payment gateway.
 */
class GeneralOperationsRepository
{
    use SendRequestTrait;

    /**
     * Process a payment request by transforming the validated request into a payload to send to the client.
     *
     * @param FormRequest $request The validated payment request data.
     * @return mixed The result of the payment request.
     */
    public function CreateBusiness($request)
    {
        // Create a DataWrapper instance to prepare the request data.
        $response = new GeneralDataWrapper($request);

        // Convert the wrapped data to an array for processing.
        $payload = $response->toArray();

        // Generate the payment endpoint from the configuration file.
        $endpoint = Config::get('TapEndpoints.business');

        // Send the payment request using the SendRequestTrait.
        return $this->sendPaymentRequest($payload, $endpoint);
    }

    public function FetchBusiness($request)
    {
        // Create a DataWrapper instance to prepare the request data.

        // Convert the wrapped data to an array for processing.
        $payload = [];

        // Generate the payment endpoint from the configuration file.
        $endpoint = Config::get('TapEndpoints.business') . '/' . $request->businessId;
        $method = 'GET';

        // Send the payment request using the SendRequestTrait.
        return $this->sendPaymentRequest($payload, $endpoint, $method);
    }



    public function FetchMerchant($request)
    {
        // Create a DataWrapper instance to prepare the request data.

        // Convert the wrapped data to an array for processing.
        $payload = [];

        // Generate the payment endpoint from the configuration file.
        $endpoint = Config::get('TapEndpoints.merchant') . '/' . $request->merchantId;
        $method = 'GET';

        // Send the payment request using the SendRequestTrait.
        return $this->sendPaymentRequest($payload, $endpoint, $method);
    }

}
