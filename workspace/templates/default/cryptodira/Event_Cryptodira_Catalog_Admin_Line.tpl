<form action="/crypt_admin/line_save" onsubmit="sendAjaxFormLine(this,'#edit_content'); return false;" method="POST">
<div>
{if isset($item.ID)}
<input type="hidden" name="id" value="{$item.ID}">
<input type="hidden" name="sid" value="{$item.CRYPTO_CATALOG_ID}">
{else}
<input type="hidden" name="sid" value="{$sid}">
{/if}
<input type="hidden" name="save" value="Save this Line">
ID:{$item.ID|default:'New'}&nbsp;&nbsp;&nbsp;<input type="submit"  value="Save this Line"><br><br>
Name:<input type="text" name="LNAME" value="{$item.LNAME|default:''}"><br>
Version: <select name="CRYPTO_VERSION_ID" >
<option value="0">Select active version</option>
{html_options options=$versions selected=$item.CRYPTO_VERSION_ID|default:0}
</select>
<br>
Downloads Counter:<input type="text" name="COUNTER" value="{$item.COUNTER|default:''}"><br>
Type: <select name="WF_PAYTYPE" >
{html_options options=$paytype selected=$item.WF_PAYTYPE|default:0}
</select><br>
<div id="tabs2">
<ul>
{foreach $langs as $nlang=>$vlang}
<li><a href="#tabs2_{$nlang}">{$vlang}</a></li>
{/foreach}
</ul>

{foreach $langs as $nlang=>$vlang}
{$item=$item_lang.$nlang|default:''}
<div id="tabs2_{$nlang}">
Info:<br>
<textarea id="line_{$nlang}_INFO_{math equation='rand(1,999999)'}" name="line_{$nlang}_INFO" rows=15 class="visualEditor1">{$item.INFO|default:''}</textarea>

</div>
{/foreach}
</div>
</div>

</form>

{if isset($save) && $save==true}
<div align=center><br>Änderung ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"} <br>Liste aktualisieren
	<a href="#" onclick="getLines();return false;"><img src="/stylespace/{$FG_SPACE}/images/exit.png" border=0></a></div>
</tr>
{/if}