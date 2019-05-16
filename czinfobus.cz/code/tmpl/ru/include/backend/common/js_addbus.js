<script language="JavaScript">
<!--
<%echo Jstring%>
	
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