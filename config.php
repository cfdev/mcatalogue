<?php if(!defined('PLX_ROOT')) exit; ?>
<?php
if(!empty($_POST)) {
$plxPlugin->setParam('mnuName', $_POST['mnuName'], 'string');
$plxPlugin->setParam('template', $_POST['template'], 'string');
$plxPlugin->saveParams();
header('Location: parametres_plugin.php?p=mcatalogue');
exit;
}
?>
<h2>Configuration</h2>
<p>Paramètres du catalogue</p>
<form action="parametres_plugin.php?p=mcatalogue" method="post">

Nom : <input type="text" name="mnuName" value="<?php echo
plxUtils::strCheck($plxPlugin->getParam('mnuName')) ?>" /><br />
Template : <input type="text" name="template" value="<?php echo
plxUtils::strCheck($plxPlugin->getParam('template')) ?>" /><br />
<br />
<input type="submit" name="submit" value="Enregistrer" />
</form>