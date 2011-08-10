<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 14:53:45
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Group_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3895701164e3e8ad9e94ec0-85522933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c7871eec22e0f9ff08c497301385336c3702e8f' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Group_List.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3895701164e3e8ad9e94ec0-85522933',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border=0 width=800>
<tr>
<td align=left><a href="#" onclick="editGruppe(0);return false;" >Gruppe einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle Gruppen zeigen</a></td>
<td align=right><input type="text" value="" onkeyup="filterGruppe(this)" onmouseup="filterGruppe(this)" placeholder="Gruppen Suche"></td>
</tr>
</table>


<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr>
<th width=10>ID</th>
<th width=200>Name</th>
<th>Beschreibung</th>
<th>Erstellt</th>
<th width=35>Aktiv</th>
<th width=65>Benutzer</th>
<th colspan=2 >&nbsp;</th>
</tr>
<?php  $_smarty_tpl->tpl_vars['Gruppe'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('itemlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['Gruppe']->key => $_smarty_tpl->tpl_vars['Gruppe']->value){
?>
<tr id="prt<?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['ID'];?>
" class="active<?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['Active'];?>
">
<td><?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['ID'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['Name'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['Info'];?>
</td>
<td width=150 align=center><?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['Created'];?>
</td>
<td align=center><?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['Active'];?>
</td>
<td width=65 nowrap><a href="/user_list/gid/<?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['ID'];?>
" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/businessman_view.png" align=left >zeigen</a></td>
<td width=20><a href="#" onclick="editGruppe(<?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['ID'];?>
);return false;" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/edit.png" ></a></td>
<td width=20><a href="#" onclick="deleteGruppe(<?php echo $_smarty_tpl->tpl_vars['Gruppe']->value['ID'];?>
);return false;" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/delete.png" ></a></td>
</tr>
<?php }} ?>
</table>


<script>
function filterGruppe(obj)
{
	var fText = $(obj).val();

	if(fText.length > 0 )
	{
		$("tr[id^='prt']").each(function(){
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
		$("tr[id^='prt']").show();
		$('.active0').hide();
	}
}


function deleteGruppe(id)
{
	setWaitStatus("#prt"+id);

	$.get("/group_list/del",{id:id},
		function(data){
			clearWaitStatus();
			if(data=='OK'){
				$("#prt"+id).addClass('active0');
			}
			else
			{
				alert(data);
			}
		});
}


function editGruppe(id)
{
	setWaitStatusDocument(document);

	$.get("/group_list/show",{id:id},
		function(data){
			$("#ajax_content").html(data);

		});

}



</script>
