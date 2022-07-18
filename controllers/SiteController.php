<?php

namespace app\controllers;


use app\interfaces\ISearchResultEmail;
use app\interfaces\ISearchService;
use app\interfaces\ISearchResultNotifyManager;
use app\interfaces\ISearchResultNotifier;

use yii\web\Controller;
use Yii;


class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @throws \yii\di\NotInstantiableException
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function actionIndex(){
        $requestData   = Yii::$app->request->post();
        $dataProvider  = Yii::$container->get(ISearchService::class)->actionSearch($requestData);

        $emailNotifier = Yii::$container->get(ISearchResultNotifier::class, [$dataProvider]);
        $notifyManager = Yii::$container->get(class:ISearchResultNotifyManager::class,
            params: ['dataProvider'=>$dataProvider])
            ->addNotifier($emailNotifier)
            ->notify();

        //todo: Do we need notify only wen se have some data
        //todo: Should we send received data via email
        //todo: Should we filter the data by the date range


         return $this->render('index',[
            'dataProvider'=>$dataProvider
        ]);
    }







}
