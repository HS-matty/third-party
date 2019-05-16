
node_id = {$node.name}<br>
{let men=fetch(content,list,hash(parent_node_id,2))}
	
	{section name=lp loop=$men}
		<a href={$lp:item.name|ezurl}>{$lp:item.name}</a> <br/>
		{let men2=fetch(content,list,hash(parent_node_id,$lp:item.node_id))}
			{section name=lp2 loop=$me2}
			<br> s_id: {$men2.node_id}
			{/section}
		{/let}
	{/section}



{/let}


  {$module_result.content}
