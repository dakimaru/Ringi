<?php print_r("$doc"); ?>

</script type="text/javascript" charset="utf-8">

function main(){
	return (nullCheck() && 
	typeCheck()&&
	doubleCheck("assetdept","expensedept")&&
	doubleCheck("asset","expense")&&
	doubleCheck("assetaccountno","expenseaccountno"));
}	

function nullCheck()
{
	var input = ["ringino","linecd","project","purpose"];

	var setAlert = 0;
	for (var i=input.length -1; i >= 0; i--) {
		var x=document.forms["applyForm"][input[i]].value;
		if (x==null || x=="") {
			document.getElementById(input[i]).style.border = "2px solid #ff0000";
			document.getElementById(input[i]).focus();
			document.getElementById(input[i]).select();
			setAlert=1;
		}
	};
	if (setAlert==1) {
		alert("Fill out all necessary fields");
		return false;
	};
	return true;
}

function typeCheck()
{
	var input = ["asset","expense","assetbudget","expensebudget","assetremain","expenseremain"];

	var setAlert = 0;
	var pattern = /^\d+.?\d*[^.]$/;
	for (var i=input.length -1; i >= 0; i--) {
		var x=document.forms["applyForm"][input[i]].value;
		if (x.match(pattern) == null) {
			document.getElementById(input[i]).style.border = "2px solid blue";;
			document.getElementById(input[i]).focus();
			document.getElementById(input[i]).select();
			setAlert=2;               
		}            
	};
	if (setAlert==2) {
		alert("Type error");
		return false;
	};
	return true;
}

function doubleCheck(var1,var2) {
	var setAlert = 0;
	var x=document.forms["applyForm"][var1].value;
	var y=document.forms["applyForm"][var2].value;
	if ((x==null || x=="") && (y==null || y=="")) {
		document.getElementById(var1).style.border = "2px solid green";
		document.getElementById(var2).style.border = "2px solid green";
		document.getElementById(var1).focus();
		document.getElementById(var1).select();
		setAlert=3;
	}
	if (setAlert==3) {
		alert("Double error");
		return false;
	};
	return true;
}
</script>