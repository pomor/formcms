<div id="partner_edit" >
{if $partner.ID > 0}
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
{/if}
<br><br>
<form action="/partner_list/save" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

{if $partner.ID > 0}
<input type="hidden" name="pid" value="{$partner.ID}">
{/if}
<table>
{if $partner.ID > 0}
<tr><td>ID</td><td>{$partner.ID}</td></tr>
{/if}
<tr><td>Name</td><td><input type="text" name="Name" value="{$partner.Name}"></td></tr>
<tr><td>Info</td><td><textarea name="Info" >{$partner.Info}</textarea></td></tr>
<tr><td>Active</td><td>{html_options name=Active options=$myOptions selected=$mySelect}</td></tr>

<tr>
	<td colspan=2 align="center"><input type="submit" value="Änderung Speichern" name="save"></td>
</tr>
{if $save==true}
<tr>
	<td colspan=2 align="center"><br><br>Änderung ist gespeichert. <br>Das Fenster schlißen und Partnerliste aktualisieren
	<a href="/partner_list"><img src="/stylespace/{$FG_SPACE}/images/exit.png" border=0></a></td>
</tr>
{/if}
</table>
</form>

</div>