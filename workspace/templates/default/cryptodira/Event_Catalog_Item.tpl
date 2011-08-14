<div class="padding10px">
<!-- the tabs angang -->
	<ul class="tabs">
		<li><a href="#">Information</a></li>
		<li><a href="#">Screenshots</a></li>
		<li><a href="#">Komentare</a></li>
	</ul>
	<!-- the tabs ende --> 
	<!-- tab "panes" anfang -->
	<div class="panes"><!-- Beshcreibung Anfang -->
	<div class="pan">

	<div class="titelblau1 borderblau2px">{$item.NAME}<div class="plus"><a href="#" onclick="addToFavorite({$item.ID},12300,this,true); return false;" class="button" title="{$catalog_lang.favorit_insert}"><img src="{$IMAGES_PATH}_neue-buttons/{if $infavorite}plus_full_gruen{else}plus_full_grau{/if}.png" width="20" height="20" alt="" border="0"></a></div>
                </div>
	<!-- Lines "accordeon" Anfang -->
	<div id="accordion">
	
	{foreach $item['lines'] as $line}
	{if !$line.VID}{continue}{/if}
	{$tid=$line.ID}
	<!-- Version Tab Anfang -->
	<div class="lines">
	<div class="prtitel"
		title="{$line.LNAME}">{$line.LNAME} &nbsp;-&nbsp; {$line.VNAME} </div>
	<div class="prdate">Aktualisiert: {$line.UDATE}</div>
	<!-- Iwill-Button Anfang -->
	<div class="prbutton">
	<div class="{if isset($mysoft.$tid)}activefull{else}iwillfull{/if}"><a href="#" class="button"
		title="{$catalog_lang.Programm_installieren}" onclick="addToMysoft({$line.ID},this,true);return false;">{if isset($mysoft.$tid)}{$catalog_lang.installed}{else}{$catalog_lang.Install}{/if}</a></div>
	
	</div>
	<!-- Iwill-Button ende -->
	<div class="clear"></div>
	</div>
	<!-- Version Tab ende --> 
	
	<!-- Version Beschreibung Anfang -->
	<div class="pane">{$line.INFO}</div>
	<!-- Version Beschreibung ende -->
	{/foreach}

	</div>
	<!-- Lines "accordeon" ende --> 
	<br>
	<br>
	<div class="prabout">
	<div class="titelgruen1 borderdashedgrau">Beschreibung</div>
	<br>
	{$item_lng.INFO}</div>
	<div class="wrap1x">
	<div class="padright52"><!-- Iwill-Button Anfang -->
	

	<!-- Iwill-Button ende --> <br>
	<br>
	<!-- Detailsbox anfang -->
	<div class="details">
	<ul>
		{$katname=$item.WF_KATEGORY}
		<li><span class="textgrau1 caps">Kategorie:</span><br>
		<a href="/crypt_catalog/{$item.WF_KATEGORY}">{$kataloglist.$katname}</a></li>
	<!--  	<li><span class="textgrau1 caps">Creator:</span><br>
		<a href="#">{$item.FG_PERSON_ID}</a></li> -->
		{$typename=$item.WF_PAYTYPE}
		<li><span class="textgrau1 caps">Typ:</span><br>
		<a href="/crypt_catalog/select/type/{$typename}">{$softtype.$typename}</a></li>		
		<li><span class="textgrau1 caps">Online seit:</span><br>
		{$item.CDATE}</li>
		<li><span class="textgrau1 caps">Aktualisiert:</span><br>
		{$item.UDATE}</li>
		<li><span class="textgrau1 caps">User Bewertung:</span><br>
		<img src="{$IMAGES_PATH}sterne{$item.RATING_USER}.png" width="83"
			height="15" alt=""> [{$item.RATING_USER_COUNT}]</li>
		<li><span class="textgrau1 caps">Expert Bewertung:</span><br>
		<img src="{$IMAGES_PATH}sterne{$item.RATING_PRO}.png" width="83"
			height="15" alt=""> [{$item.RATING_PRO_COUNT}]</li>
	
		<li><span class="textgrau1 caps">Publisher:</span><br>
		{$item.FG_USER_ID}</li>
		<!-- <li><span class="textgrau1 caps">Tags:</span><br>
		<a href="#">Internet</a>, <a href="#">Foto</a>, <a href="#">Video</a>,
		<a href="#">Tasks</a>, <a href="#">Kalender</a>, <a href="#">Fignja</a></li>  -->
	</ul>
	</div>
	<!-- Deteilsbox ende --> <br>
	<br>
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style "><a
		href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4e07577333281a4f"
		class="addthis_button_compact">Share</a> <span
		class="addthis_separator">|</span> <a
		class="addthis_button_preferred_1"></a> <a
		class="addthis_button_preferred_2"></a> <a
		class="addthis_button_preferred_3"></a> <a
		class="addthis_button_preferred_7"></a> <a
		class="addthis_button_preferred_9"></a></div>
	<script type="text/javascript"
		src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e07577333281a4f"></script>
	<!-- AddThis Button END --> <br>
	<br>
	</div>
	</div>
	</div>
	<!-- Beshcreibung ende --> <!-- Screenshots Anfang -->
	<div class="pan" align="center">
	<div class="titelblau1 borderblau2px" align="left">{$item.NAME}</div>
	<br>
	<div id="dropbox" style="min-height: 100px;">
		<div id="imagelist">
		{foreach $images as $image}
		<a href="/content/images/galery/{$item.ID}/{$image.PATH}" class="galery_images">
		<img  src="/content/images/galery/{$item.ID}/thumbs/{$image.PATH}"/>
		</a>
		{/foreach}
		</div>
		<br clear="all"/>
		</div>
	</div>
	<!-- Screenshots ende --> <!-- Komentare Anfang -->
	<div class="pan">
	<div class="titelblau1 borderblau2px">{$item.NAME}</div>
	da commt commentare
	</div>
	<!-- komentare ende -->
	</div>
	<!-- tab "panes" ende -->
</div>
<script>

document.title="{$item.NAME}";

//{literal}

// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
	$("#accordion").tabs("#accordion div.pane", {tabs: 'div.lines', effect: 'slide', initialIndex: null});
	$(".iwill").click(function(){			
		document.location.href=$(this).children('a').attr('href');
		return false;
		}
	);

	$('.galery_images').lightBox();
	
});


//{/literal}
</script>
