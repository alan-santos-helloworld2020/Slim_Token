<?php

use Slim\App;

return function (App $app) {


    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "path" => "/users", /* or ["/api", "/admin"] */
        "secure" => false,
        "attribute" => "jwt",
        "secret" => "CHAVE_SECRETA",
        "algorithm" => ["HS256"],
        "error" => function ($req, $res, $args) {
        $data["status"] = "error";
        $data["message"] = $args["message"];
        return $res
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
        ]));
};