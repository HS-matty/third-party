

{assign value=$page->getCurrentUiElement() var=ui_element}


	<h2>{$ui_element->getTitle()}</h2>
			
		<p>{$ui_element->getValue()}</p>