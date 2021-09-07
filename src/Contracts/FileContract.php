<?php
namespace Henrotaym\LaravelApiClient\Contracts;

interface FileContract
{
    public function path(): string;
    
    public function stream();
    
    public function streamName();
}