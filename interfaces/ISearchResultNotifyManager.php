<?php
namespace app\interfaces;

interface ISearchResultNotifyManager extends INotifier {
   public function addNotifier(INotifier $notifier);
   public function notify();
}