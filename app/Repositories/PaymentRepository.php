<?php

namespace App\Repositories;

use App\Traits\SendRequestTrait;
use App\Http\Resources\DataWrapper;
use App\Models\Customer;
use App\Models\CustomerAgreements;
use App\Models\CustomerCards;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

/**
 * Class PaymentRepository
 *
 * This class provides methods for processing payment-related data and interactions with the payment gateway.
 */
class PaymentRepository
{
    use SendRequestTrait;

    /**
     * Process a payment request by transforming the validated request into a payload to send to the client.
     *
     * @param FormRequest $request The validated payment request data.
     * @return mixed The result of the payment request.
     */
    public function processRequest($request)
    {
        // Create a DataWrapper instance to prepare the request data.
        $response = new DataWrapper($request);

        // Convert the wrapped data to an array for processing.
        $payload = $response->toArray();

        // Generate the payment endpoint from the configuration file.
        $endpoint = Config::get('PaymentEndpoints.charges');

        // Send the payment request using the SendRequestTrait.
        return $this->sendPaymentRequest($payload, $endpoint);
    }

    /**
     * Process the redirect response after a payment has been attempted.
     *
     * @param mixed $request The incoming request containing redirect data.
     * @return array An array containing the response and any messages.
     */
    public function processRedirectResponse($request)
    {
        // Prepare an empty payload for the GET request.
        $payload = [''];

        // Generate the endpoint using the tap_id from the request.
        $endpoint = Config::get('PaymentEndpoints.charges') . "/" . $request->tap_id;
        $method = "GET";

        // Send the payment request using the SendRequestTrait.
        $response = $this->sendPaymentRequest($payload, $endpoint, $method);

        // Check if the response indicates a successful transaction and if the save_card flag is true.
        if ($response->gateway->response->code == "0" && $response->save_card == true) {
            $customer = $this->saveCustomerCard($response);
            $card_save_message = $customer;
        } else {
            $card_save_message = "Your card is not saved.";
        }

        return ['response' => $response, "message" => $card_save_message];
    }

    /**
     * Save the customer's card information based on the payment response.
     *
     * @param mixed $response The response from the payment gateway.
     * @return string A message indicating the result of the card saving operation.
     */
    public function saveCustomerCard($response)
    {
        // Retrieve the customer based on the provided email.
        $customer = Customer::where('email', $response->customer->email)->first();

        if (isset($customer)) {
            // If the customer exists, create a new entry for their card.
            CustomerCards::create([
                'customer_email' => $response->customer->email,
                'card_id' => $response->card->id,
                'bin_number' => $response->card->first_six . 'xxxxxx' . $response->card->last_four
            ]);
        } else {
            // If the customer does not exist, create a new customer entry and their card details.
            Customer::create([
                'customer_id' => $response->customer->id,
                'email' => $response->customer->email,
                'first_name' => $response->customer->first_name
            ]);

            CustomerCards::create([
                'customer_email' => $response->customer->email,
                'card_id' => $response->card->id,
                'bin_number' => $response->card->first_six . 'xxxxxx' . $response->card->last_four
            ]);

            CustomerAgreements::create([
                'customer_email' => $response->customer->email,
                'agreement_id' => $response->payment_agreement->id,
                'contract_id' => $response->payment_agreement->contract->id,
            ]);
        }

        return 'Your card is saved successfully.';
    }
}
