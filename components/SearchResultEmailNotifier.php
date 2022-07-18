<?php

namespace app\components;

use app\interfaces\ICompanyService;
use app\interfaces\INotifier;
use yii\base\BaseObject;
use Yii;

class SearchResultEmailNotifier extends BaseObject implements INotifier
{
    public function __construct(private SearchDataProvider $dataProvider, $config=[])
    {
        parent::__construct($config);
    }

    public function notify(){
        $companyService = Yii::$container->get(ICompanyService::class);
        $searchModel = $this->dataProvider->getSearchModel();

        $companySymbol = $searchModel->companySymbol;
        $companyName   = $companyService->getCompanyNameBySymbol($companySymbol);
        $email         = $this->dataProvider->getSearchModel()->email;
        $from          = $searchModel->startDate;
        $until         = $searchModel->endDate;

        $subject = "for submitted $companySymbol => $companyName";
        $body = "From $from to $until";


        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }
}