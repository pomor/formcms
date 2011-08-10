<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 22:00:42
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Module_Admin_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8410357274e3dbef9977434-28450970%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '085f14bbd02f60c5a43779b8ec84e2892e6aa41b' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Module_Admin_List.tpl',
      1 => 1312783600,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8410357274e3dbef9977434-28450970',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h2>Modules List&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10px; cursor:pointer;" onclick="Event_Module_Admin_Create()">[Add new Modul]</span></h2>
<form onsubmit="Event_Module_Admin_Update($('#editelement'));return false;">
<table id="modulelist" style="border:#cccccc 1px solid; border-collapse:collapse; " border=1 cellpadding=5>
<tr>
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
<td style="font-weight:bold;"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</td>
<?php }} ?>
</tr>

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr rel="<?php echo $_smarty_tpl->tpl_vars['item']->value['ID'];?>
">
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['k']->value=='ID'){?>
<td><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</td>
<?php }else{ ?>
<td rel="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</td>
<?php }?>
<?php }} ?>
</tr>
<?php }} ?>
</table>
</form>


<script>
var edit_element=false;
var temp_value="";


function Event_Module_Admin_Create()
{
	$.getJSON('/module/create',function(data){
		if(data.STATUS=='OK')
		{
			var elem = $('#modulelist tr[rel]').first().clone();
			
			elem.attr('rel',data.MODUL.ID);
			elem.css('background-color','#ffff00');

			elem.find('td').text('');

			elem.find('td[rel]').dblclick(function(){
				Event_Module_Admin_Edit(this);
			});

			elem.find('td').eq(0).text(data.MODUL.ID);

			elem.insertAfter($('#modulelist tr').first());

							
		}
		else if(data.STATUS=='FOUND')
		{
			$("tr[rel='"+data.MODUL.ID+"']").css('background-color','#ffff00');
		}
		else
		{
			alert(data.STATUS);
		}

	});	
}


function Event_Module_Admin_Update(obj)
{
	var id=obj.parent().parent().attr('rel');
	var name=obj.parent().attr('rel');
	var value=obj.val();

	$.getJSON('/module/update',{id:id,name:name,val:value},function(data){
	
		if(data.STATUS=='OK')
		{
			temp_value=value;
			Event_Module_Admin_Reset();
		}
		else
		{
			alert(data.STATUS+data.MYSQL);
		}
	});

	
	
	
}


function Event_Module_Admin_Reset()
{

	var obj=$('#editelement');

	if(obj)
	{			
		obj.parent().text(temp_value);
	}

	edit_element=false;
}


function Event_Module_Admin_Edit(obj)
{
	if(edit_element)
	{
		Event_Module_Admin_Reset();
	}


	edit_element=true;
	
	var target=$(obj);

	var id=target.parent().attr('rel');	
	var name=target.attr('rel');
	var value=target.text();

	temp_value=value;
	
	var elem=$('<input id="editelement"/>');
	elem.val(value);
		
	target.text('');
	elem.appendTo(target);	
}

$(document).ready(function(){
	$("td[rel]").dblclick(function(){
		Event_Module_Admin_Edit(this);
	});

	$("td[rel]").attr('title','Edit on Dblclick');

	$(document).keyup(function(event){
		if(event.keyCode=='27')
		{
			if(edit_element)
			{
				Event_Module_Admin_Reset();
			}
		}
	});
});


</script>
