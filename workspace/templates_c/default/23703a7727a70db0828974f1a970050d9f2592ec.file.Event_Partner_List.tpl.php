<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 15:25:58
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Partner_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7531222594e3e92666ed3d8-23816116%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23703a7727a70db0828974f1a970050d9f2592ec' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Partner_List.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7531222594e3e92666ed3d8-23816116',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border=0 width=800>
<tr>
<td align=left><a href="#" onclick="editPartner(0);return false;" >Partner einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle Partner zeigen</a></td>
<td align=right><input type="text" value="" onkeyup="filterPartner(this)" onmouseup="filterPartner(this)" placeholder="Partner Suche"></td>
</tr>
</table>


<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr>
<th width=10>ID</th>
<th width=100>Name</th>
<th>Beschreibung</th>
<th>Erstellt</th>
<th width=35>Aktiv</th>
<th>Gruppen</th>
<th colspan=3 >&nbsp;</th>
</tr>
<?php  $_smarty_tpl->tpl_vars['partner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('Partners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['partner']->key => $_smarty_tpl->tpl_vars['partner']->value){
?>
<tr id="prt<?php echo $_smarty_tpl->tpl_vars['partner']->value['ID'];?>
" class="active<?php echo $_smarty_tpl->tpl_vars['partner']->value['Active'];?>
">
<td><?php echo $_smarty_tpl->tpl_vars['partner']->value['ID'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['partner']->value['Name'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['partner']->value['Info'];?>
</td>
<td width=150 align=center><?php echo $_smarty_tpl->tpl_vars['partner']->value['Created'];?>
</td>
<td align=center><?php echo $_smarty_tpl->tpl_vars['partner']->value['Active'];?>
</td>
<td width=30 nowrap><a href="/group_list/pid/<?php echo $_smarty_tpl->tpl_vars['partner']->value['ID'];?>
" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/businessman_view.png" align=left >zeigen</a></td>
<td width=50 nowrap><a href="#" onclick="editPartner(<?php echo $_smarty_tpl->tpl_vars['partner']->value['ID'];?>
);return false;" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/edit.png" align=left>edit</a></td>
<td width=60 nowrap><a href="#" onclick="deletePartner(<?php echo $_smarty_tpl->tpl_vars['partner']->value['ID'];?>
);return false;" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/delete.png" align=left>delete</a></td>
</tr>
<?php }} ?>
</table>


<script>
function filterPartner(obj)
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


function deletePartner(id)
{
	setWaitStatus("#prt"+id);

	$.get("/partner_list/del",{ pid:id},
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


function editPartner(id)
{
	setWaitStatusDocument(document);

	$.get("/index.php",{evt:"partner_list", act:"show", pid:id},
		function(data){
			$("#ajax_content").html(data);

		});

}



</script>
