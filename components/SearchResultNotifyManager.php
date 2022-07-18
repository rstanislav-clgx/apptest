<?php

namespace app\components;
use app\interfaces\INotifier;
use app\interfaces\ISearchResultNotifyManager;

class SearchResultNotifyManager extends NotifyManager implements ISearchResultNotifyManager
{
    protected array $_notifiers=[];

    public function __construct(protected SearchDataProvider $dataProvider, $config=[]){
        parent::__construct($config);
    }

    /**
     * @param INotifier $notifier
     * @return void
     */
    public function addNotifier(INotifier $notifier){
        $this->_notifiers[] = $notifier;
        return $this;
    }

    /**
     * @return bool
     */
    public function notify()
    {

        $searchModel = $this->dataProvider->getSearchModel();

        if(empty(array_filter($searchModel->attributes))){
            return false;
        }

        $searchModel->clearErrors();
        foreach($this->_notifiers as $notifier){
            $notifier->notify();
        };
    }
}