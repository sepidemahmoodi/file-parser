<?php
namespace App\Classes\Parsers;

interface ParserInterface 
{
	public function parse(string $logFilePath);
}