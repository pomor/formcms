<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 00:22:20
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menu/Event_Menu_Admin_Group_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17569986494e3dbe9c8c8136-35116122%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '38250d1a2482d7651cfe0b6b2f6f1224e8593b7d' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menu/Event_Menu_Admin_Group_List.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17569986494e3dbe9c8c8136-35116122',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<script>
	/* entfernt item aud database */
	function Event_Menu_List_Delete(id)
	{

		setWaitStatus("#item"+id);

		if(window.confirm("Bestätigen Sie bitte das Löschungseintrag!"))
		{

			$.get("/menu_admin/groupdel",{gid:id },
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






	/* edit item in popup fenster */
	function Event_Menu_List_Edit(id)
	{
		setWaitStatusDocument(document);

		$.get("/menu_admin/groupshow",{gid:id},
			function(data){
				$("#ajax_content").html(data);
			});

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
<td align=left><a href="#" onclick="Event_Menu_List_Edit(0);return false;" >Element einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle zeigen</a></td>
<td align=right><input type="text" value="" onkeyup="filterItems(this)" onmouseup="filterItems(this)" placeholder="Suche"></td>
</tr>
</table>

<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr><td>ID</td><td>Name</td><td>Erstellt</td><td>Gruppen</td><td>Bearbeiten</td><td>Löschen</td></tr>

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr id="item<?php echo $_smarty_tpl->tpl_vars['item']->value['ID'];?>
">
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['ID'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['NAME'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['CREATED'];?>
</td>
<td width=30 nowrap><a href="/menu_admin/menulist/gid/<?php echo $_smarty_tpl->tpl_vars['item']->value['ID'];?>
" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/businessman_view.png" align=left >zeigen</a></td>
<td><a href="#" onclick="Event_Menu_List_Edit(<?php echo $_smarty_tpl->tpl_vars['item']->value['ID'];?>
); return false;"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
edit.png"></a></td>
<td><a href="#" onclick="Event_Menu_List_Delete(<?php echo $_smarty_tpl->tpl_vars['item']->value['ID'];?>
); return false;"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
delete.png"></a></td></tr>
<?php }} ?>
</table>
