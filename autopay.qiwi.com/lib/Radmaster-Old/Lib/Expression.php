<?php

class Expression extends  Std_Class {



	const TYPE_Std = 'std';
	const TYPE_Uri = 'uri';





	/**
	 * ....
	 *
	 * @param string $expression_string
	 * @param array $field_name_array
	 * @example "Ford truck (F250, F350) / 2000-2003" - array ( array ("vendor " .... :)
	 * @return Std_Class
	 */
	public static function parse($expression_string,$param_name_array = null,$type = 'std'){




		$expr_result = new Std_Class();


		switch ($type){


			case self::TYPE_Uri:


				$expr_result->setParam('query_string',$expression_string);
				$query = $expr_result->addElement('query');
				if($params = split('&',$expression_string)){
					
					foreach ($params as $param){


						$param_array = split('=',$param);
						$query->setParam($param_array[0],$param_array[1]);


					}
				}


				break;


			default:
			case self::TYPE_Std :

				$tokens = split('/', $expression_string);


				foreach ($tokens  as $i => $token){
					//Ford truck (F250, F350) / 2000-2003
					if(preg_match("/([a-zA-Z\s]+)\(?([a-zA-Z0-9]+)?\)?/",trim($token),$matches)){

						/* print_r($matches);
						exit();*/
						foreach ($matches as $key=> &$value){
							if(!$key) continue;

							$param_name = $param_name_array[$i][($key-1)];
							$expr_result->addElement($param_name)->setValue(trim ($value));

							if(count($_arr = split(',',$value)) > 1){
								foreach ($_arr as &$val){
									$expr_result->getElement($param_name)->addElement()->setValue($val);

								}
							}
						}




					}else{

						if(list($left_part,$right_part) = split('-',trim($token))){

							$expr_result->setParam($param_name_array[$i][0],trim ($left_part));
							$expr_result->setParam($param_name_array[$i][1],trim ($right_part));
						}
					}




				}
				break;





		}


		return $expr_result;
	}

}


?>