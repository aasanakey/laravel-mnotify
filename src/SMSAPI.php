<?php
namespace Sanakey\Mnotify;

class SMSAPI {

    /**
     * API SMS endpoint
     * @var string
     */
    private $_endpoint;

     /**
     * @var string
     */
    private $balance_endpoint;

     /**
      * API usage summary endpoint
     * @var string
     */
    private $usage_endpoint;

    /**
      * SMS API key
     * @var string
     */
    private $key;


    public $message;
    public $numbers;
    public $sender;

    public function __construct()
    {
        $this->key = config('mnotify.sms_api_key');
        $this->_endpoint = 'https://apps.mnotify.net/smsapi';
        $this->balance_endpoint = "https://apps.mnotify.net/smsapi/balance";
        $this->usage_endpoint = "https://apps.mnotify.net/smsapi/api_usage";
    }

    /**
     * send a curl resquest to endpoint
     */
    private function initCurl($url,$method="GET")
    {
        if( !extension_loaded("curl")){
            throw new Exception("Please install and enable curl extention", 1);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }

    /**
     * Send SMS using the Mnotify sms api
     * @return stdClass
     */
    public function sendMessage()
    {

        $url = "$this->_endpoint?key=$this->key&to=$this->numbers&msg=$this->message&sender_id=$this->sender";
        $result = $this->initCurl($url);
        return json_decode($result);
    }

       /**
     * Check sms balance 
     * @return String
     */
    public function checkBalance()
    {
        $url = "$this->balance_endpoint?key=$this->key";
        $result = $this->initCurl($url);
        return $result;
    }
   
    /**
     * @param \DateTime $from Y-M-D H:s:i
     * @param \DateTime $to Y-M-D H:s:i
     */
    public function checkUsage(\DateTime $from,\DateTime  $to)
    {
        $url = "$this->usage_endpoint?key=$this->key&from=".date_format($from,'Y-M-d H:s:i')."&to=".date_format($to,'Y-M-d H:s:i');
        $result = $this->initCurl($url);
        return json_decode($result) ; 
    }

    /**
     * Interpret the response code from the server
     */
    // private function interpret($code)
    // {
    //     $status = '';
    //     switch ($code) {
    //         case '1000':
    //             $status = 'Messages has been sent successfully';
    //             return $status;
    //             break;
    //         case '1002':
    //             $status = 'SMS sending failed. Might be due to server error or other reason';
    //             return $status;
    //             break;
    //         case '1003':
    //             $status = 'Insufficient SMS credit balance';
    //             return $status;
    //             break;
    //         case '1004':
    //             $status = 'Invalid API Key';
    //             return $status;
    //             break;
    //         case '1005':
    //             $status = 'Invalid recipient\'s phone number';
    //             return $status;
    //             break;
    //         case '1006':
    //             $status = 'Invalid sender id. Sender id must not be more than 11 characters. Characters include white space';
    //             return $status;
    //             break;
    //         case '1007':
    //             $status = 'Message scheduled for later delivery';
    //             return $status;
    //             break;
    //         case '1008':
    //             $status = 'Empty Message';
    //             return $status;
    //             break;
    //         default:
    //             return $status;
    //             break;
    //     }
    // }
}


// $api = new SMSAPI();
//         $api->key = "91fyNELgb45TKoJunQYVQe5FE";
//         $result=$api->checkBalance();
//         echo $result."<br>".date_format(date_create("2020-11-5 00:00:01"),"Y-M-d H:s:i")."<br>".date_format(date_create("12-12-2020 11:59:59"),"Y-M-d H:s:i")."<br>";

//         echo $api->checkUsage(date_create("2020-11-5 00:00:01"),date_create("12-12-2020 11:59:59"));