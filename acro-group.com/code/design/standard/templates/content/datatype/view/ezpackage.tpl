{* DO NOT EDIT THIS FILE! Use an override template instead. *}
<div class="block">
    <img src={$attribute.content|ezpackage(filepath,"thumbnail")|ezroot} />
</div>
<div class="block">
{$attribute.data_text|wash}
</div>