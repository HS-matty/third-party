<h3>Import</h3>

<ul>
	<li>page: {$query_page_number}</li>
	<li>imported: {$offer_added_count}</li>
	<li>skipped: {$offer_skipped_count}</li>
	<li>total imported: {$total_offer_added_count}</li>
	<li>total skipped: {$total_offer_skipped_count}</li>
	<li>total count: {$total_offer_count}</li>
	<li>query: {$query_string}</li>
	<li><a href="{$host_name}/app/Market/Import?query_page_number={$query_page_number+1}">next page >></a></li>
	
	
</ul>

Output: {$output_string}


