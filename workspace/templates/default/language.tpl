{foreach $wvkontent as $k=>$v}
<li><div class="sprachicon"><a href="{getUri}?setlang={$k}"><img src="{$IMAGES_PATH}flagge_{$k}.png" width="16" height="16" alt="" border="0"></a></div><a href="{getUri}?setlang={$k}">{$v}</a></li>
{/foreach}            