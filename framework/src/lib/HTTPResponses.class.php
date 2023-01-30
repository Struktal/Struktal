<?php

class HTTPResponses {
    public static array $RESPONSE_OK = array(
        "code" => 200,
        "message" => "OK"
    );

    public static array $RESPONSE_CREATED = array(
        "code" => 201,
        "message" => "Created"
    );

    public static array $RESPONSE_NO_CONTENT = array(
        "code" => 204,
        "message" => "No Content"
    );

    public static array $RESPONSE_BAD_REQUEST = array(
        "code" => 400,
        "message" => "Bad Request"
    );

    public static array $RESPONSE_UNAUTHORIZED = array(
        "code" => 401,
        "message" => "Unauthorized"
    );

    public static array $RESPONSE_FORBIDDEN = array(
        "code" => 403,
        "message" => "Forbidden"
    );

    public static array $RESPONSE_NOT_FOUND = array(
        "code" => 404,
        "message" => "Not Found"
    );

    public static array $RESPONSE_METHOD_NOT_ALLOWED = array(
        "code" => 405,
        "message" => "Method Not Allowed"
    );

    public static array $RESPONSE_INTERNAL_SERVER_ERROR = array(
        "code" => 500,
        "message" => "Internal Server Error"
    );

    public static array $RESPONSE_NOT_IMPLEMENTED = array(
        "code" => 501,
        "message" => "Not Implemented"
    );

    public static array $RESPONSE_SERVICE_UNAVAILABLE = array(
        "code" => 503,
        "message" => "Service Unavailable"
    );

    private function __construct() {}
}
