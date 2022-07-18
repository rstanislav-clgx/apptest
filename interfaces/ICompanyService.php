<?php
namespace app\interfaces;

interface ICompanyService{
   public function getAll();
   public function getAllSymbols();
   public function getCompanyNameBySymbol(string $symbol);
}