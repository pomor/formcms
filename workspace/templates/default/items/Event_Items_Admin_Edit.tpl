<div id="partner_edit" style="width:900px; height:700px" >
{if isset($item_idx.ID)}
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
{/if}
<br><br>
<form action="/item_admin/save" onsubmit="Event_Items_List_Save(this); return false;" method="POST">

{if isset($item_idx.ID)}
<input type="hidden" name="id" value="{$item_idx.ID}">
{/if}

<div>ID: &nbsp; {$item_idx.ID|default:'New'}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sysname: &nbsp; <input type="text" name="SYSNAME" value="{$item_idx.SYSNAME|default:rand(10000000000,99999999999999999)}"><br>
Kategory:&nbsp;<input type="text" name="KATEGORY" value="{$item_idx.KATEGORY|default:''}" style="width:80%" maxlength=255></td></tr>
</div>
<div id="tabs">
<ul>
{foreach $langs as $nlang=>$vlang}
<li><a href="#tabs_{$nlang}">{$vlang}</a></li>
{/foreach}
</ul>

{foreach $langs as $nlang=>$vlang}
{$item=$item_lang.$nlang|default:''}
<div id="tabs_{$nlang}">
<table width="850">
<tr><td>Title:<br><input type="text" name="{$nlang}_TITLE" value="{$item.TITLE|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>Info:<br><textarea id="{$nlang}_INFO" name="{$nlang}_INFO" cols=60 rows=20 class="visualEditor">{$item.INFO|default:''}</textarea></td></tr>
<tr><td>Meta Keywords:<br><input type="text" name="{$nlang}_META" value="{$item.META|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>Tags:<br><input type="text" name="{$nlang}_TAGS" value="{$item.TAGS|default:''}" style="width:100%" maxlength=255></td></tr>

<tr><td>Active: <select name="{$nlang}_ACTIVE">{html_options options=$myOptions selected=$item.ACTIVE|default:1}</select></td></tr>
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
	<a href="/item_admin"><img src="{$IMAGES_PATH}exit.png" border=0></a></td>
</tr>
{/if}
</table>

</form>

</div>