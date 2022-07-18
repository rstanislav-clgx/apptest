<?php

namespace app\components;
use app\interfaces\IFetcher;
use yii\base\BaseObject;

class Fetcher extends BaseObject implements IFetcher
{
    public function get($url, array $params =[], array $headers =[], $method="GET"){
        $curl = curl_init();

        $url_params = $method=="GET"? http_build_query($params) : "";

        $url = "$url?$url_params";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        if ($number = curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            throw new \Exception(__CLASS__."::".__FUNCTION__."(). URL: $url,  CURL error code $number, error message:".$error_msg);
        }

        return $response;
    }
}