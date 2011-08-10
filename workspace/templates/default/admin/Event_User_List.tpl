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
{foreach $itemlist as $User}
<tr id="prt{$User.UserID}" class="active{$User.Active}">
<td>{$User.UserID}</td>
<td>{$User.Login}</td>
<td width=150 align=center>{$User.Created}</td>
<td align=center>{$User.Active}</td>
<td width=20 title="Benutzer Einstellungen bearbeiten"><a href="#" onclick="editUser({$User.UserID});return false;" ><img src="/stylespace/{$FG_SPACE}/images/edit.png" ></a></td>
<td width=20 title="Benutzer löschen"><a href="#" onclick="deleteUser({$User.UserID});return false;" ><img src="/stylespace/{$FG_SPACE}/images/delete.png" ></a></td>
</tr>
{/foreach}
</table>



{literal}
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
{/literal}