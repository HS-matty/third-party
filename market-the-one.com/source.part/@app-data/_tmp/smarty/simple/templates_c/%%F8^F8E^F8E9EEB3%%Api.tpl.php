<?php /* Smarty version 2.6.14, created on 2017-04-27 20:12:27
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/simple/App/Market/Api.tpl */ ?>
<h2>Api</h2>

<ul>
	
	<li>Base url: <?php echo $this->_tpl_vars['host_name']; ?>
/api</li>
	<li>Hash: <?php echo $this->_tpl_vars['user']->hash; ?>
</li>
	<li>Postback url: 
		<ul>
			<li>Example: http://somehost?id=<?php echo '{click_id}'; ?>
</li>
			<li>Current: <?php if ($this->_tpl_vars['user']->postback_url):  echo $this->_tpl_vars['user']->postback_url;  else: ?> not set <?php endif; ?> (<a href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/Market/Api/Settings/Form/Edit">change</a>)</li></li>
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



