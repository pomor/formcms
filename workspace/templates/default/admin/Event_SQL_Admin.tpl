<form action="/sql_admin" method="POST">
<textarea rows="10" cols="50" name="sql"></textarea><br>
<input type="submit" value="Send SQL request">
</form>
{foreach $result as $elem}
<hr>

SQL:{$elem.sql}<br>

{$items=$elem.data}
<table style="border:#cccccc 1px solid; border-collapse:collapse; " border=1 cellpadding=5>
<tr>
{foreach $items.0 as $k=>$v}
<td style="font-weight:bold;">{$k}</td>
{/foreach}
</tr>

{foreach $items as $item}
<tr >
{foreach $item as $k=>$v}
<td>{$v}</td>
{/foreach}
</tr>
{/foreach}
</table>

{/foreach}