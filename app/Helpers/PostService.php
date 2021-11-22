<?php


namespace App\Helpers;


use App\Payloads\ApiConnection;
use App\Payloads\GetInterface;
use App\Payloads\PostInterface;
use Illuminate\Support\Facades\Http;

class PostService implements PostInterface, ApiConnection
{
    public $url;
    public $dataArr = [];

    public function __construct(array $dataArr, $url)
    {
        $this->dataArr = $dataArr;
        $this->url = $url;

    }

    public function postData()
    {
        $response = Http::post($this->url, $this->dataArr);
        return $response;
    }

    public function body()
    {
        return $this->postData()->body();
    }

    public function json()
    {
        return $this->postData()->json();
    }

    public function getResult()
    {
        return $this->postData();
    }
}
