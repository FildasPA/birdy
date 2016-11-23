<?php 

class tweet extends basemodel {

	//------------------------------------------------------------------------------
	// * Récupere l'objet "post" associé au message
	//------------------------------------------------------------------------------
	public function getPost() {

		return postTable::getPostById($this->post);
	}

	//------------------------------------------------------------------------------
	// * Récupère l'objet utilisateur correspondant au rédacteur du message
	//------------------------------------------------------------------------------
	public function getParent() {

		return utilisateurTable::getUserById($this->parent);
	}

	//------------------------------------------------------------------------------
	// * Retourne le nombre d'utilisateurs ayant voté
	//------------------------------------------------------------------------------	
	public function getLikes() {

		return $this->nbVotes;
	}
}

?>