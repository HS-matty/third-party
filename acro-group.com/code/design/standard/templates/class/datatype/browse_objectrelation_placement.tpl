{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{let class=fetch(content,class,hash(class_id,$browse.content.class_id))}
<div class="maincontentheader">
<h1>
    {'Choose node for default selection'
     |i18n('design/standard/content/view')}
</h1>
</div>

<p>
    {"Please choose where you want to the default selection of objectrelation to start from.

    Select the placement and click the %buttonname button.
    Using the recent and bookmark items for quick placement is also possible.
    Click on placement names to change the browse listing."
    |i18n('design/standard/content/view',,
          hash('%buttonname','Select'|i18n('design/standard/content/view')))
    |nl2br}
</p>
{/let}