<?php

namespace Elise194\EasyCoinPayments\Controllers;

use App\Http\Controllers\Controller;
use Elise194\EasyCoinPayments\Services\CoinpaymentsService;
use Illuminate\Http\Request;

class CoinpaymentsController extends Controller
{
    /**
     * @param Request $request
     * @throws \Exception
     */
    public function callback(Request $request)
    {
        $post = $request->post();
        try {
            $service = new CoinpaymentsService();
            $service->createCoinPaymentsTransaction(0.001, 'BTC', 'BTC', '11@mail.ru');
//            $service->processingCallback($post, $request->header('hmac'));

            return;
        } catch (\Exception $e) {
            dd('here we are', $e->getMessage());
        }
    }
}
