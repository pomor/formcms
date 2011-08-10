<form name='fg_tabl01_val' method='POST' enctype='multipart/form-data'>
{$content}
<input type='submit' value='Speichern' name='save_action'>
</form>

{literal}
<script>
$(".h1 .title").click(function(){
	$(this).parent().next(".inhalt").slideToggle();
});

$(".h3 .title").click(function(){
	return false;
});

$(document).ready(function(){
	$('[check^="MSK_"]').blur(function(){
			var val = $(this).val();
			var val_type = $(this).attr('check');
			var val_new= fg_CheckVals(val, val_type);
			if(val_new == null)
			{
				if(val != "")
				{
					alert("Daten format ist falsch");
					$(this).css('background-color','#CC0000');
					$(this).focus();
					$(this).select();
				}
			}
			else
			{
				$(this).val(val_new);
				$(this).css('background-color','#FFFFFF');
			}
		});

});




	if( !String.sprintf ) {
	 String.sprintf = sprintf;
	}

</script>
{/literal}
