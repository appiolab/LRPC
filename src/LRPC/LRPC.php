<?php 

namespace AppioLab\LRPC;

/**
 * Class LRPC
 * Lightspeed Restaurant PHP Client.
 *
 * @author Ariful Haque <arifulhb@gmail.com>
 *
 * @package AppioLab\LRPC
 * @version 0.1.0
 *
 * @copyright MIT
 */
class LRPC{

    private $_server_url 	= null;

    private $_api_token		= null;

    private $_email			= null;
    private $_password		= null;
    private $_app_id		= null;
    private $_company_id	= null;


    /**
     * Class Construct
     *
     * @author Ariful Haque <arifulhb@gmail.com>*
     *
     * @param string $params['url'] API Endpoint of Lightspeed API Server
     * @param string $params['email'] Lightspeed Partner account email
     * @param string $params['password'] Lightspeed Partner account password
     * @param string $params['appid'] Application ID
     * @version 0.1.0
     * @since 0.1.0
     */
    function __construct($params = null) {

        $response = null;

        if(count($params)>0){

                //SET THE
                $this->_server_url	= $params['url'];
                $this->_email		= $params['email'];
                $this->_password	= $params['password'];
                $this->_app_id		= $params['appid'];

        }

    }//end constractor


    /**
     * @return null
     *
     * @since Version 0.1.0
     */
    public function getCompanyId(){

        return $this->_company_id;

    }

    /**
     * @param $value
     *
     * @since  Version 0.1.0
     */
    public function setCompanyId($value){
        //echo 'SET COMPANY ID: '.$value.'<BR>';
        $this->_company_id=$value;

    }

    /**
     * @param $index
     * @param $amount
     *
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getCustomers($index, $amount)
    {

        $params=array($this->_api_token,$this->_company_id, $index, $amount);

        $response = $this->invoke(11,'customerApi.getCustomers',$params);
        return $response;
    }

    /**
     * Not useing now
     *
     * @return mixed|null
     *
     * @depricated
     *
     * @since  Version 0.1.0
     */
    public function generateClientToken($param = null){

        $params=array(	$param['email'],
            $param['password'],
            $param['app_title'],
            $this->_app_id,
            "",
            "",
            "",
            false,
            "",
            "");

        $this->_client_token = $this->invoke(15,'reservationInterfaceApi.getClientToken',$params);

        return $this->_client_token;

    }//end function


    /**
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getFloor(){


        $params=array($this->_api_token,$this->_company_id);

        $response = $this->invoke(17,'posiosApi.getFloors',$params);
        return $response;

    }


    /**
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getClientToken(){

        return $this->_client_token;
    }


    /**
     * @param $client_token
     *
     * @since  Version 0.1.0
     */
    public function setClientToken($client_token){
        $this->_client_token = $client_token;
    }


    /**
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getClient(){

        $params=array($this->_api_token);
        $response = $this->invoke(13,'reservationInterfaceApi.getClient',$params);
        return $response;

    }//end function


    /**
     * @param $customer_id
     *
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getCustomerById($customer_id){

        $params=array($this->_api_token,$this->_company_id, $customer_id);

        $response = $this->invoke(18,'customerApi.getCustomerById',$params);
        return $response;

    }//end function


    /**
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getReservationSlots(){

        $params=array($this->_api_token,$this->_company_id);
        $response = $this->invoke(13,'reservationInterfaceApi.getSlots',$params);
        return $response;

    }//end function getReservationSlots

    /**
     * @param $reservation_array
     *
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function addReservation($reservation_array){

        $reservation = json_decode(json_encode($reservation_array), FALSE);

        $params=array($this->_api_token, $reservation, false);

        $response = $this->invoke(14,'reservationInterfaceApi.addClientReservation',$params);

        return $response;


    }//end function


    /**
     * @param $client_array
     *
     * @return mixed
     *
     *
     * @since  Version 0.1.0
     */
    public function addClient($client_array){


        $client = json_decode(json_encode($client_array), FALSE);

        $params=array($this->_api_token, $client, false);

        $response = $this->invoke(16,'reservationInterfaceApi.addClient',$params);

        return $response;

    }//end function


