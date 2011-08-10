<div id="partner_edit" style="width:400px; height:500px" >
{if isset($item.ID)}
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
{/if}
<br><br>
<form action="/menu_admin/groupsave" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

{if isset($item.ID)}
<input type="hidden" name="gid" value="{$item.ID}">
{/if}


<table width="300">
<tr><td>Name:<br><input type="text" name="NAME" value="{$item.NAME|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>Info:<br><input type="text" name="INFO" value="{$item.INFO|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td align="center"><br><br><input type="submit" value="Gruppe Speichern" name="save"></td></tr>
</table>

<table width="300">
{if isset($save) && $save==true}
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"}
</td>
</tr>
{/if}
<tr><td align=center><br>Das Fenster schlißen und Itemliste aktualisieren
	<a href="/menu_admin"><img src="{$IMAGES_PATH}exit.png" border=0></a></td></tr>
</table>

</form>

</div>