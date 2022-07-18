<?php
namespace app\interfaces;

interface IHistoryQuotesService{
    public function getHistoryQuotes(string $symbol, $region ='') : array;
}