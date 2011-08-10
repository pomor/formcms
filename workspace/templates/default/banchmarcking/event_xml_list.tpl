<a href="/?evt=xml&itm=o">Neu</a><br>
{foreach from=$formitems item=itm}
<a href="/?evt=xml&itm={$itm.ID}">{$itm.ID}</a><br>
{/foreach}