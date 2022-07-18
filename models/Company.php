<?php

namespace app\models;

class Company
{
    public function __construct(
        public string $companyName     = '',
        public string $FinancialStatus = '',
        public string $marketCategory  = '',
        public string $roundLotSize    = '',
        public string $securityName    = '',
        public string $symbol          = '',
        public string $testIssue       = '',
    )
    {}
}