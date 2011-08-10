<div class="padding10px">
<div class="titelblau1 borderblau2px">#{$catalog_title|default:$catalog_lang.Top_Rated_Programm}</div>
<br>
{foreach $items as $soft}
{$tid=$soft.ID}
      <!-- Programmblock klein anfang: 1x -->
            <div class="progklein">
                <div class="prtitel"><a href="/crypt_catalog/show/id/{$soft.ID}" title="{$soft.NAME}" class="button">{substrp maxlen=20}{$soft.NAME}{/substrp}</a>
                <!-- Plus V: wenn ein programm Versionen hat anfang -->
                {if $soft.LINECOUNTER > 1}
                <div class="plusv">
                	<a href="/crypt_catalog/show/id/{$soft.ID}" title="{$catalog_lang.more_versions}">
                	<img src="{$IMAGES_PATH}plusv_button.png" width="19" height="19" alt="" border="0">
                	</a>
                </div>
                {/if}
                <!-- Plus V ende -->
                </div>
                <div class="prbild"><a href="/crypt_catalog/show/id/{$soft.ID}" class="button" title="{$soft.NAME}"><img src="{$soft.ICON|default:"$IMAGES_PATH/bicon.png"}" width="48" height="48" alt="" border="0"></a></div>
                {$katname=$soft.WF_KATEGORY}
                <div class="prcategory"><a href="/crypt_catalog/show/id/{$soft.ID}" class="button">{$kataloglist.$katname}</a></div>
                <div class="prbewertung"><img src="{$IMAGES_PATH}sterne4.png" width="83" height="15" alt=""> [33]</div>
                <div class="prbutton">
                    <div class="{if isset($mysoft.$tid)}active{else}iwill{/if}"><a href="/crypt_catalog/show/id/{$soft.ID}" class="button" title="{$catalog_lang.Programm_installieren}">{if isset($mysoft.$tid)}{$catalog_lang.installed}{else}{$catalog_lang.i_wish}{/if}</a></div>
                    <div class="plus"><a href="#" onclick="addToFavorite({$soft.ID},12300,this,false); return false;" class="button" title="{$catalog_lang.favorit_insert}"><img src="{$IMAGES_PATH}_neue-buttons/{if isset($favoritelist.$tid)}plus_klein_gruen{else}plus_klein_grau{/if}.png" width="20" height="20" alt="" border="0"></a></div>
                </div>
            </div>
      <!-- programmblock klein ende: 1x  -->
{/foreach}

<div class="clear"></div>
</div>


