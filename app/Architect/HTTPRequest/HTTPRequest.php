<?php

namespace App\Architect\HTTPRequest;

use GuzzleHttp;

class HTTPRequest
{
	public static function get(string $url): object
	{
		$client = new GuzzleHttp\Client();
		$res = $client->request('GET', $url);
		$rawContent = $res->getBody();
		return json_decode($rawContent);
	}
}
