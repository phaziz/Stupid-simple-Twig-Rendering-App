<?php

	/*
	 * APP CONFIG START
	 * */
	session_start();
	error_reporting(-1);

 	const _BASE_URL	 		= 'localhost:8888/localmamp/SSTRA';
	const _DEBUG 			= false;
	const _TWIG_CACHE 		= './vendor/cache'; // false | 'cache_dir'
	const _TWIG_AUTOESCAPE	= false; // true | false
	const _TWIG_DEBUG 		= false; // true | false
	/*
	 * APP CONFIG START
	 * */



	/*
	 * CONFIGURING APP ROUTES START
	 * */
	$ROUTES = array
	(
		'/' => 'index.html',
		'/test/test' => 'test.html',
		'/test/test/test' => 'test.html',
		'/test/test/test/test' => 'test.html',
		'/404' => '404.html',
	);
	/*
	 * CONFIGURING APP ROUTES END
	 * */



	/*
	 * INCLUDING & CONFIGURING TWIG TEMPLATE ENGINE START
	 * */
	require_once __DIR__ . '/vendor/autoload.php';
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/vendor/templates');
	$twig = new Twig_Environment($loader,
		array
		(
		    'cache' => _TWIG_CACHE,
		    'autoescape' => _TWIG_AUTOESCAPE,
		    'debug' => _TWIG_DEBUG
		)
	);
	/*
	 * INCLUDING & CONFIGURING TWIG TEMPLATE ENGINE START
	 * */

	/*
	 * BUILDING THE REQUEST START
	 * */
	$APP_REQUEST = str_replace(_BASE_URL,'',$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	/*
	 * BUILDING THE REQUEST END
	 * */

	/*
	 * DEBUGGING START
	 * */
	if(_DEBUG == true)
	{
		echo '<pre>';
		echo '<h1>DEBUG INFO:</h1>';
		echo 'APP_REQUEST: ' . $APP_REQUEST . '<br>';
		echo 'array_key_exists($APP_REQUEST,$ROUTES): ' . array_key_exists($APP_REQUEST,$ROUTES) . '<br>';
		echo '$ROUTES[$APP_REQUEST]: ' . $ROUTES[$APP_REQUEST] . '<br>';
		echo '</pre>';
	}
	/*
	 * DEBUGGING END
	 * */

	/*
	 * GENERATING HTML OUTPUT START
	 * */
	if(array_key_exists($APP_REQUEST,$ROUTES) == true)
	{
		$REQUEST_VARS = explode('/',$APP_REQUEST);
		$REQUEST_VARS = array_filter($REQUEST_VARS,'strlen');

		echo $twig -> render($ROUTES[$APP_REQUEST],
			array
			(
				'APP_REQUEST' => $APP_REQUEST,
				'REQUEST_VARS' => $REQUEST_VARS,
			)
		);
	}
	else
	{
		echo $twig -> render('404.html');
	}
	/*
	 * GENERATING HTML OUTPUT END
	 * */
