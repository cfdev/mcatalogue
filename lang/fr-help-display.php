<h2>Affichage coté client</h2>
<h3>Utilisation du hook du plugin</h3>
<p>Pour afficher le menu il y a deux possiblités.</p>
<!--<p><img src="../../plugins/spxwbookmarket/lang/img/widget15.jpg" width="50%" height="auto" alt="Gestion des plugins" /></p>-->

<p>Voici un exemple d'usage du hook dans une page statique.</p>
<pre>
&lt;?php
	
	# affichage simple sans keyword
	global $plxShow;
	$o= array();
	$o["format"]='&lt;article class=&quot;bookmarmarket-link&quot;&gt;&lt;header&gt;&lt;h2&gt;&lt;a href=&quot;#url&quot;&gt;#title&lt;/a&gt;&lt;/h2&gt;&lt;/header&gt;&lt;div&gt;#content&lt;/div&gt;&lt;footer&gt;#date&lt;/footer&gt;&lt;/article&gt;';
	echo ($plxShow-&gt;callHook('spxwbookmarket::getBookmarket', $o));

    
   
	# affichage avec keyword
    global $plxShow;
	$o= array();
	$o[&quot;format&quot;]='&lt;article class=&quot;bookmarmarket-link&quot;&gt;&lt;header&gt;&lt;h2&gt;&lt;a href=&quot;#url&quot;&gt;#title&lt;/a&gt;&lt;/h2&gt;&lt;/header&gt;&lt;div&gt;#content&lt;/div&gt;&lt;footer&gt;#date
    &lt;span class=&quot;tags&quot;&gt;#tags&lt;/span&gt;&lt;/footer&gt;&lt;/article&gt;&lt;/span&gt;';
    $o[&quot;formattags&quot;]='&lt;a href=&quot;#url&quot; rel=&quot;tag&quot;&gt;#title&lt;/a&gt;';
    $o[&quot;separatortags&quot;]=', ';
	echo ($plxShow-&gt;callHook('spxwbookmarket::getBookmarketkeyword', $o));
	

</pre>

<p>Il est possible d'utiliser un shortcode à la condition d'avoir installer le plugin spxshortcodes <a href="http://www.secretsitebox.fr/site/index.php?categorie2/pluxml-plugins#post-10" target="_blank">ici</a> (version supérieur ou égal à 1.2) </p>
<p>Voici un exemple d'usage de shortcode pour un affichage simple.</p>
<pre>
[SPXWBOOKMARKET format='&lt;article class=&quot;bookmarmarket-link&quot;&gt;&lt;header&gt;&lt;h2&gt;&lt;a href=&quot;#url&quot;&gt;#title&lt;/a&gt;&lt;/h2&gt;&lt;/header&gt;&lt;div&gt;#content&lt;/div&gt;&lt;footer&gt;#date&lt;/footer&gt;&lt;/article&gt;' ]
</pre>
<p>Voici un exemple d'usage de shortcode pour un affichage avec mots clefs.</p>
<pre>
[SPXWBOOKMARKETKEYWORD format='&lt;article class=&quot;bookmarmarket-link&quot;&gt;&lt;header&gt;&lt;h2&gt;&lt;a href=&quot;#url&quot;&gt;#title&lt;/a&gt;&lt;/h2&gt;&lt;/header&gt;&lt;div&gt;#content&lt;/div&gt;&lt;footer&gt;#date&lt;span class=&quot;tags&quot;&gt;#tags&lt;/span&gt;&lt;/footer&gt;&lt;/article&gt;&lt;/span&gt;' formattags='&lt;a href=&quot;#url&quot; rel=&quot;tag&quot;&gt;#title&lt;/a&gt;' separatortags=', ' ]
</pre>




