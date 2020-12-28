<?php

/*
 * A very simple request object, allowing you to send HTTP requests with ease.
 */

declare(strict_types = 1);
namespace Programster\GuzzleWrapper;


final class Request
{
    private $m_headers;
    private $m_data;
    private $m_method;
    private $m_url;
    private $m_useFormParams;
    private $m_clientConfigArray;


    /**
     *Create a HTTP request.
     * @param  \Programster\GuzzleWrapper\Method $method - the HTTP method to send request.
     * @param  string $url     - the url that you wish to send to. E.g. http://www.google.com?foo=bar
     * @param  array  $data    - the data that you wish to send. If the request is of type GET, then this
     *                           data will automatically get put into the url when we send the request.
     * @param  array  $headers - an associative array of headers that should be sent with the requst. Useful for auth etc.
                                 This should be in name/value pair format, rather than a list of header strings.
     * @param bool $useFormParams - set to false to send the body as JSON, instead of the default of multipart form.
     *                              This has no effect on GET queries.
     * @param bool $verifySsl - manually set to false if you wish to ignore invalid SSL certificate.
     * @param array $options - any possible configuration option overrides you wish to pass through to guzzle client
     * @throws Exception
     */
    public function __construct(
        Method $method,
        string $url,
        array $data = array(),
        array $headers = array(),
        bool $useFormParams = true,
        bool $verifySsl = true,
        array $options = array()
    ) {
        if (filter_var($url, FILTER_VALIDATE_URL) === false)
        {
            throw new ExceptionInvalidUrl("Invalid URL provided");
        }

        $this->m_headers = $headers;
        $this->m_method = $method;
        $this->m_url = $url;
        $this->m_data = $data;
        $this->m_useFormParams = $useFormParams;

        if ($verifySsl === false)
        {
            $options['verify'] = false;
        }

        if (count($this->m_headers) > 0)
        {
            $options['headers'] = $this->m_headers;
        }

        $this->m_clientConfigArray = $options;
    }


    /**
     * Send the request. You could run call the send() method multiple times in order to
     * make the same request multiple times. Just be sure to store the returned responses.
     *
     * @return \Programster\GuzzleWrapper\Response
     */
    public function send() : Response
    {
        $client = new \GuzzleHttp\Client($this->m_clientConfigArray);
        $bodyFormat = $this->m_useFormParams ? "form_params" : \GuzzleHttp\RequestOptions::JSON;

        switch ((string) $this->m_method)
        {
            case 'GET':
            {
                $options = array('query' => $this->m_data);
                $guzzleResponse = $client->get($this->m_url, $options);
            }
            break;

            case 'POST':
            {
                $options = array($bodyFormat => $this->m_data);
                $guzzleResponse = $client->post($this->m_url, $options);
            }
            break;

            case 'PUT':
            {
                $options = array($bodyFormat => $this->m_data);
                $guzzleResponse = $client->put($this->m_url, $options);
            }
            break;

            case 'DELETE':
            {
                $options = array($bodyFormat => $this->m_data);
                $guzzleResponse = $client->delete($this->m_url, $options);
            }
            break;

            default:
            {
                throw new ExceptionInvalidRequestType("Unrecognized request type");
            }
        }

        return new Response($guzzleResponse);
    }
}
