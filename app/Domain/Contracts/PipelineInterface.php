<?php


namespace App\Domain\Contracts;


interface PipelineInterface
{
    public function handle($data, \Closure $next);
}