    /**
     * @param $customer_array
     *
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function addCustomer($customer_array){

        $customer = json_decode(json_encode($customer_array), FALSE);

        $params=array($this->_api_token,$this->_company_id, $customer);

        $response = $this->invoke(12,'customerApi.addCustomer',$params);

        return $response;

    }//end function


    /**
     * Connect to Lightspeed
     *
     * @return array
     *
     * @since  Version 0.1.0
     */
    public function connectToLightspeed(){

        $params=array($this->_email,$this->_password,$this->_app_id,"","","","",false,"","");

        $response = $this->invoke(1,'posiosApi.getApiToken',$params);

        if(isset($response->error)){

            $this->_api_token   = null;

            $error['code']      = $response->error->code;
            $error['message']   = $response->error->msg;

            return (Array("status"=> false, "error"=>$error));

        }elseif(isset($response->result)) {

            $this->_api_token = $response->result;
            return (Array("status"=> true));
        }


    }//end function


    /**
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getPaymentTypes(){

        $params=array($this->_api_token,$this->_company_id);

        $response = $this->invoke(2,'posiosApi.getPaymentTypes',$params);
//        return $response->result;
        return $response;

    }//end function


    /**
     * @param $from
     * @param $to
     *
     * @return mixed
     *
     *
     * @since  Version 0.1.0
     */
    public function getReceiptsByDate($from,$to){


        $params=array($this->_api_token,$this->_company_id,$from,$to);

        $response = $this->invoke(3,'posiosApi.getReceiptsByDate',$params);

        return $response;


    }//end function


    /**
     * @param $start
     * @param $amount
     *
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getCompanies($start,$amount){

        $params=array($this->_api_token,$start,$amount);

        $response = $this->invoke(6,'posiosApi.getCompanies',$params);

        return $response;


    }//end function


    /**
     * @param $status
     *
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getReceiptsByStatus($status){


        $params=array($this->_api_token,$this->_company_id,$status);

        $response = $this->invoke(4,'posiosApi.getReceiptsByStatus',$params);

        return $response;


    }//end function

    /**
     * @return null
     *
     * @since  Version 0.1.0
     */
    public function getApiToken(){

        return $this->_api_token;

    }//end function


    /**
     * @param $api_token
     *
     * @since  Version 0.1.0
     */
    public function setApiToken($api_token){

        $this->_api_token=$api_token;

    }//end function


    /**
     * @return mixed
     *
     * @since  Version 0.1.0
     */
    public function getVersion(){

        $response=$this->invoke(9999,'posiosApi.getVersion',array());

        return $response;

    }

    /**
     * @return null
     *
     * @since  Version 0.1.0
     */
    public function getServerUrl(){

        return $this->_server_url;
    }


    /**
     * @param $value
     *
     * @since  Version 0.1.0
     */
    public function setServerUrl($value){

        $this->_server_url=$value;

    }

    /**
     * @param $id
     * @param $method
     * @param $params
     *
     * @return mixed
     *
     *
     * @since  Version 0.1.0
     */
    private function invoke($id, $method, $params){

        /*echo('<br>INVOKE ID:'.$id.' METHOD: '.$method.' params: ');
        print_r($params);
        echo 'server url: '.$this->_server_url.'<br>';
        echo "<br><br>";*/
        //$url='http://dev.posios.com:8080/PosServer/JSON-RPC';

        //PREPARE FOR JSON
        $data=array("id"=>$id,
            "method"=>$method,
            "params"=>$params);

        $content=json_encode($data);
        $curl = curl_init($this->_server_url);

        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 5000); //in miliseconds


        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

        $result     = curl_exec($curl);

        /*print_r($result);
        echo '<pre>';
        echo 'show results<br>';*/
        $response   = json_decode($result);


        /*        print_r($response);
                echo '</pre>';*/

        curl_close($curl);

        return $response;
        //var_dump($response);


    }//end function invoke


}//END CLASS
