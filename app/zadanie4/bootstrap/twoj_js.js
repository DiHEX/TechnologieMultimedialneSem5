function myLoadHeader() 
{ 
	$(document).ready(function()
	{ 
		$('#myHeader').load("./bootstrap/header.php"); 
	}); 
}

function myLoadHeaderSamePath() 
{ 
	$(document).ready(function()
	{ 
		$('#myHeader').load("./header.php"); 
	}); 
}
