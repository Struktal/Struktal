<?php

class Curl {
    public static string $METHOD_POST = "POST";
    public static string $METHOD_GET = "GET";

    private CurlHandle $curl;
    private string $url;
    private string $method;
    private array $headers;
    private string $postFields;

    public function __construct() {
        $this->curl = curl_init();
        $this->headers = array();
        $this->postFields = "";
    }

    public function setUrl(string $url): Curl {
        $this->url = $url;
        return $this;
    }

    public function setMethod(string $method): Curl {
        $this->method = $method;
        return $this;
    }

    public function setHeaders(array $headers): Curl {
        $this->headers = $headers;
        return $this;
    }

    public function addHeader(string $header): Curl {
        $this->headers[] = $header;
        return $this;
    }

    public function setPostFields(array $postFields): Curl {
        $this->postFields = http_build_query($postFields);
        return $this;
    }

    public function execute(): string {
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);

        if($this->method == self::$METHOD_POST) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->postFields);
        }
        
        return curl_exec($this->curl);
    }
}