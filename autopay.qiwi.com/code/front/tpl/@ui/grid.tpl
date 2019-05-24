{assign var=grid value=$workspace->getElement('grid','type')}
{assign var=grid_accordion value=$workspace->getElement('accordion')}
{assign var=grid_filter value=$workspace->getElement('form','type')}
{assign var=tab value=$workspace->getElement('tab','type')}

 <!-- load grid header (form and accordion)-->
{if $tab}
		{assign var=ui_element value=$tab}
		{include file="/@ui/@element/tab.tpl"}
	
{/if}
	
<div class="row">
	{if $grid_filter}
	<div class="span3">
		{assign var=ui_element value=$grid_filter}
		{include file="/@ui/@element/form/filter.tpl"}
	</div>
	{/if}
	{if $grid_accordion}
	<div class="span9">
	{assign var=ui_element value=$grid_accordion}
		{include file="/@ui/@element/accordion.tpl"}
	</div>
	{/if}

</div>
	{if $grid}
		{assign var=ui_element value=$grid}
		{include file="/@ui/@element/grid.tpl"}
	
	{/if}
	

