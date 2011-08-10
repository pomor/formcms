<div id="partner_edit" >
<br><p id="errorfeld" class="showError"></p><br>
<form action="/user_list/saveKontakt"  onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

<input type="hidden" name="uid" value="{$UserID}">
{if isset($user.ID)}
<input type="hidden" name="id" value="{$user.ID|default:''}">
{/if}
<table width="100%"><tr>
<td width="33%">&nbsp;</td>
<td width="33%" align=center onclick="clearWaitStatusDocument();" valign="middle"  style="cursor: pointer;" ><img src="{$IMAGES_PATH}exit.png"></td>
<td width="33%" align=right onclick="editUserBack({$UserID});" valign="middle"  style="cursor: pointer;">Login<img src="{$IMAGES_PATH}arrow_right_green.png" align="right">&nbsp;&nbsp;</td>
</tr></table>
Kontakt
<table>

<tr><td>Land</td><td><input type="text" name="Land" value="{$user.Land|default:''}"></td></tr>
<tr><td>Bundesland</td><td><input type="text" name="Bundesland" value="{$user.Bundesland|default:''}"></td></tr>
<tr><td>Ort</td><td><input type="text" name="Ort" value="{$user.Ort|default:''}"></td></tr>
<tr><td>Plz</td><td><input type="text" name="Plz" value="{$user.Plz|default:''}"></td></tr>
<tr><td>Bezirk</td><td><input type="text" name="Bezirk" value="{$user.Bezirk|default:''}"></td></tr>
<tr><td>Strasse</td><td><input type="text" name="Strasse" value="{$user.Strasse|default:''}"></td></tr>
<tr><td>Hausnummer</td><td><input type="text" name="Hausnummer" value="{$user.Hausnummer|default:''}"></td></tr>
<tr><td>Postfach</td><td><input type="text" name="Postfach" value="{$user.Postfach|default:''}"></td></tr>
<tr><td>Private Telefon</td><td><input type="text" name="P_Telefon" value="{$user.P_Telefon|default:''}"></td></tr>
<tr><td>Private Mobil</td><td><input type="text" name="P_Mobil" value="{$user.P_Mobil|default:''}"></td></tr>
<tr><td>Private Fax</td><td><input type="text" name="P_Fax" value="{$user.P_Fax|default:''}"></td></tr>
<tr><td>Private Email</td><td><input type="text" name="P_Email" value="{$user.P_Email|default:''}"></td></tr>
<tr><td>Dienst Telefon</td><td><input type="text" name="F_Telefon" value="{$user.F_Telefon|default:''}"></td></tr>
<tr><td>Dienst Mobil</td><td><input type="text" name="F_Mobil" value="{$user.F_Mobil|default:''}"></td></tr>
<tr><td>Dienst Fax</td><td><input type="text" name="F_Fax" value="{$user.F_Fax|default:''}"></td></tr>
<tr><td>Dienst Email</td><td><input type="text" name="F_Email" value="{$user.F_Email|default:''}"></td></tr>

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