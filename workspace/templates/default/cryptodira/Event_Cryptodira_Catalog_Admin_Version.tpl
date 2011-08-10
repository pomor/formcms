<form action="/crypt_admin/version_save" onsubmit="sendAjaxForm(this,'#edit_content'); return false;" method="POST">
{if isset($item.ID)}
<input type="hidden" name="id" value="{$item.ID}">
{/if}

<input type="hidden" name="lid" value="{$item.CRYPTO_LINE_ID}">
<input type="hidden" name="sid" value="{$item.CRYPTO_CATALOG_ID}">

ID:{$item.ID|default:'New'}<br><br>
<table>
<tr><td>Name</td><td>:&nbsp;<input type="text" name="VNAME" value="{$item.VNAME|default:''}" style="width:300px"></td></tr>
<tr><td>URL</td><td>:&nbsp;<input type="text" name="URL" value="{$item.URL|default:''}" style="width:300px"></td></tr>
<tr><td>VERSID</td><td>:&nbsp;<input type="text" name="VERSID" value="{$item.VERSID|default:0}" style="width:300px"></td></tr>
<tr><td>UNID</td><td>:&nbsp;<input type="text" name="UNID" value="{$item.UNID|default:''}"  style="width:300px"></td></tr>
</table>

<input type="submit" name="save" value="Save this Version">
</form>


{if isset($save) && $save==true}
<div align=center><br>Änderung ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"} <br>Liste aktualisieren
	<a href="#" onclick="getLines();return false;"><img src="/stylespace/{$FG_SPACE}/images/exit.png" border=0></a></div>
</tr>
{/if}