<?php

namespace app\services;

use app\models\SearchModel;
use app\components\SearchDataProvider;
use app\interfaces\IHistoryQuotesService;
use yii\base\Component;

class SearchService extends Component
{
    protected int $cacheDuration = 0;

    public function __construct(
        private SearchDataProvider    $dataProvider,
        private SearchModel           $searchModel,
        private IHistoryQuotesService $historyQuotesService,
        $config = []
    )
    {
        parent::__construct($config);
    }

    /**
     * @param array $requestData could be $_POST params
     * @return SearchDataProvider
     * @throws \Exception
     */
    public function actionSearch(array $requestData): SearchDataProvider
    {
        $searchModel = $this->searchModel;
        $this->dataProvider->setSearchModel($searchModel);

        $historyQuotesService = $this->historyQuotesService;

        if ($searchModel->load($requestData) && $searchModel->validate()) {
            $cacheKey = $searchModel->companySymbol . $searchModel->region;

            $data = \Yii::$app->cache->getOrSet($cacheKey, function () use ($historyQuotesService, $searchModel) {
                return  $historyQuotesService->getHistoryQuotes($searchModel->companySymbol, $searchModel->region);
            },$this->cacheDuration);

            $resultRows = $data['prices'] ?? [];

            $this->dataProvider->setModels($resultRows);
            $this->dataProvider->setTotalCount(sizeof($resultRows));
        }

        return $this->dataProvider;
    }
}