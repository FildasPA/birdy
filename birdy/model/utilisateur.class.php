<?php

//=============================================================================
// ▼ Utilisateur
// ----------------------------------------------------------------------------
//
//=============================================================================
class utilisateur extends basemodel
{
	//------------------------------------------------------------------------------
	// * Copie l'avatar sur le serveur
	//------------------------------------------------------------------------------
	private function copy_avatar($url,$dest_file)
	{
		$dest_dir  = dirname(dirname(dirname(__FILE__))) . "/images/";
		$dest_file = $dest_dir . $dest_file;
		if(copy($url,$dest_file)) {
			return true;
		}	else {
			echo "<p style='color:red;'>L'image n'a pas pu être ajoutée...</p>";
			return false;
		}
	}

	//------------------------------------------------------------------------------
  // * Register
  //------------------------------------------------------------------------------
  public function register($request,$files)
  {
		$this->data = array('nom'         => $request['name'],
		                    'prenom'      => $request['firstname'],
		                    'identifiant' => $request['login'],
		                    'pass'        => sha1($request['password']));

		// URL de l'image (serveur & upload)
		$avatar_url     = $files['avatar']['tmp_name'];
		$avatar_name    = $files['avatar']['name'];
		$image_type     = substr($avatar_name,strrpos($avatar_name,"."));

  	// Informations générales
		$this->data['avatar'] = 'avatar_' . $this->data['identifiant'] . $image_type;

		return (utilisateurTable::getUserByLogin($this->data['identifiant']) === false &&
		        $this->save() != false &&
		        $this->copy_avatar($avatar_url,$this->data['avatar']));
	}
}

?>
