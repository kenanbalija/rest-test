<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    private $model;
    private $apiKey;
    private $listId;
    private $list = [];

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param mixed $key
     */
    public function setApiKey($key)
    {
       $this->apiKey = $key;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return bool
     */
    public function apiKeyExists()
    {
        return $this->model->where('apiKey', '=', $this->apiKey)->exists();
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @param mixed $listId
     */
    public function setListId($listId)
    {
        $this->listId = $listId;
    }

    /**
     * @return bool
     */
    public function listOwnsKey()
    {
        return $this->list = $this->model->select('apiKey')->where('listId', '=', $this->listId)->exists();
    }

    /**
     * @return array
     */
    public function getEmails()
    {
        return $this->model->select('email')->where('listId', '=', $this->listId)->get();
    }

    /**
     * @param $email
     * @return bool
     */
    public function emailExists($email)
    {
        $emails = $this->getEmails();

        if (in_array($email, $emails)) {
            return true;
        }
        return false;
    }


    /**
     * @param $data
     * @return bool
     */
    public function saveSubscription($data)
    {
        $user = $this->model;
        $user['listId'] = $data['listId'];
        $user['apiKey'] = $data['apiKey'];
        $user['email'] = $data['email'];
        $user['name'] = $data['name'];
        $user['surname'] = $data['surname'];
        $user->save();
    }
}