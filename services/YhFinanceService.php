<?php

namespace app\services;

use app\interfaces\IFetcher;
use app\interfaces\IHistoryQuotesService;
use yii\base\BaseObject;

class YhFinanceService extends BaseObject implements IHistoryQuotesService{
    public string $xRapidApiKey;
    public string $xRapidApiHost;
    public string $xRapidUri;


    public function __construct(private IFetcher $fetcher, $config=[])
     {
        if(empty($config)){
            throw new \Exception('YhFinanceService has empty config params');
        } elseif (empty($config['xRapidApiKey'])) {
            throw new \Exception('YhFinanceService has empty xRapidApiKey config param');
        }
         elseif ( empty($config['xRapidApiHost'])) {
            throw new \Exception('YhFinanceService has empty xRapidApiHost config param');
        }
        elseif ( empty($config['xRapidUri'])) {
            throw new \Exception('YhFinanceService has empty xRapidUri config param');
        }

         parent::__construct($config);
     }


    public function getHistoryQuotes(string $symbol, $region ='') : array
     {
        $headers = array(
            "X-RapidAPI-Key: $this->xRapidApiKey",
            "X-RapidAPI-Host: $this->xRapidApiHost"
        );

         $params = array(
             'symbol' => $symbol,
             'region' => $region
         );

         $response = $this->fetcher->get("https://{$this->xRapidApiHost}{$this->xRapidUri}", $params, $headers);

         return $response? json_decode($response, true) : [];
     }
}