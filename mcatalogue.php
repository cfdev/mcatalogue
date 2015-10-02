<?php
/**
 * Plugin mcatalogue
 *
 * @package cfdev
 * @version	
 * @date	01/10/2015
 * @author	cfdev
 **/


class mcatalogue extends plxPlugin {	
	private $template = "static.php"; # template utilisé pour la page statique
	public $url = "mcatalogue"; # motif dans l'url permettant d'accéder à la page statique
	
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
		$this->setParam('spxshortcodes_shortcode', '1', 'string');
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
					"name"		=> "'.$this->name.'",
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
	 * Méthode a l'activation du plugin
	 *
	 * @author	JE-EVRARD
	 **/
	public function OnActivate() {
		
	}
	
	# getloc call by spxdatas
	public function get_loc($mylang) {
		
		$filename = PLX_PLUGINS.$this->spxname.'/spxdatas/table/table_loc/'.$mylang.'/admin.php';
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
	 * @param	numéro de la catégorie à afficher
	 * @return	stdio
	 * @author	cfdev
	 **/
    public function mcatalogueShow($cat) {
		global $plxShow;
		$plxMotor = plxMotor::getInstance();
		$imagePath = isset($plxMotor->aConf['medias']) ? plxUtils::getRacine().$plxMotor->aConf['medias'] : plxUtils::getRacine().$plxMotor->aConf['images'];

		# Parcour le tableau config
		$c = array();
		$c["table"] = "configuration";
		$c["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$config = $tmp->getData($c);
		foreach($config as $val) {			
			$currency = $val["currency"];
		}
		
		# Affiche la liste des produits
		$o= array();
		$o["table"]="product";
		$o["filter"]="actif=1 and category=".$cat;
		$o["out"]="html";
		$o["format"]='<li class="col sml-6 med-3"><a href="'.$this->url.'/#url" title="#title"><img src="'.$imagePath.'#image" alt="#title"/>#title</a><p>#short_description</p><p>#price'.$currency.'</p></li>';

		echo ("<ul class=\"grid\">".$plxShow->callHook('spxdatas::getData',$o)."</ul>");		
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
		$o["table"] = "product";
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
			$getUrl = "mcatalogue::productImage : Error getUrl";
		}
		
		# Parcour le tableau data
		$o = array();
		$o["table"] = "product";
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
	
} // End Class

?>