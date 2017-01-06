<?php

//=============================================================================
// ▼ Utilisateur
// ----------------------------------------------------------------------------
//
//=============================================================================
class utilisateur extends basemodel
{
	//---------------------------------------------------------------------------
	// * Upload avatar
	// Enregistre l'image dans le dossier avatar et met à jour le champ avatar.
	// Supprime l'ancien fichier s'il existe et est accessible en écriture.
	// Le fichier prend pour nom identifiant.imageType
	// Prend en charge l'opération pour un serveur pedago ou un serveur local.
	//---------------------------------------------------------------------------
	public function uploadAvatar($files)
	{
		$file = $files['avatar'];
		if(!$file) return;

		$imageType = substr($file['name'],strrpos($file['name'],"."));
		// TODO: vérifier le type de l'image

		$path = "/images/avatars/" . $this->identifiant;
		$fileDestination = protectedMethods::getServerRoot() . $path;

		// Supprime l'ancien fichier s'il existe
		$oldFile  = $fileDestination;
		$oldFile .= substr($this->avatar,strrpos($this->avatar,'.'));
		if(file_exists($oldFile) && is_writable($oldFile))
			unlink($oldFile);

		$this->avatar = protectedMethods::getServerUrl() . $path;
		$this->avatar    .= $imageType;
		$this->save();

		$fileDestination .= $imageType;

		// echo "Avatar (url)<br>"; var_dump($fileDestination); echo "<br>";
		// echo "Avatar (bdd)<br>"; var_dump($this->avatar); echo "<br>";

		return move_uploaded_file($file['tmp_name'],$fileDestination);
	}
}
