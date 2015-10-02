<?php if(!defined('PLX_ROOT')) exit; ?>
<style type="text/css">
#spxwbookmarket_help img {
	margin:5px;
	border: 1px solid #999;
}
#spxwbookmarket_help p {
	margin-bottom:5px;
}
#spxwbookmarket_help pre {
	font-size:14px;
	border: 1px solid #999;
	padding: 20px;
	white-space: pre-wrap;
	word-wrap: break-word;
	background-color: #FFF;
}
#spxwbookmarket_help .red {color:red;}


#spxwbookmarket_help ul.tabnav {
	margin:25px 0 0 0;
	padding:0 0 20px 10px;
	border-bottom:1px solid #025b87
}
	#spxwbookmarket_help  ul.tabnav li {
		margin:0;
		padding:0;
		display:inline;
		list-style-type:none;
		float:left
	}
	#spxwbookmarket_help ul.tabnav a:link, ul.tabnav a:visited {
		line-height:14px;font-weight:bold;margin:0 10px 4px 10px;text-decoration:none;color:#0084c5
	}
	#spxwbookmarket_help ul.tabnav li.active a:link, ul.tabnav li.active a:visited, ul.tabnav a:hover {
		border-bottom:4px solid #025b87;padding-bottom:2px;background:#fff;color:#025b87
	}
	#spxwbookmarket_help ul.tabnav a:hover {
		color:#025b87
	}
#spxwbookmarket_help h3 {
	margin: 12px 0px 7px 0px;
	padding: 0px;
	font-size: 18px;
	color: #555;
}
#spxwbookmarket_help h4 {
	margin: 12px 0px 7px 0px;
	padding: 0px;
	font-size: 15px;
	color: #555;
}
#spxwbookmarket_help ul,
#spxwbookmarket_help ol {
  padding: 0;
  margin: 0 0 10px 25px;
  
}



#spxwbookmarket_help li {
  line-height: 20px;
}

#spxwbookmarket_help ul.unstyled,
#spxwbookmarket_help ol.unstyled {
  margin-left: 0;
  list-style: none;
}

#spxwbookmarket_help ul.inline,
#spxwbookmarket_help ol.inline {
  margin-left: 0;
  list-style: none;
}

#spxwbookmarket_help ul.inline > li,
#spxwbookmarket_help ol.inline > li {
  display: inline-block;
  *display: inline;
  padding-right: 5px;
  padding-left: 5px;
  *zoom: 1;
}
#spxwbookmarket_help li {background: url(../../plugins/spxwbookmarket/img/list_arrow.png) no-repeat 0% 50%; padding: 0 0 0 16px;}

#spxwbookmarket_help .field_head {
	font-size: 18px;
	margin-top: 20px;
}

</style>
<?php

if(isset($_GET['page'])) {
	$page = $_GET['page'];
}else{
	$page = "start";
}
?>

<div id="spxwbookmarket_help">
    <h2>Configuration et aide sur le plugin spxwbookmarket</h2>
    <ul class="tabnav">
      <li <?php if ($page=="start") echo ('class="active"'); ?>>
       <a href="parametres_pluginhelp.php?p=spxwbookmarket&page=start" title="Pour commencer" target="_self">Pour commencer</a>
      </li>
       <li <?php if ($page=="configuration") echo ('class="active"'); ?>>
        <a href="parametres_pluginhelp.php?p=spxwbookmarket&page=configuration" title="configuration de spxwbookmarket" target="_self">Configuration</a>
      </li>
      <li <?php if ($page=="widget") echo ('class="active"'); ?>>
        <a href="parametres_pluginhelp.php?p=spxwbookmarket&page=widget" title="Création du widget" target="_self">Création widget</a>
      </li>
      <li <?php if ($page=="display") echo ('class="active"'); ?>>
        <a href="parametres_pluginhelp.php?p=spxwbookmarket&page=display" title="Affichage du widget" target="_self">Affichage coté client</a>
      </li>
    </ul>

	<?php include('fr-help-'.$page.'.php'); ?>



</div>