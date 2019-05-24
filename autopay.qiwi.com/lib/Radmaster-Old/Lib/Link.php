<?php

class Link extends Std_Class {

	
	
	protected $_link_params;
	protected $_request_params;
	
	
	public function setLinkParams($params){
		$this->_link_params = $params;
		return $this;
	}
	
	public function setRequestParams($params){
		$this->_request_params = $params;
		return $this;
	}


	public function __toString(){


		if($this->_link || $this->_link_params){
			
			$config = Registry::get('config');
			$host_name = $config->getParam('hostname');

			$link = $host_name .'/';


			if($this->link_params) {

				foreach ($this->link_params as $param){

					$link .= $param.'/';
				}
			}

			if($this->request_params) {

				$link .= '?';
				foreach ($this->request_params as $key=>$value){
					$link .= "$key=$value&";
				}
			}
			$this->_link = $link;
		}

		return $this->_link;
	}


	
}



?>