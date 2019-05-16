{* Real video - Full view *}

<div class="content-view-full">
    <div class="class-real_video">

    <h2>{$node.name}</h2>

    <div class="attribute-short">
        {attribute_view_gui attribute=$node.object.data_map.description}
    </div>

    <div class="content-media">
    {let attribute=$node.object.data_map.file}
        <object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA"
                width="{$attribute.content.width}" height="{$attribute.content.height}">
        <param name="src" value={concat("content/download/",$attribute.contentobject_id,"/",$attribute.content.contentobject_attribute_id,"/",$attribute.content.original_filename)|ezurl} />
        <param name="controls" value="{$attribute.content.controls}" />
        <param name="autostart" value="{section show=$attribute.content.is_autoplay}true{/section}" />
        <embed src={concat("content/download/",$attribute.contentobject_id,"/",$attribute.content.contentobject_attribute_id,"/",$attribute.content.original_filename)|ezurl}
               {*pluginspage="{$attribute.content.pluginspage}"*}
               pluginspage="http://real.com"
               type="audio/x-pn-realaudio-plugin"
               width="{$attribute.content.width}" height="{$attribute.content.height}" autostart="{section show=$attribute.content.is_autoplay}true{/section}"
               controls="{$attribute.content.controls}" >
        </embed>
        </object>
    {/let}
    </div>

    </div>
</div>