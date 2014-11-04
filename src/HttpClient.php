<?php

namespace Saxulum\HttpClient\Vinelab;

use Vinelab\Http\Client;
use Vinelab\Http\Response as VinelabResponse;
use Saxulum\HttpClient\HeaderConverter;
use Saxulum\HttpClient\HttpClientInterface;
use Saxulum\HttpClient\Request;
use Saxulum\HttpClient\Response;

class HttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = null !== $client ? $client : new Client();
    }

    /**
     * @param  Request  $request
     * @return Response
     */
    public function request(Request $request)
    {
        $method = strtolower($request->getMethod());
        $headers = HeaderConverter::convertAssociativeToRaw(
            $this->prepareHeaders($request)
        );

        /** @var VinelabResponse $vinelabResponse */
        $vinelabResponse = $this->client->$method(array(
            'version' => $request->getProtocolVersion(),
            'url' => (string) $request->getUrl(),
            'headers' => $headers,
            'content' => $request->getContent()
        ));

        return new Response(
            $request->getProtocolVersion(),
            $vinelabResponse->statusCode(),
            $this->getStatusMessage($vinelabResponse->statusCode()),
            $vinelabResponse->headers(),
            $vinelabResponse->content()
        );
    }

    /**
     * @param  Request $request
     * @return array
     */
    protected function prepareHeaders(Request $request)
    {
        $headers = $request->getHeaders();
        if (null !== $request->getContent() && !isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        return $headers;
    }

    /**
     * @param  int        $statusCode
     * @return string
     * @throws \Exception
     */
    protected static function getStatusMessage($statusCode)
    {
        static $reflectionResponse;

        if (null === $reflectionResponse) {
            $responseClass = 'Saxulum\HttpClient\Response';
            $reflectionResponse = new \ReflectionClass($responseClass);
        }

        $constantName = self::getCodeConstantName($statusCode);

        if (!$reflectionResponse->hasConstant($constantName)) {
            throw new \Exception("Unknown status code {$statusCode}!");
        }

        return $reflectionResponse->getConstant($constantName);
    }

    /**
     * @param  int    $statusCode
     * @return string
     */
    protected static function getCodeConstantName($statusCode)
    {
        return 'STATUS_MESSAGE_' . $statusCode;
    }
}
