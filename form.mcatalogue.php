<?php if(!defined('PLX_ROOT')) exit; ?>

<?php

	# r�cup�ration d'une instance de plxMotor
	$plxMotor = plxMotor::getInstance();
	$plxPlugin = $plxMotor->plxPlugins->getInstance('mcatalogue');

	#R�cup�ration du produit
	$product = $plxPlugin -> productContent();
	
	#Titre du produit
	echo('<h1>');
	echo $product["title"];
	echo('</h1>');

	$plxPlugin -> productShowImage("img-responsive");
	
	#Description du produit
	echo $product["content"];

?>
