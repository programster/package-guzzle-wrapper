<?php

/*
 * An object to represent a very simple response.
 * If you need to do anything complicated, you can get the guzzleResponse object itself and work
 * with that.
 */


namespace Programster\GuzzleWrapper;


final class Response
{
    private $headers;
    private $body;
    private $guzzleResponse;
    
    
    public function __construct(\Guzzle\Http\Message\Response $response)
    {
        $this->headers = $response->getHeaders();
        $this->body = $response->getBody(true);
        $this->guzzleResponse = $response;
    }
    
    
    public function getHeaders() : array
    {
        return $this->headers;
    }
    
    
    public function getBody() : string
    {
        return $this->body;
    }
    
    
    public function getGuzzleResponseObject() : \Guzzle\Http\Message\Response
    {
        return $this->guzzleResponse;
    }
}
