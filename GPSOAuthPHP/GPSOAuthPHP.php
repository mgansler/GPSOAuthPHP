<?php

namespace GPSOAuthPHP;

class GPSOAuthPHP
{
    protected $authUrl;
    protected $useragent;
    protected $proxy;

    function __construct($proxy = '')
    {
        $this->authUrl = "https://android.clients.google.com/auth";
        $this->useragent = "GPSOAuthPHP/0.1";
        $this->proxy = $proxy;
    }

    public function performMasterLogin(
        $email,
        $passwd,
        $android_id,
        $service = 'ac2dm',
        $device_country='us',
        $operatorCountry='us',
        $lang='en',
        $sdk_version=17
    ) {
        $data = [
            'accountType' => 'HOSTED_OR_GOOGLE',
            'Email' => $email,
            'has_permission' => 1,
            'add_account' => 1,
            'Passwd' => $passwd,
            // 'EncryptedPasswd' => google.signature(email, password, android_key_7_3_29),
            'service' => $service,
            'source' => 'android',
            'androidId' => $android_id,
            'device_country' => $device_country,
            'operatorCountry' => $operatorCountry,
            'lang' => $lang,
            'sdk_version' => $sdk_version
        ];

        return $this->performAuthRequest($data);
    }

    public function performOAuth(
        $email,
        $master_token,
        $android_id,
        $service,
        $app,
        $client_sig,
        $device_country='us',
        $operatorCountry='us',
        $lang='en',
        $sdk_version=17
    ) {
        $data = [
            'accountType' => 'HOSTED_OR_GOOGLE',
            'Email' => $email,
            'has_permission' => 1,
            'EncryptedPasswd' => $master_token,
            'service' => $service,
            'source' => 'android',
            'androidId' => $android_id,
            'app' => $app,
            'client_sig' => $client_sig,
            'device_country' => $device_country,
            'operatorCountry' => $operatorCountry,
            'lang' => $lang,
            'sdk_version' => $sdk_version
        ];

        return $this->performAuthRequest($data);
    }

    /**
     * send the actual request to Google.
     * 
     * @param  array  $data postfield data
     * @return mixed        parsed response if successful, false otherwise.
     */
    private function performAuthRequest(array $data)
    {
        $options = [
            CURLOPT_URL             => $this->authUrl,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_USERAGENT       => $this->useragent,
            CURLOPT_TIMEOUT         => 10,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => $this->encodePostfields($data),
        ];

        if ($this->proxy) {
            $options[CURLOPT_PROXY] = $this->proxy;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response ? $this->parseAuthResponse($response) : false;
    }

    /**
     * Encodes the data into the post body string.
     * We can't use http_build_query() here because it encodes special characters "$-_.+!*'(),"
     * and we won't receive the Token then.
     * 
     * @param  array  $data associative array of fields to be sent
     * @return string       String in the form of par1=val1&par2=val2...
     */
    private function encodePostfields(array $data)
    {
        $postfields = null;
        foreach ($data as $key => $value) {
            $postfields .= "{$key}={$value}&";
        }
        return rtrim($postfields, "&");
    }

    /**
     * Parses the response from Google as an associative array
     * 
     * @param  string $response Response from Google
     * @return array            Associative array
     */
    private function parseAuthResponse($response)
    {
        $parsed = array();

        $response = explode("\n", $response);
        foreach ($response as $line) {
            $line = explode("=", $line);
            $parsed[$line[0]] = $line[1];
        }
        return $parsed;
    }
}