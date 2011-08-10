<div id="partner_edit" >
<br><p id="errorfeld" class="showError"></p><br>
<form action="/user_list/savePerson/uid/{$UserID}" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

{if isset($user.ID)}
<input type="hidden" name="id" value="{$user.ID|default:''}">
{/if}
<table width="100%"><tr>
<td width="33%" align=left onclick="editUserBack({$UserID});" valign="middle" style="cursor: pointer;">&nbsp;&nbsp;<img src="{$IMAGES_PATH}arrow_left_green.png" align="left">Login</td>
<td width="33%" align=center onclick="clearWaitStatusDocument();" valign="middle"  style="cursor: pointer; " ><img src="{$IMAGES_PATH}exit.png" ></td>
<td width="33%" >&nbsp;</td>
</tr></table>
Person
<table>
<tr><td>Vorname</td><td><input type="text" name="Vorname" value="{$user.Vorname|default:''}"></td></tr>
<tr><td>Nachname</td><td><input type="text" name="Nachname" value="{$user.Nachname|default:''}"></td></tr>
<tr><td>Geschlecht</td><td>{html_options name=Geschlecht options=$myOptions selected=$user.Geschlecht|default:''}</td></tr>
<tr><td>Geburtsdatum</td><td><input type="text" name="Geburtsdatum" value="{$user.Geburtsdatum|default:''}"></td></tr>
<tr><td>Geburtsort</td><td><input type="text" name="Ort" value="{$user.Ort|default:''}"></td></tr>
<tr><td>Staatsangehorigkeit</td><td><input type="text" name="Staatsangehorigkeit" value="{$user.Staatsangehorigkeit|default:''}"></td></tr>
<tr><td>Herkunft</td><td><input type="text" name="Herkunft" value="{$user.Herkunft|default:''}"></td></tr>
<tr><td>Konfession</td><td><input type="text" name="Konfession" value="{$user.Konfession|default:''}"></td></tr>
<tr><td>Extrainfo</td><td>&nbsp;</td></tr>
<tr><td colspan=2><textarea name="Extrainfo" style="width: 100%; height:100px;">{$user.Extrainfo|default:''}</textarea></td></tr>
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