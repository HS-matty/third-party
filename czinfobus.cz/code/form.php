	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>NextFramework / </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
select {
	text-align: center;
	vertical-align: middle;
	background-color: #FFFFFC;
	height: 40px;
	width: 450px;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 12px;
	font-weight: normal;
	border-top: 1px solid #333333;
	border-right: 1px none #333333;
	border-bottom: 1px solid #333333;
	border-left: 1px solid #333333;

}
.pages{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	text-decoration: none;
	text-align: left;
	vertical-align: middle;
}

tr#white{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: center;
	vertical-align: middle;
	background-color: #F2F2F2;
}
td#realty{
	height: 40px;
}

tr#yellow{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: center;
	vertical-align: middle;
	background-color: #FFFFCC;
	height: 40px;
}

tr#header{
	background-color: #CC6600;
	color: #FFFFFF;
	
	text-align: center;
	vertical-align: middle;

}
td#header{
height: 40px;
} 
a:link,a:visited {
	text-decoration: none;
	color: #3E0B0C

}
a:hover {
	text-decoration: underline;
	font-weight: bold;
}

td#menu {
	text-align: center;
	vertical-align: middle;
	background-color: #FFFFCC;
	height: 40px;
	width: 150px;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 12px;
	font-weight: normal;
	border-top: 1px solid #333333;
	border-right: 1px none #333333;
	border-bottom: 1px solid #333333;
	border-left: 1px solid #333333;

	
}
td#menu3 {
	text-align: center;
	vertical-align: middle;
	background-color: #EBEBEB;
	height: 20px;
	width: 120px;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10px;
	border: 1px solid #EBEBEB;

	
}
td#menu2 {
	background-color: #FFFFCC;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: solid;
	border-top-color: #333333;
	border-right-color: #333333;
	border-bottom-color: #333333;
	border-left-color: #333333;
	
}
td#menu4 {
	background-color: #FFFFCC;

	
}

	
.menu {
	
	font-style: normal;
	color: #333333;
	text-decoration: none;
}


.copy {
	font-family: "Times New Roman", Times, serif;
	font-size: 12px;
	font-style: normal;
	color: #666666;
}
.realtylist {
	text-decoration: none;
}
tr#realty {
	background-color: #FFFFCC;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 15px;
	font-style: normal;
	color: #666666;
	text-decoration: none;
	text-align: left;
	vertical-align: top;
	height: 35px;
}
td#realtyfilter{
	background-color: #FFFFCC;
	text-align: left;
	vertical-align: middle;
	height: 30px;
	padding-left: 15px;

}
td#realtyfilter2{
	background-color: #FFFFFF;
	text-align: left;
	vertical-align: middle;
	height: 30px;
	padding-left: 10px;

}
.filterObj {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-style: normal;
	background-color:  #F4F4F4;
	height: 20px;
	width: 200px;
}
.button {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	background-color: #FFFFCC;
	height: 25px;
	width: 70px;
	border: 1px solid #CCCCCC;
	text-align: center;

}

-->
</style>

<script language="JavaScript">
<!--

<?php

function CreateRouteArray($StartDate,$EndDate,$data) {
    $StartDate = mktime(0,0,0,date('n',$StartDate),date('j',$StartDate),date('Y',$StartDate));
    $EndDate = mktime(0,0,0,date('n',$EndDate),date('j',$EndDate),date('Y',$EndDate));
    $StartDayweek = date('w',$StartDate);
    $EndDayweek = date('w',$EndDate);
    
    $Route = array();
    for( $i=0; $i<count($data); $i++ ) {
        $Route[$i]['id'] = $data[$i]['route_id'];
        $Route[$i]['name'] = $data[$i]['route_name_latin'].' / '.$data[$i]['route_name_ru'];
        $days = array();
        for( $j=0; $j<count($data[$i]['days']); $j++ )
            $days[$data[$i]['days'][$j]['day_departure']] = true;
        
        // Fills data for the first week
        $StartTimestamp = $StartDate-$StartDayweek*86400;
        foreach( $days as $day_num => $dummy ) {
            $date = $StartTimestamp + $day_num*86400;
            if( $date >= $StartDate )
                $Route[$i]['dates'][$date] = true;
        }
        
        // Start of next week after $StartDate (Sunday)
        $StartTimestamp = $StartDate+(7-$StartDayweek)*86400;
        // End of previous week before $EndDate (Saturday)
        $EndTimestamp = $EndDate-(1+$EndDayweek)*86400;
        while( $StartTimestamp < $EndTimestamp ) {
            foreach( $days as $day_num => $dummy ) {
                $date = $StartTimestamp + $day_num*86400;
                $Route[$i]['dates'][$date] = true;
            }
            $StartTimestamp += 7*86400;
        }
        
        // Fills data for the first week
        $StartTimestamp = $EndDate-$EndDayweek*86400;
        foreach( $days as $day_num => $dummy ) {
            $date = $StartTimestamp + $day_num*86400;
            if( $date <= $EndDate )
                $Route[$i]['dates'][$date] = true;
        }
    }
    
    $JSRoute = array();
    for( $i=0; $i<count($Route); $i++ ) {
        if( count($Route[$i]['dates']) == 0 ) continue;
        $JSRoute[$i]['id'] = $Route[$i]['id'];
        $JSRoute[$i]['name'] = $Route[$i]['name'];
        foreach( $Route[$i]['dates'] as $date => $dummy ) {
            $JSRoute[$i]['years'][date('Y',$date)][date('n',$date)][date('j',$date)] = true;
        }
    }
    
    $JSRouteStr = 'Route=new Array(';
    for( $i=0; $i<count($JSRoute); $i++ ) {
        $JSRouteStr .= "\n".$JSRoute[$i]['id'].',"'.addslashes($JSRoute[$i]['name']).'",new Array(';
        foreach( $JSRoute[$i]['years'] as $year => $months ) {
            $JSRouteStr .= "\n".$year.',new Array(';
            foreach( $months as $month => $days ) {
                $JSRouteStr .= "\n".$month.',"Month name #'.$month."\",new Array(";
                foreach( $days as $day => $dummy )
                    $JSRouteStr .= $day.',';
                $JSRouteStr = substr($JSRouteStr,0,-1).'),';
            }
            $JSRouteStr = substr($JSRouteStr,0,-1).'),';
        }
        $JSRouteStr = substr($JSRouteStr,0,-1)."),";
    }
    $JSRouteStr = substr($JSRouteStr,0,-1).");";
    return $JSRouteStr;
}

