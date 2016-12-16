
<div class="socials">
		
			<div class ="socialdivs">
				
				<div class = "fb">
				<a href = "http://facebook.com" target ="_blank" class="sociallink"><i class="icon-facebook-rect"></i> </a>
							
				</div>
				<div class = "yt">
				<a href = "http://youtube.com" target ="_blank" class="sociallink"><i class="icon-youtube"></i> </a>
							
				</div>
				<div class = "tw">
				<a href = "http://twitter.com" target ="_blank" class="sociallink"><i class="icon-twitter-bird"></i> </a>
						
				</div>
				<div class = "gplus">
				<a href = "http://plus.google.com" target ="_blank" class="sociallink"><i class="icon-googleplus-rect"></i> </a>
							
				</div>
				
				<div style = "clear:both"></div>
			
			
			</div>	<!-- end_socialivs -->
			
		
		</div>	<!-- end_socials -->
		
		</div>
		
		<div class="footer">Witcher 3 &copy; 2016 Thank you for visiting our web site :-)
		
		</div>
		
		<div id="zegar"> </div>
	</div>
	
	
	
	<script src="jquery-3.1.0.min.js"></script>
	
	<script>

			$(document).ready(function() {
			var NavY = $('.nav').offset().top;
			 
			var stickyNav = function(){
			var ScrollY = $(window).scrollTop();
				  
			if (ScrollY >NavY) { 

				$('.nav').addClass('sticky');
				$('.pasek').addClass('aktywnypasek'); 
			} else {
				$('.nav').removeClass('sticky'); 
				$('.pasek').removeClass('aktywnypasek');
			}
			};
			 
			stickyNav();
			 
			$(window).scroll(function() {
				stickyNav();
			});
			});
		
	</script>

 

