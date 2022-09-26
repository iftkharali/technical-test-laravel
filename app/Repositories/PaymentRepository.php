<?php

namespace App\Repositories;

use App\Contracts\PaymentRepositoryInterface;
use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function getAll()
    {
        return Payment::all();
    }

    public function store($data)
    {
        return Payment::create($data);
    }
}
