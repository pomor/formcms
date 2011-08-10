<ul>
{$last_level=0}
{foreach from=$menuar  item=menu}
{if $last_level>0 && $menu.lvl <$last_level}
{section name=test loop=$last_level - $menu.lvl}
</ul></li>
{/section}
{/if}

{$last_level=$menu.lvl}

<li><a href="{$menu.url}" target="{$menu.target}" class="button {if $menu.active==true}active{/if}">{$menu.text}</a>
{if $menu.parent==true}
<ul>
{else}
</li>
{/if}
{/foreach}
{section name=test2 loop=$last_level}
</ul></li>
{/section}
</ul>
