<?php 
/**
	Author: cfdev
	website: http://cfdev.fr/
	Shortcodes plugin: http://secretsitebox.fr/site/index.php?categorie2/pluxml-plugins#post-10/
	
*/     
   
   
/**
*/
function mcatalogue_func( $atts, $content = null ) {

	global $plxShow;

	extract( shortcode_atts( array(
		'cat' => 'cat',
		'order' => 'order',	
	), $atts ) );


	return $plxShow->callHook('mcatalogueShow',$atts);
}

add_shortcode('MCATALOGUE', 'mcatalogue_func');

?>