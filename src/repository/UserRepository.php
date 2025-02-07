<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\User;
use App\Exceptions\LoginExceptions;

/**
 * Class representing a repository of users 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class UserRepository extends Repository {
    // * GET * //
    

    // * INSERT * //


    // * UPDATE * //


    // * OTHER * // 
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

        $users = array_map(function($user_data) {
            return User::fromArray($user_data);
        }, $users);
        
        $i = 0;
        $find = false;
        $size = $users != null ? count($users) : 0;    

        while($i < $size && !$find) {
            if($users[$i]->getIdentifier() == $identifier && password_verify($password, $users[$i]->getPassword())) {
                $find = true;

                $_SESSION['user'] = $users[$i];

                break;
            } 
            
            $i++;
        }

        if($i == $size) {
            throw new LoginExceptions("Identifiant ou mot de passe incorrect !");
        }
    }
}