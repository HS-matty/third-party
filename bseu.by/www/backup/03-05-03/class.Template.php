<?php
// Template v1.0

class Template {
	var		$m_rootDir = ".";		// ���������� ��� ��������
	var		$m_win32 = true;		// true - \, false - / (*nix)

	var		$m_extension = "tpl";	// ���������� ��� ������ �������

	var		$m_die = true;			// ��������� ������, ���� ������
	var		$m_error = "";			// ��������� ������, ���� �����, �� �� �� ����

	var		$m_templates = array();	// ������ ��������: ���� -> ��� �������, �������� -> ���� �������

	var		$m_showErrors = true;	// ���������� ������

	// {{ Template: constructor
	function Template ($dir = ".") {
		$this->setDir($dir);
	}
	// }} Template

	// {{ setDir: function
	function setDir($dir = ".") {
		$trailer = substr($dir, -1);

		if(!$this->m_win32) {
			if((ord($trailer)) != 47) $dir = "$dir".chr(47);

			if(is_dir($dir)) $this->m_rootDir = $dir;
			else {
				$this->m_rootDir = "";
				$this->error("'$dir', �� �������� �����������");
			}
		} else {
			if((ord($trailer)) != 92) $dir = "$dir".chr(92);
			$this->m_rootDir = $dir;
		}
	}
	// }} setDir

	// {{ load: function
	// �������� �������� � ������ $m_templates
	// ����� ������ (��� ����������) ������������� ����� �������
	function load($names, $addslashes = true) {
		$namesarray = explode(",", $names);

		while (list($key, $name) = each($namesarray)) {
			$file = $this->m_rootDir.$name.".".$this->m_extension;

			if(is_file($file)) {
				if($this->isLoaded($name)) $this->warning("������ $name ��� ��������");

				$this->m_templates["$name"] = join("", file($file));
				// ����� ������������ addslashes ��� ���������� ������ � ��������
				// ����� �� ���� ������ ��� ������ ������� eval � �������.
				if($addslashes) {
//					$this->m_templates["$name"] = str_replace("\"", "\\\"", $this->m_templates["$name"]);
//					$this->m_templates["$name"] = str_replace("'", "\\'", $this->m_templates["$name"]);
					$this->m_templates["$name"] = addslashes($this->m_templates["$name"]);
				}
			} else {
				$this->error("������ '$file' �� ����������");
			}
		}
	}
	// }} load

	// {{ get: function
	function get($name, $showinfo = false) {
//		if(!isset($this->m_templates[$name])) {
//			$this->error("������ '$name' �� ��������");
//		}
		if(!$this->isLoaded($name)) $this->load($name);

		$template = $this->m_templates["$name"];

		$template = str_replace("\\'", "'", $template);
		if($showinfo) return "<!-- Start Template: $name -->$template<!-- End template: $name -->";
		return "$template";
	}
	// }} get

	// {{ isLoaded: function
	// �������� �������: �������� ��, ��� ���.
	function isLoaded($name) {
		return isset($this->m_templates["$name"]);
	}
	// }}

	function unload($name) {
		unset($this->m_templates["$name"]);
	}

	// {{ error: function
	function error($message) {
		$this->m_error = $message;
		if($this->m_showErrors) {
			print "<br /><b>������:</b> ".$message."<br />\n";
			if($this->m_die) die();
		}
	}
	// }} error
	
	// {{ warning: function
	function warning($message) {
		$this->m_error = $message;
		if($this->m_showErrors) {
			print "<br /><b>��������������</b>: ".$message."<br />\n";
		}
	}
	// }} warning: function
}
// }} Template: class
?>