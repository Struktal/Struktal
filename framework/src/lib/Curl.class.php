<?php

class Curl {
    public static string $METHOD_POST = "POST";
    public static string $METHOD_GET = "GET";

    private CurlHandle $curl;
    private string $url;
    private string $method;
    private array $headers;
    private string $postFields;
    private bool $executed = false;

    public function __construct() {
        $this->curl = curl_init();
        $this->headers = array();
        $this->postFields = "";
    }

    public function __destruct() {
        curl_close($this->curl);
    }

    /**
     * Set the URL for the Curl Request
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): Curl {
        $this->url = $url;
        return $this;
    }

    /**
     * Set the HTTP Method for the Curl Request
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method): Curl {
        $this->method = $method;
        return $this;
    }

    /**
     * Set the Headers for the Curl Request
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): Curl {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Add a Header to the Curl Request
     * @param string $header
     * @return $this
     */
    public function addHeader(string $header): Curl {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * Set the Post Fields for the Curl Request
     * @param array $postFields
     * @return $this
     */
    public function setPostFields(array $postFields): Curl {
        $this->postFields = http_build_query($postFields);
        return $this;
    }

    /**
     * Execute the Curl Request
     * @return string Response
     */
    public function execute(): string {
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);

        if($this->method == self::$METHOD_POST) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->postFields);
        }

        $response = curl_exec($this->curl);
        $this->executed = true;
        return $response;
    }

    /**
     * Get the HTTP Code of the Curl Request
     * @return int HTTP Code or -1 if the Request was not executed
     */
    public function getHttpCode(): int {
        if($this->executed) {
            return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        } else {
            return -1;
        }
    }

    /**
     * Close the Curl Request
     * @return void
     */
    public function close(): void {
        curl_close($this->curl);
    }
}