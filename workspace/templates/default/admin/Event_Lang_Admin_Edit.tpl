<div id="partner_edit" style="width:900px; height:700px" >

<br><br>
<form action="/lang_admin/save" onsubmit="Event_Items_List_Save(this); return false;" method="POST">

{if isset($item_idx.ID)}
<input type="hidden" name="id" value="{$item_idx.ID}">
{/if}


<div>ID: &nbsp; {$item_idx.ID|default:'New'}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sysname: &nbsp; <input type="text" name="NAME" value="{$item_idx.NAME|default:''}">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Group: &nbsp;<span id='sgtype' title="{$item_idx.GTYPE|default:''}"><select name="GTYPE" id='GTYPE' onchange="Event_Lang_Custom_Group();">{html_options output=$groups values=$groups selected=$item_idx.GTYPE|default:''}</select></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="delScEditor(); return false;">Toggle Visual Editor</a>
</div>


<div id="tabs">
<ul>
{foreach $langs as $lang}
<li><a href="#tabs_{$lang.name}">{$lang.val}</a></li>
{/foreach}
</ul>

{foreach $langs as $lang}
{$nlang=$lang.name}
{$item=$item_lang.$nlang|default:''}
<div id="tabs_{$nlang}">
<table width="850">
<tr><td>Content:<br><textarea id="{$nlang}_CONTENT" name="{$lang.name}_CONTENT" cols=60 rows=20 class="visualEditor" style="width:100%">{$item.CONTENT|default:''}</textarea></td></tr>
</table>
</div>
{/foreach}
</div>

<table width="750">
<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Eintrag Speichern" name="save"></td>
</tr>
{if isset($save) && $save==true}
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"} <br>Das Fenster schlißen und Itemliste aktualisieren
	<a href="/lang_admin/dum/{$smarty.now|date_format:"%d%m%Y%H%M%S"}#{$item_idx.GTYPE|default:''}"><img src="{$IMAGES_PATH}exit.png" border=0></a></td>
</tr>
{/if}
</table>

</form>

</div>