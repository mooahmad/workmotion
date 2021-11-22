<?php


namespace App\Payloads;


interface ApiConnection
{
    public function body();

    public function json();

    public function getResult();
}
