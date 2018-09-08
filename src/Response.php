<?php

/*
 * An object to represent a very simple response.
 * If you need to do anything complicated, you can get the guzzleResponse object itself and work
 * with that.
 */

declare(strict_types = 1);
namespace Programster\GuzzleWrapper;


final class Response
{
    private $headers;
    private $body;
    private $guzzleResponse;
    
    
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->body = $response->getBody()->getContents();
        $this->guzzleResponse = $response;
        
        // unfortunately guzzle does some funky stuff with headers, that we simplify to name/value
        // pairs
        $this->headers = array();
        $this->headers = $response->getHeaders();
        
        if (false) {
            $headersArray = $response->getHeaders();

            foreach ($headersArray as $name => $subArray)
            {
                if (is_array($subArray) && count($subArray) == 1) {
                    $this->headers[$name] = array_pop($subArray);
                }
                else
                {
                    $this->headers[$name] = $subArray;
                }
            }
        }
    }
    
    
    /**
     * Get the headers of the response.
     *
     * @return array - array of name/value pairs.
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }
    
    
    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }
    
    
    /**
     * Get the raw Guzzle response object that this object simplified.
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function getGuzzleResponseObject() : \Guzzle\Http\Message\Response
    {
        return $this->guzzleResponse;
    }
}
