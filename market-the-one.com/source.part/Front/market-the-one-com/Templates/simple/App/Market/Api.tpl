<h2>Api</h2>

<ul>
	
	<li>Base url: {$host_name}/api</li>
	<li>Hash: {$user->hash}</li>
	<li>Postback url: 
		<ul>
			<li>Example: http://somehost?id={literal}{click_id}{/literal}</li>
			<li>Current: {if $user->postback_url}{$user->postback_url}{else} not set {/if} (<a href="{$host_name}/app/Market/Api/Settings/Form/Edit">change</a>)</li></li>
		</ul>
	
	<li>Functions</li>
		<ul>
			<li>/offers  : get partners offers</li>
				<ul>
					<li>params:</li>
						<ul>
							<li>all=1 : get all available offers</li>
						</ul>
				</ul>
			</li>
			
		<li>/clicks  : get partners clicks</li>
				
			</li>
		</ul>

</ul>




