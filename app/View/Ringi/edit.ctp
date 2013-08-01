<?php echo $doc ?>

<?php echo ("<input type='hidden' name='ringino' value="."$ringino"." id='ringino'>") ?>
<br>

<script type="text/javascript" charset="utf-8">

function delet()
{
 document.applyForm.action ="ringi/delete";
}

function reapply()
{
document.applyForm.action = "ringi/reapply";
document.applyForm.onsubmit="return main()";		//was deleted but not saved
}

function main(){
	return (nullCheck("ringino") &&
                nullCheck("linecd") &&
                doubleCheck("assetdept","expensedept")&&
                nullCheck("project") &&
                nullCheck("purpose") &&
                nullCheck("assetbudget") &&
                typeCheck("assetbudget")&&
                nullCheck("assetremain") &&
                typeCheck("assetremain")&&
                nullCheck("expensebudget") &&
                typeCheck("expensebudget")&&
                nullCheck("expenseremain") &&
                typeCheck("expenseremain")&&
                doubleCheck("asset","expense")&&
                typeCheck("asset")&&
                typeCheck("expense")&&
        	doubleCheck("assetaccountno","expenseaccountno"));
}	
function nullCheck(var1){
	//var input = ["ringino","linecd","project","purpose"];

	var x=document.forms["applyForm"][var1].value;
	if (x==null || x=="") {
		document.getElementById(var1).style.border = "2px solid #ff0000";
		document.getElementById(var1).focus();
		document.getElementById(var1).select();
                
		alert("Fill out all necessary fields");
		return false;
	}
	return true;
}

function typeCheck(var1){
	//var input = ["asset","expense","assetbudget","expensebudget","assetremain","expenseremain"];

	var pattern1 = /^\d+[\\.]\d+$/;
	var pattern2 = /^\d*$/;
	var x=document.forms["applyForm"][var1].value;
	if ((x.match(pattern1) == null) && (x.match(pattern2) == null)) {
		document.getElementById(var1).style.border = "2px solid blue";;
		document.getElementById(var1).focus();
		document.getElementById(var1).select();
		alert("Type error");
		return false;           
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
