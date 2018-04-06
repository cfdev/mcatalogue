<?php if(!defined('PLX_ROOT')) exit; ?>

<?php
	# Récupétion d'une instance de plxMotor
	$plxMotor = plxMotor::getInstance();
	$plxPlugin = $plxMotor->plxPlugins->getInstance('mcatalogue');

	# Récupération de la config
	$config = $plxPlugin->mcatalogueConfig();
	# Récupération du produit
	$product = $plxPlugin->productContent();

	# Breadcrumb
	echo '<ul class="menu breadcrumb">';
	echo '<li>'.$plxPlugin->mnuName.'</li>';
	echo '<li><a href="'.str_replace(substr(strrchr(plxUtils::getGets(), "/"), 1), '', plxUtils::getGets()).'">'.$product["categoryName"].'</a></li>';
	echo '<li><a href="'.plxUtils::getGets().'">'.$product["title"].'</a></li>';
	echo "</ul>";

	# Titre du produit
	echo('<h1>');
	echo $product["title"];
	echo('</h1>');

	# Images produit
	echo '
	<div class="grid row">
	<div id="productImage" class="col sml-12 med-6 *** col-xs-12 col-sm-6 col-md-6">
		<img class="img-product img-master center" src="'.$plxPlugin->productImage(1).'" alt="image product" />
			<div class="grid row">
	';

	# Attention si php < 5.5 obligation de déclarer des var avant le test empty
	$img1 = $plxPlugin->productImage(1);
	$img2 = $plxPlugin->productImage(2);
	$img3 = $plxPlugin->productImage(3);

	if( !empty($img2) || !empty($img3) ) {
		echo '<div class="col sml-4 med-4 *** col-xs-4 col-md-4"><img class="thumb thumbnail" src="'.$plxPlugin->productImage(1).'" alt="image 1" title="cliquez pour changer"/></div>';
	}
	if( !empty($img2) ) {
		echo '<div class="col sml-4 med-4 *** col-xs-4 col-md-4"><img class="thumb thumbnail" src="'.$plxPlugin->productImage(2).'" alt="image 1" title="cliquez pour changer"/></div>';
	}
	if( !empty($img3) ) {
		echo '<div class="col sml-4 med-4 *** col-xs-4 col-md-4"><img class="thumb thumbnail" src="'.$plxPlugin->productImage(3).'" alt="image 1" title="cliquez pour changer"/></div>';
	}
	echo '
			</div>
	</div>';

	# Prix du produit
	echo '<div id="productContent" class="col sml-12 med-6 *** col-xs-12 col-sm-6 col-md-6">
		<p>
		<span class="productBackPrice">
		<span class="productPrice">'
		.$product["price"].
		'<sup>'.$config["currency"].'</sup></span></span></p><br/>';

	# Rt2012
	if( $product["rt2012"] == 1){
		echo '<img class="pBadges_page" src="'.PLX_PLUGINS.'mcatalogue/img/rt2012.png" />';
	}

	# Bouton de devis
	echo '<p><a href="index.php?contact" title="Commander" class="btn btn-success">Demander un devis gratuit</a></p>';

	# Description du produit
	echo $product["content"];

	# lien de partage
	if( $config["share"] == 1){
			echo '<div class="text-center">
				 <div id="lessbuttons_holder"></div><script async src="https://lessbuttons.com/script.js?facebook=1&twitter=1&googleplus=1&position=inline"></script>
				</div>';
	}

	echo '</div></div>';


	#Détails
	if( !empty($product["details"]) ) :
?>
	<h2>En savoir plus</h2>
    <div id="mtab" class="mtab">
        <ul class="tabs">
			<li><a href="#mtab" title="Détails techniques" class="tab active">Détails</a></li>
			<!-- <li><a href="#mtab" title="content_2" class="tab">Images</a></li> -->
        </ul>

        <div id="content_1" class="content">
			<?php echo $product["details"]; ?>
        </div>
    </div>
	<?php endif; ?>

	<div class="readmore">
		<h3>A voir également dans <?php echo $product["categoryName"] ?></h3>
		<?php
		$atts = array(
			"productId"	=> $product["mcatalogue_product_id"],
			"cat"	  	=> $product["category"],
			"count" 	=> 4,
		);
		$plxPlugin->showReadMore($atts);
		?>
	</div>


<!-- JQUERY POWER! -->
<script type="text/javascript">
    // Une fois le chargment de la page terminé ...
    $(document).ready(  function() {
		// Lorsqu'un lien a.tab est cliqué
		$("a.tab").click(   function () {
			// Mettre tous les onglets non actifs
				$(".active").removeClass("active");

				// Mettre l'onglet cliqué actif
				$(this).addClass("active");

				// hide the content
				$(".content").hide();

				// Show other content
				// avons modifié le titre du lien par le nom de
				// l'identifiant de la boite de contenu
				var contenu_aff = $(this).attr("title");
				$("#" + contenu_aff).show();
			}
		);
	// Change l'image sur un clic souris
		$( "img.thumb" ).click(function() {
			var src = $(this).attr("src");
			$( "img.img-product" ).attr("src", src);
		});

	}
);
</script>
