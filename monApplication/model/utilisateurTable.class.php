<?php

class utilisateurTable
{
  public static function getUserByLoginAndPass($login,$pass)
  {
    $connection = new dbconnection() ;
    $sql = "select * from jabaianb.utilisateur where identifiant='".$login."' and pass='".sha1($pass)."'" ;

    $res = $connection->doQuery( $sql );
    
    if($res === false)
      return false ;

    return $res ;
  }

  public static function getUserById($id)
  {
  }

  public static function getUsers()
  {
  }
}
