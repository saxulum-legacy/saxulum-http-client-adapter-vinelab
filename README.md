# saxulum-http-client-adapter-vinelab

[![Build Status](https://api.travis-ci.org/saxulum/saxulum-http-client-adapter-vinelab.png?branch=master)](https://travis-ci.org/saxulum/saxulum-http-client-adapter-vinelab)
[![Total Downloads](https://poser.pugx.org/saxulum/saxulum-http-client-adapter-vinelab/downloads.png)](https://packagist.org/packages/saxulum/saxulum-http-client-adapter-vinelab)
[![Latest Stable Version](https://poser.pugx.org/saxulum/saxulum-http-client-adapter-vinelab/v/stable.png)](https://packagist.org/packages/saxulum/saxulum-http-client-adapter-vinelab)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/saxulum/saxulum-http-client-adapter-vinelab/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/saxulum/saxulum-http-client-adapter-vinelab/?branch=master)

## Features

 * Provides a http client interface adapter for [vinelab][1]

## Requirements

 * PHP 5.3+
 * Vinelab ~1.1

## Installation

Through [Composer](http://getcomposer.org) as [saxulum/saxulum-http-client-adapter-vinelab][2].

## Usage

``` {.php}
use Saxulum\HttpClient\Vinelab\HttpClient;
use Saxulum\HttpClient\Request;

$httpClient = new HttpClient();
$response = $httpClient->request(new Request(
    '1.1',
    Request::METHOD_GET,
    'http://en.wikipedia.org',
    array(
        'Connection' => 'close',
    )
));
```

You can inject your own vinelab client instance while creating the http client instance.

``` {.php}
use Vinelab\Http\Client;
use Saxulum\HttpClient\Vinelab\HttpClient;

$client = new Client;
$httpClient = new HttpClient($client);
```

[1]: https://packagist.org/packages/vinelab/http
[2]: https://packagist.org/packages/saxulum/saxulum-http-client-adapter-vinelab