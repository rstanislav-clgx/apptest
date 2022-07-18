<?php

namespace tests\unit\models;


use app\interfaces\ICompanyService;
use app\models\SearchModel;
use Yii;

class SearchModelTest extends \Codeception\Test\Unit
{
    private SearchModel $model;

    protected function _before()
    {
        $this->model = Yii::$container->get(SearchModel::class);
        parent::_before();
    }

    public function testRequiredFields()
    {
        $model = $this->model = Yii::$container->get(SearchModel::class);
        verify($model->validate())->false();

        $correctValues =[
            'companySymbol'=>'AAL',
            'email'=>'fakeemail@gmail.com',
        ];

        foreach ($correctValues  as $attributeName => $attributeValue){
            verify($model->validate($attributeName))->false();
            $model->setAttributes([$attributeName => $attributeValue]);
            verify($model->validate($attributeName))->true();
        }

        verify($model->validate('startDate'))->false();
        verify($model->validate('endDate'))->false();

        $model->setAttributes([
            'startDate'=>"2022-12-01",
            'endDate'=>"2022-12-02",
        ]);

        verify($model->validate('startDate'))->true();
        verify($model->validate('endDate'))->true();

        verify($model->validate(''))->true();
    }

    public function testCompanySymbolIsValid()
    {
        $companyService =  $this->constructEmpty(ICompanyService::class,[],
           [ 'getAllSymbols'=>function(){return ['AAA', 'BBB'];}]);

       $attributeName ='companySymbol';
       $model = $this->model = new SearchModel($companyService);

       $model->companySymbol = "AAA";
       verify($model->validate($attributeName))->true();

        $model->companySymbol = "BBB";
        verify($model->validate($attributeName))->true();

        $model->companySymbol = "BBBC";
        verify($model->validate($attributeName))->false();

        $model->companySymbol = "CCC";
        verify($model->validate($attributeName))->false();
    }

    public function testDatesHaveCorrectFormat()
    {
        $model = $this->model;
        $model->setAttributes([
            'companySymbol'=>'AAL',
            'email'=>'fakeemail@gmail.com',
            'startDate'=>'2022-07-01',
            'endDate'=>'2022-07-02',
        ]);

        foreach (['startDate', 'endDate'] as $attributeName){
            $model->$attributeName = "";
            verify($model->validate($attributeName))->false();

            $model->$attributeName = "asdfasdf";
            verify($model->validate($attributeName))->false();

            $model->$attributeName = "2022";
            verify($model->validate($attributeName))->false();

            $model->$attributeName = "2022-07";
            verify($model->validate($attributeName))->false();

            $model->$attributeName = "2022-07-1";
            verify($model->validate($attributeName))->false();

            $model->$attributeName = "2022-07-01";
            verify($model->validate($attributeName))->true();
        }
    }


    public function testStartDateIsLessOrEqualThanEndDate()
    {
        $model = $this->model;
        $attributeName = 'startDate';
        $model->setAttributes([
            'companySymbol' => 'AAL',
            'email' => 'fakeemail@gmail.com',
            'endDate' => '2022-07-02',
        ]);

        $model->$attributeName = "2022-07-3";
        verify($model->validate($attributeName))->false();

        $model->$attributeName = "2023-07-3";
        verify($model->validate($attributeName))->false();

        $model->$attributeName = "2022-07-02";
        verify($model->validate($attributeName))->true();

        $model->$attributeName = "2022-06-02";
        verify($model->validate($attributeName))->true();

        $model->$attributeName = "2002-06-02";
        verify($model->validate($attributeName))->true();
    }

    public function testEndDateIsGreaterOrEqualThanStartDate()
    {
        $model = $this->model;
        $attributeName = 'endDate';
        $model->setAttributes([
            'companySymbol' => 'AAL',
            'email' => 'fakeemail@gmail.com',
            'startDate' => '2022-07-02',
        ]);

        $model->$attributeName = "2022-06-29";
        verify($model->validate($attributeName))->false();

        $model->$attributeName = "2022-07-01";
        verify($model->validate($attributeName))->false();

        $model->$attributeName = "2022-07-02";
        verify($model->validate($attributeName))->true();


        $model->$attributeName = "2022-07-03";
        verify($model->validate($attributeName))->true();
    }


    public function testEmailIsCorrect()
    {
        $model = $this->model;
        $attributeName = 'email';

        verify($model->validate($attributeName))->false();

        $model->email = 'fakeem';
        verify($model->validate($attributeName))->false();

        $model->email = 'fakeemail';
        verify($model->validate($attributeName))->false();

        $model->email = 'fakeemail@';
        verify($model->validate($attributeName))->false();

        $model->email = 'fakeemail@gmail';
        verify($model->validate($attributeName))->false();

        $model->email = 'fakeemail@gmail.com';
        verify($model->validate($attributeName))->true();
    }

}
