<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\GetEmails;
use App\Http\Requests\ListIdSubscribe;

class ApiController extends Controller
{
    private $userRepo;

    /**
     * ApiController constructor.
     * @param UserRepository $UserRepo
     */
    public function __construct(UserRepository $UserRepo)
    {
        $this->userRepo = $UserRepo;
    }


    /**
     * @param GetEmails $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmails(GetEmails $request)
    {
        $this->userRepo->setApiKey($request['apikey']);
        if ($this->userRepo->apiKeyExists()){

            $this->userRepo->setListId($request['listId']);
            if ($this->userRepo->listOwnsKey()){

                $emails = $this->userRepo->getEmails();
                return response()->json($emails, 200);
            }
            return response()->json('List does not own the key', 400);
        };
        return response()->json('Api key does not exist', 400);
    }


    /**
     * @param ListIdSubscribe $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribeUser(ListIdSubscribe $request)
    {
        $data = $request;
        $this->userRepo->setApiKey($data['apikey']);
        if ($this->userRepo->apiKeyExists()){

            $this->userRepo->setListId($data['listId']);

            if ($this->userRepo->listOwnsKey()) {

                if (!$this->userRepo->emailExists($data['email'])) {

                    $this->userRepo->saveSubscription($data->all());
                    return response()->json('User subscribed', 200);
                };
                return response()->json('Email already exists!', 400);

            }
            return response()->json('This apikey does not match this list ID!', 400);

        };
        return response()->json('Api key does not exist', 400);

    }
}
