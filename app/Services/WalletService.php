<?php
namespace App\Services;

use App\Data\ResponseData;

class WalletService
{
    /**
     * @var \SoapClient
     */
    private $client;

    public function __construct()
    {
        $wsdl = config('soap.clients.wallet.base_wsdl');

        $opts = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $context = stream_context_create($opts);

        $this->client = new \SoapClient($wsdl, array(
                'stream_context' => $context, 'trace' => true)
        );
    }

    /**
     * register Customer
     *
     * @param string $nroDocument
     * @param string $name
     * @param string $email
     * @param string $cellphone
     * @return ResponseData
     */
    public function registerCustomer(string $nroDocument, string $name, string $email, string $cellphone): ResponseData
    {
        try {
            $response = $this->client->registerCustomer(['nroDocument' => $nroDocument, 'name' => $name, 'email' => $email, 'cellphone' => $cellphone]);
            $result = $response->registerCustomerResult;

            return new ResponseData($result->success, $result->cod_error, $result->message_error, []);
        } catch (\Exception $e) {
            return new ResponseData(false, '01', $e->getMessage(), []);
        }
    }

    /**
     * Wallet Recharge
     *
     * @param string $nroDocument
     * @param string $cellphone
     * @param float $amount
     * @return ResponseData
     */
    public function walletRecharge(string $nroDocument, string $cellphone, float $amount): ResponseData
    {
        try {
            $response = $this->client->walletRecharge(['nroDocument' => $nroDocument, 'cellphone' => $cellphone, 'amount' => $amount]);
            $result = $response->walletRechargeResult;

            return new ResponseData($result->success, $result->cod_error, $result->message_error, []);
        } catch (\Exception $e) {
            return new ResponseData(false, '01', $e->getMessage(), []);
        }
    }

    /**
     * Pay
     *
     * @param string $nroDocument
     * @param string $cellphone
     * @param float $amount
     * @return ResponseData
     */
    public function pay(string $nroDocument, string $cellphone, float $amount): ResponseData
    {
        try {
            $response = $this->client->pay(['nroDocument' => $nroDocument, 'cellphone' => $cellphone, 'amount' => $amount]);
            $result = $response->payResult;

            return new ResponseData($result->success, $result->cod_error, $result->message_error, $result->data);
        } catch (\Exception $e) {
            return new ResponseData(false, '01', $e->getMessage(), []);
        }
    }

    /**
     * Confirm Pay
     *
     * @param string $sessionId
     * @param string $token
     * @return ResponseData
     */
    public function confirmPay(string $sessionId, string $token): ResponseData
    {
        try {
            $response = $this->client->confirmPay(['sessionId'=> $sessionId, 'token' => $token]);
            $result = $response->confirmPayResult;

            return new ResponseData($result->success, $result->cod_error, $result->message_error, []);
        } catch (\Exception $e) {
            return new ResponseData(false, '01', $e->getMessage(), []);
        }
    }

    /**
     * Check Balance
     *
     * @param string $nroDocument
     * @param string $cellphone
     * @return ResponseData
     */
    public function checkBalance(string $nroDocument, string $cellphone): ResponseData
    {
        try {
            $response = $this->client->checkBalance(['nroDocument' => $nroDocument, 'cellphone' => $cellphone]);
            $result = $response->checkBalanceResult;

            return new ResponseData($result->success, $result->cod_error, $result->message_error, $result->data);
        } catch (\Exception $e) {
            return new ResponseData(false, '01', $e->getMessage(), []);
        }
    }
}
