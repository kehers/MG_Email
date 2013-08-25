<?php
// Quick (dirty) email validation using mailgun's api
//  (http://documentation.mailgun.com/api-email-validation.html)
// Pre: You will need a public apikey from mailgun.
//       ...Signup @ maigun.com/signup for one
// author: @kehers

class MG_Email {
    var $key;
    var $spell_check;
    
    function __construct($key) {
        $this->key = $key;
    }
    
    function is_valid($email) {
        $response = json_decode($this->get('https://api.mailgun.net/v2/address/validate?address='.$email));
        $this->spell_check = $response->did_you_mean ? $response->did_you_mean : '';
        
        //var_dump($response);
        return $response->is_valid ? true : false;
    }
    
    private function get($url) {
        $url .= '&api_key='.$this->key;
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // set to 1 to verify ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
        $response = curl_exec($ch);
        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($status != 200) {
            // Something is wrong with the api,
            // Revert to another verification method
            // is_email (code.google.com/p/isemail/) maybe?
        }
        
        curl_close($ch);
        
        return $response;
    }
}
?>