
var listing_id;
var current_tab_id = 0;
var new_tab_id;
var add_listing_id;
var gmap_markers = new Array();

function showSubs(num,div) {
	var targetSub = document.getElementById("sub" + num);
	if(!targetSub) return;
	targetSub.style.left = getLeft(div) + Element.getWidth(div) - 5 + "px";
	if (targetSub.className == "submenuBubble") {
		targetSub.style.top = getTop(div) + Element.getHeight(div) - 105 + "px";
	} else {
		targetSub.style.top = getTop(div) + Element.getHeight(div) - 78 + "px";
	}
	targetSub.style.display = "";
	
	div.onmouseout = function() {
		targetSub.style.display = "none";
	}
}

function showLocationBubble(id) {

	var target = document.getElementById("locationBubble");
	var div = document.getElementById("changeLocation");
	if(id) {
		div = document.getElementById(id);
	}
		
	target.style.left = getLeft(div) + Element.getWidth(div) - 200 + "px";
	target.style.top = getTop(div) + Element.getHeight(div) + "px";
	target.style.display = "";
	
/*	div.onclick = function() {
		if(target.style.display == "") target.style.display = "none";
		else target.onclick = showLocationBubble();
	}*/
	target.onmouseout = function() {
		target.style.display = "none";
	}
}

function showFlagBubble(listing_id,flagLink) {
	this.listing_id = listing_id
	
	var target = document.getElementById("flagBubble");
	if(flagLink) var div = flagLink;
	else var div = document.getElementById("flagLink" + listing_id);
	
	if(!div)  div = document.getElementById("flagLink");

	target.style.left = getLeft(div) + Element.getWidth(div) + "px";
	target.style.top = getTop(div) + Element.getHeight(div) - 50 + "px";
	target.style.display = "";
	
/*	div.onclick = function() {
		if(target.style.display == "") target.style.display = "none";
		else target.onclick = showFlagBubble();
	}
	*/
	target.onmouseout = function() {
		
		target.style.display = "none";
	}
}

function getLeft(obj) {
	if ('string' == typeof obj)
	obj = document.getElementById(obj);
	var x = 0;
	while (obj != null) {
		x += obj.offsetLeft;
		obj = obj.offsetParent;
	}
	return x;
}

function getTop(obj) {
	if ('string' == typeof obj)
	obj = document.getElementById(obj);
	var y = 0;
	while (obj != null) {
		y += obj.offsetTop;
		obj = obj.offsetParent;
	}
	return y;
}

function showDiv(id) {
	document.getElementById(id).style.display = "block";	
}
function hideDiv(id) {
	document.getElementById(id).style.display = "none";	
}

// Contact Form //


