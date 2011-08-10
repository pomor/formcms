{literal}
<script>
	/* entfernt item aud database */
	function Event_Items_List_Delete(id)
	{

		setWaitStatus("#item"+id);

		if(window.confirm("Bestätigen Sie bitte das Löschungseintrag!"))
		{			

			$.get("/lang_admin/del",{ id:id },
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

		$.get("/lang_admin/show",{id:id},
			function(data){
				$("#ajax_content").html(data);
				var $tabs = $( "#tabs" ).tabs();
				$tabs.tabs("select",0);
				//setScEditor();
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
				//setScEditor();
			}


		});

	}


	function delScEditor()
	{
		var $editors = $(".visualEditor");
			    if ($editors.length) {
			        $editors.each(function() {
			            var editorID = $(this).attr("id");
			            var instance = CKEDITOR.instances[editorID];
			            if (instance) { instance.destroy(true); }
			            else {CKEDITOR.replace(editorID)};
			        });
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



	function Event_Lang_Custom_Group()
	{	
		
		if($('#GTYPE').val()=='add new')
			$('#sgtype').html('<input type="text" name="GTYPE" value="">');
	}

	$(document).ready(
		function()
		{
			var ind=window.location.href.indexOf('#');
			if(ind>0)
			{
				var param = window.location.href.substring(ind+1);
				$('#poisk').val(param);
				filterItems('#poisk');				
			}
		}
	);

</script>
{/literal}

<table border=0 width=800>
<tr>
<td align=left><a href="#" onclick="Event_Items_List_Edit(0);return false;" >Element einfügen</a></td>
<td align=center><a href="#" onclick="$('.active0').toggle();return false;" >Alle zeigen</a></td>
<td align=right><input type="text" id="poisk" value="" onkeyup="filterItems(this)" onmouseup="filterItems(this)" placeholder="Suche"></td>
</tr>
</table>

<table border=1 cellpadding=4 cellspacing=0 width=800>
<tr><td width=20>ID</td><td width=90>Group</td><td>Name</td><td width=50>Bearbeiten</td><td width=50>Löschen</td></tr>

{foreach $items as $item}
<tr id="item{$item.ID}">
<td>{$item.ID}</td>
<td onclick="$('#poisk').val($(this).html());filterItems($('#poisk'));" style="cursor:pointer;">{$item.GTYPE}</td>
<td>{$item.NAME}</td>
<td ><a href="#" onclick="Event_Items_List_Edit({$item.ID}); return false;"><img src="{$IMAGES_PATH}edit.png"></a></td>
<td ><a href="#" onclick="Event_Items_List_Delete({$item.ID}); return false;"><img src="{$IMAGES_PATH}delete.png"></a></td></tr>
{/foreach}
</table>
