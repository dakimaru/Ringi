<?php print_r("$doc"); ?>

<script type="text/javascript" charset="utf-8">
	function validateForm()
	{
		var input = ["ringino","lineCd","assetdept","expensedept","assetbudget","assetremain","description","purpose""expensebudget","assetaccountno"];
		
		var setAlert = 0;
		for (var i=input.length -1; i >= 0; i--) {
			var x=document.forms["applyForm"][input[i]].value;
			if (x==null || x=="") {
				document.getElementById(input[i]).style.border = "1px solid #ff0000";;
				document.getElementById(input[i]).focus();
				document.getElementById(input[i]).select();
				setAlert=1;
			}
		};
		if (setAlert=1) {
			alert("Fill out all necessary fields");
			return false;
		};
	}
</script>