{literal}
<SCRIPT LANGUAGE="JavaScript">
<!--
function parse(id,title){
window.opener.document.getElementById({/literal}"{$id}{literal}_user_value").innerHTML = {/literal}'{$PathStr}'{literal};
window.opener.document.getElementById({/literal}"{$id}{literal}_puser_value").value = title;
window.opener.document.getElementById({/literal}"{$id}{literal}").value = id;

self.close();
}

// -->
</SCRIPT>
{/literal}

{foreach from=$TreePath item=p}
<a href="?id={$id}&cid={$p.category_id}">{$p.short_description} </a> / 
{/foreach}

{if $Locations}<h2>{$LevelTitle}</h2>{/if}
<br>
<ul>
{foreach from=$Categories item=c}
<li><a href="?id={$id}&cid={$c.category_id}">{$c.short_description}</a> (<a href="#" onClick="parse({$c.category_id},'{$c.short_description}')">choose</a>)</li>
{/foreach}
</ul>
