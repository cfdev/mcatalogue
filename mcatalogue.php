<?php
/**
 * Plugin mcatalogue
 *
 * @package cfdev
 * @version	2.1
 * @date	30/03/2016
 * @author	Cyril Frausti ®All right reserved
 * @url		http://cfdev.fr
 **/

 // Aciver les messages d'erreurs
//ini_set('display_errors', 'On');

require('toolbar.php');

class mcatalogue extends plxPlugin {	
	private $template = "static.php"; # template utilisé pour la page statique
	public $url = "mcatalogue"; # motif dans l'url permettant d'accéder à la page statique
	public $mnuName = "Catalogue"; # titre du menu dans la liste des pages statiques
	
	/**
	 * Constructeur de la classe
	 *
	 * @param	default_lang	langue par défaut
	 * @return	stdio
	 * @author	CFDEV
	 **/
	public function __construct($default_lang) {
		
		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);
		# init du plugin
		$this->initconfiguration();		
		# Hooks
		$this->addHook('plxShowConstruct', 'plxShowConstruct'); // Obligatoire
		$this->addHook('plxMotorPreChauffageBegin', 'plxMotorPreChauffageBegin');
		$this->addHook('plxShowPageTitle', 'plxShowPageTitle');
		$this->addHook('SitemapStatics', 'SitemapStatics');
		$this->addHook('mcatalogueShow', 'mcatalogueShow');
		$this->addHook('mcatalogueCatsList', 'mcatalogueCatsList');
	}	
	/**
	 * Méthode qui initialise les variables
	 *
	 * @author	JE-EVRARD
	 **/
	public function initconfiguration() {
		# VARIOUS PARAMS
		$this->setParam('spxdatas_widget', '1', 'string');
		$this->setParam('spxshortcodes_shortcode', '1', 'string');	//Shortcode	
		# limite l'accès à l'écran d'administration du plugin
		$this->setConfigProfil(PROFIL_ADMIN);
		# get config
		if (plxUtils::strCheck($this->getParam('mnuName'))=="") $this->setParam('mnuName','Catalogue','string');
		if (plxUtils::strCheck($this->getParam('template'))=="") $this->setParam('template','static.php','string');
		$this->mnuName = $this->getParam('mnuName');
		$this->template = $this->getParam('template');
	}

	 /**
     * Méthode 
     *
     * @return    null
     * @author    Stéphane F
     **/
	public function plxShowConstruct() {
		# infos sur la page statique
		$string  = '
			if($this->plxMotor->mode=="'.$this->url.'") {;
				$array = array();
				$array[$this->plxMotor->cible] = array(
					"name"		=> "'.$this->mnuName.'",
					"menu"		=> "",
					"url"		=> "'.$this->url.'",
					"readable"	=> 1,
					"active"	=> 1,
					"group"		=> ""
				);
				$this->plxMotor->aStats = array_merge($this->plxMotor->aStats, $array);
			}
		';
		echo "<?php ".$string." ?>";
	}
	
    /**
     * Méthode qui effectue une analyse de la situation et détermine
     * le mode à appliquer. Cette méthode alimente ensuite les variables
     * de classe adéquates
     *
     * @return    null
     * @author    Stéphane F
     **/
	public function plxMotorPreChauffageBegin($template="static.php") {
		
		$template = $this->template==''?'static.php':$this->template;
		
		$string= '
			if ($this->get && preg_match("#^'.$this->url.'/[\w\-]+/?$#",$this->get, $capture)) {
				$prefix = str_repeat("../", substr_count(trim(PLX_ROOT.$this->aConf["racine_statiques"], "/"), "/"));
				$this->mode = "'.$this->url.'";
				$this->cible = $prefix.PLX_PLUGINS."'.get_class($this).'/form.category";
				$this->template = "'.$template.'";
				return true;
			}
			if ($this->get && preg_match("#^'.$this->url.'/?#",$this->get, $capture)) {
				$prefix = str_repeat("../", substr_count(trim(PLX_ROOT.$this->aConf["racine_statiques"], "/"), "/"));
				$this->mode = "'.$this->url.'";
				$this->cible = $prefix.PLX_PLUGINS."'.get_class($this).'/form.product";
				$this->template = "'.$template.'";
				return true;
			}
		';
		echo "<?php ".$string." ?>";
	
	}
	
	/**
     * Méthode qui renseigne le titre de la page dans la balise html <title>
     *
     * @return    stdio
     * @author    cfdev
     **/
    public function plxShowPageTitle() {
		# Récupération d'une instance de plxMotor
		$plxMotor = plxMotor::getInstance();
		# Récupération des infos dans l'urls
		$get = plxUtils::getGets();
		if($get) {
			$arrayUrl = explode("/",$get);
			$getUrl = $arrayUrl[1];
		}
		
        if (isset($getUrl)){
            echo '<?php
                if($this->plxMotor->mode == '.$this->url.') {
                    echo plxUtils::strCheck($this->plxMotor->aConf["title"]." - '.substr($getUrl, strrpos($getUrl, '/')).'");
                    return true;
                }
            ?>';
        }
    }

    /**
     * Méthode qui référence les produits dans le sitemap
     *
     * @return    stdio
     * @author    cfdev
     **/
    public function SitemapStatics() {
		echo '<?php
		echo "\n";
		echo "\t<url>\n";
		echo "\t\t<loc>".$plxMotor->urlRewrite("?'.$this->url.'")."</loc>\n";
		echo "\t\t<changefreq>monthly</changefreq>\n";
		echo "\t\t<priority>0.8</priority>\n";
		echo "\t</url>\n";
		?>';
    }
	
	/**
	 * Méthode a l'activation du plugin
	 *
	 * @author	JE-EVRARD
	 **/
	public function OnActivate() {
		
	}
	
	# getloc call by spxdatas
	public function get_loc($mylang) {
		
		$filename = PLX_PLUGINS.'mcatalogue/spxdatas/table/table_loc/'.$mylang.'/admin.php';
		$LANG = array();
		//echo ("mylang = ".is_file($filename));
		if(is_file($filename)) {
			include($filename);
		}
		return $LANG;
	}

	/**
	 * Méthode qui affiche la liste des categories
	 *
	 * @param	format #cat_url et #cat_name
	 * @return	stdio
	 * @author	cfdev
	 **/
    public function mcatalogueCatsList($format) {
		global $plxShow;
		$plxMotor = plxMotor::getInstance();
		$list = '';
		# Parcour le tableau data category
		$ocat = array();
		$ocat["table"] = "mcatalogue_category";
		$ocat["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$cats = $tmp->getData($ocat);
		# URL
		$url = $plxMotor->urlRewrite('index.php?'.$this->url);		
		
		foreach($cats as $cat) {
			//plxUtils::debug($cat);
			if($cat['actif'] >0 ) {
				$row = $format;					
				$row = str_replace('#cat_url',plxUtils::strCheck($url.'/'.$cat['url']),$row);
				$row = str_replace('#cat_name',plxUtils::strCheck($cat['title']),$row);								
				$list .= $row;
			}
		}
		echo($list);
	}

	/**
	 * Méthode qui affiche les produits en fonction de la categorie
	 *
	 * @param	array (cat, page, order)
	 * @return	stdio
	 * @author	cfdev
	 **/
    public function mcatalogueShow($atts) {
		global $plxShow;
		$plxMotor = plxMotor::getInstance();
		$imagePath = isset($plxMotor->aConf['medias']) ? plxUtils::getRacine().$plxMotor->aConf['medias'] : plxUtils::getRacine().$plxMotor->aConf['images'];

		#Check var entree
		$cat = $atts["cat"];
		$page = $atts["page"];
		$order = $atts["order"];
		
		if( !isset($page) || $page<1 ){
			$page = 1;
		}
		
		# Parcour le tableau config
		$c = array();
		$c["table"] = "mcatalogue_configuration";
		$c["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$config = $tmp->getData($c);
		foreach($config as $val) {			
			$currency = $val["currency"];
			$itemsByPage = $val["itemsByPage"];
		}
		# URL
		$url = $plxMotor->urlRewrite('index.php?'.$this->url);
	
		# Parcour le tableau data category
		$ocat = array();
		$ocat["table"] = "mcatalogue_category";
		$ocat["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$cats = $tmp->getData($ocat);
		# recupération de l'url de la catégorie
		$catUrl = $cats[$cat]['url'];

		# Affiche la liste des produits
		$o= array();
		$o["table"]		= "mcatalogue_product";
		$o["filter"]	= "actif=1 and category=".$cat;
		$o["order"]		= $order;
		$o["limit"]		= $itemsByPage * $page;
		$o["offset"]	= $itemsByPage * ($page-1);
		$o["out"]		= "html";
		$o["format"]	= '<div class="mcatalogue col sml-6 med-3 col-xs-6 col-md-3"> <div class="product"><img class="pBadge rt2012_#rt2012" src="'.PLX_PLUGINS.'mcatalogue/img/rt2012.png" />  <a href="'.$url.'/'.$catUrl.'/#url" title="#title"><img src="'.$imagePath.'#image" class="product_img" alt="#title"/>#title</a><p class="short_description">#short_description</p><p><span class="productBackPrice"><span class="productPrice">#price<sup>'.$currency.'</sup></span></span></p></div></div>';

		# Affichage
		echo ("<div class=\"grid row\">".$plxShow->callHook('spxdatas::getData',$o)."</div>");
	
		# DEBUG: Ajoute la pagination si nécessaire
		$count = array();
		$count["table"] = "mcatalogue_product";
		$count["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$tabCount = $tmp->getData($count);	
		if(count($tabCount) > $itemsByPage) {
			echo '<br/>PAGE:'.$page.' / '.ceil( count($tabCount)/$itemsByPage );
			echo '<br/>ItemsBy page:'.$itemsByPage;
			echo '<br/>Offset:'.($itemsByPage * ($page-1));
			echo ' -> PAGINATION OUI';
		}		
	}
	
	

	/**
	 * Méthode qui affiche d'autres produits en fonction de la categorie
	 *
	 * @param	array (productId, cat, count)
	 * @return	stdio
	 * @author	cfdev
	 **/
    public function showReadMore($atts) {
		global $plxShow;
		$plxMotor = plxMotor::getInstance();
		$imagePath = isset($plxMotor->aConf['medias']) ? plxUtils::getRacine().$plxMotor->aConf['medias'] : plxUtils::getRacine().$plxMotor->aConf['images'];

		#Check var entree
		$productId = $atts["productId"];
		$cat = $atts["cat"];
		$count = $atts["count"];
		
		# Parcour le tableau config
		$c = array();
		$c["table"] = "mcatalogue_configuration";
		$c["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$config = $tmp->getData($c);
		foreach($config as $val) {			
			$currency = $val["currency"];
			$itemsByPage = $val["itemsByPage"];
		}

		# Parcour le tableau data category
		$ocat = array();
		$ocat["table"] = "mcatalogue_category";
		$ocat["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$cats = $tmp->getData($ocat);
		# recupération de l'url de la catégorie
		$catUrl = $cats[$cat]['url'];

		# URL
		$url = $plxMotor->urlRewrite('index.php?'.$this->url);
		
		# Récupère la liste des produits
		$o= array();
		$o["table"]		= "mcatalogue_product";
		$o["filter"]	= "actif=1 and category=".$cat;
		$o["out"]		= "array"; //html
		$listArray = $plxShow->callHook('spxdatas::getData',$o);
		
		//var_dump($listArray);
		if($listArray and sizeof($listArray)>1) {
			# recherche aléatoire des produit à recommander
			$random = array_rand($listArray, ($count > sizeof($listArray) ? sizeof($listArray) : $count) );

			foreach($random as $prod) {
				# on ne liste pas le produit en cours 
				if($listArray[$prod]["mcatalogue_product_id"] <> $productId) {
					$row = '<div class="mcatalogue col sml-6 med-3 col-xs-6 col-md-3"> <div class="product"><img class="pBadge rt2012_#rt2012" src="'.PLX_PLUGINS.'mcatalogue/img/rt2012.png" />  <a href="#url" title="#title"><img src="#image" alt="#title"/>#title</a><p class="short_description">#short_description</p><p><span class="productBackPrice"><span class="productPrice">#price<sup>#currency</sup></span></span></p></div></div>';
					$row = str_replace('#title',plxUtils::strCheck($listArray[$prod]["title"]),$row);
					$row = str_replace('#rt2012',plxUtils::strCheck($listArray[$prod]["rt2012"]),$row);						
					$row = str_replace('#url',plxUtils::strCheck($url.'/'.$cats[$listArray[$prod]['category']]['url'].'/'.$listArray[$prod]["url"]),$row);
					$row = str_replace('#image',plxUtils::strCheck($imagePath.$listArray[$prod]["image"]),$row);
					$row = str_replace('#price',plxUtils::strCheck($listArray[$prod]["price"]),$row);
					$row = str_replace('#currency',plxUtils::strCheck($currency),$row);
					$row = str_replace('#short_description',plxUtils::strCheck($listArray[$prod]["short_description"]),$row);
									
					$list .= $row;
					
					//var_dump($row);
					//var_dump($listArray[$prod]);
				}
			}
		}
		
		# Affiche la liste des produits
		echo ("<div class=\"grid row\">".$list."</div>");
	
	}
	
	
		/**
	 * Méthode qui retourne la configuration de mcatalogue
	 *
	 * @author	cfdev
	*/
	public function mcatalogueConfig() {
		# Récupération d'une instance de plxMotor
		$plxMotor = plxMotor::getInstance();
		
		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_configuration";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$config = $tmp->getData($o);
		foreach($config as $val) {			
		}	
		#Return
		return $val;
	}
	
	/**
	 * Méthode qui retourn le contenu du produit
	 *
	 * @author	cfdev
	*/
	public function productContent() {
		# Récupération d'une instance de plxMotor
		$plxMotor = plxMotor::getInstance();
		# Récupération des infos dans l'urls
		$get = plxUtils::getGets();
		if($get) {
			$arrayUrl = explode("/",$get);
			//plxUtils::debug($arrayUrl);
			$urlCategory = $arrayUrl[1];
			$urlProduct = $arrayUrl[2];
		}
		else{
			$urlProduct = "mcatalogue::productContent : Error getUrl";
		}

		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_product";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$products = $tmp->getData($o);

		foreach($products as $product) {
			if($urlProduct == $product["url"]) {
				$content = $product;
			}
		}

		# Parcour le tableau data categorie
		$o = array();
		$o["table"] = "mcatalogue_category";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$cats = $tmp->getData($o);

		foreach($cats as $cat) {
			if($cat["mcatalogue_category_id"] == $content["category"]) {
				 $content["categoryName"] = $cat["title"];
			}
		}

		#Return
		return $content;
	}

	/**
	 * Méthode qui affiche l'image du produit
	 * 
	 * @param class additionnelle pour l'image
	 * @author	cfdev
	*/
	public function productShowImage($class) {
		# récupération d'une instance de plxMotor
		$plxMotor = plxMotor::getInstance();
		# Récupération des infos dans l'urls
		$get = plxUtils::getGets();
		if($get) {
			$arrayUrl = explode("/",$get);
			$urlCategory = $arrayUrl[1];
			$urlProduct = $arrayUrl[2];
		}
		else{
			$urlProduct = "mcatalogue::productShowImage : Error getUrl";
		}

		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_product";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$products = $tmp->getData($o);

		foreach($products as $product) {
			if($urlProduct == $product["url"]) {
				$image = $product["image"];
			}
		}
		#Récupération du chemin image
		$imagePath = isset($plxMotor->aConf['medias']) ? plxUtils::getRacine().$plxMotor->aConf['medias'] : plxUtils::getRacine().$plxMotor->aConf['images'];

		$content = '<img class="'.$class.'" src="'.$imagePath.$image.'" />';

		#Return
		echo $content;
	}
	
	
	/**
	 * Méthode qui retourn l'image du produit
	 * 
	 * @param number of image
	 * @return src of image
	 * @author	cfdev
	*/
	public function productImage($num) {
		# récupération d'une instance de plxMotor
		$plxMotor = plxMotor::getInstance();
		# Récupération des infos dans l'urls
		$get = plxUtils::getGets();
		if($get) {
			$arrayUrl = explode("/",$get);
			$urlCategory = $arrayUrl[1];
			$urlProduct = $arrayUrl[2];
		}
		else{
			$urlProduct = "mcatalogue::productImage : Error getUrl";
		}

		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_product";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$products = $tmp->getData($o);

		foreach($products as $product) {
			if($urlProduct == $product["url"]) {
				if($num == 1)$image = $product["image"];
				if($num == 2)$image = $product["image2"];
				if($num == 3)$image = $product["image3"];
			}
		}
		#Récupération du chemin image
		$imagePath = isset($plxMotor->aConf['medias']) ? plxUtils::getRacine().$plxMotor->aConf['medias'] : plxUtils::getRacine().$plxMotor->aConf['images'];

		if( !empty($image) ){
			$content = $imagePath.$image;
		}

		#Return
		return $content;
	}


	/**
	 * Méthode qui retourn le contenu de la catégorie
	 *
	 * @author	cfdev
	*/
	public function categoryContent() {
		# Récupération d'une instance de plxMotor
		$plxMotor = plxMotor::getInstance();
		# Récupération des infos dans l'urls
		$get = plxUtils::getGets();
		if($get) {
			$arrayUrl = explode("/",$get);
			//plxUtils::debug($arrayUrl);
			$urlCategory = $arrayUrl[1];
		}
		else{
			$urlCategory = "mcatalogue::categoryContent : Error getUrl";
		}

		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_category";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$categories = $tmp->getData($o);

		foreach($categories as $cat) {
			if($urlCategory == $cat["url"]) {
				$content = $cat;
			}
		}
		#Return
		return $content;
	}
	
} // End Class

?>