require 'array.txt';
echo CreateRouteArray(mktime(0,0,0,5,18,2004),mktime(0,0,0,8,31,2005),$RouteData);

?>

function InitForm(){
    FormObj=document.RouteForm;
    FormObj.SelRoute.selectedIndex=0;
    FormObj.SelYear.selectedIndex=0;
    FormObj.SelMonth.selectedIndex=0;
    FormObj.SelDay.selectedIndex=0;
    FormObj.SelRoute.options.length=1;
    FormObj.SelYear.options.length=1;
    FormObj.SelMonth.options.length=1;
    FormObj.SelDay.options.length=1;
    for(i=0;i<Route.length;i+=3)
        FormObj.SelRoute.options[FormObj.SelRoute.options.length]=new Option(Route[i+1],Route[i]);
}

function RouteChange() {
    FormObj=document.RouteForm;
    FormObj.SelYear.selectedIndex=0;
    FormObj.SelMonth.selectedIndex=0;
    FormObj.SelDay.selectedIndex=0;
    FormObj.SelYear.options.length=1;
    FormObj.SelMonth.options.length=1;
    FormObj.SelDay.options.length=1;
    if(FormObj.SelRoute.selectedIndex<1)return;
    RouteInd=3*FormObj.SelRoute.selectedIndex-1;
    for(i=0;i<Route[RouteInd].length;i+=2)
        FormObj.SelYear.options[FormObj.SelYear.options.length]=new Option(Route[RouteInd][i],Route[RouteInd][i]);
}

function YearChange() {
    FormObj=document.RouteForm;
    FormObj.SelMonth.selectedIndex=0;
    FormObj.SelDay.selectedIndex=0;
    FormObj.SelMonth.options.length=1;
    FormObj.SelDay.options.length=1;
    if(FormObj.SelRoute.selectedIndex<1)return;
    if(FormObj.SelYear.selectedIndex<1)return;
    RouteInd=3*FormObj.SelRoute.selectedIndex-1;
    YearInd=2*FormObj.SelYear.selectedIndex-1;
    for(i=0;i<Route[RouteInd][YearInd].length;i+=3)
        FormObj.SelMonth.options[FormObj.SelMonth.options.length]=new Option(Route[RouteInd][YearInd][i+1],Route[RouteInd][YearInd][i]);
}

function MonthChange() {
    FormObj=document.RouteForm;
    FormObj.SelDay.selectedIndex=0;
    FormObj.SelDay.options.length=1;
    if(FormObj.SelRoute.selectedIndex<1)return;
    if(FormObj.SelYear.selectedIndex<1)return;
    if(FormObj.SelMonth.selectedIndex<1)return;
    RouteInd=3*FormObj.SelRoute.selectedIndex-1;
    YearInd=2*FormObj.SelYear.selectedIndex-1;
    MonthInd=3*FormObj.SelMonth.selectedIndex-1;
    for(i=0;i<Route[RouteInd][YearInd][MonthInd].length;i++)
        FormObj.SelDay.options[FormObj.SelDay.options.length]=new Option(Route[RouteInd][YearInd][MonthInd][i],Route[RouteInd][YearInd][MonthInd][i]);
}

