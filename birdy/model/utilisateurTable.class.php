<?php

class utilisateurTable
{
  public static function getUserByLoginAndPass($login,$pass)
  {
    $connection = new dbconnection() ;
    $sql = "SELECT *
            FROM jabaianb.utilisateur
            WHERE identifiant='" . $login . "' AND pass='" . sha1($pass) . "'";

    $res = $connection->doQuery($sql);

    if($res === false)
      return false;

    return $res;
  }

  public static function getUserById($id)
  {
  }

  public static function getUsers()
  {
  }
}
