	<?php include('sesja.php'); ?>
<!DOCTYPE HTML>
<html lang="pl">

<head>


	<?php include('naglowek.php'); ?>
		
	
	<style>
	
		body
		{
			font-size: 24px;
			color: white;	
		}
		.tlo
		{
			background-image: none;;
		}
	</style>
	
	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	
	
	<script type="text/javascript">
		
		var numer = Math.floor(Math.random()*5)+1;
		
		var timer1 = 0;
		var timer2 = 0;
		
		
		function ustawslajd(nrslajdu)
		{
			clearTimeout(timer1);
			clearTimeout(timer2);
			numer=nrslajdu - 1;
			
			schowaj();
			setTimeout("zmienslajd()",500);
		
		}
		
		
		function schowaj()
		{
			$("#slider").fadeOut(500);
		}
		
		function zmienslajd()
		{
			numer++; 
			if(numer>5) numer=1;
			
			var plik = "<img src=\"slajdy/slajd" + numer + ".png\" />";
			
			document.getElementById("slider").innerHTML = plik;
			
			
			$("#slider").fadeIn(500);
			
			
			timer1 = setTimeout("zmienslajd()",5000);
			timer2 = setTimeout("schowaj()",4500);
		}
		
		
		
		
	</script>
	
	
	
</head>



<body onload="zmienslajd()">


	<?php include('menu.php'); ?>
	
	
			
			<div id = "slider" > </div>
			
			<div id="slider_menu">
				<span onclick = "ustawslajd(1)" style="cursor:pointer;">[ . ]</span>
				<span onclick = "ustawslajd(2)" style="cursor:pointer;">[ . ]</span>
				<span onclick = "ustawslajd(3)" style="cursor:pointer;">[ . ]</span>
				<span onclick = "ustawslajd(4)" style="cursor:pointer;">[ . ]</span>
				<span onclick = "ustawslajd(5)" style="cursor:pointer;">[ . ]</span>
			</div>
		
		
		
	<?php include('stopka.php'); ?>

 
</body>




</html>