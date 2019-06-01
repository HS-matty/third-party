<?php /* Smarty version 2.6.14, created on 2017-05-15 14:47:09
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/bootstrap/App/Market/Import.tpl */ ?>
<h3>Import</h3>

<ul>
	<li>page: <?php echo $this->_tpl_vars['query_page_number']; ?>
</li>
	<li>imported: <?php echo $this->_tpl_vars['offer_added_count']; ?>
</li>
	<li>skipped: <?php echo $this->_tpl_vars['offer_skipped_count']; ?>
</li>
	<li>skipped-no-tracking-url: <?php echo $this->_tpl_vars['offer_skipped_count_no_tracking_url']; ?>
</li>
	<li>total imported: <?php echo $this->_tpl_vars['total_offer_added_count']; ?>
</li>
	<li>total skipped: <?php echo $this->_tpl_vars['total_offer_skipped_count']; ?>
</li>
	<li>total count: <?php echo $this->_tpl_vars['total_offer_count']; ?>
</li>
	<li>query: <?php echo $this->_tpl_vars['query_string']; ?>
</li>
	<li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/Market/Import?query_page_number=<?php echo $this->_tpl_vars['query_page_number']+1; ?>
">next page >></a></li>
	
	
</ul>

Output: <?php echo $this->_tpl_vars['output_string']; ?>


