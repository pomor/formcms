<div id="partner_edit" style="width:600px; height:500px" >
{if isset($item.ID)}
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
{/if}
<br><br>
<form action="/menu_admin/menusave/gid/{$gid}" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

{if isset($item.ID)}
<input type="hidden" name="id" value="{$item.ID}">
{/if}

<div>ID: &nbsp; {$item.ID|default:'New'}</div>

<table width="550">
<tr><td>Sysname:<br><input type="text" name="Name" value="{$item.Name|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>URL:<br><input type="text" name="Url" value="{$item.Url|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>Menu Event:<br><input type="text" name="Event" value="{$item.Event|default:''}" style="width:100%" maxlength=255></td></tr>
{foreach $langs as $nlang=>$vlang}
{$litem=$item_lang.$nlang|default:''}
<tr><td>Language {$nlang|upper}:<br>
<input type="text" name="{$nlang}_NAME" value="{$litem.NAME|default:''}" style="width:100%" maxlength=255 ondblclick="$('#{$lang.name}_INFO').toggle();">
<br><span><textarea id="{$nlang}_INFO" name="{$lang.name}_INFO" cols=60 rows=10 style="width:100%; display: none;" >{$litem.INFO|default:''}</textarea></span>
</td></tr>



{/foreach}
</table>

<table width="550">
<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Eintrag Speichern" name="save"></td>
</tr>
{if isset($save) && $save==true}
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"} <br>Das Fenster schlißen und Menuliste aktualisieren
	<a href="#" onclick="$('#form_menu_ord').submit(); return false;"><img src="{$IMAGES_PATH}exit.png" border=0></a></td>
</tr>
{/if}
</table>

</form>

</div>