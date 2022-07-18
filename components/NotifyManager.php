<?php

namespace app\components;

use app\interfaces\INotifier;
use yii\base\BaseObject;

class NotifyManager extends BaseObject implements INotifier
{
    /**
     * @param array $_notifiers
     */
    public function __construct(protected array $_notifiers = [], $config=[])
    {
        parent::__construct($config);
    }

    /**
     * @param INotifier $notifier
     * @return void
     */
    public function addNotifier(INotifier $notifier){
        $this->_notifiers[] = $notifier;
    }

    /**
     * @return bool
     */
    public function notify()
    {
        return array_walk($this->_notifiers, callback: function (INotifier $notifier){
           $notifier->notify();
        });
    }
}