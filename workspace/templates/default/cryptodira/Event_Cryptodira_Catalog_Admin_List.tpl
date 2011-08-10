{literal}
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
{/literal}

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

{foreach $items as $soft}
<tr id="item{$soft.ID}">
<td>{$soft.ID}</td>
<td><img src="{$soft.ICON|default:''}"></td>
<td>{$soft.NAME}</td>
<td>{$soft.LINECOUNTER}</td>
<td>{$soft.ORD}</td>
<td>{$soft.CDATE}</td>
<td>{$soft.UDATE}</td>
<td ><a href="/crypt_admin/soft_show/id/{$soft.ID}"><img src="{$IMAGES_PATH}edit.png"></a></td>
<td ><a href="#" onclick="Event_Items_List_Delete({$soft.ID}); return false;"><img src="{$IMAGES_PATH}delete.png"></a></td>
</tr>
{/foreach}

</table>