<?php

class Comm {
    /**
     * Redirects the User to the given Path
     * @param string $redirectPath
     * @return void
     */
    public static function redirect(string $redirectPath): void {
        header("Location: " . $redirectPath);
        exit;
    }

    /**
     * Sends a JSON Response and exits
     * @param array $data
     * @return void
     */
    public static function sendJson(array $data): void {
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }

    /**
     * Sends a JSON Response together with a Response Code and Message and exits
     * @param array $response
     * @param array $data
     * @return void
     */
    public static function apiSendJson(array $response, array $data): void {
        header("Content-Type: application/json");
        echo json_encode([
            "code" => $response["code"],
            "message" => $response["message"],
            "data" => $data
        ]);
        exit;
    }

    private function __construct() {}
}
