{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{section name=Author loop=$attribute.content.author_list sequence=array(bglight,bgdark) }
 {$Author:item.name|wash(xhtml)} - ( <a href="mailto:{$Author:item.email|wash(xhtml)}">{$Author:item.email|wash(email)}</a> )

{delimiter}
,
{/delimiter}
{/section}