<?php
/**
 * Plugin mcatalogue
 *
 * @package cfdev
 * @version	2.0
 * @date	15/10/2015
 * @author	Cyril Frausti
 * @url		http://cfdev.fr
 **/

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
			if ($this->get && preg_match("#^'.$this->url.'/?#",$this->get, $capture)) {
				$prefix = str_repeat("../", substr_count(trim(PLX_ROOT.$this->aConf["racine_statiques"], "/"), "/"));
				$this->mode = "'.$this->url.'";
				$this->cible = $prefix.PLX_PLUGINS."'.get_class($this).'/form";
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
		
		# Affiche la liste des produits
		$o= array();
		$o["table"]		= "mcatalogue_product";
		$o["filter"]	= "actif=1 and category=".$cat;
		$o["order"]		= $order;
		$o["limit"]		= $itemsByPage * $page;
		$o["offset"]	= $itemsByPage * ($page-1);
		$o["out"]		= "html";
		$o["format"]	= '<div class="mcatalogue col sml-6 med-3 col-xs-6 col-md-3"> <div class="product"> <a href="'.$url.'/#url" title="#title"><img src="'.$imagePath.'#image" alt="#title"/>#title</a><p class="short_description">#short_description</p><p><span class="productBackPrice"><span class="productPrice">#price<sup>'.$currency.'</sup></span></span></p></div></div>';

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
			$getUrl = $arrayUrl[1];
		}
		else{
			$getUrl = "mcatalogue::productContent : Error getUrl";
		}
		
		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_product";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$products = $tmp->getData($o);	

		foreach($products as $product) {	
			if($getUrl == $product["url"]) {
				$content = $product;
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
			$getUrl = $arrayUrl[1];
		}
		else{
			$getUrl = "mcatalogue::productShowImage : Error getUrl";
		}
		
		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_product";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$products = $tmp->getData($o);	

		foreach($products as $product) {	
			if($getUrl == $product["url"]) {
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
			$getUrl = $arrayUrl[1];
		}
		else{
			$getUrl = "mcatalogue::productImage : Error getUrl";
		}
		
		# Parcour le tableau data
		$o = array();
		$o["table"] = "mcatalogue_product";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$products = $tmp->getData($o);	

		foreach($products as $product) {	
			if($getUrl == $product["url"]) {
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
	
	
} // End Class

?>