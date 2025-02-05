<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\User;
use App\Exceptions\LoginExceptions;

class UserRepository extends Repository {
    /**
     * Public method connecting the user to the application 
     * 
     * @param string $identifier The user's id (ex: name.f)
     * @param string $password The user's password
     * @return void
     */
    public function connectUser(string $identifier, string $password) {
        $request = "SELECT * FROM Users WHERE Identifier = :identifier";
        $params = [ ":identifier" => $identifier ];
        $users = $this->get_request($request, $params, false, true);

        var_dump($users);

        $i = 0;
        $find = false;
        $size = $users != null ? count($users) : 0;    

        while($i < $size && !$find) {
            if($users[$i]["Identifier"] == $identifier && password_verify($password, $users[$i]["Password"])) {
                $find = true;

                $_SESSION['user'] = new User(
                    $users[$i]['Id'],
                    $users[$i]['Identifier'], 
                    $users[$i]['Name'],
                    $users[$i]['Firstname'],
                    $users[$i]['Email'], 
                    $password, 
                    $users[$i]['PasswordTemp'],
                    $users[$i]['Key_Roles'],
                    $users[$i]['Key_Establishments']
                );

                break;
            } 
            
            $i++;
        }

        if($i == $size) {
            throw new LoginExceptions("Identifiant ou mot de passe incorrect !");
        }
    }
}