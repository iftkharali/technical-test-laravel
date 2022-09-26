<?php

namespace App\Jobs;

use App\Events\StorePayment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCreatePaymentlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $endpoint = env('DOLLAR_API_URL');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint);

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            $content = $response->getBody();
            $res = json_decode($content);
            $data = collect($res->serie);
            if ($data->count()) {
                $date = Carbon::parse($this->details['payment_date'])->format('Y-m-d');
                $data = $data->map(function ($item) {
                    $item->fecha =  Carbon::parse($item->fecha)->format('Y-m-d');
                    return $item;
                });
                $ready_to_go = $data->where('fecha', $date);
                if (count($ready_to_go)) {
                    foreach ($ready_to_go as $key => $item) {
                        $this->details['clp_usd'] = $item->valor;
                        $payment = Payment::where('payment_date', $this->details['payment_date'])->first();
                        if (!$payment) {
                            event(new StorePayment($this->details));
                        }
                    }
                }
            }
        }
    }
}
