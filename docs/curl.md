# Documentation
## Curl
You can use the ``Curl`` class to send HTTP GET or POST requests to other servers. To do that, use
```php
// GET request to a HTML page
$curl = new Curl();
$curl->setUrl("URL");
$curl->setMethod(Curl::$METHOD_GET);
$curl->addHeader(array(
    "accept" => "text/html, application/xhtml+xml"
));
$response = $curl->execute();
$responseCode = $curl->getHttpCode();
$curl->close();

// POST request to a JSON API 
$curl = new Curl();
$curl->setUrl("URL");
$curl->setMethod(Curl::$METHOD_POST);
$curl->addHeader(array(
    "accept" => "application/json"
));
$curl->addPostData(array(
    "key" => "value"
));
$response = $curl->execute();
$responseCode = $curl->getHttpCode();
$curl->close();
```
with ``URL`` being the URL of the server that you want to send the request to.