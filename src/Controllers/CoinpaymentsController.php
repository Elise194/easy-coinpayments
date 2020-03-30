<?php

namespace Elise194\EasyCoinPayments\Controllers;

use Elise194\EasyCoinPayments\CoinPayments;
use Elise194\EasyCoinPayments\Services\CoinpaymentsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            $service->processingCallback($post, $request->header('hmac'));
            return true;
        } catch (\Exception $e) {

        }
    }
}
