<?php
	global $plxPlugin;
		
	# Parcour le tableau data
	$orequest= array();
	$orequest["table"]="mcatalogue_product";
	$orequest["filter"]="mcatalogue_product_id=".$o["mastertableID"];
	$orequest["out"]="array";
	$aproduct = $plxPlugin->getData($orequest,true);

	// récupération de l'url
	$url = $aproduct[0]["url"];
	$title = $aproduct[0]["title"];

	# Si l'url est vide on update avec le titre mit en forme
	if ($url==""){
		$orecord=array();
		$orecord["table"]="mcatalogue_product";
		$orecord["id"]=$o["mastertableID"];
		$orecord["column"]=array("url");
		$url = plxUtils::title2url($title);
		$orecord["value"]=array($url);

		$plxPlugin->setData($orecord,true);
	}
?>