{* DO NOT EDIT THIS FILE! Use an override template instead. *}
<form action={concat($module.functions.groupedit.uri,"/",$classgroup.id)|ezurl} method="post" name="GroupEdit">

<div class="maincontentheader">
<h1>{"Editing class group - %1"|i18n("design/standard/class/edit",,array($classgroup.name|wash))}</h1>
<div>

<div class="byline">
<p class="modified">{"Modified by %username on %time"|i18n("design/standard/class/edit",,hash('%username',$classgroup.modifier.contentobject.name,'%time',$classgroup.modified|l10n(shortdatetime)))}</p>
</div>

<div class="block">
<label>{"Name"|i18n("design/standard/class/edit")}</label><div class="labelbreak"></div>
{include uri="design:gui/lineedit.tpl" name=Name id_name=Group_name value=$classgroup.name}
</div>

<div class="buttonblock">
{include uri="design:gui/defaultbutton.tpl" name=Store id_name=StoreButton value="Store"|i18n("design/standard/class/edit")}
{include uri="design:gui/button.tpl" name=Discard id_name=DiscardButton value="Discard"|i18n("design/standard/class/edit")}
</div>

</form>
