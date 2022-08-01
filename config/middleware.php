<?php



return function ($app)
{



    $app->add(Function ($req,$res,$next){
        $response = $next($req,$res);
        return $response->withHeader("Access-Control-Allow-Origin","*")
            ->withHeader("Access-Control-Allow-Headers","X-Requested-With,Content-Type,Accept,Origin,Authorization")
            ->withHeader("Access-Control-Allow-Methods","GET,POST,PUT,PATCH,OPTIONS,DELETE")
            ->withHeader("Access-Control-Allow-Credentials","true");
    });
};