function clearContactForm() {
	document.contact.name.value = "";
	document.contact.email.value = "";
	document.contact.message.value = "";
	document.contact.security.value = "";
}
function switchTab_mypostings(num,isListingPage,getFolderI) {

//	for (var i = 0; i < 10; i++) {
//alert(num);

tab = document.getElementById("tab" + num);
if(tab){
		tab.className = "tabCurrent";
		this.current_tab_id = num;
	
		document.getElementById("listings" + num).style.display = "block";
					
		
}



	


for (var i=1;i<5;i++) {
		var _tab = document.getElementById("tab" +  i);
		
		if(_tab && _tab.id != 'tab'+num){
			document.getElementById("tab" +   i).className = "tab";
		
			document.getElementById("listings" + i).style.display = "none";
		}
			
		
	}
	
}
function switchTab(num,isListingPage,getFolderI) {

//	for (var i = 0; i < 10; i++) {
//alert(num);

var tab = document.getElementById("tab" + num);
if(tab){
		if(tab.parentNode.id == 'tabsHidden') showNextTab(0);
		else showPrevTab(0);
		tab.className = "tabCurrent";
		this.current_tab_id = num;
		if(getFolderI) getFolderItems(num);
		if (isListingPage) {
					document.getElementById("listings" + num).style.display = "block";
					
		}
}



	


for (var i in  folders_array) {
		var _tab = document.getElementById("tab" +  folders_array[i].search_id);
		
		if(_tab && _tab.id != 'tab'+num)	document.getElementById("tab" +  folders_array[i].search_id).className = "tab";
		if (isListingPage) {
					document.getElementById("listings" + i).style.display = "none";
		}			

/*
		if (document.getElementById("tab" + num)) {
			if (i == num) {
				document.getElementById("tab" + num).className = "tabCurrent";
				this.current_tab_id = num;
				if(getFolderI) getFolderItems(num);
				if (isListingPage) {
					document.getElementById("listings" + num).style.display = "block";
				}
			} else {
				document.getElementById("tab" + num).className = "tab";
				if (isListingPage) {
					document.getElementById("listings" + num).style.display = "none";
				}
			}
		}*/
		
		
	}
	
	
	/*
	tab = document.getElementById("tab" + num);
	if(tab){
		tab.className = "tabCurrent";
		this.current_tab_id = num;
		if(getFolderI) getFolderItems(num);
		if (isListingPage) {
					document.getElementById("listings" + num).style.display = "block";
					
		}
	

	
	
		for(var i = 0; i < 20; i++){
			

					document.getElementById("tab" + i).className = "tab";
					if (isListingPage) {
					document.getElementById("listings" + i).style.display = "none";
					}			
				
	
		}	
			
	}
	
	*/
	
	
}
/*
function renameTab() {
	for (var i = 0; i < 10; i++) {
		if (document.getElementById("tab" + i) && document.getElementById("tab" + i).className == "tabCurrent") {
			break;
		} 
	}
	document.getElementById("tab" + i).innerHTML = "<input type='text' id='rename' style='width: " + (document.getElementById("tab" + i).offsetWidth - 26) + "px;' value='" + document.getElementById("tab" + i).innerHTML + "' />";
	document.getElementById("rename").select();
	
	document.getElementById("rename").onblur = function() {
		document.getElementById("tab" + i).innerHTML = 	document.getElementById("rename").value;
	}
}

function createTab() {
	var counter = 0;
	for (var i = 1; i < 10; i++) {
		if (document.getElementById("tab" + i)) {
			counter++;
		} 
	}
	
	var newTab = document.createElement("div");
	newTab.className = "tab";
	newTab.id = "tab" + (counter+1);
	newTab.onclick = function() { switchTab(counter+1); }
	newTab.innerHTML = "<input type='text' id='newTab' style='width: 80px; height: 15px;' value='' />";
	document.getElementById("tabs").appendChild(newTab);
	document.getElementById("newTab").select();
	
	document.getElementById("newTab").onblur = function() {
		var val = document.getElementById("tab" + (counter+1)).innerHTML = 	document.getElementById("newTab").value;
			addFolderAjax(val);
	}
}
*/


function showNextTab(SwitchToLast) {
	document.getElementById("tabsHidden").style.display = "block";
	document.getElementById("prevTabSet").style.backgroundImage = "url(/../../../images/prev_tabs_arrow.gif)";
	document.getElementById("prevTabSet").style.cursor = "pointer";
	document.getElementById("nextTabSet").style.backgroundImage = "url(/../../../images/more_tabs_arrow_gray.gif)";
	document.getElementById("nextTabSet").style.cursor = "auto";
	document.getElementById("tabs").style.display = "none";
	
	if(SwitchToLast) switchTab(firstHiddenFolderId,0,1);
}
function showPrevTab() {
	document.getElementById("tabsHidden").style.display = "none";
	document.getElementById("prevTabSet").style.backgroundImage = "url(/../../../images/prev_tabs_arrow_gray.gif)";
	document.getElementById("prevTabSet").style.cursor = "auto";
	document.getElementById("nextTabSet").style.backgroundImage = "url(/../../../images/more_tabs_arrow.gif)";
	document.getElementById("nextTabSet").style.cursor = "pointer";
	document.getElementById("tabs").style.display = "block";
	
//	switchTab(DefaultFolderId,0,1);
}

function showFlaggedDetail(id,item_id) {	
	var div = document.getElementById("flaggedDetail"+item_id);
		
	div.style.left = getLeft(id) - 290 + "px";
	div.style.top = getTop(id) - 63 + "px";

	div.style.display = "";
	
	div.onmouseout = function() {
		div.style.display = "none";
	}
}



   
      


function showSaveBubble(div,listing_id) {
	var target = document.getElementById("saveBubble");

//alert ("ok");

	add_listing_id = listing_id;	
	target.style.left = getLeft(div) + Element.getWidth(div) + "px";
	target.style.top = getTop(div) + Element.getHeight(div) - document.getElementById("results").scrollTop - 75 + "px";
	target.style.display = "block";
	
	document.getElementById("mapSmall").onmouseover = function() {
		target.style.display = "none";
		hideDiv("saveToNew"); 
		showDiv("saveTo");
	}

}

