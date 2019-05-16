<a href="#" id="windowOpen">Open window</a>
<div id="window">
	<div id="windowTop">
		<div id="windowTopContent">Window example</div>
		<img src="{$HostName}/images/window_min.jpg" id="windowMin" />
		<img src="{$HostName}/images/window_max.jpg" id="windowMax" />
		<img src="{$HostName}/images/window_close.jpg" id="windowClose" />
	</div>
	<div id="windowBottom"><div id="windowBottomContent">&nbsp;</div></div>

	<div id="windowContent"><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut eget  lectus in diam iaculis tempor. Suspendisse consectetuer, justo nec  euismod sodales, augue nisi convallis diam, in posuere pede turpis at  massa. Donec mi nunc, iaculis eu, vehicula sed, malesuada eget, ligula.  In eu urna. Suspendisse pede quam, tempor id, tempor at, placerat eget,  massa. Maecenas porta elementum tellus. Ut nulla diam, posuere non,  consequat nec, fermentum vitae, turpis. Pellentesque tempor metus at  lorem. Donec nulla ipsum, euismod in, pretium vitae, ornare nonummy,  lectus. Aliquam ullamcorper. Vestibulum eget leo. Proin pretium, enim  vitae bibendum accumsan, dolor urna feugiat felis, et ultrices ipsum  odio et dui. Praesent non eros sit amet nisi laoreet aliquet. Nulla  diam. Maecenas et sem eget lorem porttitor tincidunt. Donec sed dui. </p>
	  <p>Nam non dolor. Donec ultricies mattis libero. Donec ac eros.  Praesent id arcu. Phasellus odio massa, blandit nec, iaculis ac,  blandit nec, enim. Nunc rutrum. Mauris pretium mattis nunc. Integer  lectus. Suspendisse potenti. Ut dignissim enim eget ipsum. Suspendisse  eget nulla ac dolor volutpat pellentesque. Donec odio diam, pulvinar  sed, ornare a, semper in, nisi. Duis a odio id enim lacinia fringilla.  Integer rutrum erat in ante. Morbi eleifend ipsum vel quam. Vestibulum  in mauris. Donec vulputate hendrerit nulla. </p>
	  <p>Phasellus nulla ipsum, dapibus et, laoreet quis, volutpat sed, nibh.  Nunc massa ipsum, vehicula et, ullamcorper fermentum, imperdiet vitae,  enim. Morbi non augue. Morbi vitae sapien. Nulla at metus. Pellentesque  a sem id arcu faucibus tincidunt. Pellentesque sit amet urna quis arcu  elementum volutpat. Sed sed sapien. Suspendisse cursus. Nulla commodo  libero ac tortor dictum pulvinar. Mauris id leo non velit iaculis  mollis. Fusce at augue ut mi laoreet molestie. Quisque facilisis.  Maecenas ornare mattis justo. Vestibulum vel lorem in nisl venenatis  semper. Aliquam erat volutpat. Aliquam tellus turpis, posuere eu,  commodo sed, fermentum sit amet, mi. </p>
	</div>
	<img src="{$HostName}/images/window_resize.gif" id="windowResize" />
</div>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut eget  lectus in diam iaculis tempor. Suspendisse consectetuer, justo nec  euismod sodales, augue nisi convallis diam, in posuere pede turpis at  massa. Donec mi nunc, iaculis eu, vehicula sed, malesuada eget, ligula.  In eu urna. Suspendisse pede quam, tempor id, tempor at, placerat eget,  massa. Maecenas porta elementum tellus. Ut nulla diam, posuere non,  consequat nec, fermentum vitae, turpis. Pellentesque tempor metus at  lorem. Donec nulla ipsum, euismod in, pretium vitae, ornare nonummy,  lectus. Aliquam ullamcorper. Vestibulum eget leo. Proin pretium, enim  vitae bibendum accumsan, dolor urna feugiat felis, et ultrices ipsum  odio et dui. Praesent non eros sit amet nisi laoreet aliquet. Nulla  diam. Maecenas et sem eget lorem porttitor tincidunt. Donec sed dui. </p>
	  <p>Nam non dolor. Donec ultricies mattis libero. Donec ac eros.  Praesent id arcu. Phasellus odio massa, blandit nec, iaculis ac,  blandit nec, enim. Nunc rutrum. Mauris pretium mattis nunc. Integer  lectus. Suspendisse potenti. Ut dignissim enim eget ipsum. Suspendisse  eget nulla ac dolor volutpat pellentesque. Donec odio diam, pulvinar  sed, ornare a, semper in, nisi. Duis a odio id enim lacinia fringilla.  Integer rutrum erat in ante. Morbi eleifend ipsum vel quam. Vestibulum  in mauris. Donec vulputate hendrerit nulla. </p>

	  <p>Phasellus nulla ipsum, dapibus et, laoreet quis, volutpat sed, nibh.  Nunc massa ipsum, vehicula et, ullamcorper fermentum, imperdiet vitae,  enim. Morbi non augue. Morbi vitae sapien. Nulla at metus. Pellentesque  a sem id arcu faucibus tincidunt. Pellentesque sit amet urna quis arcu  elementum volutpat. Sed sed sapien. Suspendisse cursus. Nulla commodo  libero ac tortor dictum pulvinar. Mauris id leo non velit iaculis  mollis. Fusce at augue ut mi laoreet molestie. Quisque facilisis.  Maecenas ornare mattis justo. Vestibulum vel lorem in nisl venenatis  semper. Aliquam erat volutpat. Aliquam tellus turpis, posuere eu,  commodo sed, fermentum sit amet, mi. </p>
	  {literal}
<script type="text/javascript">
$(document).ready(
	function()
	{
		$('#windowOpen').bind(
			'click',
			function() {
				if($('#window').css('display') == 'none') {
					$(this).TransferTo(
						{
							to:'window',
							className:'transferer2', 
							duration: 400,
							complete: function()
							{
								$('#window').show();
							}
						}
					);
				}
				this.blur();
				return false;
			}
		);
		$('#windowClose').bind(
			'click',
			function()
			{
				$('#window').TransferTo(
					{
						to:'windowOpen',
						className:'transferer2', 
						duration: 400
					}
				).hide();
			}
		);
		$('#windowMin').bind(
			'click',
			function()
			{
				$('#windowContent').SlideToggleUp(300);
				$('#windowBottom, #windowBottomContent').animate({height: 10}, 300);
				$('#window').animate({height:40},300).get(0).isMinimized = true;
				$(this).hide();
				$('#windowResize').hide();
				$('#windowMax').show();
			}
		);
		$('#windowMax').bind(
			'click',
			function()
			{
				var windowSize = $.iUtil.getSize(document.getElementById('windowContent'));
				$('#windowContent').SlideToggleUp(300);
				$('#windowBottom, #windowBottomContent').animate({height: windowSize.hb + 13}, 300);
				$('#window').animate({height:windowSize.hb+43}, 300).get(0).isMinimized = false;
				$(this).hide();
				$('#windowMin, #windowResize').show();
			}
		);
		$('#window').Resizable(
			{
				minWidth: 200,
				minHeight: 60,
				maxWidth: 700,
				maxHeight: 400,
				dragHandle: '#windowTop',
				handlers: {
					se: '#windowResize'
				},
				onResize : function(size, position) {
					$('#windowBottom, #windowBottomContent').css('height', size.height-33 + 'px');
					var windowContentEl = $('#windowContent').css('width', size.width - 25 + 'px');
					if (!document.getElementById('window').isMinimized) {
						windowContentEl.css('height', size.height - 48 + 'px');
					}
				}
			}
		);
	}
);
</script>

{/literal}