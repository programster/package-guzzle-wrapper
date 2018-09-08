<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

declare(strict_types = 1);

class TestGetRequestWithDataNotInUrl implements TestInterface
{
    private $passed;
    
    
    public function __construct()
    {
        $this->passed = false;
    }
    
    
    public function run()
    {
        $request = new Programster\GuzzleWrapper\Request(
            Programster\GuzzleWrapper\Method::createGet(), 
            'http://localhost', 
            ['hello' => 'world']
        );

        $response = $request->send();
        $bodyObject = json_decode($response->getBody(), true);
        
        if (isset($bodyObject['get_params']))
        {
            $getParams = $bodyObject['get_params'];
            
            if ( 
                isset($getParams['hello'])
                && $getParams['hello'] === "world"
            ) {
                $this->passed = true;
            }
        }
    }

    
    public function getPassed(): bool 
    {
        return $this->passed;
    }
}
