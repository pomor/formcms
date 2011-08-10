<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 14:51:46
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_User_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4315104954e3e8a6232c135-34646160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8db694c3567c0b2976ddd85970a55b6b95170545' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_User_List.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4315104954e3e8a6232c135-34646160',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border=0 width=800>
<tr>
<td align=left><a href="#" onclick="editUser(0);return false;" >Benutzer einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle Benutzer zeigen</a></td>
<td align=right><input type="text" value="" onkeyup="filterUser(this)" onmouseup="filterUser(this)" placeholder="Benutzer Suche"></td>
</tr>
</table>


<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr>
<th width=10>ID</th>
<th width=200>Name</th>
<th>Erstellt</th>
<th width=35>Active</th>

<th colspan=2 >&nbsp;</th>
</tr>
<?php  $_smarty_tpl->tpl_vars['User'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('itemlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['User']->key => $_smarty_tpl->tpl_vars['User']->value){
?>
<tr id="prt<?php echo $_smarty_tpl->tpl_vars['User']->value['UserID'];?>
" class="active<?php echo $_smarty_tpl->tpl_vars['User']->value['Active'];?>
">
<td><?php echo $_smarty_tpl->tpl_vars['User']->value['UserID'];?>
</td>
<td><?php echo $_smarty_tpl->tpl_vars['User']->value['Login'];?>
</td>
<td width=150 align=center><?php echo $_smarty_tpl->tpl_vars['User']->value['Created'];?>
</td>
<td align=center><?php echo $_smarty_tpl->tpl_vars['User']->value['Active'];?>
</td>
<td width=20 title="Benutzer Einstellungen bearbeiten"><a href="#" onclick="editUser(<?php echo $_smarty_tpl->tpl_vars['User']->value['UserID'];?>
);return false;" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/edit.png" ></a></td>
<td width=20 title="Benutzer löschen"><a href="#" onclick="deleteUser(<?php echo $_smarty_tpl->tpl_vars['User']->value['UserID'];?>
);return false;" ><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/delete.png" ></a></td>
</tr>
<?php }} ?>
</table>




<script>

function checkPassword()
{
	pass=$('#Pass').val();
	pass2=$('#Pass2').val();

	if(pass && pass != pass2)
	{
		$('#Pass').parent().addClass("showError");
		$('#Pass2').parent().addClass("showError");

		return false;
	}

	$('#Pass').parent().removeClass("showError");
	$('#Pass2').parent().removeClass("showError");

	return true;
}

function filterUser(obj)
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


function deleteUser(id)
{
	setWaitStatus("#prt"+id);

	$.get("/user_list/del",{id:id},
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


function editUser(id)
{
	setWaitStatusDocument(document);

	$.get("/user_list/show",{id:id}, function(content){$("#ajax_content").hide().html(content).slideDown('slow');});

}

function editUserBack(id)
{
	$.get("/user_list/show",{id:id}, function(content){castomAnimation(content);});

}


function editUserPerson(id)
{

	$.get("/user_list/showPerson",{id:id}, function(content){castomAnimation(content);});

}

function editUserKontakt(id)
{

	$.get("/user_list/showKontakt",{id:id}, function(content){castomAnimation(content);});

}


function castomAnimation(content)
{
	pos = $("#partner_edit").offset();
	my_kontent = $("<div align=center></div>").html(content)
					.css('left',pos.left)
					.css('top',pos.top)
					.css('width',$("#partner_edit").width())
					.css('height',$("#partner_edit").height())
					.css('z-index',100)
					.css('position','absolute')
					.hide();


	$('body').append(my_kontent);

	$(my_kontent).html(content).fadeIn('slow', function(){
			$("#ajax_content").html(content).show();
			$(my_kontent).hide().remove();
		});
}



function saveUser()
{

	if(!checkPassword())
	{
		$('#errorfeld').html("Kennnwort und Kennwort2 sollen identisch sein");
		return false;
	}

	return true;	

}


</script>
