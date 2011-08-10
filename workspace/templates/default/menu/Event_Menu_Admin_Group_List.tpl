{literal}
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
{/literal}

<table border=0 width=800>
<tr>
<td align=left><a href="#" onclick="Event_Menu_List_Edit(0);return false;" >Element einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle zeigen</a></td>
<td align=right><input type="text" value="" onkeyup="filterItems(this)" onmouseup="filterItems(this)" placeholder="Suche"></td>
</tr>
</table>

<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr><td>ID</td><td>Name</td><td>Erstellt</td><td>Gruppen</td><td>Bearbeiten</td><td>Löschen</td></tr>

{foreach $items as $item}
<tr id="item{$item.ID}">
<td>{$item.ID}</td>
<td>{$item.NAME}</td>
<td>{$item.CREATED}</td>
<td width=30 nowrap><a href="/menu_admin/menulist/gid/{$item.ID}" ><img src="/stylespace/{$FG_SPACE}/images/businessman_view.png" align=left >zeigen</a></td>
<td><a href="#" onclick="Event_Menu_List_Edit({$item.ID}); return false;"><img src="{$IMAGES_PATH}edit.png"></a></td>
<td><a href="#" onclick="Event_Menu_List_Delete({$item.ID}); return false;"><img src="{$IMAGES_PATH}delete.png"></a></td></tr>
{/foreach}
</table>
