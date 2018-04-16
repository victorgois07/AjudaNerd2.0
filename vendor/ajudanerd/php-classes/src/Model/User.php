<?php

namespace AjudaNerd\Model;

use \AjudaNerd\DB\Sql;
use \AjudaNerd\Model;

Class User extends Model {

    const SESSION = "User";
    const SECRET = "HcodePhp7_Secret";

    public static function getFromSession()
    {
        $user = new User();

        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0) {
            $user->setData($_SESSION[User::SESSION]);
        }

        return $user;

    }
    public static function checkLogin($nlaccess = true)
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
        ) {

            //Não está logado
            return false;

        } else {

            if ($nlaccess === true && (bool)$_SESSION[User::SESSION]['nlaccess'] === true) {
                return true;
            } else if ($nlaccess === false) {
                return true;
            } else {
                return false;
            }
        }
    }
    public static function login($login, $password)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_user a INNER JOIN tb_person b ON a.id_user = b.id_person WHERE a.email = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        var_dump($results);

        if (count($results) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválidaaaaaa.");
        }

        $data = $results[0];

        if (password_verify($password, $data["password"]) === true)
        {
            $user = new User();
            $data['person'] = utf8_encode($data['person']);
            $user->setData($data);
            $_SESSION[User::SESSION] = $user->getValues();
            return $user;
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }
    }

    public static function verifyLogin($nlaccess = true)
    {
        if (!User::checkLogin($nlaccess)) {
            if ($nlaccess) {
                header("Location: /AjudaNerd2.0/admin/login");
            } else {
                header("Location: /login");
            }
            exit;
        }
    }
    //Função para sair da sessão que está usando.
    public static function logout()
    {
        $_SESSION[User::SESSION] = null;
    }

}

?>