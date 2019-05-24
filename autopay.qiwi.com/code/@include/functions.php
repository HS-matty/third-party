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
        $replace = array("�"=>"A","�"=>"a","�"=>"B","�"=>"b","�"=>"V","�"=>"v","�"=>"G","�"=>"g","�"=>"D","�"=>"d",
                "�"=>"E","�"=>"e","�"=>"E","�"=>"e","�"=>"Zh","�"=>"zh","�"=>"Z","�"=>"z","�"=>"I","�"=>"i",
                "�"=>"I","�"=>"i","�"=>"K","�"=>"k","�"=>"L","�"=>"l","�"=>"M","�"=>"m","�"=>"N","�"=>"n","�"=>"O","�"=>"o",
                "�"=>"P","�"=>"p","�"=>"R","�"=>"r","�"=>"S","�"=>"s","�"=>"T","�"=>"t","�"=>"U","�"=>"u","�"=>"F","�"=>"f",
                "�"=>"Kh","�"=>"kh","�"=>"Tc","�"=>"tc","�"=>"Ch","�"=>"ch","�"=>"Sh","�"=>"sh","�"=>"Shch","�"=>"shch",
                "�"=>"Y","�"=>"y","�"=>"E","�"=>"e","�"=>"Iu","�"=>"iu","�"=>"Ia","�"=>"ia","�"=>"","�"=>"");
    }
    else
    {
        $arStrES = array("��","��","��","��","��","��","��","��","��","��","��","��","��","��");
        $arStrOS = array("�","�","�","��","�","��","��","��","��","�","��","��","��","��");        
        $arStrRS = array("�$","�$","�$","�$","�$","�$","�$","�$","�$","�$","�$","�$","@","@");
                    
        $replace = array("�"=>"A","�"=>"a","�"=>"B","�"=>"b","�"=>"V","�"=>"v","�"=>"G","�"=>"g","�"=>"D","�"=>"d",
                "�"=>"Ye","�"=>"e","�"=>"Ye","�"=>"e","�"=>"Zh","�"=>"zh","�"=>"Z","�"=>"z","�"=>"I","�"=>"i",
                "�"=>"Y","�"=>"y","�"=>"K","�"=>"k","�"=>"L","�"=>"l","�"=>"M","�"=>"m","�"=>"N","�"=>"n",
                "�"=>"O","�"=>"o","�"=>"P","�"=>"p","�"=>"R","�"=>"r","�"=>"S","�"=>"s","�"=>"T","�"=>"t",
                "�"=>"U","�"=>"u","�"=>"F","�"=>"f","�"=>"Kh","�"=>"kh","�"=>"Ts","�"=>"ts","�"=>"Ch","�"=>"ch",
                "�"=>"Sh","�"=>"sh","�"=>"Shch","�"=>"shch","�"=>"","�"=>"","�"=>"Y","�"=>"y","�"=>"","�"=>"",
                "�"=>"E","�"=>"e","�"=>"Yu","�"=>"yu","�"=>"Ya","�"=>"ya","@"=>"y","$"=>"ye");
                
        $string = str_replace($arStrES, $arStrRS, $string);
        $string = str_replace($arStrOS, $arStrRS, $string);
    }
        
    return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}


function transliterate($st) {

  $st = strtr($st, 

    "����������������������������������������������",

    "abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE"

  );

  $st = strtr($st, array(

    '�'=>"yo",    '�'=>"h",  '�'=>"ts",  '�'=>"ch", '�'=>"sh",  

    '�'=>"shch",  '�'=>'',   '�'=>'',    '�'=>"yu", '�'=>"ya",

    '�'=>"Yo",    '�'=>"H",  '�'=>"Ts",  '�'=>"Ch", '�'=>"Sh",

    '�'=>"Shch",  '�'=>'',   '�'=>'',    '�'=>"Yu", '�'=>"Ya",

  ));

  return $st;

}


function rus2translit($string) {

    $converter = array(

        '�' => 'a',   '�' => 'b',   '�' => 'v',

        '�' => 'g',   '�' => 'd',   '�' => 'e',

        '�' => 'e',   '�' => 'zh',  '�' => 'z',

        '�' => 'i',   '�' => 'y',   '�' => 'k',

        '�' => 'l',   '�' => 'm',   '�' => 'n',

        '�' => 'o',   '�' => 'p',   '�' => 'r',

        '�' => 's',   '�' => 't',   '�' => 'u',

        '�' => 'f',   '�' => 'h',   '�' => 'c',

        '�' => 'ch',  '�' => 'sh',  '�' => 'sch',

        '�' => '\'',  '�' => 'y',   '�' => '\'',

        '�' => 'e',   '�' => 'yu',  '�' => 'ya',

        

        '�' => 'A',   '�' => 'B',   '�' => 'V',

        '�' => 'G',   '�' => 'D',   '�' => 'E',

        '�' => 'E',   '�' => 'Zh',  '�' => 'Z',

        '�' => 'I',   '�' => 'Y',   '�' => 'K',

        '�' => 'L',   '�' => 'M',   '�' => 'N',

        '�' => 'O',   '�' => 'P',   '�' => 'R',

        '�' => 'S',   '�' => 'T',   '�' => 'U',

        '�' => 'F',   '�' => 'H',   '�' => 'C',

        '�' => 'Ch',  '�' => 'Sh',  '�' => 'Sch',

        '�' => '\'',  '�' => 'Y',   '�' => '\'',

        '�' => 'E',   '�' => 'Yu',  '�' => 'Ya',

    );

    return strtr($string, $converter);

}

function str2url($str) {

    // ��������� � ��������

    $str = rus2translit($str);

    // � ������ �������

    $str = strtolower($str);

    // ������� ��� �������� ��� �� "-"

    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);

    // ������� ��������� � �������� '-'

    $str = trim($str, "-");

    return $str;

}





















?>