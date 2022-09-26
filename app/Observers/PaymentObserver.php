<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Payment;

class PaymentObserver
{

    public function creating(Payment $payment)
    {
        $payment->uuid = Str::uuid();
    }
}
