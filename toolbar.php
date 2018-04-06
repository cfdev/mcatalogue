<?php
/**
 * Part of Plugin mcatalogue
 *
 * @package cfdev
 * @version	1.0
 * @date	01/06/2016
 * @author	Cyril Frausti ®All right reserved
 * @url		http://cfdev.fr
 **/

class toolBar {
  private $types;
  private $cats;
  private $brands;

	/**
	 * Constructeur de la classe
	 *
	 * @param	default_lang	langue par défaut
	 * @return	stdio
	 * @author	CFDEV
	 **/
	public function __construct($default_lang) {
    global $plxShow;
    $plxMotor = plxMotor::getInstance();

    # Parcour le tableau data types
	  $o = array();
		$o["table"] = "mcatalogue_type";
		$o["out"] = "array_asso";
		$tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
		$this->types = $tmp->getData($o);

    # Parcour le tableau data category
    $o = array();
    $o["table"] = "mcatalogue_category";
    $o["out"] = "array_asso";
    $tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
    $this->cats = $tmp->getData($o);

    # Parcour le tableau data brand
    $o = array();
    $o["table"] = "mcatalogue_brand";
    $o["out"] = "array_asso";
    $tmp = $plxMotor->plxPlugins->aPlugins["spxdatas"];
    $this->brands = $tmp->getData($o);
	}

  /**
	 * Affiche la toolbar
	 *
	 * @return	echo
	 * @author	CFDEV
	 **/
  public function show($cat) {

    plxUtils::debug($_POST);

    // Types
    foreach($this->types as $type) {
        if($_POST['type'] == $type["mcatalogue_type_id"]) $selected = 'selected';
        else  $selected = '';
         $typesName .= '<option value="'.$type["mcatalogue_type_id"].'" '.$selected.'>'.$type["title"].'</option>';
    }
    // Marques
    foreach($this->brands as $brand) {
        if( $_POST['brand'] == $brand["mcatalogue_brand_id"]) $selected = 'selected';
        else  $selected = '';
        $brandsName .= '<option value="'.$brand["mcatalogue_brand_id"].'" '.$selected.'>'.$brand["title"].'</option>';
    }
    // Orders
    foreach($this->brands as $brand) {
        if( $_POST['order'] == "A"){
          $ordersName = '<option value="A" selected>Croissant</option>';
          $ordersName .= '<option value="D">Décroissant</option>';
        }
        else {
          $ordersName = '<option value="A">Croissant</option>';
          $ordersName .= '<option value="D" selected>Décroissant</option>';
        }
    }

  /*
       <div class="form-group">
         <label>Puissance (kW): </label>
         <input type="number" class="form-control" placeholder="6" value="6" name="power" style="max-width:65px" >
       </div>

       */
    echo (
    '<nav class="navbar navbar-default" id="nav-filter">
      <div class="container-fluid">
        <!-- mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-filter" aria-expanded="false">
            <span class="sr-only">filter</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="navbar-brand">Filtrer</span>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-filter">

          <form class="navbar-form navbar-left" method="post" action="#nav-filter">

            <label>Type: </label>
            <select id="name" name="type" class="form-control">
              <option value="">Tout</option>
            '.$typesName.'
            </select>

            <label>Marque: </label>
            <select name="brand" class="form-control">
              <option value="">Toutes</option>
              '.$brandsName.'
            </select>

              <div class="form-group">
                <label>Prix: </label>
                <select name="order" class="form-control">
                '.$ordersName.'
                </select>
                <button type="valid" class="btn btn-warning">valider</button>
              </div>

          </form>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>');
  }

} // End Class

?>
