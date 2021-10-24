<?php

	// exécute un fichier php ici inc.twig.php'
	include 'inc.twig.php';

	// ajoute le template twig
	$template_index = $twig->loadTemplate('index.tpl');

	// créé une variable "nombre de jours en prévison" qui contient le chiffre "3"
	$n_jours_previsions = 3;

	// créé une variable "ville" qui contient la chaine de caractères "Limoges"
	$ville = "Limoges"; 

	//~ Clé API
	//~ Si besoin, vous pouvez générer votre propre clé d'API gratuitement, en créant 
	//~ votre propre compte ici : https://home.openweathermap.org/users/sign_up
	$apikey = "10eb2d60d4f267c79acb4814e95bc7dc";

	// créé une variable "url data" qui contient le lien vers l'api openweathermap pour récupérer les données de manière dynamique
	$data_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?APPID='.$apikey.'&q='.$ville.',fr&lang=fr&units=metric&cnt='.$n_jours_previsions;

	// Lit en chaine de caractères le contenu de la variable $data_url
	$data_contenu = file_get_contents($data_url);
	
	//Récupère la chaîne encodée JSON et la convertit en une variable PHP
	$_data_array = json_decode($data_contenu, true);

	// déclaration d'un tableau "$_ville" composé des éléments du tableau $_data_array['city']
	$_ville = $_data_array['city'];
	// déclaration d'un tableau "$_journees_meteo" composé des éléments du tableau $_data_array['list']
	$_journees_meteo = $_data_array['list'];

	for ($i = 0; $i < count($_journees_meteo); $i++) {
		$_meteo = getMeteoImage($_journees_meteo[$i]['weather'][0]['icon']);
		
		$_journees_meteo[$i]['meteo'] = $_meteo;
	}

	echo $template_index->render(array(
		'_journees_meteo'	=> $_journees_meteo,
		'_ville'			=>$_ville,
		'n_jours_previsions'=> $n_jours_previsions
	));

	//récuperer dans le tableau la valeur de l'icone correspondant et la retourner
	function getMeteoImage($code){
		if(strpos($code, 'n'))
			return 'entypo-moon';
		
	//Tableau stockant les différentes valeur des icones 
		$_icones_meteo =array(
			'01d' => 'entypo-light-up',
			'02d' => 'entypo-light-up',
			'03d' => 'entypo-cloud',
			'04d' => 'entypo-cloud',
			'09d' => 'entypo-water', 
			'10d' => 'entypo-water',
			'11d' => 'entypo-flash',
			'13d' => 'entypo-star', 
			'50d' => 'entypo-air'
		);

		if(array_key_exists($code, $_icones_meteo)) {
			return $_icones_meteo[$code];
		} else {
			return 'entypo-help';
		}
	}

// ajout de la balise fermante php
?>