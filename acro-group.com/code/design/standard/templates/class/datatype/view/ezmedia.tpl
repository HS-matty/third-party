{* DO NOT EDIT THIS FILE! Use an override template instead. *}
<div class="block">
<label>{"Media player type"|i18n("design/standard/class/datatype")}</label><div class="labelbreak"></div>
{section show=eq($class_attribute.data_text1,'flash')}{"Flash"|i18n("design/standard/class/datatype")}{/section}
{section show=eq($class_attribute.data_text1,'quick_time')}{"QuickTime"|i18n("design/standard/class/datatype")}{/section}
{section show=eq($class_attribute.data_text1,'real_player')}{"Real player"|i18n("design/standard/class/datatype")}{/section}
{section show=eq($class_attribute.data_text1,'windows_media_player')}{"Windows media player"|i18n("design/standard/class/datatype")}{/section}
</div>

<div class="block">
<label>{"Max file size"|i18n("design/standard/class/datatype")}</label><div class="labelbreak"></div>
<p>{$class_attribute.data_int1}&nbsp;MB</p>
</div>