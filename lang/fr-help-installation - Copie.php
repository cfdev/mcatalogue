<h2>Installation du plugin</h2>

<h3>1) A noter</h3>
<p><strong>Seul l'administrateur peut modifier la base</strong> (a droite de la liste des différentes tables : &quot;editer base&quot;).</p>
<h3>2) Création d'une base</h3>
<h4>Description d'une base simple avec une table (en rouge):</h4>
<pre>&lt;?xml version=&quot;1.0&quot; encoding=&quot;UTF-8&quot;?&gt;<br />&lt;document&gt;<br />	<span class="red">&lt;table name=&quot;link&quot; &gt;<br />		&lt;description&gt;&lt;![CDATA[Description de la table link]]&gt;&lt;/description&gt;<br />		&lt;column&gt;<br />			&lt;parameter name=&quot;name&quot; type=&quot;cdata&quot; option=&quot;textinput/15/20&quot;&gt;&lt;/parameter&gt;<br />			&lt;parameter name=&quot;description&quot; type=&quot;cdata&quot; option=&quot;textarea/20/1&quot;&gt;&lt;/parameter&gt;<br />			&lt;parameter name=&quot;link&quot; type=&quot;cdata&quot; option=&quot;textinput/30/100&quot;&gt;&lt;/parameter&gt;<br />                        <br />		&lt;/column&gt;<br />	&lt;/table&gt;</span><br />	<br />&lt;/document&gt;</pre>
<p>A noter que vous pouvez spécifier le formatage du champs des textinput et textarea :</p>
<pre><span class="red">&lt;parameter name=&quot;name&quot; type=&quot;cdata&quot; option=&quot;textinput/30/100&quot;&gt;&lt;/parameter&gt;</span></pre>
<p>Le premier paramètre est la taille du champs dans l'admin (size) : ici 30<br />
Le deuxième est le maximum de caractères (maxlength) : ici 100</p>
<p>Les différents types de paramètres possibles :</p>
<pre>&lt;!-- par default 3 possibilités (sans option) --&gt; 
&lt;!-- pour du textarea, texte input... --&gt; <br />&lt;parameter name=&quot;param1&quot; type=&quot;<span class="red">cdata</span>&quot; &gt;&lt;/parameter&gt;
&lt;!-- pour un code par exemple sans formatage particulier --&gt; <br />&lt;parameter name=&quot;param2&quot; type=&quot;<span class="red">string</span>&quot; &gt;&lt;/parameter&gt;
&lt;!-- pour un nombre --&gt; <br />&lt;parameter name=&quot;param3&quot; type=&quot;<span class="red">number</span>&quot; &gt;&lt;/parameter&gt;

&lt;!-- pour aller plus loin --&gt; 

&lt;!-- liste dépendante des entrées d'une autre table--&gt; 
&lt;parameter name=&quot;param4&quot; type=&quot;<span class="red">string</span>&quot; option=&quot;<span class="red">liste/table/name</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- checkbox dépendant des entrées d'une autre table--&gt; 
&lt;parameter name=&quot;param5&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">checkboxliste/table/name</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- selection oui ou non --&gt; 
&lt;parameter name=&quot;param5&quot; type=&quot;<span class="red">string</span>&quot; option=&quot;<span class="red">boolean</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- text input --&gt; 
&lt;parameter name=&quot;param6&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">textinput/size/maxlength</span>&quot;&gt;&lt;/parameter&gt;
&lt;parameter name=&quot;param7&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">text/size/maxlength</span>&quot;&gt;&lt;/parameter&gt;
&lt;parameter name=&quot;param8&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">password/size/maxlength</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- text area --&gt; 
&lt;parameter name=&quot;param9&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">textarea/cols/rows</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- image a sélectionner via une fenetre popup media--&gt; 
&lt;parameter name=&quot;param10&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">image</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- liste des dossiers contenu dans media/images --&gt; 
&lt;parameter name=&quot;directory&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">scandirliste/images</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- affichage d'un calendrier jquery pour enregistrement d'une date --&gt; 
&lt;parameter name=&quot;date&quot; type=&quot;<span class="red">cdata</span>&quot; option=&quot;<span class="red">date</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- liste des du home, statique et catégories pluxml --&gt; 
&lt;parameter name=&quot;url&quot; type=&quot;cdata&quot; option=&quot;<span class="red">listestaticandcat</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- image picker du theme (remplace folder par les dossiers du theme)--&gt; 
&lt;parameter name=&quot;vignette&quot; type=&quot;cdata&quot; option=&quot;<span class="red">imagepickerThemesCurrentTheme/folder</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- image picker du dossier image (remplace folder par les dossiers des images)--&gt; 
&lt;parameter name=&quot;vignette&quot; type=&quot;cdata&quot; option=&quot;<span class="red">imagepickerDataImages/folder</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- color picker --&gt; 
&lt;parameter name=&quot;color1&quot; type=&quot;cdata&quot; option=&quot;<span class="red">colorpicker</span>&quot;&gt;&lt;/parameter&gt;

