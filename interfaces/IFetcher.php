<?php
namespace app\interfaces;

interface IFetcher{
    /**
     * @param string $url
     * @param array $headers
     * @param array $params
     * @param array $headers
     * @return array
     */
    public function get(   string $url,  array $params = [], array $headers = [], string $method = "GET");
}