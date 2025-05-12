<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\User;
use App\Exceptions\LoginExceptions;

/**
 * Class representing a repository of Users 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class UserRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one user by his primary key
     * 
     * @param int $key_user The user's primary key
     * @return User The user
     */
    public function get(int $key_user): User {
        $request = "SELECT * FROM Users WHERE Id = :id";

        $params = ["id" => $key_user];

        $fetch = $this->get_request($request, $params, true, true);

        return User::fromArray($fetch);
    }

    /**
     * Public method returning the list of users 
     * 
     * @return array
     */
    public function getList(): array {
        $request = "SELECT * FROM Users";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return User::fromArray($c);
        }, $fetch);

        return $response;
    }

    /**
     * Public method returning the list of users for AutoComplet items
     * 
     * @return array The list of users
     */
    public function getAutoCompletion(): array {
        $fetch = $this->getList();

        $response = array_map(function($c) {
            return array(
                "id" => $c->getId(), 
                "text" => $c->getName() . " " . $c->getFirstname()
            );
        }, $fetch);

        return $response;
    }

    // * INSERT * //


    // * UPDATE * //
    /**
     * Public method updating the user in the database
     *
     * @param User $user The user to update
     * @return void
     */
    public function update(User &$user): void {
        $request = "UPDATE Users SET Identifier = :identifier, Name = :name, Firstname = :firstname, Email = :email WHERE Id = :id";

        $params = [
            "id"          => $user->getId(),
            ":identifier" => $user->getIdentifier(),
            ":name"       => $user->getName(),
            ":firstname"  => $user->getFirstname(),
            ":email"      => $user->getEmail(),
        ];

        $this->post_request($request, $params); 
    }
    /**
     * Public method updating the user's password in the database
     *
     * @param User $user The user to update
     * @return void
     */
    public function updatePassword(User &$user): void {
        $request = "UPDATE Users SET Password = :password, PasswordTemp = 0 WHERE Id = :id";

        $params = [
            "id"        => $user->getId(),
            ":password" => password_hash($user->getPassword(), PASSWORD_DEFAULT),
        ];

        $this->post_request($request, $params);
    }

    /**
     * Public method updating the user's password in the database
     *
     * @param User $user The user to update
     * @return void
     */
    public function updateResetPassword(User &$user): void {
        $request = "UPDATE Users SET Password = :password, PasswordTemp = 1 WHERE Id = :id";

        $params = [
            "id"        => $user->getId(),
            "password" => password_hash($user->getPassword(), PASSWORD_DEFAULT),
        ];

        $this->post_request($request, $params);
    }


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

                if($users[$i]->getDesactivated()) {
                    throw new LoginExceptions("<b>Vos accès ont été désactivés</b>. <br>Contacter le support informatique via leur adresse incident pour plus de renseignements.");
                }

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