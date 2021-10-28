<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;


require_once './Controller/UserController.php';
require_once './Midleware/Auth.php';

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);



$app->add((new Tuupola\Middleware\JwtAuthentication([
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
])));



$app->post('/',UserController::class . ":gerarToken");

$app->get('/decoder',UserController::class . ":decoderToken");

$app->post('/users',function(Request $request,Response $response,$args){
    $dados = array(
        ["nome"=>"alan"],
        ["nome"=>"jose"],
        ["nome"=>"mario"],
        ["nome"=>"paulo"],
        ["nome"=>"arthur"]
    );
    $response->getBody()->write(json_encode($dados,JSON_UNESCAPED_SLASHES),200);
    return $response;
});

$app->run();


