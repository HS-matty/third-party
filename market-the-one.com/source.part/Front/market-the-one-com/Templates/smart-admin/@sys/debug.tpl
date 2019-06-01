
	<br>
<div class="_container" style="font-size:12px;padding-left:40px;padding-top:15px;background-color:#DFDFDF;width:1000px">
	<h4>Common log:</h4>
	
		<ol>
		{foreach from=$log->getMessageList() item=msg}
			<li>{$msg}</li>
		{/foreach}
		</ol>


	<h4>SQL log:</h4>
	
		<ol>
		{foreach from=$log->getMessageList('sql') item=msg_sql}
			<li>{$msg_sql}</li>
		{/foreach}
		</ol>
	
	<h4>User:</h4>
	
		{if $user->id}
		<ol>
			<ul>id: {$user->id}</ul>
			<ul>email: {$user->email}</ul>
			<ul>type: {$user->type}</ul>
			<ul>role: {$user->role}</ul>
		</ol>
		{else}
			no user
		{/if}
		
	<h4>Default templates:</h4>
	<ul>
	{foreach from=$window->workspace item=ui_element}
	
	{assign value=$ui_element->getType() var=type }
	{assign var=file value = "/@ui/@element/$type.tpl"}

		<li>{$type}: {$file}</li>
	{/foreach}
	</ol>
	</h4>
		<br />
		<br />
		<br />
		
</div>
