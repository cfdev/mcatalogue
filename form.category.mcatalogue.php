<?php if(!defined('PLX_ROOT')) exit; ?>

<?php
	# Récupétion d'une instance de plxMotor
	$plxMotor = plxMotor::getInstance();
	$plxPlugin = $plxMotor->plxPlugins->getInstance('mcatalogue');

	# Récupération de la config
	$config = $plxPlugin->mcatalogueConfig();
	# Récupération de la category
	$category = $plxPlugin->categoryContent();

	# Breadcrumb
	echo '<ul class="menu breadcrumb">';
	echo '<li>'.$plxPlugin->mnuName.'</li>';
	echo '<li><a href="'.plxUtils::getGets().'">'.$category["title"].'</a></li>';
	echo "</ul>";

  # Titre de la catégorie produit
	echo('<h1>'.$category['title'].'</h1>');

  # contenu de la catégorie
	echo('<section>'.$category['content'].'</section>');

	# Liste des produits
	$atts = array();
	$atts["cat"] = $category['mcatalogue_category_id'];
	$atts["page"] = 1;
	$atts["order"] = ""; /*price|A*/
	$plxPlugin->mcatalogueShow($atts);
?>