&lt;!-- rendre un champs en lecture seule (valable aussi pour les listes)--&gt; 
&lt;parameter name=&quot;vignette&quot; type=&quot;cdata&quot; <span class="red">reado=&quot;1&quot;</span> &gt;&lt;/parameter&gt;<br />
</pre>
<h3>3) Note sur les niveaux d'administration</h3>
<p>Le tableau ci-dessous dresse la liste des niveaux d'administration et du code a appliquer pour les autorisations d'accès.</p>
<table width="200" border="1">
  <tr>
    <th>Niveau</th>
    <th>Code</th>
  </tr>
  <tr>
    <td>Administrateur</td>
    <td>0</td>
  </tr>
  <tr>
    <td>Gestionnaire</td>
    <td>1</td>
  </tr>
  <tr>
    <td>Modérateur</td>
    <td>2</td>
  </tr>
  <tr>
    <td>Editeur</td>
    <td>3</td>
  </tr>
  <tr>
    <td>Redacteur</td>
    <td>4</td>
  </tr>
</table>
<h3>4) Autorisation d'accès des tables</h3>
<h4>Autorisation  de lecture de table selon le niveau de l'administrateur.</h4>
<p>Une table peux etre vue ou non selon sa configuration.</p>
<p>Exemple : tableuserlevel=&quot;0,1,2,3,4&quot; defini une table visible par tous.</p>
<p>Exemple 2: tableuserlevel=&quot;0,1,2&quot; defini une table visible par l'administrateur, le gestionnaire et le modérateur.</p>
<pre>&lt;table name=&quot;auteur&quot; maxparam=&quot;4&quot; <span class="red">tableuserlevel=&quot;0,1,2,3,4&quot;</span> tableuserinclude=&quot;&quot; tableuserexclude=&quot;&quot; &gt;</pre>
<h4>Inclusion et exclusion de lecture de table selon l'id de l'administrateur.</h4>
<p>Il est tout a fait possible d'exclure ou d'inclure un utilisateur.</p>
<p>Exemple d'inclusion : tableuserinclude=&quot;004,005&quot; defini une table visible par les utilisateurs id &quot;004&quot; et &quot;005&quot; quel que soit leurs niveaux.</p>
<p>Exemple 2: tableuserexclude=&quot;002&quot; defini une table invisible par l'utilsateur &quot;002&quot; quel que soit son niveau.</p>
<pre>&lt;table name=&quot;auteur&quot; maxparam=&quot;4&quot; tableuserlevel=&quot;0,1,2,3,4&quot; <span class="red">tableuserinclude=&quot;004,005&quot; tableuserexclude=&quot;002&quot;</span> &gt;</pre>
<h3>5) Autorisation d'accès aux données des utilisateurs</h3>
<p>Chaque enregistrement est associé à l'id de son créateur. On a deux choix possible :</p>
<ul>
  <li>L'administrateur voit toutes les données enregistrées de la table. C'est à dire même les enregistrement des autres (option par default).</li>
  <li>L'administrateur voit uniquement ses propres enregistrements.</li>
