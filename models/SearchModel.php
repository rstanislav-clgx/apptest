<?php

namespace app\models;

use app\interfaces\ICompanyService;
use Yii;
use yii\base\Model;


class SearchModel extends Model
{
    public $companySymbol;
    public $startDate;
    public $endDate;
    public $email;
    public $region;


    public function __construct(private ICompanyService $companyService, $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function getAvailableSymbols(){
        return $this->companyService->getAllSymbols();
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        //todo: validate dates for now
        return [
            [['companySymbol', 'startDate', 'endDate', 'email'],  'required' ],
            ['companySymbol',  'in', 'range'=>$this->getAvailableSymbols()],

            [['startDate', "endDate"] , 'date',  "format"=>"yyyy-mm-dd",  'enableClientValidation' =>true],
            [['startDate', "endDate"] , 'string',  "length"=> 10,  'enableClientValidation' =>true],

            ['startDate', 'compare', 'compareAttribute'=> 'endDate', 'operator' => '<=',
                'enableClientValidation' =>true
            ],

            ['endDate', 'compare', 'compareAttribute'=> 'startDate', 'operator' => '>=',
                'enableClientValidation' =>true
            ],
            ['email', 'email'],
        ];
    }

}
