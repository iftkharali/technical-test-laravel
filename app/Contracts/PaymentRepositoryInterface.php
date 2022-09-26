<?php

namespace App\Contracts;


interface PaymentRepositoryInterface
{
    public function getAll();
    public function store($data);
}
