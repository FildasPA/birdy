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
	// Le fichier prend pour nom identifiant.imageType
	// Prend en charge l'opération sur le serveur pedago ou un serveur local.
	//---------------------------------------------------------------------------
	public function uploadAvatar($file)
	{
		$avatarsFolder = "images/avatars/";
		$localhostProjectFolder = "/Projets/birdy/";

		$imageType = substr($file['name'],strrpos($file['name'],"."));

		if($_SERVER["SERVER_NAME"] == "localhost") {
			$this->avatar = "http://" . $_SERVER["HTTP_HOST"] . $localhostProjectFolder;
			$fileDestination = $_SERVER["DOCUMENT_ROOT"]. $localhostProjectFolder;
		}	else { // Serveur pedago
			$this->avatar  = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"];
			$this->avatar .= $_SERVER["CONTEXT_PREFIX"] . "/";
			$fileDestination = $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/";
		}

		$this->avatar    .= $avatarsFolder . $this->identifiant . $imageType;
		$fileDestination .= $avatarsFolder . $this->identifiant . $imageType;

		// echo "Avatar (url)<br>"; var_dump($fileDestination); echo "<br>";
		// echo "Avatar (bdd)<br>"; var_dump($this->avatar);       echo "<br>";

		$this->save();

		return move_uploaded_file($file['tmp_name'],$fileDestination);
	}
}
