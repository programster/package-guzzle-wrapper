<?php

/*
 * An object to represent an HTTP request type. E.g. GET, PUT, POST, DELETE.
 * This just helps prevent mistakes/typos. I don't have to worry about case sensitivity either.
 */

declare(strict_types = 1);
namespace Programster\GuzzleWrapper;


final class Method
{
    private $type;
    
    
    /**
     * Private constructor, use one of the static create methods to create one of these objects.
     *
     * @param string $type
     */
    private function __construct(string $type)
    {
        $this->type = $type;
    }
    
    
    public static function createGet()
    {
        return new Method('GET');
    }
    
    
    public static function createPost()
    {
        return new Method('POST');
    }
    
    
    public static function createPut()
    {
        return new Method('PUT');
    }
    
    
    public static function createDelete()
    {
        return new Method('DELETE');
    }
    
    
    public function __toString() 
    {
        return $this->type;
    }
}
