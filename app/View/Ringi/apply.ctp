<?php 

//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($ringiunique)) {
	//print_r($ringiunique[0]);
	//if ($ringiunique[0]>0) {
	//	$this->session->flash("Your passwords don't match!");
	//}
//}

print_r("$doc"); 

?>

<script type="text/javascript" charset="utf-8">

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

	for (var i=0; i < input.length; i++) {
		var x=document.forms["applyForm"][input[i]].value;
		if (x==null || x=="") {
			document.getElementById(input[i]).style.border = "2px solid #ff0000";
			document.getElementById(input[i]).focus();
			document.getElementById(input[i]).select();
			alert("Fill out all necessary fields");
			return false;
		}
	}
	return true;
}

function typeCheck()
{
	var input = ["asset","expense","assetbudget","expensebudget","assetremain","expenseremain"];

	var pattern1 = /^\d+[\\.]\d+$/;
	var pattern2 = /^\d+$/;
	for (var i=0; i < input.length; i++) {
		var x=document.forms["applyForm"][input[i]].value;
		if ((x.match(pattern1) == null) && (x.match(pattern2) == null)) {
			document.getElementById(input[i]).style.border = "2px solid blue";;
			document.getElementById(input[i]).focus();
			document.getElementById(input[i]).select();
			alert("Type error");
			return false;           
		}            
	}
	return true;
}

function doubleCheck(var1,var2) {
	var x=document.forms["applyForm"][var1].value;
	var y=document.forms["applyForm"][var2].value;
	if ((x==null || x=="") && (y==null || y=="")) {
		document.getElementById(var1).style.border = "2px solid green";
		document.getElementById(var2).style.border = "2px solid green";
		document.getElementById(var1).focus();
		document.getElementById(var1).select();
		alert("Double error");
		return false;
	}
	return true;
}
</script>