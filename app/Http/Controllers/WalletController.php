<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * @var WalletService
     */
    private $walletService;

    public function __construct()
    {
        $this->walletService = new WalletService();
    }

    public function registerCustomer(Request $request)
    {
        $this->validate($request, [
            'nroDocument' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'cellphone' => 'required',
        ]);

        $response = $this->walletService->registerCustomer($request->input('nroDocument'), $request->input('name'), $request->input('email'),$request->input('cellphone'));

        return response()->json($response);
    }

    public function walletRecharge(Request $request)
    {
        $this->validate($request, [
            'nroDocument' => 'required',
            'cellphone' => 'required',
            'amount' => 'required|numeric|between:0,9999999999.99'
        ]);

        $response = $this->walletService->walletRecharge($request->input('nroDocument'), $request->input('cellphone'), $request->input('amount'));

        return response()->json($response);
    }

    public function pay(Request $request)
    {
        $this->validate($request, [
            'nroDocument' => 'required',
            'cellphone' => 'required',
            'amount' => 'required|numeric|between:0,9999999999.99'
        ]);

        $response = $this->walletService->pay($request->input('nroDocument'), $request->input('cellphone'), $request->input('amount'));

        return response()->json($response);
    }

    public function confirmPay(Request $request)
    {
        $this->validate($request, [
            'sessionId' => 'required',
            'token' => 'required',
        ]);

        $response = $this->walletService->confirmPay($request->input('sessionId'), $request->input('token'));

        return response()->json($response);
    }

    public function checkBalance(Request $request)
    {
        $this->validate($request, [
            'nroDocument' => 'required',
            'cellphone' => 'required',
        ]);

        $response = $this->walletService->checkBalance($request->input('nroDocument'), $request->input('cellphone'));

        return response()->json($response);
    }
}