</ul>
<h4>Autorisation de lecture des enregistrements selon le niveau de l'administrateur.</h4>
<p>Une table peux etre vue ou non selon sa configuration.</p>
<p>Exemple : datauserlevel=&quot;0,1,2,3,4&quot;. Tout le monde voit les enregistrement de tout le monde.</p>
<p>Exemple 2: datauserlevel=&quot;0,1,2&quot; . Ici seul  l'administrateur, le gestionnaire et le modérateur peuvent voir l'ensemble des enregistrements. Les autres ne peuvent voir que leur propre enregistrements.</p>
<pre>&lt;table name=&quot;auteur&quot; maxparam=&quot;4&quot; <span class="red">datauserlevel=&quot;0,1,2&quot;</span> datauserinclude=&quot;&quot; datauserexclude=&quot;&quot; &gt;</pre>
<h4>Inclusion et exclusion des enregistrements selon l'id de l'administrateur.</h4>
<p>Il est tout a fait possible d'exclure ou d'inclure un utilisateur.</p>
<p>Exemple d'inclusion : datauserinclude=&quot;004,005&quot;. les utilisateur 004 et 005 quel que soit leurs niveaux peuvent voir tous les enregistrements de la table.</p>
<p>Exemple d'exclusion : datauserexclude=&quot;002&quot;. L'utilisateur  002 quel que soit son niveau ne peux voir que ses propres enregistrements.</p>
<pre>&lt;table name=&quot;auteur&quot; maxparam=&quot;4&quot; datauserlevel=&quot;0,1,2,3&quot; <span class="red">datauserinclude=&quot;004,005&quot; datauserexclude=&quot;002&quot;</span> &gt;
</pre>
<h3>6) Fixer les droits d'action</h3>
<p>Vous pouvez fixer définir les droits d'action pour la création, la modification et la destruction d'un enregistrement.</p>
<p>Le code est CMD (creation, modification, delete).</p>
<p>111 : (par default) permet de créer modifier et detruire</p>
<p>000 : impossible de créer, de modifier ou de supprimer (lecture seule)</p>
<p>010 : seul la modification est possible</p>
<p>Exemple : <span class="red">rightCMDlevel=&quot;3:010,4:010&quot;</span>. Les utilisateurs de niveau 3 et 4 peuvent juste modfier les champs des tables. Pas de création ni de modification possible.</p>
<pre>&lt;table name=&quot;auteur&quot; <span class="red">rightCMDlevel=&quot;4:010&quot;</span> &gt;</pre>
<p>Définir des droits selon l'id de l'administrateur.</p>
<p>Exemple : <span class="red">rightCMDuser=&quot;004:010&quot;</span> l'utilisateur 004 peux juste modfier les champs des tables. Pas de création ni de modification.</p>
<h3>7) Forcer le maximum de paramètre visible dans l'admin générale.</h3>
<p>Vous pouvez fixer le nombre maximum de champs visibles dans l'admin générale pour chaque table.</p>
<pre>&lt;table name=&quot;auteur&quot; <span class="red">maxparam=&quot;4&quot;</span> &gt;
</pre>
<h3>8) Fixer le nombre maximum de record possible</h3>
<p>Vous pouvez fixer le nombre maximum d'enregistrements pour une table d'un point de vue global et du point de vue du &quot;user_id&quot;.</p>
<p>Maximum d'enregistrement totale. Le nombre fixé a 1 permet de créer de créer directement des formulaires dans le plugin ce qui peux visuellement être très pratique.</p>
<pre>&lt;table name=&quot;auteur&quot; <span class="red">maxrecord=&quot;100&quot;</span> &gt;</pre>
<p>Maximum d'enregistrement pour un utilsateur</p>
<pre>&lt;table name=&quot;auteur&quot; <span class="red">maxrecorduser=&quot;10&quot;</span> &gt;
</pre>
<h3>9) Ajouter la possibilité de manipuler l'ordre des données</h3>
<p>Vous pouvez définir l'activation de l'order permettre la gestion manuelle de l'ordre dans les entrées.</p>
<pre>&lt;table name=&quot;auteur&quot; <span class="red">order=&quot;true&quot;</span> &gt;</pre>
<h3>10) Classer les tables en groupe</h3>
<p>Vous pouvez grouper vos tables pour des raisons pratiques (un onglet de l'administration est un groupe).</p>
<pre>&lt;table name=&quot;auteur&quot; <span class="red">groupe=&quot;artistes&quot;</span>&gt;</pre>
<h3>11) Choisir le format d'enregistrement des données</h3>
<p>Vous pouvez choisir le format d'enregistrement (xml ou json). Par default l'enregistrement est en xml.</p>
<pre>&lt;table name=&quot;auteur&quot; <span class="red">dataformat=&quot;json&quot;</span>&gt;</pre>

<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<h3>&nbsp;</h3>
<p>&nbsp;</p>
<p>- </p>
<p>&nbsp;</p>
