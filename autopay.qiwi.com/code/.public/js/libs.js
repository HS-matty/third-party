$(document).ready(function(){	
	$(".calc").keyup( function() {
		var field1 = $("#field1").val() * 1;
		var field2 = $("#field2").val() * 1;
		var field3 = $("#field3").val() * 1;
		var field4 = $("#field4").val() * 1;
		var field5 = $("#field5").val() * 1;
		var field6 = $("#field6").val() * 1;
		var field7 = $("#field7").val() * 1;
		var field8 = $("#field8").val() * 1;
		var field9 = $("#field9").val() * 1;
		var field10 = $("#field10").val() * 1;
		var field11 = $("#field11").val() * 1;
		var field12 = $("#field12").val() * 1;

		var result = ( field1 * ( field2 + field3 + field4 + field5 + field6 + field7 + field8 + field9 + field10 ) ) + field11 + field12;
		
		if ( result != '' ) {
			$(".calc #answer").text( result );
		}
	});
});



var logopened=false;
$(document).ready(function(){
    $('#logbtn').click(function(){
        if(logopened)
        {
            $('#logform').hide('fast');
            $('#logbtn').removeClass('selected');
        }    
        else
        {
            $('#logform').show('fast');
            $('#logbtn').addClass('selected');
        }
        logopened=!logopened;
        return false;
    });
}).click(function(e){
    if(!logopened)
        return;
    e=e||window.event;
    var target=e.target||e.srcElement;
    while(target)
    {
        if(target==$('#logform').get(0))
            return;
        target=target.parentNode;
    }
    $('#logform').hide('fast');
    $('#logbtn').removeClass('selected');
    logopened=false;    
});

$(document).ready(function(){
		$('#topmenu li.sublnk').hover(
		function() {
			$(this).addClass("selected");
			$(this).find('ul').stop(true, true);
			$(this).find('ul').show('fast');
		},
		function() {
			$(this).find('ul').hide('fast');
			$(this).removeClass("selected");
		}
	);
});

$(document).ready(function(){
	var tabContainers = $('#news-arch .tabcont');
		tabContainers.hide().filter(':first').show();
								
		$('#news-arch .tabmenu a').click(function () {
			tabContainers.hide();
			tabContainers.filter(this.hash).show();
			$('#news-arch .tabmenu a').removeClass('selected');
			$(this).addClass('selected');
			return false;
		}).filter(':first').click();
});