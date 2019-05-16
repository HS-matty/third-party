<?php
/* 
   ������ � ������� �� ��������� Nested Sets. 
   ���������� ������� � ������. 
   ������������ ����� dbtree.php 
   ����� ��� �����: http://dev.e-taller.net/dbtree/ 

    --------------------- 
    Author: Maxim Matykhin, Baturov Michail(docker@inbox.ru)     
    mailto: max@webscript.ru 
*/ 

/* ��� ������������ ������ ������� ��������� ��������� ������ ��
   �������� �������:
 
CREATE TABLE categories (
cid int(10) unsigned NOT NULL auto_increment,
title varchar(128) NOT NULL default '',
cleft int(10) unsigned NOT NULL default '0',
cright int(10) unsigned NOT NULL default '0',
clevel int(10) unsigned NOT NULL default '0',
PRIMARY KEY (cid),
KEY cleft (cleft, cright, clevel)
) TYPE=MyISAM;

 */

$table="categories"; // ������� ��������� 
$id_name="cid";     // ��� ���� ���������� ����� 
$field_names = array( // ����� ����� ������� 
   'left' => 'cleft', 
   'right'=> 'cright', 
   'level'=> 'clevel', 
); 

require_once "database.php"; 
require_once "dbtree.php"; 

$dbh=new CDataBase("my", "localhost", "my", "mypass"); 
$Tree = new CDBTree($dbh, $table, $id_name, $field_names); 

if ($Tree->isEmpty()) {
    // ������� "��������" ������ (��. ��������� � ������) 
    $id=$Tree->clear(array("title"=>"������� ��������")); 
    
    $level_2=array(); 
    $level_2[0]=$Tree->insert($id,array("title"=>"����������������")); 
    $level_2[1]=$Tree->insert($id,array("title"=>"�������")); 
    $level_2[2]=$Tree->insert($id,array("title"=>"�����")); 
    $level_2[3]=$Tree->insert($id,array("title"=>"������")); 
    
    // ������ �������� ��������� ������� �������� ������ 
    $level_3=array(); 
    $level_3[0]=$Tree->insert($level_2[0],array("title"=>"PHP")); 
    $level_3[1]=$Tree->insert($level_2[0],array("title"=>"Perl")); 
    $level_3[2]=$Tree->insert($level_2[0],array("title"=>"Delphi")); 
    
    $level_3[3]=$Tree->insert($level_2[1],array("title"=>"��������")); 
    
    $level_3[4]=$Tree->insert($level_2[2],array("title"=>"������")); 
    $level_3[5]=$Tree->insert($level_2[2],array("title"=>"�������")); 
    
    $level_3[6]=$Tree->insert($level_2[3],array("title"=>"��������")); 
    $level_3[7]=$Tree->insert($level_2[3],array("title"=>"��������")); 
    $level_3[8]=$Tree->insert($level_2[3],array("title"=>"��������������")); 
                                                   
    // � ��� ��������� ������� ��������� ������� 
    $Tree->insert($level_3[0],array("title"=>"PEAR")); 
    $Tree->insert($level_3[8],array("title"=>"�����������")); 
    $Tree->insert($level_3[6],array("title"=>"�����")); 
    echo "������� ���������.<br><br>";
}

// ������������ ������� ����������� �����-����
if (isset($_GET['order']) && isset($_GET['tid'])) {
    // ������� ����� � �������� ������ ������
    $Tree->changeBranchOrder($_GET['tid'], $_GET['order']);
    header('Location: ?'.time());
}

// ����� ������ ��������
$query="SELECT * FROM ".$table." ORDER BY ".$Tree->left." ASC"; 
$result=$dbh->query($query); 
while($row = $dbh->fetch_array($result)) 
{
   echo str_repeat("&nbsp;",6*$row[$Tree->level]).$row['title'].'&nbsp;&nbsp;&nbsp;';
   print '<a href="?tid='.$row[$id_name].'&order=up">up</a> ';
   print '<a href="?tid='.$row[$id_name].'&order=down">down</a><br>';
}
?>