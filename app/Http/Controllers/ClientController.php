<?php

namespace App\Http\Controllers;

use App\Contracts\ClientRepositoryInterface;

class ClientController extends Controller
{
    protected ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->clientRepository->getAll();

        return response()->json(['data'=>$clients],200);
    }
}
