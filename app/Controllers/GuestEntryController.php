<?php

namespace App\Controllers;

use App\Models\GuestEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Respect\Validation\Validator as v;
use App\Validation\Validator;
class GuestEntryController
{
    protected $customResponse;
    protected $guestEntry;
    protected $validator;
    public  function  __construct()
    {
        $this->customResponse=new CustomResponse();
        $this->guestEntry=new GuestEntry();
        $this->validator=new Validator();
    }

    public function createGuest(Request $request,Response $response){

        $this->validator->validate($request,[
            "name"=>v::notEmpty(),
            "email"=>v::notEmpty()->email(),
            "password"=>v::notEmpty()
        ]);
        if($this->validator->failed()){
            $responseMessage=$this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        $this->guestEntry->insert([
            "name"=>CustomRequestHandler::getParam($request,"name"),
            "email"=>CustomRequestHandler::getParam($request,"email"),
            "password"=>CustomRequestHandler::getParam($request,"password")
        ]);
        $responseMessage="New user succesfully";
        $this->customResponse->is200Response($response,$responseMessage);
    }

    public function viewGuests(Request $request,Response $response){

        $responseMessage= $this->guestEntry->get();
        $this->customResponse->is200Response($response,$responseMessage);
    }
    public function getSingleGuest(Request $request,Response $response,$id){
        $singleGuest=$this->guestEntry->select("name","password")->where(["id"=>$id])->get();

        $this->customResponse->is200Response($response,$singleGuest);
    }
    public function editGuest(Request $request,Response $response,$id){
        $this->validator->validate($request,[
            "name"=>v::notEmpty(),
            "email"=>v::notEmpty(),
            "password"=>v::notEmpty()
        ]);
        if($this->validator->failed()){
            $responseMessage=$this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }


        $this->guestEntry->where(['id'=>$id])->update([
            "name"=>CustomRequestHandler::getParam($request,"name"),
            "email"=>CustomRequestHandler::getParam($request,"email"),
            "password"=>CustomRequestHandler::getParam($request,"password")
        ]);

        $responseMessage="Updated User";
        $this->customResponse->is200Response($response,$responseMessage);
    }
    public function deleteGuest(Request $request,Response $response,$id){
        $this->guestEntry->where(["id"=>$id])->delete();
        $responseMessage="Deleted User";
        $this->customResponse->is200Response($response,$responseMessage);
    }
    public function countGuests(Request $request,Response $response){
        $responseMessage="countGuests work";
        $this->customResponse->is200Response($response,$responseMessage);
    }
}