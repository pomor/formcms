{literal}
<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width:800px}
#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em;  height: 18px;  }
#sortable li img{ display: block; }

.selected_menu
{
	background-color: #cccccc;
}


</style>

<script>

/* entfernt menu from database */
function Event_Menu_Item_Delete(id,gid)
{

	setWaitStatus("#item"+id);

	if(window.confirm("Bestätigen Sie bitte das Löschungseintrag!"))
	{

		$.get("/menu_admin/menudel",{ id:id, gid:gid},
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
function Event_Menu_Item_Edit(id,gid)
{
	setWaitStatusDocument(document);

	$.get("/menu_admin/menushow",{id:id, gid:gid},
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


	$(document).ready(
		function(){

			correctLvl();
			$( "#sortable" ).sortable();
			
			$("#sortable > li").click(
				function()
				{
					if($(this).hasClass('selected_menu'))
					{
						$(this).removeClass('selected_menu');
					}
					else
					{
						$(this).addClass('selected_menu');
					}
				}
			);
		}
	);


	function plusLvl()
	{
		$(".selected_menu").each(
			function(){
				setLvl(this,1);
			}
		);

		correctLvl();
	}

	function minusLvl()
	{
		$(".selected_menu").each(
			function(){
				setLvl(this,-1);
			}
		);

		correctLvl();
	}

	function correctLvl()
	{
		var allLi = $("#sortable > li");


		for(var i=0; i<allLi.length; i++)
		{
			var elem=$(allLi[i]);
			var val= parseInt(elem.children("input:[name^='lvls']").val());

			if(i==0 && val>0)
			{
				val=0;
				elem.children("input:[name^='lvls']").val(0);
			}
			else if(i>0)
			{
				var vorlvl=parseInt($(allLi[i-1]).children("input:[name^='lvls']").val());
				if(val-vorlvl > 1)
				{
					val=vorlvl+1;
					elem.children("input:[name^='lvls']").val(val);
				}
			}

			elem.css('padding-left',(val*1.5+1.5)+"em");
			
		}		
	}

	function setLvl(obj,val)
	{		
		var nwval= parseInt($(obj).children("input:[name^='lvls']").val())+val;

		if(nwval<0)nwval=0;
		
		$(obj).children("input:[name^='lvls']").val(nwval);
	}

	function deselect()
	{
		$(".selected_menu").removeClass('selected_menu');
	}
	

</script>
{/literal}

<table border=0 width=800>
<tr>
<td align=left><a href="#" onclick="Event_Menu_Item_Edit(0,{$gid});return false;" >Menu einfügen</a></td>
<td align=center><a href="#" onclick="$('#form_menu_ord').submit();return false;" >Reinfolge speichern</a></td>
<td align=center >
<div style="float:left; padding:5px;"><a href="#" onclick="minusLvl();return false;" title="Level Down" ><img src="{$IMAGES_PATH}arrow_left_green.png"></a></div>
<div style="float:left; padding:5px;"><a href="#" onclick="deselect();return false;" title="Deselect" style="float:left"><img src="{$IMAGES_PATH}check.png"></a></div>
<div style="float:left; padding:5px;"><a href="#" onclick="plusLvl();return false;" title="Level Up" style="float:left"><img src="{$IMAGES_PATH}arrow_right_green.png"></a></div>
<div style="clear:left"></div></td>
<td align=right><input type="text" value="" onkeyup="filterItems(this)" onmouseup="filterItems(this)" placeholder="Suche"></td>
</tr>
</table>

<form action="/" method="post" id="form_menu_ord">
<input type="hidden" name="evt" value="menu_admin">
<input type="hidden" name="act" value="menuord">
<input type="hidden" name="gid" value="{$gid}">
<ul id="sortable">
{foreach $items as $item}
<li id="item{$item.ID}">
<input type="hidden" name="items[]" value="{$item.ID}">
<input type="hidden" name="lvls[]" value="{$item.Lvl}">
<table><tr>
<td nowrap style="cursor: hand">{$item.Name}</td>
<td><a href="#" onclick="Event_Menu_Item_Edit({$item.ID},{$gid}); return false;"><img src="{$IMAGES_PATH}edit.png"></a></td>
<td><a href="#" onclick="Event_Menu_Item_Delete({$item.ID},{$gid}); return false;"><img src="{$IMAGES_PATH}delete.png"></a></td>
</tr></table>
</li>
{/foreach}
</ul>
</form>
