<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetrieveRequst;
use App\Repositories\InternalOperationsRepository;
use Illuminate\Http\Request;

class InternalOperationsController extends Controller
{

    /**
     * The GeneralOperationsRepository instance used for handling payment-related database operations.
     *
     * @var InternalOperationsRepository
     */
    protected $InternalOperationsRepository;

    //
    /**
     * PaymentController constructor.
     *
     * @param GeneralOperationsRepository $requestRepository The PaymentRepository instance for processing payment requests.
     */
    public function __construct(InternalOperationsRepository $requestRepository)
    {
        $this->InternalOperationsRepository = $requestRepository;
    }

    public function retrievePT(){
        return view('dash.in.retreivePT');
    }


    public function fetchPT(RetrieveRequst $request){

        $response = $this->InternalOperationsRepository->FetchPT($request);


        // Check if a redirect URL is provided in the response and redirect the user if available.
        return $response;
    }

    public function whitelist(){
        return view('dash.in.ab.whitelist');
    }

    public function PostWhitelist(Request $request){
        $response = $this->InternalOperationsRepository->whitelist($request);


        // Check if a redirect URL is provided in the response and redirect the user if available.
        return $response;

    }

    public function RetrieveWhitelist(){
        return view('dash.in.ab.retrieveWhitelist');
    }

    public function PostRetrieveWhitelist(Request $request){
        $response = $this->InternalOperationsRepository->whitelist($request);


        // Check if a redirect URL is provided in the response and redirect the user if available.
        return $response;

    }
}
