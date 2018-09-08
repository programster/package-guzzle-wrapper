<?php

/*
 * A very simple request object, allowing you to send HTTP requests with ease.
 */


namespace Programster\GuzzleWrapper;


final class Request
{
    private $method;
    private $url;
    
    
    public function __construct(
        Method $method, 
        string $url, 
        array $bodyData = array(), 
        array $headers = array()
    ) { 
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new Exception("Invalid URL provided");
        }
        
        $this->method = $method;
        $this->url;
    }
    
    
    /**
     * Send the request. You could run call the send() method multiple times in order to
     * make the same request multiple times. Just be sure to store the returned responses.
     *
     * @return \Programster\GuzzleWrapper\Response
     */
    public function send() : Response
    {
        $client = new \Guzzle\Http\Client();
        
        $request = $client->createRequest(
            (string) $this->method, 
            $this->url, 
            $this->headers, 
            $this->body, 
            $options
        );
        
        $guzzleResponse = $request->send();
        return new Response($guzzleResponse);
    }
}
