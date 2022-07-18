<?php

namespace app\services;

use app\interfaces\ICompanyService;
use app\models\Company;
use yii\base\BaseObject;

class CompanyService extends BaseObject implements ICompanyService
{
    private array $companies = [];

    public function __construct(private $jsonFilePath, $config=[])
    {
        if(!file_exists($this->jsonFilePath)){
            throw new \Exception(__CLASS__.":: $jsonFilePath is not exists!");
        }

        if(!$this->getAll()){
            throw new \Exception(__CLASS__.":: $jsonFilePath is empty or has wrong format");
        }

        parent::__construct($config);
    }

    /**
     * @return mixed
     */
    public function getAll(){
        if(empty($this->companies)){
            $rows = json_decode(file_get_contents($this->jsonFilePath), 1);
            foreach ($rows as $row){
                $this->companies[] = new Company(
                    $row['Company Name'],
                    $row['Financial Status'],
                    $row['Market Category'],
                    $row['Round Lot Size'],
                    $row['Security Name'],
                    $row['Symbol'],
                    $row['Test Issue'],
                );
            }
        }

        return  $this->companies;
    }

    public function getAllSymbols(): array
    {
      return array_column($this->getAll(), 'symbol');
    }

    public function getCompanyBySymbol(string $symbol) : Company
    {
      $companies = array_filter($this->getAll(), function (Company $company) use ($symbol){
         return $company->symbol == $symbol;
      });

      return current($companies);
    }

    public function getCompanyNameBySymbol(string $symbol)
    {
        return $this->getCompanyBySymbol($symbol)->companyName;
    }
}