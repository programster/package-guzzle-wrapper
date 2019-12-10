<?php

/*
 * A very simple request object, allowing you to send HTTP requests with ease.
 */

declare(strict_types = 1);
namespace Programster\GuzzleWrapper;


final class Request
{
    private $headers;
    private $data;
    private $method;
    private $url;
    private $useFormParams;


    /**
     * Create a HTTP request.
     *
     * @param  \Programster\GuzzleWrapper\Method $method - the HTTP method to send request.
     * @param  string $url     - the url that you wish to send to. E.g. http://www.google.com?foo=bar
     * @param  array  $data    - the data that you wish to send. If the request is of type GET, then this
     *                           data will automatically get put into the url when we send the request.
     * @param  array  $headers - an associative array of headers that should be sent with the requst. Useful for auth etc.
                                 This should be in name/value pair format, rather than a list of header strings.
     * @param bool $useFormParams - set to false to send the body as JSON, instead of the default of multipart form.
     *                              This has no effect on GET queries.
     * @throws Exception
     */
    public function __construct(
        Method $method,
        string $url,
        array $data = array(),
        array $headers = array(),
        bool $useFormParams = true
    ) {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new Exception("Invalid URL provided");
        }

        $this->headers = $headers;
        $this->method = $method;
        $this->url = $url;
        $this->data = $data;
        $this->useFormParams = $useFormParams;
    }


    /**
     * Send the request. You could run call the send() method multiple times in order to
     * make the same request multiple times. Just be sure to store the returned responses.
     *
     * @return \Programster\GuzzleWrapper\Response
     */
    public function send() : Response
    {
        if (count($this->headers) > 0)
        {
            $client = new \GuzzleHttp\Client(['headers' => $this->headers]);
        }
        else
        {
            $client = new \GuzzleHttp\Client();
        }

        $bodyFormat = $this->useFormParams ? "form_params" : \GuzzleHttp\RequestOptions::JSON;

        switch ((string) $this->method)
        {
            case 'GET':
            {
                $options = array('query' => $this->data);
                $guzzleResponse = $client->get($this->url, $options);
            }
            break;

            case 'POST':
            {
                $options = array($bodyFormat => $this->data);
                $guzzleResponse = $client->post($this->url, $options);
            }
            break;

            case 'PUT':
            {
                $options = array($bodyFormat => $this->data);
                $guzzleResponse = $client->put($this->url, $options);
            }
            break;

            case 'DELETE':
            {
                $options = array($bodyFormat => $this->data);
                $guzzleResponse = $client->delete($this->url, $options);
            }
            break;

            default:
            {
                throw new \Exception("Unrecognized request type");
            }
        }

        return new Response($guzzleResponse);
    }
}
