<?php
use app\components\SearchResultEmailNotifier;
use app\components\SearchResultNotifyManager;
use app\interfaces\ICompanyService;
use app\interfaces\IHistoryQuotesService;
use app\interfaces\IFetcher;
use app\interfaces\ISearchResultNotifier;
use app\interfaces\ISearchResultNotifyManager;
use app\interfaces\ISearchService;
use app\components\Fetcher;
use app\services\CompanyService;
use app\services\YhFinanceService;
use app\services\SearchService;

use yii\di\Instance;

$params = require __DIR__ . '/params.php';

return [
    'singletons'=>[
        IFetcher::class=> Fetcher::class,
        ICompanyService::class => [CompanyService::class,[ $params['companiesDataJsonFile'] ]],
        IHistoryQuotesService::class =>[
            YhFinanceService::class,[
                Instance::of(IFetcher::class),
                $params['xRapidConfigs'],
                ['cacheDuration'=>2]
            ],
        ],
        ISearchService::class => SearchService::class,
        ISearchResultNotifyManager::class => SearchResultNotifyManager::class,
        ISearchResultNotifier::class => SearchResultEmailNotifier::class,
    ]
];