//-->
</script>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="javascript:InitForm();">

<table width="300" border="0" cellspasing="0" cellpadding="0">
<tr><td><form name="RouteForm"></td></tr>
<tr><td>
    <table width="100%" border="0" cellspacing="5" cellpadding="3" bgcolor="#C0C080">
     <tr>
      <td>Route:</td>
      <td><select name="SelRoute" onchange="javascript:RouteChange();">
        <option>--Please Select--</option>
      </select></td>
     </tr><tr>
      <td>Year:</td>
      <td><select name="SelYear" onchange="javascript:YearChange();">
        <option>--Please Select--</option>
      </select></td>
     </tr><tr>
      <td>Month:</td>
      <td><select name="SelMonth" onchange="javascript:MonthChange();">
        <option>--Please Select--</option>
      </select></td>
     </tr><tr>
      <td>Day:</td>
      <td><select name="SelDay">
        <option>--Please Select--</option>
      </select></td>
     </tr><tr>
      <td colspan="2"><input type="Submit" value="Go!"></td>
     </tr>
    </table>
</td></tr>
<tr><td></form></td></tr>
</table>

<!--
<br><br>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p>&nbsp;</p>

  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="menu"><a href='http://bus/admin/backend/index/ru/?sid=3dd05e21294c828d157da12b29442374' class='menu' >Главная страница</a></td>
    
    
    
    	<td id="menu"><a href='http://bus/admin/busservice/index/ru/?sid=3dd05e21294c828d157da12b29442374' class='menu' >Система управления автобусными маршрутами</a></td>
    
    
    
    	<td id="menu"><a href='http://bus/admin/content/index/ru/?sid=3dd05e21294c828d157da12b29442374' class='menu' >Контент сайта</a></td>
    
    
    
    
<td id='menu'><a href='http://bus/admin/backend/index/ru/?sid=3dd05e21294c828d157da12b29442374&action=logout' class='menu' >Выйти</a></td>

		<td id='menu2'>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	
    <td id="menu3"> <a href="http://bus/admin/busservice/routes/ru/?sid=3dd05e21294c828d157da12b29442374" >Маршруты</a></td>
	
	
    <td id="menu3"> <a href="http://bus/admin/busservice/partners/ru/?sid=3dd05e21294c828d157da12b29442374" >Партнеры</a></td>
	
	
    <td id="menu3"> <a href="http://bus/admin/busservice/points/ru/?sid=3dd05e21294c828d157da12b29442374" >Пункты</a></td>
	
	
    <td id="menu3"> <a href="http://bus/admin/busservice/clients/ru/?sid=3dd05e21294c828d157da12b29442374" >Клиенты</a></td>
	
	
    <td id="menu3"> <a href="http://bus/admin/busservice/buses/ru/?sid=3dd05e21294c828d157da12b29442374" >Автобусы</a></td>
	
	
	<td >&nbsp;</td>
  </tr>
</table>




<form action="http://bus/admin/busservice/addbus/ru/?sid=3dd05e21294c828d157da12b29442374" method="post" enctype="application/x-www-form-urlencoded" name="addbus">
  <table width="850" border="0" cellspacing="0" cellpadding="0">
     <tr  id='realty'>
      <td width='150'>Маршрут:</td>
      <td width='700'>
      <select name="route_id" onchange="javascript:OnRouteChange(this.value,this.selectedIndex);">
      <option selected="selected"  value="0">Выберите маршрут</option>
      
      <option value="69" >Пинск / Pinsk-Mpgilev</option>
       
      <option value="68" >Minsk-Moskva / Минск-Москва</option>
            
      </select></td>
    </tr>
    <tr id='realty' > 
    <td width='150'>Год:</td>
    <td width='700'><select  name ="year" disabled="true" onchange="javascript:OnYearChange(this.value,this.selectedIndex);">
	<option value="0" >Выберите год</option>

      </select>
         </td>
         </tr>
         
         
     <tr id='realty'> 
    <td width='150'>месяц</td>
    <td width='700'>
    <select name="month" disabled="true" onchange="javascript:OnMonthChange(this.value,this.selectedIndex);" >
	<option value="0" selected="selected" >Выберите месяц</option>
 
         </td>
         </tr>

    <tr id='realty'> 
    <td width='150'>Число</td>
    <td width='700'>
    <select name="days" disabled="true">
	<option value="0" selected="selected"   disabled='disabled'>Выберите число</option>
 
         </td>
         </tr>

    
      
    
  
  </table>
  <input type="hidden" name="post" value="1">
</form>




<br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10" id="menu2">&nbsp;</td>
  </tr>
  <tr>
    <td ><div align="center" class="copy"> 

         Powered by NextFramework. <br>&copy; KESSO LTD 2004-2005.
      </div></td>
  </tr>
</table>
<br>page generated in 0.13035702705383 seconds
-->
</body>
</html>