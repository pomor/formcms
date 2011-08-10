<h2>Modules List&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10px; cursor:pointer;" onclick="Event_Module_Admin_Create()">[Add new Modul]</span></h2>
<form onsubmit="Event_Module_Admin_Update($('#editelement'));return false;">
<table id="modulelist" style="border:#cccccc 1px solid; border-collapse:collapse; " border=1 cellpadding=5>
<tr>
{foreach $items.0 as $k=>$v}
<td style="font-weight:bold;">{$k}</td>
{/foreach}
</tr>

{foreach $items as $item}
<tr rel="{$item.ID}">
{foreach $item as $k=>$v}
{if $k=='ID'}
<td>{$v}</td>
{else}
<td rel="{$k}">{$v}</td>
{/if}
{/foreach}
</tr>
{/foreach}
</table>
</form>

{literal}
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
{/literal}