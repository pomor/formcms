<div id="div_permissions" >
<br>
<b>Custom Permissions</b>
<br><br>
<form action="/perm/save" onsubmit="sendAjaxForm(this,$('#div_permissions').parent()); return false;" method="POST">

<input type="hidden" name="oid" value="{$oid}">
<input type="hidden" name="otype" value="{$otype}">

<table>

<tr><td>Benutzer Rechte</td><td>{html_options name=PERM_RECHTE options=$perms selected=$selperm}</td></tr>
<tr><td>Eingelogt</td><td>{html_options name=LOGIN options=$myOptions selected=$sellogin}</td></tr>
<tr><td colspan=2>
{foreach $modulen as  $tmp}
<tr><td>{$tmp[0]}</td><td>{html_options name=$tmp[1] options=$myOptions  selected=$tmp[2]}</td></tr>
{/foreach}
</td>
</tr>
<tr>
	<td colspan=2 align="center"><input type="submit" value="Änderung Speichern" name="save"></td>
</tr>
{if $save==true}
<tr><td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"}</td></tr>
{/if}

</table>
</form>

</div>