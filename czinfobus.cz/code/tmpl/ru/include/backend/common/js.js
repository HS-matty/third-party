<script language="JavaScript">
<!--


var RouteId;
var RouteIdIndex;
var YearId;
var YearIdIndex;
var MonthId;
var DayId;
var RMonth = 0;
var RYear = 0;
var RDays = 0;


function confirm() {   
	if (confirm("Are you sure?")) 
		{      cleanUp()   }
}


function Calculate(){
	addbus.year.disabled = false;

	
	Data  = Array();
	Data[0] = Array();
	Data[0]['RouteId'] = 68;
	Data[0]['Years'] = Array();
	Data[0]['Days'] = Array();

	Data[0]['Years'][0] = Array();
	Data[0]['Years'][0]['Year'] = '2008';
	Data[0]['Years'][0]['Months'] = Array();
	Data[0]['Years'][0]['Months'][3] = 'March';
	Data[0]['Years'][0]['Months'][5] = 'May';
	
	Data[0]['Years'][1]['Year'] = '2009';
	
	Data[0]['Days'][0] = 1;
	Data[0]['Days'][1] = 3;
	Data[0]['Days'][2] = 5;
	Data[0]['Days'][3] = 10;
	
	Years = Array();
	Years[68] = Array();
	Years[68][0] = '2004';
	Years[68][1] = '2005';
	Years[68]['month'] = Array();
	Years[68]['month'][0] = 'test';
//	Years[68]['999'][2005] = Array();
//	Years[68]['999'][2005][1] = 1;
//	Years[68][999][2005][21] = 'zJanuary';
	
	Years[69] = Array();
	Years[69][0] = '2007';
//	Years[69][1] = '2008';

		

//	Months[68][2005][3] = 3;
//	Months[68][2005][23] = 'March';
	Months = Array();
	Months[68] = Array();
	Months[68][2004] = Array();
	Months[68][2004][1] = 1;
	Months[68][2004][21] = 'J1anuary';
	Months[68][2004][5] = 5;
	Months[68][2004][25] = 'May';
	
	Months[69] = Array();
	Months[69][2007] = Array();
	Months[69][2007][1] = 1;
	Months[69][2007][21] = 'January';
	Days = Array();
	Days[68] = Array();
	Days[68][2005] = Array();
	
	Days[68][2005][3] = Array();
	Days[68][2005][3][0] = 1;
	Days[68][2005][3][1] = 3;
	Days[68][2005][3][2] = 6;	


	
	
	//years
	//Data = this.Data;

	if(this.RouteId == null) this.RouteId = 99;
	if(this.YearId == null) this.YearId = 99;
	if(this.MonthId == null) this.MonthId = 99;
	if(this.DayId == null) this.DayId = 99;
	var j;
	var Index;

	for(i=0;i<Data.length;i++){ 
	
		if(Data[i]['RouteId'] == this.RouteId){
			
			Index = i;
			break;
		}else {
			Index = null;
			addbus.year.disabled = true
		}		
	
	}
	
	if((this.RYear == 1) && Index != null){
				
		for(j=0;j<Data[Index]['Years'].length;j++){
			addbus.year.options[j+1] = new Option(Data[Index]['Years'][j],Data[Index]['Years'][j],false,false);
			
				
		}	
	
		
	}else{

		addbus.year.options[this.YearIdIndex].selected = true;

		addbus.month.disabled = true;
		addbus.days.disabled = true;
	}


	if( (this.RMonth == 1) ){

		addbus.month.disabled = false;
		j=1;
	
		for (i=0;i<12;i++) {

			if(Data[Index]['Months'][i] != null) {
			
				addbus.month.options[j] = new Option(Data[Index]['Months'][i],Data[Index]['Months'][i],false,false);
				j++;
			}
		
		
			
		}	
	
		addbus.month.options[0].selected = true;

	}else{

	addbus.year.options[this.YearIdIndex].selected = true;
//		addbus.month.disabled = true;
//		addbus.day.disabled = true;
	}

	if(this.RDays == 1){
		addbus.month.disabled = false;
		addbus.days.disabled = false;
		for (i=0;i<Data[Index]['Days'].length;i++) {
	
				addbus.days.options[i+1] = new Option(Data[Index]['Days'][i],Data[Index]['Days'][i],false,false);
		
			
		
		
			
		}
	
	
	}else{
	
		addbus.days.options[0].selected = true;
	
	}

}

function OnYearChange(YearId,YearIdIndex){

	this.YearIdIndex = YearIdIndex;
	this.YearId = YearId;
	addbus.days.disabled = true;
	
	
	this.RYear = 0;
	this.RMonth = 1;
	this.RDays = 0;

	this.Calculate();
	
}
function OnMonthChange(MonthId,MonthIdIndex){

	this.MonthIdIndex = MonthIdIndex;
	this.MonthId = MonthId;


	this.RYear = 0;
	this.RMonth = 0;
	this.RDays = 1;
	this.Calculate();
	
}
function OnRouteChange(RouteId,RouteIdIndex){


	this.RouteId = RouteId;
	this.RouteIdIndex = RouteIdIndex;
	this.MonthIdIndex = 0;
	addbus.days.disabled = true;
	addbus.month.disabled = true;
	
	this.RYear = 1;
	this.RMonth = 0;
	this.RDays = 0;
	this.Calculate();
	



	
return false;
}

//-->
</script>