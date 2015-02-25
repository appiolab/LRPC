<?php
/**
 * Created by PhpStorm.
 * User: ariful
 * Date: 2/25/15
 * Time: 1:03 PM
 */

namespace AppioLab\Tests\LRPC;


/**
 * Autoloading Test fiels
 *
 */

include (__DIR__.'/../../src/LRPC/LRPC.php');


use AppioLab\LRPC\LRPC;

class LRPCTest {

    private $lrpc;

    function __construct(){

        echo "================================".PHP_EOL;
        echo "LRPC TEST".PHP_EOL;
        echo "================================".PHP_EOL;

//        @TODO update the params to test
        $params = Array();
        $params['url']      = 'http://dev.posios.com:8080/PosServer/JSON-RPC';      // Change the url
        $params['email']    = '';                                                   // Add Partner email
        $params['password'] = '';                                                   // Add Partner Password
        $params['appid']    = '';                                                   // Add your appId e.g. MyLSApp

        $lrpc = new LRPC($params);
        $status = $lrpc->connectToLightspeed();

        if($status['status']==1){

            $lrpc->setCompanyId("0000");// Add your CompanyID
            $paymentTypes = $lrpc->getPaymentTypes();
            echo "Payment Types";
            print_r($paymentTypes);
        }else{
            echo "wrong";
        }

        print_r($status);
//        echo "Token is: ". $lrpc->getApiToken();

        echo PHP_EOL;

    }




}//end class