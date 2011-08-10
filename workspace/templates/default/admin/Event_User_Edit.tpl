<div id="partner_edit" style="width:400px" >
{if $user.UserID > 0}
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
{/if}
<br><p id="errorfeld" class="showError"></p><br>
<form action="/user_list/save" onsubmit="if(saveUser())sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

{if $user.UserID > 0}
<input type="hidden" name="uid" value="{$user.UserID}">

<table width="100%"><tr>
<td width="33%" align=left onclick="editUserKontakt('{$user.UserID}');" valign="middle"  style="cursor: pointer; ">&nbsp;&nbsp;<img src="{$IMAGES_PATH}arrow_left_green.png" align="left">Kontakt</td>
<td width="33%" align=center onclick="clearWaitStatusDocument();" valign="middle"  style="cursor: pointer;" ><img src="{$IMAGES_PATH}exit.png" ></td>
<td width="33%" align=right onclick="editUserPerson('{$user.UserID}');" valign="middle"  style="cursor: pointer;">Person<img src="{$IMAGES_PATH}arrow_right_green.png" align="right">&nbsp;&nbsp;</td>
</tr></table>
{/if}
<table>
{if $user.UserID > 0}
<tr><td>ID</td><td>{$user.UserID}</td></tr>
{/if}
<tr><td>Login</td><td><input type="text" name="Login" value="{$user.Login}"></td></tr>
<tr><td>Kennwort</td><td><input type="password" name="Pass" id="Pass" value="" onkeyup="checkPassword()"></td></tr>
<tr><td>Kennwort2</td><td><input type="password" name="Pass2" id="Pass2" value="" onkeyup="checkPassword()"></td></tr>
<tr><td>Active</td><td>{html_options name=Active options=$myOptions selected=$mySelect}</td></tr>

<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Änderung Speichern" name="save"></td>
</tr>
{if $save==true}
<tr>
	<td colspan=2 align="center"><br><br>Änderung ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"} <br>Das Fenster schlißen und Benutzerliste aktualisieren
	<a href="/user_list"><img src="/stylespace/{$FG_SPACE}/images/exit.png" border=0></a></td>
</tr>
{/if}
</table>
</form>

</div>