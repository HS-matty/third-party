<?php

function _error_handler($errno, $errstr, $errfile, $errline)
{
    if ((error_reporting() & $errno)) 
         
    switch ($errno) {

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}




function translate_ru_to_en_translit($string, $gost=false)
{
    if($gost)
    {
        $replace = array("À"=>"A","à"=>"a","Á"=>"B","á"=>"b","Â"=>"V","â"=>"v","Ã"=>"G","ã"=>"g","Ä"=>"D","ä"=>"d",
                "Å"=>"E","å"=>"e","¨"=>"E","¸"=>"e","Æ"=>"Zh","æ"=>"zh","Ç"=>"Z","ç"=>"z","È"=>"I","è"=>"i",
                "É"=>"I","é"=>"i","Ê"=>"K","ê"=>"k","Ë"=>"L","ë"=>"l","Ì"=>"M","ì"=>"m","Í"=>"N","í"=>"n","Î"=>"O","î"=>"o",
                "Ï"=>"P","ï"=>"p","Ð"=>"R","ð"=>"r","Ñ"=>"S","ñ"=>"s","Ò"=>"T","ò"=>"t","Ó"=>"U","ó"=>"u","Ô"=>"F","ô"=>"f",
                "Õ"=>"Kh","õ"=>"kh","Ö"=>"Tc","ö"=>"tc","×"=>"Ch","÷"=>"ch","Ø"=>"Sh","ø"=>"sh","Ù"=>"Shch","ù"=>"shch",
                "Û"=>"Y","û"=>"y","Ý"=>"E","ý"=>"e","Þ"=>"Iu","þ"=>"iu","ß"=>"Ia","ÿ"=>"ia","ú"=>"","ü"=>"");
    }
    else
    {
        $arStrES = array("àå","óå","îå","ûå","èå","ýå","ÿå","þå","¸å","åå","üå","úå","ûé","èé");
        $arStrOS = array("à¸","ó¸","î¸","û¸","è¸","ý¸","ÿ¸","þ¸","¸¸","å¸","ü¸","ú¸","ûé","èé");        
        $arStrRS = array("à$","ó$","î$","û$","è$","ý$","ÿ$","þ$","¸$","å$","ü$","ú$","@","@");
                    
        $replace = array("À"=>"A","à"=>"a","Á"=>"B","á"=>"b","Â"=>"V","â"=>"v","Ã"=>"G","ã"=>"g","Ä"=>"D","ä"=>"d",
                "Å"=>"Ye","å"=>"e","¨"=>"Ye","¸"=>"e","Æ"=>"Zh","æ"=>"zh","Ç"=>"Z","ç"=>"z","È"=>"I","è"=>"i",
                "É"=>"Y","é"=>"y","Ê"=>"K","ê"=>"k","Ë"=>"L","ë"=>"l","Ì"=>"M","ì"=>"m","Í"=>"N","í"=>"n",
                "Î"=>"O","î"=>"o","Ï"=>"P","ï"=>"p","Ð"=>"R","ð"=>"r","Ñ"=>"S","ñ"=>"s","Ò"=>"T","ò"=>"t",
                "Ó"=>"U","ó"=>"u","Ô"=>"F","ô"=>"f","Õ"=>"Kh","õ"=>"kh","Ö"=>"Ts","ö"=>"ts","×"=>"Ch","÷"=>"ch",
                "Ø"=>"Sh","ø"=>"sh","Ù"=>"Shch","ù"=>"shch","Ú"=>"","ú"=>"","Û"=>"Y","û"=>"y","Ü"=>"","ü"=>"",
                "Ý"=>"E","ý"=>"e","Þ"=>"Yu","þ"=>"yu","ß"=>"Ya","ÿ"=>"ya","@"=>"y","$"=>"ye");
                
        $string = str_replace($arStrES, $arStrRS, $string);
        $string = str_replace($arStrOS, $arStrRS, $string);
    }
        
    return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}


function transliterate($st) {

  $st = strtr($st, 

    "àáâãäåæçèéêëìíîïðñòóôûýÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÛÝ",

    "abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE"

  );

  $st = strtr($st, array(

    '¸'=>"yo",    'õ'=>"h",  'ö'=>"ts",  '÷'=>"ch", 'ø'=>"sh",  

    'ù'=>"shch",  'ú'=>'',   'ü'=>'',    'þ'=>"yu", 'ÿ'=>"ya",

    '¨'=>"Yo",    'Õ'=>"H",  'Ö'=>"Ts",  '×'=>"Ch", 'Ø'=>"Sh",

    'Ù'=>"Shch",  'Ú'=>'',   'Ü'=>'',    'Þ'=>"Yu", 'ß'=>"Ya",

  ));

  return $st;

}


function rus2translit($string) {

    $converter = array(

        'à' => 'a',   'á' => 'b',   'â' => 'v',

        'ã' => 'g',   'ä' => 'd',   'å' => 'e',

        '¸' => 'e',   'æ' => 'zh',  'ç' => 'z',

        'è' => 'i',   'é' => 'y',   'ê' => 'k',

        'ë' => 'l',   'ì' => 'm',   'í' => 'n',

        'î' => 'o',   'ï' => 'p',   'ð' => 'r',

        'ñ' => 's',   'ò' => 't',   'ó' => 'u',

        'ô' => 'f',   'õ' => 'h',   'ö' => 'c',

        '÷' => 'ch',  'ø' => 'sh',  'ù' => 'sch',

        'ü' => '\'',  'û' => 'y',   'ú' => '\'',

        'ý' => 'e',   'þ' => 'yu',  'ÿ' => 'ya',

        

        'À' => 'A',   'Á' => 'B',   'Â' => 'V',

        'Ã' => 'G',   'Ä' => 'D',   'Å' => 'E',

        '¨' => 'E',   'Æ' => 'Zh',  'Ç' => 'Z',

        'È' => 'I',   'É' => 'Y',   'Ê' => 'K',

        'Ë' => 'L',   'Ì' => 'M',   'Í' => 'N',

        'Î' => 'O',   'Ï' => 'P',   'Ð' => 'R',

        'Ñ' => 'S',   'Ò' => 'T',   'Ó' => 'U',

        'Ô' => 'F',   'Õ' => 'H',   'Ö' => 'C',

        '×' => 'Ch',  'Ø' => 'Sh',  'Ù' => 'Sch',

        'Ü' => '\'',  'Û' => 'Y',   'Ú' => '\'',

        'Ý' => 'E',   'Þ' => 'Yu',  'ß' => 'Ya',

    );

    return strtr($string, $converter);

}

function str2url($str) {

    // ïåðåâîäèì â òðàíñëèò

    $str = rus2translit($str);

    // â íèæíèé ðåãèñòð

    $str = strtolower($str);

    // çàìåíÿì âñå íåíóæíîå íàì íà "-"

    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);

    // óäàëÿåì íà÷àëüíûå è êîíå÷íûå '-'

    $str = trim($str, "-");

    return $str;

}





















?>