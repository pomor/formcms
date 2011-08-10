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
{foreach $Partners as $partner}
<tr id="prt{$partner.ID}" class="active{$partner.Active}">
<td>{$partner.ID}</td>
<td>{$partner.Name}</td>
<td>{$partner.Info}</td>
<td width=150 align=center>{$partner.Created}</td>
<td align=center>{$partner.Active}</td>
<td width=30 nowrap><a href="/group_list/pid/{$partner.ID}" ><img src="/stylespace/{$FG_SPACE}/images/businessman_view.png" align=left >zeigen</a></td>
<td width=50 nowrap><a href="#" onclick="editPartner({$partner.ID});return false;" ><img src="/stylespace/{$FG_SPACE}/images/edit.png" align=left>edit</a></td>
<td width=60 nowrap><a href="#" onclick="deletePartner({$partner.ID});return false;" ><img src="/stylespace/{$FG_SPACE}/images/delete.png" align=left>delete</a></td>
</tr>
{/foreach}
</table>

{literal}
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
{/literal}