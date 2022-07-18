<?php

namespace app\components;

use yii\data\ArrayDataProvider;
use \app\models\SearchModel;

class SearchDataProvider extends ArrayDataProvider
{
    private SearchModel $searchModel;

    public function setSearchModel(SearchModel $searchModel){
        $this->searchModel = $searchModel;
    }

    public function getSearchModel(){
        return $this->searchModel;
    }
}