<div id="lines_list">
<ul>
{foreach $soft.lines as $line}
<li><a href="#" class="soft_line" onclick="showLine({$line.ID}); return false;">{$line.LNAME}</a>&nbsp;&nbsp;(<a href="#" onclick="showVersion(0,{$line.ID}); return false;">+</a>)
<ul>
{foreach $line.versions as $versions}
<li><a href="#" class="soft_version" onclick="showVersion({$versions.ID},{$line.ID}); return false;">{$versions.VNAME}</a></li>
{/foreach}
</ul>
</li>
{/foreach}
</ul>
</div>