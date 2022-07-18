<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $searchModel */
/** @var $allSymbols */
/** @var \app\components\SearchDataProvider $dataProvider */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use \yii\jui\DatePicker;
use yii\grid\GridView;
use miloschuman\highcharts\Highstock;
use yii\web\JsExpression;
use yii\jui\Tabs;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
$searchModel = $dataProvider->getSearchModel();
?>

<style type="text/css">
    .feedback .invalid-feedback{
        display: block!important;
    }
</style>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-12" id="form-wrapper">
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "<div class='col-4'>{label}</div>\n<div class='col-4'>{input}</div>\n<div class='col-4 feedback'>{error}</div>",
                'labelOptions' => ['class' => 'col-form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback'],
            ],
        ]); ?>
        <?=$form->errorSummary($searchModel); ?>
        <?= $form->field($searchModel, 'companySymbol')->widget(\yii\jui\AutoComplete::className(), [
                'options'=>['class'=>'form-control'],
                'clientOptions'=>[
                    'source'=>$searchModel->getAvailableSymbols(),
                    'minLength'=>2,
                    'autoFill'=>true,
                ]
            ],
        ) ?>
        <?= $form->field($searchModel, 'startDate')->widget(DatePicker::className(),[
                'dateFormat'=>"yyyy-MM-dd",
                'options'=>['class'=>'form-control', 'maxLength'=>10, 'minLength'=>10],
                'clientOptions'=>[
                    'maxDate'=>"-0",
                    'maxlength'=>10,
                ]
            ]
        ) ?>
        <?= $form->field($searchModel, 'endDate')->widget(DatePicker::className(), [
                'dateFormat'=>"yyyy-MM-dd",
                'options'=>['class'=>'form-control', 'maxLength'=>10, 'minLength'=>10],
                'clientOptions'=>[
                    'maxDate'=>"-0",
                ]
        ]) ?>
        <?= $form->field($searchModel, 'email')->textInput([]) ?>

        <?php $form->field($searchModel, 'region')->textInput([]) ?>
        <div class="form-group" style="text-align: right">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'search-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <hr/>
    <div class="" id="result-wrapper">
        <?= Tabs::widget([
                'items'=>[
                    [
                        'label' => 'Grid',
                        'content'=> GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns'=>[
                                'date'=>[
                                    'header'=>'Date',
                                    'value'=>function($item){
                                        return date("Y-m-d h:i",$item['date']);
                                    }
                                ],
                                'open',
                                'high',
                                'low',
                                'close',
                                'volume'
                            ]
                            //'itemView' => '_post',
                        ])
                    ],
                    [
                        'label' => 'Chart',
                        'content'=> Highstock::widget([
                        'container'=>'chart-container',
                        'options' => [
                            'title' => ['text' => 'Fruit Consumption'],
                            'rangeSelector'=>['selected'=>1],
                            'series' => [[
                                    'type'=>'candlestick',
                                    'name'=>'stock',
                                    'data'=> $dataProvider->getModels(),
                                ]]
                            ]
                        ])
                    ],
                ]
        ]); ?>
    </div>

</div>