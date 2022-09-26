<?php

namespace App\Listeners;

use App\Contracts\PaymentRepositoryInterface;
use App\Events\StorePayment as EventsStorePayment;
use App\Mail\StorePayment as MailStorePayment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class StorePayment
{
    protected  PaymentRepositoryInterface $paymentRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventsStorePayment $event)
    {

        $payment = $this->paymentRepository->store($event->data);
        if($payment){
            Mail::to($payment->client)->send(new MailStorePayment($payment));
        }

    }
}
