<table border=0 width=800>
<tr>
<td align=left><a href="#" onclick="editGruppe(0);return false;" >Gruppe einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle Gruppen zeigen</a></td>
<td align=right><input type="text" value="" onkeyup="filterGruppe(this)" onmouseup="filterGruppe(this)" placeholder="Gruppen Suche"></td>
</tr>
</table>


<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr>
<th width=20>ID</th>
<th width=200>Name</th>
<th>Beschreibung</th>
<th>Erstellt</th>
<th width=35>Aktiv</th>
<th width=65>Benutzer</th>
<th colspan=2 >&nbsp;</th>
</tr>
{foreach $itemlist as $Gruppe}
<tr id="prt{$Gruppe.ID}" class="active{$Gruppe.Active}">
<td width=20>{$Gruppe.ID}</td>
<td>{$Gruppe.Name}</td>
<td>{$Gruppe.Info}</td>
<td width=150 align=center>{$Gruppe.Created}</td>
<td align=center>{$Gruppe.Active}</td>
<td width=65 nowrap><a href="/user_list/list/gid/{$Gruppe.ID}" ><img src="/stylespace/{$FG_SPACE}/images/businessman_view.png" align=left >zeigen</a></td>
<td width=20><a href="#" onclick="editGruppe({$Gruppe.ID});return false;" ><img src="/stylespace/{$FG_SPACE}/images/edit.png" ></a></td>
<td width=20><a href="#" onclick="deleteGruppe({$Gruppe.ID});return false;" ><img src="/stylespace/{$FG_SPACE}/images/delete.png" ></a></td>
</tr>
{/foreach}
</table>

{literal}
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
{/literal}