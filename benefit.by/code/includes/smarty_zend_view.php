<?php
/**
 * Smarty templates for zend, added by Sergey Volchek
 *
 */
/*class Smarty_Zend_View extends Zend_View_Abstract {



	public function setParam($ParamName,$ParamValue){
		$this->$ParamName  = $ParamValue;
	}
	protected function _run(){

		require_once(ROOT_PATH.'/3rd_party/smarty/Smarty.class.php');

		$this->test = 'blabla';





		$Template =  basename(func_get_arg(0));
		$smarty  = new Smarty();

		$smarty->caching = false;
		$smarty->template_dir = ROOT_PATH.'/application/views/frontend/';

		$smarty->compile_dir = ROOT_PATH.'/3rd_party/smarty/stuff/templates_c';
		$smarty->config_dir = ROOT_PATH.'/3rd_party/smarty/stuff/configs';
		$smarty->cache_dir = ROOT_PATH.'/3rd_party/smarty/stuff/cache';


		//set sub index template

		$TemplatePath = $smarty->template_dir.'/'.$this->ModuleTitle.'/';

		$this->setScriptPath($TemplatePath);
		$this->setScriptPath($smarty->template_dir.'/_index');
		$FullSubTemplatePath = $TemplatePath.$Template;
		$smarty->assign('Path',$FullSubTemplatePath);

		//{include file="$Path"}

		foreach ($this as $key => &$val){

			$smarty->assign($key, $val);


		}

		//display index file /_index/index.tpl

		$IndexTemplate  = $smarty->template_dir.'/_index/index.tpl';
		if($this->UseIndexTemplate) echo $smarty->display($IndexTemplate);
		else  echo $smarty->display($FullSubTemplatePath);



	}



}
*/
require_once 'Zend/View/Interface.php';
//require_once 'Smarty.class.php';

class Zend_View_Smarty implements Zend_View_Interface
{

	public $UseIndexTemplate = true;
	public $IndexTemplate = 'index.tpl';
	public $ModuleName = 'directory';
	public $PreIndexPath = '';
	public $AfterIndexPath = '';


	public function setModuleName($Name){
		$this->ModuleName = $Name;
	}

	public function addBasePath($path, $classPrefix = 'Zend_View'){
		
	}
	
	public function setBasePath($path, $classPrefix = 'Zend_View'){
		
	}
	public function getScriptPaths(){
		
	}
	public function setParam($ParamName,$ParamValue){
		$this->$ParamName  = $ParamValue;
	}

	/**
     * ������ Smarty
     * @var Smarty
     */
	protected $_smarty;

	/**
     * �����������
     *
     * @param string $tmplPath
     * @param array $extraParams
     * @return void
     */
	
	
	public function __construct($tmplPath = null, $extraParams = array())
	{
		
		global $Config;
		require_once($Config->SitePath.'/3rd_party/smarty/Smarty.class.php');
		$smarty  = new Smarty();

		$smarty->caching = false;
		
	//	$this->PreIndexPath = $Config->SitePath.'/application/views/frontend/';

		$smarty->compile_dir = $Config->SitePath.'/3rd_party/smarty/stuff/templates_c';
		$smarty->config_dir = $Config->SitePath.'/3rd_party/smarty/stuff/configs';
		$smarty->cache_dir = $Config->SitePath.'/3rd_party/smarty/stuff/cache';
		$smarty->assign('HostName',$Config->Hostname);
		
		$this->_smarty = $smarty;

		if (null !== $tmplPath) {
			$this->setScriptPath($tmplPath);
		}

		foreach ($extraParams as $key => $value) {
			$this->_smarty->$key = $value;
		}
	}

	/**
     * ����������� ������� �������������
     *
     * @return Smarty
     */
	public function getEngine()
	{
		return $this->_smarty;
	}

	/**
     * ��������� ���� � ��������
     *
     * @param string $path ����������, ��������������� ��� ���� � ��������
     * @return void
     */
	public function setScriptPath($path)
	{
		
		if (is_readable($path)) {
			$this->_smarty->template_dir = $path;
			return;
		}else die($path);

		throw new Exception('Invalid path provided');
	}
	public function setPreScriptPath($path){
		$this->PreIndexPath = $path;
	}

	/**
     * ���������� �������� ���������� �������
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     */
	public function __set($key, $val)
	{
		$this->_smarty->_tpl_vars[$key] =  $val;
		
	}

	/**
     * ��������� �������� ����������
     *
     * @param string $key The variable name.
     * @return mixed The variable value.
     */
	public function __get($key)
	{
		return $this->_smarty->get_template_vars($key);
	}

	/**
     * ��������� ��������� ���������� ����� empty() � isset()
     *
     * @param string $key
     * @return boolean
     */
	public function __isset($key)
	{
		return (null !== $this->_smarty->get_template_vars($key));
	}

	/**
     * ��������� ������� �������� ������� ����� unset()
     *
     * @param string $key
     * @return void
     */
	public function __unset($key)
	{
		$this->_smarty->clear_assign($key);
	}

	/**
     * ���������� ���������� �������
     *
     * ��������� ���������� �������� � ������������� ����� ��� �������� ������
     * ��� ���� => ��������
     *
     * @see __set()
     * @param string|array $spec ���� ��� ������ ��� ���� => ��������
     * @param mixed $value (��������������) ���� ������������� �������� �����
     * ����������, �� ����� ���� ���������� �������� ����������
     * @return void
     */
	public function assign($spec, $value = null)
	{
/*		if (is_array($spec)) {
			$this->_smarty->assign($spec);
			return;
		}*/

		$this->_smarty->_tpl_vars[$spec] = $value;
	}

	/**
     * �������� ���� ����������
     *
     * @return void
     */
	public function clearVars()
	{
		$this->_smarty->clear_all_assign();
	}

	/**
     * ������������ ������ � ���������� �����
     *
     * @param string $name ������ ��� ���������
     * @return string �����
     */
	public function render($name,$echo = true)
	{
		
		
		$TemplatePath = $this->PreIndexPath.$this->ModuleName.'/';
		


		
		
		
		//$this->setScriptPath($TemplatePath);
		//$this->setScriptPath($this->_smarty->template_dir.'/_index');
		$FullSubTemplatePath = $TemplatePath.$name;
	
		
		$this->_smarty->assign('Path',$FullSubTemplatePath);
		$this->_smarty->assign('View',$this);
		$this->_smarty->assign('Page',$this);

		//{include file="$Path"}

/*		foreach ($this as $key => &$val){

			$this->_smarty->assign($key, $val);


		}*/

		//display index file /_index/index.tpl

		$IndexTemplate  = $this->PreIndexPath.'_index/'.$this->IndexTemplate;

	
		if($this->UseIndexTemplate)   {
			
			return  $this->_smarty->fetch($IndexTemplate);
			
		}
		elseif($echo)  return  $this->_smarty->display($FullSubTemplatePath);
		
		return $this->_smarty->fetch($name);
	}

	public function compileSmartyBlock($Template,$Path,$Vars = null){

		if($Vars)
		foreach ($Vars as $key => &$val){

			$this->_smarty->assign($key, $val);


		}

		$TemplatePath = $this->PreIndexPath.$Path;
		return $this->_smarty->fetch($TemplatePath.$Template);




	}
	public function getIndexTmpl($tpl){
		
		return $this->PreIndexPath.'_index/'.$this->AfterIndexPath.$tpl;
		
		
	}
	public function setIndexPath($Path){
		$this->AfterIndexPath  = $Path;
	}





}


?>