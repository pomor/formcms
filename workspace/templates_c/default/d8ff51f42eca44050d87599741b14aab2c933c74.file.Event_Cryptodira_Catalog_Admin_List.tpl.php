<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 22:00:39
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16661352654e3c484b659f75-66284099%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8ff51f42eca44050d87599741b14aab2c933c74' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_List.tpl',
      1 => 1312783648,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16661352654e3c484b659f75-66284099',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<script>
	/* entfernt item aud database */
	function Event_Items_List_Delete(id)
	{

		setWaitStatus("#item"+id);

		if(window.confirm("Bestätigen Sie bitte das Löschungseintrag!"))
		{

			$.get("/crypt_admin/soft_delete",{ id:id },
				function(data){

					if(data=='OK')
					{
						$('#item'+id).remove();
					}
					else
					{
						alert(data);
					}

					clearWaitStatus();
				});

		}
		else
		{
			clearWaitStatus();
		}
	}
	


	function filterItems(obj)
	{
		var fText = $(obj).val();

		if(fText.length > 0 )
		{
			$("tr[id^='item']").each(function(){
				if($(this).children("td:contains('"+fText+"')").length > 0)
				{
					$(this).show();
				}
				else
				{
					$(this).hide();
				}
			});
		}
		else
		{
			$("tr[id^='item']").show();
			$('.active0').hide();
		}
	}
	

</script>


<table border=0 width=800>
<tr>
<td align=left><a href="/crypt_admin/soft_show/id/0"  >Soft einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle zeigen</a></td>
<td align=right><input type="text" id="poisk" value="" onkeyup="filterItems(this)" onmouseup="filterItems(this)" placeholder="Suche"></td>
</tr>
</table>

<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr>
<td>ID</td>
<td>Icon</td>
<td>Name</td>
<td>Lines</td>
<td>Prio</td>
<td>Created</td>
<td>Updated</td>
<td width=50>Edit</td>
<td width=50>Delete</td>
</tr>

<?php  $_smarty_tpl->tpl_vars['soft'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['soft']->key => $_smarty_tpl->tpl_vars['soft']->value){
?>
<tr id="item<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
">
<td><?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
</td>
<td><img src="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['soft']->value['ICON'])===null||$tmp==='' ? '' : $tmp);?>
"></td>
<td><?php echo $_smarty_tpl->tpl_vars['soft']->value['NAME'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['soft']->value['LINECOUNTER'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['soft']->value['ORD'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['soft']->value['CDATE'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['soft']->value['UDATE'];?>
</td>
<td ><a href="/crypt_admin/soft_show/id/<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
edit.png"></a></td>
<td ><a href="#" onclick="Event_Items_List_Delete(<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
); return false;"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
delete.png"></a></td>
</tr>
<?php }} ?>

</table>