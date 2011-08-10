<div id="partner_edit" style="width:600px; height:500px" >

<form action="/crypt_admin/kategory_save" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

{if isset($item.ID)}
<input type="hidden" name="id" value="{$item.ID}">
{/if}

<div>ID: &nbsp; {$item.ID|default:'New'}</div>

<table width="550">
<tr><td>Name:<br><input type="text" name="name" value="{$item.name|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>Value:<br><input type="text" name="val" value="{$item.val|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>Info:<br><input type="text" name="info" value="{$item.info|default:''}" style="width:100%" maxlength=255></td></tr>
<tr><td>Order:<br><input type="text" name="ord" value="{$item.ord|default:0}" style="width:30px" maxlength=5></td></tr>
{foreach $langs as $nlang=>$vlang}

{$litem=$item_lang.$nlang|default:''}
<tr><td>{$vlang}:<br>
<input type="text" name="{$nlang}_LNG" value="{$litem.LNG|default:''}" style="width:100%" maxlength=255 >
</td></tr>

{/foreach}
</table>

<table width="550">
<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Eintrag Speichern" name="save"></td>
</tr>
{if isset($save) && $save==true}
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"} <br>Das Fenster schlißen und add Kategory
	<a href="#" onclick="addKategory({$item.ID},'{$item.name}'); return false;"><img src="{$IMAGES_PATH}exit.png" border=0></a></td>
</tr>
{/if}
</table>

</form>

</div>