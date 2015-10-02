
<table name="product" maxparam="4" groupe="mcatalogue" order="true"  >
	<description><![CDATA[<p>Your content catalog</p>]]></description>
	<column>
		<parameter name="title" type="cdata" option="textinput/30/40" ></parameter>
		<parameter name="url" type="cdata" option="textinput/30/40" ></parameter>
		<parameter name="actif" type="string" option="checkboxBooleanreverse" ></parameter>
		<parameter name="price" type="cdata" option="textinput/6/6" ></parameter>	
		<parameter name="image" type="cdata" option="image" ></parameter>
		<parameter name="category" type="string" option="liste/category/title"></parameter>
		<parameter name="short_description" type="cdata" option="textinput/30/40" ></parameter>
		<parameter name="content" type="cdata" option="textarea/10/10"></parameter>	
		<parameter name="details" type="cdata" option="textarea/10/10"></parameter>			
	</column>
	
	<actions name="exec_static_action_plugin" actiontype="alwaysexecute">
		<action_description><![CDATA[Set the url]]></action_description>
		<actions_property><![CDATA[mcatalogue/spxdatas/actions/setUrl.php]]></actions_property>
	</actions>		
</table>

<table name="category" maxparam="3" groupe="mcatalogue" >
	<description><![CDATA[<p>Your content catalog</p>]]></description>
	<column>
		<parameter name="title" type="cdata" option="textinput/30/40" ></parameter>
		<parameter name="url" type="cdata" option="textinput/30/40" ></parameter>
		<parameter name="actif" type="string" option="checkboxBooleanreverse" ></parameter>
		<parameter name="template" type="cdata" option="textinput/30/40" ></parameter>			
	</column>
</table>

<table name="configuration" maxparam="3" maxrecord="1" groupe="mcatalogue" >
	<description><![CDATA[]]></description>
	<column>
		<parameter name="currency" type="cdata" option="textinput/5/5" ></parameter>		
	</column>
</table>