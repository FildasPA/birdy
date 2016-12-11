<?php

//=============================================================================
// ▼ Tweet
// ----------------------------------------------------------------------------
//
//=============================================================================
class tweet extends basemodel
{
	//---------------------------------------------------------------------------
	// * Récupère le post associé au message
	//---------------------------------------------------------------------------
	public function getPost()
	{
		return postTable::getPostById($this->post)[0];
	}

	//---------------------------------------------------------------------------
	// * Récupère l'objet utilisateur correspondant au rédacteur du message
	//---------------------------------------------------------------------------
	public function getParent()
	{
		return utilisateurTable::getUserById($this->parent)[0];
	}

	//---------------------------------------------------------------------------
	// * Récupère l'objet utilisateur correspondant à l'émetteur du tweet
	//---------------------------------------------------------------------------
	public function getSender()
	{
		return utilisateurTable::getUserById($this->emetteur)[0];
	}

	//---------------------------------------------------------------------------
	// * Retourne le nombre d'utilisateurs ayant voté
	//---------------------------------------------------------------------------
	public function getLikes()
	{
		return $this->nbvotes;
	}
}

?>
