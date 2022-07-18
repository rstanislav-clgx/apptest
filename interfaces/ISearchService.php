<?php

namespace app\interfaces;


use app\components\SearchDataProvider;

interface ISearchService
{
    public function actionSearch(array $requestData) : SearchDataProvider;

}