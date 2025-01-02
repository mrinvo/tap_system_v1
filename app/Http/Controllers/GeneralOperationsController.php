<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Http\Requests\RetrieveRequst;
use Illuminate\Http\Request;
use App\Repositories\GeneralOperationsRepository;

class GeneralOperationsController extends Controller
{
    /**
     * The GeneralOperationsRepository instance used for handling payment-related database operations.
     *
     * @var GeneralOperationsRepository
     */
    protected $GeneralOperationsRepository;

    /**
     * PaymentController constructor.
     *
     * @param GeneralOperationsRepository $requestRepository The PaymentRepository instance for processing payment requests.
     */
    public function __construct(GeneralOperationsRepository $requestRepository)
    {
        $this->GeneralOperationsRepository = $requestRepository;
    }

    public function createBusiness(){
        return view('dash.gn.business.create');
    }

    public function storeBusiness(BusinessRequest $request){

        $response = $this->GeneralOperationsRepository->CreateBusiness($request);

        // Check if a redirect URL is provided in the response and redirect the user if available.
        return (isset($response->transaction->url))
            ? redirect($response->transaction->url)
            : view('error', compact('response'));

        // return redirect()->route('business.create')->with('success', 'Business created successfully!');
    }

    public function retrieveBusiness(){
        return view('dash.gn.business.retrieve');
    }


    public function fetchBusiness(RetrieveRequst $request){

        $response = $this->GeneralOperationsRepository->FetchBusiness($request);


        // Check if a redirect URL is provided in the response and redirect the user if available.
        return $response;
    }
}
