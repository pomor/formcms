{literal}
<script>



$(document).ready(function(){
	var $tabs = $("#tabs").tabs();
	$tabs.tabs("select",0);

	var $tabs1 = $("#tabs1").tabs();
	$tabs1.tabs("select",0);

	setScEditor();
});



	var manager = new ImageManager('/extmodule/ImageManager','en');

    ImageSelector =
	{
		update : function(params)
		{

			if(this.field && this.field.value != null)
			{
				this.field.value = params.f_file; //params.f_url
				this.imageDIV.attr('src',params.f_file);

			}
		},
		select: function(textfieldID,imageDIV,bw,bh)
		{
			this.field = document.getElementById(textfieldID);
            this.imageDIV=$(imageDIV).children('img');
            this.bw=bw;
            this.bh=bh;

			manager.popManager(this);
		}
	};



    function showKategory()
    {
    	setWaitStatusDocument(document);

    	$.get("/crypt_admin/kategory_show",{id:0},
    		function(data){
    			$("#ajax_content").html(data);
    		});
    }


    function addKategory(id,name)
    {
        $('#WF_KATEGORY').append(new Option(name,id,true,true));
        clearWaitStatusDocument();
    }

    function showLine($id)
    {
    	$('#edit_content').hide();
    	$.get("/crypt_admin/line_show/id/"+$id,
    			function(data){
    				$("#edit_content").html(data);
    				setScEditor(".visualEditor1");
    				var $tabs1 = $("#tabs2").tabs();
    				$tabs1.tabs("select",0);
    				$('#edit_content').slideDown();
    			});

    }

    function showVersion($id,$lid)
    {
        $('#edit_content').hide();
        $.get("/crypt_admin/version_show/id/"+$id+"/lid/"+$lid,
    			function(data){
    				$("#edit_content").html(data);
    				$('#edit_content').slideDown();

    			});

    }


    function getLines()
    {
        $('#lines_list').hide();
        $.get("/crypt_admin/line_list",
    			function(data){
    				$("#lines_list").html(data);
    				$('#lines_list').slideDown();

    			});

    }
    
    
    function sendAjaxFormLine(formobj,showobject)
    {
    	updateScEditor(".visualEditor1");
    	var content = $(formobj).serialize();

    	var act=$(formobj).attr('action')||'/index.php';

    	$.ajax({
    		url: act,
    		type: 'POST',
    		data: content,
    		dataType: "html",
    		success: function(data){
    			$(showobject).html(data);
    			setScEditor(".visualEditor1");
    			var $tabs1 = $("#tabs2").tabs();
    			$tabs1.tabs("select",0);
    		},
    		beforeSend: function(){
    			setWaitStatusKind(showobject);
    		}

    	});

    }


</script>
{/literal}

<div id="tabs1">

<ul>
<li><a href="#tabs1_soft">Soft</a></li>
{if isset($soft.ID)}
<li><a href="#tabs1_line">Lines and Versions</a></li>
<li><a href="#tabs1_screens">Screenshots</a></li>

{/if}
</ul>


<div id="tabs1_soft">

<form action="/crypt_admin/soft_save"  method="POST">

{if isset($soft.ID)}
<input type="hidden" name="id" value="{$soft.ID}">
{/if}
<input type="hidden" value="{$soft.ICON|default:''}" name="ICON" id="ICON" />
<table >
<tr><td>ID</td><td>{$soft.ID|default:'New'}</td></tr>
<tr><td>Icon</td><td style="cursor:pointer" onclick="ImageSelector.select('ICON',this,48,48);"><img src="{$soft.ICON|default:"$IMAGES_PATH/bicon.png"}"></td></tr>
<tr><td>Name</td><td><input type="text" name="NAME" value="{$soft.NAME|default:''}" style="width:300px" maxlength=255"></td></tr>

<tr><td>Kategory</td><td>
<select name="WF_KATEGORY" id="WF_KATEGORY" style="width:300px">
{html_options options=$kategory selected=$soft.WF_KATEGORY|default:0}
</select>&nbsp;<a href="#" onclick="showKategory();return false;">add</a>
</td></tr>

<tr><td>Type</td><td>
<select name="WF_PAYTYPE" id="WF_PAYTYPE" style="width:300px">
{html_options options=$paytype selected=$soft.WF_PAYTYPE|default:0}
</select>
</td></tr>

<tr><td>Tags</td>
<td>
<textarea name="TAGS" style="width:300px" >{$soft.TAGS|default:''}</textarea></td>
</tr>

</table>

<br>

<div id="tabs">
<ul>
{foreach $langs as $nlang=>$vlang}
<li><a href="#tabs_{$nlang}">{$vlang}</a></li>
{/foreach}
</ul>

{foreach $langs as $nlang=>$vlang}
{$item=$item_lang.$nlang|default:''}
<div id="tabs_{$nlang}">
<table width="450">

<tr><td>Info:<br><textarea id="{$nlang}_INFO" name="{$nlang}_INFO" style="width:450px" rows=20 class="visualEditor">{$item.INFO|default:''}</textarea></td></tr>
<tr><td>AGB:<br><textarea id="{$nlang}_AGB" name="{$nlang}_AGB" style="width:450px"  rows=20 class="visualEditor">{$item.AGB|default:''}</textarea></td></tr>
</table>
</div>
{/foreach}
</div>

<table width="450">
<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Eintrag Speichern" name="save"></td>
</tr>
{if isset($save) && $save==true}
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br>{$smarty.now|date_format:"%d-%m-%Y %H:%M:%S"} <br>Das Fenster schlißen und Softlist aktualisieren
	<a href="/crypt_admin"><img src="{$IMAGES_PATH}exit.png" border=0></a></td>
</tr>
{/if}
</table>

</form>
</div>
{if isset($soft.ID)}
<div id="tabs1_line">
<a href="#" onclick="showLine(0); return false;">Add New Line</a>
<div id="edit_content" style="display: none;">&nbsp;</div>
<div id="lines_list">
{include file='cryptodira/Event_Cryptodira_Catalog_Admin_Lines_List.tpl'}
</div>
</div>

<div id="tabs1_screens">
{event room='cryptodira' class='Event_Cryptodira_Galerie_Admin' method='actionGalerieList'}
</div>
{/if}

</div>

