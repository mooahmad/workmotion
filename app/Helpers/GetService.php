<?php


namespace App\Helpers;


use App\Payloads\ApiConnection;
use App\Payloads\GetInterface;
use App\Payloads\PostInterface;
use Illuminate\Support\Facades\Http;

class GetService implements GetInterface, ApiConnection
{
    public $url;
    public $dataArr =[];
    public $headers = [];

    public function __construct(array $headers, $url,$dataArr=[])
    {
        $this->dataArr = $dataArr;
        $this->url = $url;
        $this->headers = $headers;
    }

    public function getData()
    {
        $response = Http::withHeaders($this->headers)->get($this->url,$this->dataArr);
        return $response;
    }

    public function getResult()
    {
        return $this->getData();
    }

    public function body()
    {
      return $this->getData()->body();
    }

    public function json()
    {
       return $this->getData()->json();
    }

    public function status()
    {
       return $this->getData()->status();
    }
}
