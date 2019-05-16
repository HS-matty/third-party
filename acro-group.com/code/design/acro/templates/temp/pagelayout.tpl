
{* Set your top category here *}
{let top_cat=2
     used_node=false()}

{* See if we have already a node id otherwise use the top category as current node *}
{section show=is_set($DesignKeys:used.node)}
        {set used_node=$DesignKeys:used.node}
{section-else}
        {set used_node=$top_cat}
{/section}

{* Get a proper node object *}
{let node_obj=fetch(content,node,hash(node_id,$used_node))}

{* FIRST LEVEL *}
{section loop=fetch(content,list,hash(parent_node_id,$top_cat, class_filter_type, "include", class_filter_array, array(1),sort_by,array(array(priority))))}
- <a class="path" href={concat("/content/view/full/",$:item.node_id,"/")|ezurl}>{$:item.name}</a><br />

        {* SECOND LEVEL *}
        {section  loop=fetch(content,list,hash(parent_node_id,$:item.node_id, class_filter_type, "include", class_filter_array, array(1),sort_by,array(array(priority))))}
                -- <a class="path" href={concat("/content/view/full/",$:item.node_id,"/")|ezurl}>{$:item.name}</a><br />

               
        {/section}
{/section}
{/let}
{/let}
<br>
  {$module_result.content}
