<div class="padding10px">
<div class="titelblau1 borderblau2px">{$catalog_title|default:$catalog_lang.Top_Rated_Programm}</div>
<br>
{foreach $items as $soft}
{$soft.ID} / {$soft.NAME} {$soft.LNAME} {$soft.VNAME}  inserted: {$soft.CDATE} 

	<div class="prbutton">
	<div class="{if $soft.STATUS==0}waitfull{else}activefull{/if}"><a href="#" class="button"
		title="{$catalog_lang.installed}" >{if $soft.STATUS==0}{$catalog_lang.status_wait}{else}{$catalog_lang.installed}{/if}</a></div>	
	</div> {if $soft.STATUS==0}delete{/if}
	<!-- Iwill-Button ende -->
	<div class="clear"></div>
	
<br> 
{/foreach}

<div class="clear"></div>
</div>


