<?php

namespace alexshent\webapp\application\controllers;

use alexshent\webapp\application\models\User;
use alexshent\webapp\application\models\UserBuilder;

class ApiController extends \alexshent\webapp\core\Controller {

    public function getAllUsersAction(): void {
        $users = User::findAll();
        $result = new \stdClass();
        $result->status = "ok";
        $result->users = $users;
        $this->sendReply($result);
    }
    
    public function saveUserAction(): void {
        $this->checkContentType();
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, false);
        if (empty($decoded)) {
            throw new \InvalidArgumentException("empty user");
        }
        $userBuilder = new UserBuilder();
        $user = $userBuilder
        ->withId($decoded->id)
        ->withFirstName($decoded->firstName)
        ->withSecondName($decoded->secondName)
        ->withPosition($decoded->position)
        ->build();
        $user->save();
        $result = new \stdClass();
        $result->status = "ok";
        $this->sendReply($result);
    }
    
    public function deleteUserAction(): void {
        $this->checkContentType();
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, false);
        if (empty($decoded)) {
            throw new \InvalidArgumentException("empty user");
        }
        $userBuilder = new UserBuilder();
        $user = $userBuilder
        ->withId($decoded->id)
        ->withFirstName($decoded->firstName)
        ->withSecondName($decoded->secondName)
        ->withPosition($decoded->position)
        ->build();
        $user->delete();
        $result = new \stdClass();
        $result->status = "ok";
        $this->sendReply($result);
    }
    
    private function checkContentType(): void {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType !== "application/json") {
            throw new \InvalidArgumentException("invalid content type");
        }
    }
    
    private function sendReply(\stdClass $reply): void {
        $jsonHeader = "Content-Type: application/json; charset=UTF-8";
        $json = json_encode($reply);
        header($jsonHeader);
        echo $json;
    }
}
