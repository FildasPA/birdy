<?php
/*
 * Controler
 */

class mainController
{

	public static function superTest($request,$context)
	{
		$context->par1 = $request['par1'];
		$context->par2 = $request['par2'];
		return context::SUCCESS;
	}

	public static function helloWorld($request,$context)
	{
		$context->mavariable = "hello world";
		return context::SUCCESS;
	}

	public static function index($request,$context)
	{
		return context::SUCCESS;
	}

}
