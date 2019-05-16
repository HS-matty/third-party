{default image_class=large
         hspace=false()
	 align="center"
         border_size=0}
{let image_attribute=$object.data_map.image
     image_content=$image_attribute.content}

  {section show=is_set($attribute_parameters.align)}
    {set align=$attribute_parameters.align}
  {section-else}
    {set align="center"}
  {/section}

  {let image=$image_content[$image_class]}

       {pdf(image,hash(src,$image.full_path,
		       width,$image.width,
		       height,$image.height,
		       border,$border_size,
		       align, $align))}

  {/let}
{* {/section} *}
{/let}
{/default}