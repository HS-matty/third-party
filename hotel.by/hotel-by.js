<script type="text/javascript" charset="utf-8"> 
			google.load("jquery", "1.4.2");
			
			var popup_hotel_id = null;
			var gps_longitude = null;
			var gps_latitude = null;
			
		</script>

		
				
			<script type="text/javascript">
			
				function  _callback(){
				
					 getRoomsByHotelId(15);			
			;
			
					return ;
				
				}
				function getRoomsByHotelId(id){
			//	alert( window.popup_hotel_id);
			
					var ajax_result_html;

					$.ajax({
						type: "GET",
						dataType: "html",
						data: "hotel_id="+window.popup_hotel_id + "&lang=ru&search_id=" ,
						url: "/ajax/searchbyhotel/",
						cache: false,
						success: function(data){
							$("#numer").html(data);
							
						}
					});
					
					return ;

					
				}
				
			
				$(document).ready(function(){			
						
			
					$("a[rel^='prettyPhoto']").prettyPhoto({
						custom_markup: '<div id="map_canvas" style="width:810px; height:520px"></div>',
						changepicturecallback: function(){ initialize(); }
					});
                    
                    
                    	$("a[rel^='prettyPhotoRoom']").prettyPhoto({
						custom_markup: '<div id="numer" style="width:930px; height:400px"></div>',
						changepicturecallback: function(){ _callback();}
					});
                    
				});
				
				
				
				
				
						
				
			</script>
		
				<!-- Google Maps Code -->
				<script type="text/javascript"
				    src="http://maps.google.com/maps/api/js?sensor=true">
				</script>
				<script type="text/javascript">
                    function initialize() {
                        var latlng = new google.maps.LatLng(
            			 /*parseFloat('34.162532'),
            			parseFloat('-118.255639')*/
							parseFloat(window.gps_latitude), 
            			  	parseFloat(window.gps_longitude)
            			);
            
            			var map = new google.maps.Map(
            				document.getElementById("map_canvas"),
            				{
            			      zoom		: 15,
            			      center	: latlng,
                         
            			      mapTypeId	: google.maps.MapTypeId.ROADMAP
            			    }
            			);
            
            		    var marker = new google.maps.MarkerImage(
            	        	"/i/star.png",
            	        	new google.maps.Size(25, 25),
            	        	new google.maps.Point(0, 0),
            	        	new google.maps.Point(12, 12)
            	        );
            		    new google.maps.Marker({
            		        position: latlng,
            		        map : map,
            		        icon: marker
            		    });
                 
				  }

				</script>
				
				
				<script type="text/javascript">
			
				function  _callback(){
				
					 getRoomsByHotelId(15);			
			;
			
					return ;
				
				}
				function getRoomsByHotelId(id){
			//	alert( window.popup_hotel_id);
			
					var ajax_result_html;

					$.ajax({
						type: "GET",
						dataType: "html",
						data: "hotel_id="+window.popup_hotel_id + "&lang=ru&search_id=" ,
						url: "/ajax/searchbyhotel/",
						cache: false,
						success: function(data){
							$("#numer").html(data);
							
						}
					});
					
					return ;

					
				}
				
			
				$(document).ready(function(){			
						
			
					$("a[rel^='prettyPhoto']").prettyPhoto({
						custom_markup: '<div id="map_canvas" style="width:810px; height:520px"></div>',
						changepicturecallback: function(){ initialize(); }
					});
                    
                    
                    	$("a[rel^='prettyPhotoRoom']").prettyPhoto({
						custom_markup: '<div id="numer" style="width:930px; height:400px"></div>',
						changepicturecallback: function(){ _callback();}
					});
                    
				});
				
				
				
				
				
						
				
			</script>
		

					
			<script type="text/javascript">
			
				function  _callback(){
				
					 getRoomsByHotelId(15);			
			;
			
					return ;
				
				}
				function getRoomsByHotelId(id){
			//	alert( window.popup_hotel_id);
			
					var ajax_result_html;

					$.ajax({
						type: "GET",
						dataType: "html",
						data: "hotel_id="+window.popup_hotel_id + "&lang=ru&search_id=" ,
						url: "/ajax/searchbyhotel/",
						cache: false,
						success: function(data){
							$("#numer").html(data);
							
						}
					});
					
					return ;

					
				}
				
			
				$(document).ready(function(){			
						
			
					$("a[rel^='prettyPhoto']").prettyPhoto({
						custom_markup: '<div id="map_canvas" style="width:810px; height:520px"></div>',
						changepicturecallback: function(){ initialize(); }
					});
                    
                    
                    	$("a[rel^='prettyPhotoRoom']").prettyPhoto({
						custom_markup: '<div id="numer" style="width:930px; height:400px"></div>',
						changepicturecallback: function(){ _callback();}
					});
                    
				});
				
				
				
				
				
						
				
			</script>

