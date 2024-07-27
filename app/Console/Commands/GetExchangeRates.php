<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To get Exchange Rates and Store in Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // set API Endpoint and API key
        $endpoint = 'latest';
        $access_key = config('services.exchangerates.key');

// Initialize CURL:
        $ch = curl_init('http://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

// Decode JSON response:
        $exchangeRates = json_decode($json, true);

// Access the exchange rate values, e.g. GBP:
        if (isset($exchangeRates) && $exchangeRates['success'] == true){
            $rates = [];
            foreach ($exchangeRates['rates'] as $code => $rate){
                $rates[] = [
                    'code' => $code,
                    'rate' => $rate,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            ExchangeRate::insert($rates);

        }

    }
}
