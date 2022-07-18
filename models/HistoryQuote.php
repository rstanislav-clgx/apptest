<?php

namespace app\models;

class HistoryQuote extends Model
{
    public float $date;
    public float $open;
    public float $high;
    public float $low;
    public float $close;
    public float $volume;
    public float $adjclose;
}