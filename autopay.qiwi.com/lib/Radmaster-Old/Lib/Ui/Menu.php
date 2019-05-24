<?php


require_once('Menu/Element.php');

class Ui_Menu extends Ui_Element {


	public static $level = 0;

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $name
	 * @param Ui_Element $parent
	 * @return Ui_Menu
	 */
	public  static function init($name,Ui_Element $parent = null){

		
		$config = Registry::get('config');
		$path = PATH_META_DATA;
		$file = $path.'/'.$name.'.xml';

		$lang = 'en';
		$lang = $config->getParam('lang');

		$meta = simplexml_load_file($file);

		$return_value = null;

		if($meta){

			if($parent) $menu = $parent;
			else{
				$menu	 = new Ui_Menu();

				$menu->setName($name);
				$menu->setTitle( (string) $meta->title->{$lang});
				$menu->setType(Ui::Type_MENU);
			}

			$i=0;
			foreach ($meta as $key=>$menu_element_meta){

				isset($menu_element_meta['id']) ? $name = (string) $menu_element_meta['id'] : $name = (string) $menu_element_meta['name'];

				
				$menu_item = $menu->addElement(new Ui_Menu_Element())->setName('menu_item'.$i)->setTitle((string) $menu_element_meta->title->{$lang})->setValue($name);

				$menu_item->setProperty('group_id',(string) $menu_element_meta['group_id']);
				
				$menu_item->addAction(new Ui_Action())->setType(Ui_Action::Type_CLICK)->setName('onClick')->setValue($name);

			if(file_exists($path.'/menu/'.$name.'.xml')){

					Ui_Menu::$level++;
					if(Ui_Menu::$level > 4 && false){
						throw new Exception('exceeded elements-tree level: '.$level);
					}

					Ui_Menu::init('menu/'.$name,$menu_item);
					//$menu_item->addElement();

				}
				//check for submenu

				$i++;

			}
			$return_value = $menu;
		}


		return $return_value;

	}

	public static  function loadMeta($file){

		$meta = simplexml_load_file($file);

		return $meta;



	}

	
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $alias
	 * @return Ui_Menu_Element 
	 */
	public function getMenuElementByAlias($alias){
		
		$return_value = null;
		foreach ($this->getElements() as $el){
			
			$value = $el->getValue();
			if($value == $alias){
				$return_value = $el;
				break;
				
			}
			
		}
		return $return_value;
		
		
	}

}

?>