<?php /* Smarty version 2.6.14, created on 2017-05-12 19:57:16
         compiled from file:D:%5Cdev%5Cweb-server-root%5Ccms/Static/Articles/Api.tpl */ ?>
<?php echo '
<h2>Api @ Market-The-One.com (v0.7) DRAFT</h2>

<ul>
	
	
	<li>Base url: ';  echo $this->_tpl_vars['host_name']; ?>
/api<?php echo '</li>
	<li>Hash (mto_partner_hash): ';  echo $this->_tpl_vars['user']->hash;  echo '</li>
	
	<li>Offer redirect-url: http:///market-the-one.com/redirect/offer/mto_offer_id={mto_offer_id}&partner_id={partner_id}&partner_source_id={partner_source_id}</li>
	<li>Partner-Postback: 
		<ul>
				<li>Example: http://somehost?id={click_id}</li>
				
			<li>Current: ';  if ($this->_tpl_vars['user']->postback_url):  echo $this->_tpl_vars['user']->postback_url;  else: ?> not set <?php endif; ?> (<a href="<?php echo $this->_tpl_vars['host_name'];  echo '/app/Market/Api/Settings/Form/Edit">change</a>)</li></li>
		</ul>

	


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
							<li>rows_per_page (optional) = { 150 >= [numeric] > 0 }, default:30</li>
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
			
			<li><strong>/postback</strong> : perform postback 
					<ul>
					<li>params:</li>
						<ul>
							<li>partner_click_id</li>
							<li>partner_source_id</li>
							<li>hash : mto_partner_hash </li>
						</ul>
					<li>example:  http://market-the-one.com/api/postback?click_id={partner_click_id}&source_id={partner_source_id}&hash={mto_partner_hash}</li>
				</ul>
			
			</li>
		
				
			
		<!--li>/clicks  : get partners clicks</li-->
		
				
		</li>
	'; ?>

		</ul>

</ul>

