<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentRepositoryInterface;
use App\Events\StorePayment;
use App\Http\Requests\StorePaymentRequest;
use App\Jobs\SendCreatePaymentlJob;

class PaymentController extends Controller
{
    protected PaymentRepositoryInterface $paymentRepository;
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = $this->paymentRepository->getAll();
        return response()->json(['data'=>$payments],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        dispatch(new SendCreatePaymentlJob($request->all()));
        return response()->json(['message'=>'Congrats, Job Dispatched Successfully!']);
    }
}
