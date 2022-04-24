<?php

namespace Engwaqas\Paymentgateway\Base\Gateways;

use Tzsk\Payu\Concerns\Attributes;
use Tzsk\Payu\Concerns\Customer;
use Tzsk\Payu\Concerns\Transaction;
use Tzsk\Payu\Facades\Payu;
use Engwaqas\Paymentgateway\Base\PaymentGatewayBase;

class PayUmoneyPay extends PaymentGatewayBase
{

    public function charge_amount($amount)
    {
        // TODO: Implement charge_amount() method.
    }

    public function ipn_response(array $args)
    {
        // TODO: Implement ipn_response() method.
    }

    public function charge_customer(array $args)
    {
        $url = "https://test.payu.in/_payment";

        $req = curl_init($url);
        curl_setopt($req, CURLOPT_URL, $url);
        curl_setopt($req, CURLOPT_POST, true);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);

        $headers = array( "Content-Type: application/x-www-form-urlencoded", );
        curl_setopt($req, CURLOPT_HTTPHEADER, $headers);
        $required_data = [
            'key' => 'JP***g',
            'txnid' => 'xVoehYja6N6UXo',
             'amount'=>'10.00',
            'firstname'=> "PayU User",
            'email' => 'test@gmail.com',
            'phone' => '9876543210',
            'productinfo'=>'iPhone',
            'bankcode' => '', // nor required
            'surl'=>'https://apiplayground-response.herokuapp.com/', // success url
            'furl' => 'https://apiplayground-response.herokuapp.com/', //failed url,
//            'hash'=> '33e5d638040036ba195049cb0d75cbc37cf8345a52a5478503462bb75f79d2d8b9d18c444438a725f5e514e54d566be9a6b201b371da9119fa9a0f9b5e956309'
            'hash'=> $this->createHash($args)
        ];
        $data = "key=JP***g&txnid=xVoehYja6N6UXo&amount=10.00&firstname=PayU User&email=test@gmail.com&phone=9876543210&productinfo=iPhone&pg=&bankcode=&surl=https://apiplayground-response.herokuapp.com/&furl=https://apiplayground-response.herokuapp.com/&ccnum=&ccexpmon=&ccexpyr=&ccvv=&ccname=&txn_s2s_flow=&hash=33e5d638040036ba195049cb0d75cbc37cf8345a52a5478503462bb75f79d2d8b9d18c444438a725f5e514e54d566be9a6b201b371da9119fa9a0f9b5e956309";

curl_setopt($req, CURLOPT_POSTFIELDS, $data);
$resp = curl_exec($req);
curl_close($req);
var_dump($resp);

        // TODO: Implement charge_customer() method.
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, 'https://test.payu.in/_payment-H');
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POST, 1);
//
//        // generate hash
//        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=mji6olvE&txnid=SU0CsnMBP2AYQt&amount=10.00&firstname=PayU User&email=test@gmail.com&phone=9876543210&productinfo=iPhone&surl=https://apiplayground-response.herokuapp.com/&furl=https://apiplayground-response.herokuapp.com/&hash=3fe4bb610aaa84ed23ff1f3605e0e58d8613895cdf68ffd890d9954b41ecaa788f635851db20c9a8735b53d220676847328b9e7836920c75d51a1c17122cc651");
//
//        $headers = array();
//        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
//        $result = curl_exec($ch);
//        if (curl_errno($ch)) {
//            echo 'Error:' . curl_error($ch);
//        }
//        curl_close($ch);
//        return $result;
//        dd($result);
    }

    public function supported_currency_list()
    {
        // TODO: Implement supported_currency_list() method.
    }

    public function charge_currency()
    {
        // TODO: Implement charge_currency() method.
    }

    public function gateway_name()
    {
        // TODO: Implement gateway_name() method.
    }

    protected function createHash($args){
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $SALT;


        $hash = strtolower(hash('sha512', $hash_string));
    }
}
