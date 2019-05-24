<?php

class Std_Type_Float extends Std_Type{
	
	

		protected $_integer_part = 0;
		protected $_float_part = 0;
	
		/**
		 * .. ..
		 *
		 * @return float
		 */
		public function getValue(){
			
			return floatval((string) $this->_integer_part.".".$this->_float_part);
			
		}
		
		
}

?>