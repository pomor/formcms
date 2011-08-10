{literal}
<script>
	/* entfernt item aud database */
	function Event_Items_List_Delete(id)
	{

		setWaitStatus("#item"+id);

		if(window.confirm("Bestätigen Sie bitte das Löschungseintrag!"))
		{

			$.get("/item_admin/del",{id:id },
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
	function Event_Items_List_Edit(id)
	{
		setWaitStatusDocument(document);

		$.get("/item_admin/show",{id:id},
			function(data){
				$("#ajax_content").html(data);
				var $tabs = $( "#tabs" ).tabs();
				$tabs.tabs("select",0);
				setScEditor();
			});

	}

	/* speichert änderung oder generiert neu item */
	function Event_Items_List_Save(formobj)
	{

		updateScEditor();

		var formcontent = $(formobj).serialize();
		var act=$(formobj).attr('action')||'/index.php';
		
		$.ajax({
			url: act,
			type: 'POST',
			data: formcontent,
			dataType: "html",
			success: function(data){
				$('#ajax_content').html(data);
				var $tabs = $( "#tabs" ).tabs();
				$tabs.tabs("select",0);
				setScEditor();
			}


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
<td align=left><a href="#" onclick="Event_Items_List_Edit(0);return false;" >Element einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle zeigen</a></td>
<td align=right><input type="text" value="" onkeyup="filterItems(this)" onmouseup="filterItems(this)" placeholder="Suche"></td>
</tr>
</table>

<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr><td>ID</td><td>Title</td><td>Erstellt</td><td>Bearbeiten</td><td>Löschen</td></tr>

{foreach $items as $item}
<tr id="item{$item.ID}">
<td>{$item.ID}</td>
<td>{$item.TITLE}</td>
<td>{$item.CREATED}</td>
<td><a href="#" onclick="Event_Items_List_Edit({$item.ID}); return false;"><img src="{$IMAGES_PATH}edit.png"></a></td>
<td><a href="#" onclick="Event_Items_List_Delete({$item.ID}); return false;"><img src="{$IMAGES_PATH}delete.png"></a></td></tr>
{/foreach}
</table>
