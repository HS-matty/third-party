<?php /* Smarty version 2.6.14, created on 2017-05-03 19:52:41
         compiled from file:D:%5Cdev%5Cweb-server-root%5Ccms/Static/Articles/Api.tpl */ ?>
<h2>Api @ Market-The-One.com (v0.7) DRAFT</h2>

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


	<?php echo '
	<li>Available functions:
		
		<ul>
			<li><strong>/offers</strong>  : get offers
				<ul>
					<li>params:</li>
						<ul>
							<li>all=1 (optional): get all available offers</li>
							<li>mto_offer_id[] (optional): get selected  offers</li>
							<li>page={int}  (optional): page number</li>
							<li>order_by (optional) ={field_name}</li>
						</ul>
					<li>example 1: http(s)://market-the-one.com/api/offers/?hash={your_hash}&page=0</li>
					<li>example 2: http(s)://market-the-one.com/api/offers/?hash={your_hash}&mto_offer_id[]=1&mto_offer_id[]=2</li>
				</ul>
			
			</li>
			<li><strong>/offer</strong> : get a single offer
					<ul>
					<li>params:</li>
						<ul>
							<li>{id|mto_offer_id}: MTO-Offer-ID</li>
							<li>mto_partner_id : MTO-Partner-ID</li>
							<li>partner_click_id : Partner-Click-ID</li>
							<li>partner_source_id (optional) : Partner-Source-ID</li>
						</ul>
					<li>example: http(s)://market-the-one.com/api/offer/?mto_offer_id=1&mto_partner_id={partner_id}&partner_click_id={partner_click_id}&partner_source_id={partner_source_id}</li>
				</ul>
			
			</li>
		
				
			
		<li>/clicks  : get partners clicks</li>
				
		</li>
	'; ?>

		</ul>

</ul>


market-the-one.com/api/offer?id=1&mto_partner_id=3&partner_click_id=33&partner_source_id=232