<?php
// Template v1.0

class Template {
	var		$m_rootDir = ".";		// директория для шаблонов
	var		$m_win32 = true;		// true - \, false - / (*nix)

	var		$m_extension = "tpl";	// расширение для файлов шаблона

	var		$m_die = true;			// завершать скрипт, если ошибка
	var		$m_error = "";			// последняя ошибка, если пусто, то ее не было

	var		$m_templates = array();	// массив шаблонов: ключ -> имя шаблона, значение -> тело шаблона

	var		$m_showErrors = true;	// показывать ошибки

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
				$this->error("'$dir', не является директорией");
			}
		} else {
			if((ord($trailer)) != 92) $dir = "$dir".chr(92);
			$this->m_rootDir = $dir;
		}
	}
	// }} setDir

	// {{ load: function
	// загрузка шаблонов в массив $m_templates
	// имена файлов (без расширения) перечисляются через запятую
	function load($names, $addslashes = true) {
		$namesarray = explode(",", $names);

		while (list($key, $name) = each($namesarray)) {
			$file = $this->m_rootDir.$name.".".$this->m_extension;

			if(is_file($file)) {
				if($this->isLoaded($name)) $this->warning("Шаблон $name уже загружен");

				$this->m_templates["$name"] = join("", file($file));
				// здесь используется addslashes для добавления слешей к кавычкам
				// чтобы не было ошибок при вызове функции eval в скрипте.
				if($addslashes) {
//					$this->m_templates["$name"] = str_replace("\"", "\\\"", $this->m_templates["$name"]);
//					$this->m_templates["$name"] = str_replace("'", "\\'", $this->m_templates["$name"]);
					$this->m_templates["$name"] = addslashes($this->m_templates["$name"]);
				}
			} else {
				$this->error("Шаблон '$file' не существует");
			}
		}
	}
	// }} load

	// {{ get: function
	function get($name, $showinfo = false) {
//		if(!isset($this->m_templates[$name])) {
//			$this->error("Шаблон '$name' не загружен");
//		}
		if(!$this->isLoaded($name)) $this->load($name);

		$template = $this->m_templates["$name"];

		$template = str_replace("\\'", "'", $template);
		if($showinfo) return "<!-- Start Template: $name -->$template<!-- End template: $name -->";
		return "$template";
	}
	// }} get

	// {{ isLoaded: function
	// Проверка шаблона: загружен он, или нет.
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
			print "<br /><b>Ошибка:</b> ".$message."<br />\n";
			if($this->m_die) die();
		}
	}
	// }} error
	
	// {{ warning: function
	function warning($message) {
		$this->m_error = $message;
		if($this->m_showErrors) {
			print "<br /><b>Предупреждение</b>: ".$message."<br />\n";
		}
	}
	// }} warning: function
}
// }} Template: class
?>