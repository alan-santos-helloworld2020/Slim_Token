<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;


final class UserController{
 

     private $key = "CHAVE_SECRETA";
     public function gerarToken(Request $request,Response $response,array $args): Response
     {
        $username = $request->getParsedBody()["username"];
        $email = $request->getParsedBody()["email"];
        $payload = array(
            "int" => time(),  
            "exp" => time() + (60 * 60),
            "username" => $username
        );
        
        $jwt = JWT::encode($payload, $this->key);
        $token = ["token" => $jwt];
        $response->getBody()->write(json_encode($token,JSON_UNESCAPED_UNICODE));
        return $response;

       

     }

     public function decoderToken(Request $request,Response $response,array $args): Response
     {
      
        $jwt = $request->getHeader("Authorization")[0];
        $str_jwt = explode(' ',$jwt)[1];
        $decoded = JWT::decode($str_jwt,$this->key, array('HS256'));
        $response->getBody()->write(json_encode($decoded,JSON_UNESCAPED_UNICODE));
        return $response;

 
    }






}


/*@return object — The JWT's payload as a PHP object

@throws InvalidArgumentException — Provided JWT was empty

@throws UnexpectedValueException — Provided JWT was invalid

@throws SignatureInvalidException
Provided JWT was invalid because the signature verification failed

@throws BeforeValidException
Provided JWT is trying to be used before it's eligible as defined by 'nbf'

@throws BeforeValidException*/