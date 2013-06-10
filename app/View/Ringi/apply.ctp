<script>

$(document).ready()

	function raplace() {
		
		var replaced = $("body").html().replace(/xxx/g,'<textarea class="textarea" id=0 style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none"></textarea>');
		
	//$('body').html(replaced);
	}
	
	function changeAtt() {
	
		var i=2;
		while (document.getElementById('0')) {
			//$('#0')[0].name = 'text'+i;
			//$('#0')[0].id = i;
			document.getElementById("0").name = "text" + i;
			document.getElementById("0").id = i;
			//document.getElementById("0").setAttribute("name","text"+i);
			//document.getElementById("0").setAttribute("id",i);
			i++;
			
			
		};
	};
	
</script>

<form method="post" action="apply_check" name="apply_check1">
	
<?php
//$this->Html->script('jquery'); //Include jQuery libarary under webroot/libs

$excelfile = "Ringi.xls";
$data = new Spreadsheet_Excel_Reader($excelfile); 

		$objPHPExcel = PHPExcel_IOFactory::load($excelfile);
		
		//header('Content-Type: application/vnd.ms-excel'); 
		//header('Content-Disposition: attachment;filename="myfile.xls"'); 
		//header('Cache-Control: max-age=0');
		
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
		$starting_row = 1;
		
		//$objPHPExcel->getActiveSheet()->SetCellValue('I2', 'xxx');
		
		$objPHPExcel->getActiveSheet()->getStyle("A1:$highestColumn$highestRow")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					for ($i=1; $i < $highestRow; $i++) { 
						for ($j='A'; $j < 'M'; $j++) {
							
							
							if ($objPHPExcel->getActiveSheet()->getCell("$j$i") == 'xxx' or $objPHPExcel->getActiveSheet()->getCell("$j$i") == 'xxxx') {
								$objPHPExcel->getActiveSheet()->SetCellValue("$j$i", 'xxx');
							}
						}		
					}
					
																	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
		 //$objPHPExcel->getActiveSheet()->getStyle("A".$starting_row.":".$highestColumn.$highestRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
		//$objPHPExcel->getActiveSheet()->getStyle("A".$starting_row.":".$highestColumn.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
		//$objPHPExcel->getActiveSheet()->getStyle("A".$starting_row.":".$highestColumn.$highestRow)->getBorders()->getAllBorders()->getColor()->setARGB("FFd0d7e5");
		
		$objWriter->setUseInlineCSS(true);
		
		$objWriter->save('php://output');
		
		
		//outputExcel($objWriter);
		
		

		?>
		
		<div class="text-center">
		<button class="btn btn-success">Apply</button>
		</div>
		
		</form>

	<?//php echo $data->dump(true,true); ?>

<?php /*
<form method="post" action="apply_check" name="apply_check1">
<table border=0 cellpadding=0 cellspacing=0 width=1320 style='border-collapse:
 collapse;table-layout:fixed;width:1320pt'>
 <col class=xl66 width=73 style='mso-width-source:userset;mso-width-alt:3114;
 width:73pt'>
 <col class=xl66 width=129 style='mso-width-source:userset;mso-width-alt:5504;
 width:129pt'>
 <col class=xl66 width=66 style='mso-width-source:userset;mso-width-alt:2816;
 width:66pt'>
 <col class=xl66 width=57 style='mso-width-source:userset;mso-width-alt:2432;
 width:57pt'>
 <col class=xl66 width=84 style='mso-width-source:userset;mso-width-alt:3584;
 width:84pt'>
 <col class=xl66 width=78 style='mso-width-source:userset;mso-width-alt:3328;
 width:78pt'>
 <col class=xl66 width=44 style='mso-width-source:userset;mso-width-alt:1877;
 width:44pt'>
 <col class=xl66 width=45 style='mso-width-source:userset;mso-width-alt:1920;
 width:45pt'>
 <col class=xl66 width=81 style='mso-width-source:userset;mso-width-alt:3456;
 width:81pt'>
 <col class=xl66 width=73 style='mso-width-source:userset;mso-width-alt:3114;
 width:73pt'>
 <col class=xl66 width=48 style='mso-width-source:userset;mso-width-alt:2048;
 width:48pt'>
 <col class=xl66 width=52 style='mso-width-source:userset;mso-width-alt:2218;
 width:52pt'>
 <col class=xl66 width=61 style='mso-width-source:userset;mso-width-alt:2602;
 width:61pt'>
 <col class=xl66 width=55 style='width:55pt'>
 <col class=xl66 width=69 style='mso-width-source:userset;mso-width-alt:2944;
 width:69pt'>
 <col class=xl66 width=305 style='mso-width-source:userset;mso-width-alt:13013;
 width:305pt'>
 <tr height=29 style='height:29.0pt'>
  <td height=29 width=73 style='height:29.0pt;width:73pt' align=left
  valign=top><span style='position:relative;z-index:1'><span style='position:
  absolute;left:71px;top:-1px;width:71px;height:50px'><span style='position:
  absolute;z-index:1;margin-left:11px;margin-top:0px;width:47px;height:33px'><img
  width=47 height=33 src="/Applications/XAMPP/htdocs/Ringi/app/View/Ringi/Ringi_files/image001.png" alt="AWNC Picture2"></span><span
  style='position:absolute;z-index:1;margin-left:0px;margin-top:31px;
  width:71px;height:19px'><img width=71 height=19
  src="/Applications/XAMPP/htdocs/Ringi/app/View/Ringi/Ringi_files/image002.png"></span></span></span>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=29 class=xl66 width=73 style='height:29.0pt;width:73pt'></td>
   </tr>
  </table>
  </span></td>
  <td colspan=6 rowspan=2 class=xl176 width=458 style='width:458pt'><a
  name="Print_Area">RINGI</a></td>
  <td class=xl65 width=45 style='width:45pt'></td>
  <td class=xl66 width=81 style='width:81pt'></td>
  <td class=xl66 width=73 style='width:73pt'></td>
  <td class=xl66 width=48 style='width:48pt'></td>
  <td class=xl66 width=52 style='width:52pt'></td>
  <td class=xl66 width=61 style='width:61pt'></td>
  <td class=xl66 width=55 style='width:55pt'></td>
  <td class=xl66 width=69 style='width:69pt'></td>
  <td class=xl66 width=305 style='width:305pt'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td class=xl65></td>
  <td rowspan=2 class=xl123 style='border-bottom:1.0pt solid black'>Ringi No.</td>
  <td colspan=4 rowspan=2 class=xl166 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <?php echo "$ringino"; ?>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=16 style='mso-height-source:userset;height:16.5pt'>
  <td height=16 class=xl66 style='height:16.5pt'></td>
  <td colspan=7 class=xl188>Document effective: November 2012</td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='mso-height-source:userset;height:15.75pt'>
  <td height=15 class=xl66 style='height:15.75pt'></td>
  <td class=xl103>Director</td>
  <td colspan=2 class=xl157 style='border-right:1.0pt solid black'>Director</td>
  <td colspan=2 class=xl131 style='border-right:1.0pt solid black;border-left:
  none'>Tresurer</td>
  <td colspan=3 class=xl189 style='border-right:1.0pt solid black;border-left:
  none'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Request By:</td>
  <td colspan=4 class=xl184 style='border-right:1.0pt solid black;border-left:
  none'>
  <?php echo "$username"; ?>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='mso-height-source:userset;height:15.75pt'>
  <td height=15 class=xl66 style='height:15.75pt'></td>
  <td rowspan=2 class=xl123 style='border-bottom:1.0pt solid black;border-top:
  none'>
  xxxxx
  </td>
  <td colspan=2 rowspan=2 class=xl132 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  xxxx
  </td>
  <td colspan=2 rowspan=2 class=xl131 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  xxxx
  </td>
  <td colspan=3 class=xl184 style='border-right:1.0pt solid black;border-left:
  none'>Dept:</td>
  <td colspan=4 class=xl179 style='border-right:1.0pt solid black;border-left:
  none'>
  <textarea cols="40" wrap="soft" align="center" name="text5" id="text5"></textarea> 
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=51 style='mso-height-source:userset;height:51.0pt'>
  <td height=51 class=xl66 style='height:51.0pt'></td>
  <td colspan=2 class=xl122 style='border-right:1.0pt solid black;border-left:
  none'>
  xxxx
  </td>
  <td class=xl110 style='border-top:none;border-left:none'>
  xxxx
  </td>
  <td colspan=2 class=xl122 style='border-right:1.0pt solid black;border-left:
  none'> 
  xxxx
  </td>
  <td colspan=2 class=xl122 style='border-right:1.0pt solid black;border-left:
  none'>
  xxxx
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=18 style='height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td class=xl104 style='border-top:none'>PR</td>
  <td colspan=2 class=xl159 style='border-right:1.0pt solid black'>
  <textarea cols="15" wrap="soft" align="center" name="text10" id="text10"></textarea>
  </td>
  <td colspan=2 class=xl155 style='border-right:1.0pt solid black;border-left:
  none'>HR</td>
  <td colspan=2 class=xl158 style='border-right:1.0pt solid black;border-left:
  none'>GM</td>
  <td class=xl87 style='border-left:none'>AGM</td>
  <td colspan=2 class=xl92 style='border-right:1.0pt solid black;border-left:
  none'>MGR</td>
  <td colspan=2 class=xl192 style='border-right:1.0pt solid black'>Requester</td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:17.25pt'>
  <td height=17 class=xl66 style='height:17.25pt'></td>
  <td class=xl111 style='border-top:none'>
  xxx
  </td>
  <td colspan=2 class=xl111 style='border-right:1.0pt solid black'>
  xxxx
  </td>
  <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:
  none'>
  xxx
  </td>
  <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:
  none'>
  xxxx
  </td>
  <td class=xl112 style='border-left:none'>
  xxxxx
  </td>
  <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:
  none'>
  xxxx
  </td>
  <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:
  none'>
  <?php echo date("m-d-Y"); ?> 
  </td>
  <td class=xl67></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:21.75pt'>
  <td height=21 class=xl66 style='height:21.75pt'></td>
  <td class=xl96 style='border-top:none'>Project:</td>
  <td colspan=11 class=xl90 style='border-right:1.0pt solid black'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl72></td>
 </tr>
 <tr height=59 style='mso-height-source:userset;height:59.25pt'>
  <td height=59 class=xl66 style='height:59.25pt'></td>
  <td colspan=12 class=xl209 width=818 style='border-right:1.0pt solid black;
  width:818pt'>
  <textarea wrap="soft" cols="150" rows="10" align="center" name="text18" id="text18"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:21.75pt'>
  <td height=21 class=xl66 style='height:21.75pt'></td>
  <td class=xl96 style='border-top:none'>Purpose:</td>
  <td colspan=11 class=xl90 style='border-right:1.0pt solid black'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=90 style='mso-height-source:userset;height:90.0pt'>
  <td height=90 class=xl66 style='height:90.0pt'></td>
  <td colspan=12 class=xl214 width=818 style='border-right:1.0pt solid black;
  width:818pt'>
  <textarea wrap="soft" cols="150" rows="10" ign="center" name="text19" id="text19"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:24.75pt'>
  <td height=24 class=xl66 style='height:24.75pt'></td>
  <td colspan=4 class=xl205>Comment by related dept:</td>
  <td colspan=2 class=xl199 style='border-right:1.0pt solid black'>Dept:</td>
  <td class=xl94 colspan=3 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>Finace review/comments</td>
  <td class=xl95 style='border-top:none'></td>
  <td colspan=2 class=xl197 style='border-right:1.0pt solid black'>Finance<span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=23 style='mso-height-source:userset;height:23.25pt'>
  <td height=23 class=xl66 style='height:23.25pt'></td>
  <td colspan=4 rowspan=4 class=xl166 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="55" rows="10" align="center" name="text20" id="text20"></textarea>
  </td>
  <td colspan=2 rowspan=2 class=xl166 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="10"  align="center" name="text21" id="text21"></textarea>
  </td>
  <td colspan=4 rowspan=2 class=xl202 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="30" rows="5" align="center" name="text22" id="text22"></textarea>
  </td>
  <td class=xl92 style='border-top:none;border-left:none'>Manager:</td>
  <td class=xl113 style='border-top:none'>
  <textarea wrap="soft" cols="8" rows="2" align="center" name="text23" id="text23"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:24.0pt'>
  <td height=24 class=xl66 style='height:24.0pt'></td>
  <td class=xl93 style='border-top:none;border-left:none'>Date:</td>
  <td class=xl114 style='border-left:none'> 
  <textarea wrap="soft" cols="8" rows="2" align="center" name="text24" id="text24"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:20.25pt'>
  <td height=20 class=xl66 style='height:20.25pt'></td>
  <td colspan=2 class=xl199 style='border:1.0pt'>Dept:</td>
  <td colspan=4 class=xl193 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>Purchasing
  cost compared</td>
  <td colspan=2 class=xl197 style='border-right:1.0pt solid black;border-left:
  none'>Purchasing</td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:21.0pt'>
  <td height=21 class=xl66 style='height:21.0pt'></td>
  <td colspan=2 rowspan=2 class=xl166 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="10" align="center" name="text25" id="text25"></textarea>
   </td>
  <td colspan=4 rowspan=2 class=xl166 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="30" rows="5" align="center" name="text26" id="text26"></textarea>
  </td>
  <td class=xl91 style='border-top:none'>Manager:</td>
  <td class=xl113 style='border-top:none;border-left:none'>
  <textarea wrap="soft" cols="8" rows="2" align="center" name="text27" id="text27"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:24.0pt'>
  <td height=24 class=xl66 style='height:24.0pt'></td>
  <td class=xl97 >Budget No:</td>
  <td colspan=3 class=xl122 style='border-right:1.0pt solid black'>
  <select name="budgetid2">
        <?php foreach($budget_list as $id): ?>
        <option value=<?php echo $id ?> >Budget No: <?php echo $id; ?></option>
        <?php endforeach; ?>
        </select>
  </td>
  <td class=xl93 style='border-left:none'>Date:</td>
  <td class=xl115 style='border-top:none;border-left:none'>
  <textarea wrap="soft" cols="8" rows="2" align="center" name="text29" id="text29"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td class=xl96 style='border-top:none'></td>
  <td colspan=6 class=xl90 style='border-right:1.0pt solid black'>Asset(US$)</td>
  <td colspan=5 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>Expense (US$)</td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=19 style='height:19.0pt'>
  <td height=19 class=xl66 style='height:19.0pt'></td>
  <td class=xl90 style='border-top:none'>Fiscal year</td>
  <td colspan=3 class=xl90 style='border-right:1.0pt solid black'>Current year</td>
  <td colspan=3 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>Remain cost</td>
  <td colspan=2 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>Current Year</td>
  <td colspan=3 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>Remain cost</td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=27 style='mso-height-source:userset;height:27.0pt'>
  <td height=27 class=xl66 style='height:27.0pt'></td>
  <td class=xl88 style='border-top:none'>Budget</td>
  <td colspan=3 class=xl223 style='border-right:1.0pt solid black;border-left:
  none'>
  <textarea wrap="soft" cols="15" rows="2" align="center" name="text30" id="text30"></textarea>
  </td>
  <td colspan=3 class=xl174 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" cols="15" rows="2" align="center" name="text31" id="text31"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td colspan=2 class=xl174 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" align="center" name="text32" id="text32"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td colspan=3 class=xl163 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" align="center" name="text33" id="text33"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=19 style='height:19.0pt'>
  <td height=19 class=xl66 style='height:19.0pt'></td>
  <td class=xl88 style='border-top:none'>Fiscal year</td>
  <td colspan=3 class=xl221 style='border-right:1.0pt solid black'>Current year</td>
  <td colspan=3 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>After current year</td>
  <td colspan=2 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>Current Year</td>
  <td colspan=3 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>After current year</td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=30 style='mso-height-source:userset;height:30.0pt'>
  <td height=30 class=xl66 style='height:30.0pt'></td>
  <td class=xl90 style='border-top:none'>Application</td>
  <td colspan=2 class=xl161 align=right style='border-right:1.0pt solid black'>
                       1 </td>
  <td class=xl116 style='border-top:none'><span
  style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" cols="10" align="center" name="text34" id="text34"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl230 align=right style='border-top:none;border-left:none'> 2 </td>
  <td colspan=2 class=xl175 style='border-right:1.0pt solid black'><span
  style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" cols="10" align="center" name="text35" id="text35"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl230 align=right style='border-top:none;border-left:none'><span
  style="mso-spacerun:yes">&nbsp;</span>a<span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl116 style='border-top:none'><span
  style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" cols="8" align="center" name="text36" id="text36"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl230 align=right style='border-top:none;border-left:none'><span
  style="mso-spacerun:yes">&nbsp;</span>b<span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td colspan=2 class=xl175 style='border-right:1.0pt solid black'><span
  style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" cols="10" align="center" name="text37" id="text37"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=27 style='mso-height-source:userset;height:27.75pt'>
  <td height=27 class=xl66 style='height:27.75pt'></td>
  <td class=xl90 style='border-top:none'>Total</td>
  <td colspan=2 class=xl227 style='border-right:1.0pt solid black'>T1(1+2)</td>
  <td colspan=4 class=xl174 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" align="center" name="text38" id="text38"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl89 style='border-top:none;border-left:none'>T2<font class="font11">
  </font><font class="font10">(a+b)</font></td>
  <td colspan=4 class=xl174 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" align="center" name="text39" id="text39"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=33 style='mso-height-source:userset;height:33.0pt'>
  <td height=33 class=xl66 style='height:33.0pt'></td>
  <td class=xl98 width=129 style='border-top:none;width:129pt'>Scrapping
  Disposal</td>
  <td colspan=3 class=xl224 width=207 style='border-right:1.0pt solid black;
  width:207pt'>
  <textarea wrap="soft" align="center" name="text40" id="text40"></textarea>
  </td>
  <td colspan=3 class=xl174 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" align="center" name="text41" id="text41"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl231 align=right style='border-top:none;border-left:none'><span
  style="mso-spacerun:yes">&nbsp;</span>1+a<span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl116 style='border-top:none'><span
  style="mso-spacerun:yes">&nbsp;</span>
  <textarea wrap="soft" align="center" cols="8" name="text42" id="text42"></textarea>
  <span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl89 style='border-top:none;border-left:none'>T1 + T2</td>
  <td colspan=2 class=xl219 style='border-right:1.0pt solid black;border-left:
  none'>
  <textarea wrap="soft" align="center" cols="10" name="text43" id="text43"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='mso-height-source:userset;height:15.0pt'>
  <td height=15 class=xl66 style='height:15.0pt'></td>
  <td class=xl102 width=129 style='border-top:none;width:129pt'></td>
  <td colspan=2 class=xl140 style='border-right:1.0pt solid black'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Account No</td>
  <td colspan=2 class=xl142 style='border-right:1.0pt solid black;border-left:
  none'><span style="mso-spacerun:yes">&nbsp; </span>Dept code</td>
  <td colspan=2 class=xl140 style='border-right:1.0pt solid black;border-left:
  none'>Account No<span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;</span></td>
  <td colspan=2 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>Start</td>
  <td colspan=3 class=xl90 style='border-right:1.0pt solid black;border-left:
  none'>End</td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=34 style='mso-height-source:userset;height:34.5pt'>
  <td height=34 class=xl66 style='height:34.5pt'></td>
  <td class=xl105 style='border-top:none'>Accounting</td>
  <td class=xl101 style='border-top:none'>Asset</td>
  <td class=xl109 style='border-top:none'>
  <textarea wrap="soft" cols="7" align="center" name="text44" id="text44"></textarea>
  </td>
  <td class=xl106 style='border-top:none;border-left:none'>Expense</td>
  <td class=xl108 style='border-top:none'>
  <textarea wrap="soft" cols="8" align="center" name="text45" id="text45"></textarea>
  </td>
  <td colspan=2 class=xl122 style='border-right:1.0pt solid black;border-left:
  none'>
  <textarea wrap="soft" cols="8" align="center" name="text46" id="text46"></textarea>
  </td>
  <td class=xl107 style='border-top:none;border-left:none'>YY/MM</td>
  <td class=xl113 style='border-top:none;border-left:none'>
  <textarea wrap="soft" cols="8" align="center" name="text47" id="text47"></textarea>
  </td>
  <td class=xl107 style='border-top:none;border-left:none'>YY/MM</td>
  <td colspan=2 class=xl122 style='border-right:1.0pt solid black;border-left:
  none'>
  <textarea wrap="soft" cols="8" align="center" name="text48" id="text48"></textarea>
   </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:20.0pt'>
  <td height=20 class=xl66 style='height:20.0pt'></td>
  <td class=xl229>Routing:</td>
  <td class=xl119></td>
  <td class=xl117></td>
  <td class=xl120></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl121></td>
  <td class=xl118></td>
  <td class=xl121></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:17.0pt'>
  <td height=17 class=xl66 style='height:17.0pt'></td>
  <td class=xl75 colspan=9 style='mso-ignore:colspan'>Requesting Dept<span
  style="mso-spacerun:yes">&nbsp; </span>-&gt;<span
  style="mso-spacerun:yes">&nbsp; </span>Related Dept<span
  style="mso-spacerun:yes">&nbsp; </span>-&gt;<span
  style="mso-spacerun:yes">&nbsp; </span>Finance<span
  style="mso-spacerun:yes">&nbsp; </span>-&gt;<span
  style="mso-spacerun:yes">&nbsp; </span>Management<span
  style="mso-spacerun:yes">&nbsp; </span>-&gt; Finance(Original)<span
  style="mso-spacerun:yes">&nbsp; </span>-&gt; Requesting Dept(Copy)</td>
  <td class=xl71></td>
  <td class=xl71></td>
  <td class=xl74></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='height:15.0pt'>
  <td height=15 class=xl66 style='height:15.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=18 style='height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td colspan=6 rowspan=2 height=32 width=458 style='height:32.0pt;width:458pt'
  align=left valign=top><span style='position:absolute;z-index:2;margin-left:
  201px;margin-top:5px;width:229px;height:4px'>
  
  </span>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td colspan=6 rowspan=2 height=32 class=xl144 width=458 style='height:32.0pt;
    width:458pt;'>REASON SHEET</td>
   </tr>
  </table>
  </span></td>
  <td align=left valign=top><span style='position:absolute;z-index:5;
  margin-left:44px;margin-top:6px;width:161px;height:3px'>

  </span>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=18 class=xl76 width=45 style='height:18.0pt;width:45pt'></td>
   </tr>
  </table>
  </span></td>
  <td colspan=2 class=xl149></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl78></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=21 style='height:21.0pt'>
  <td height=21 class=xl66 style='height:21.0pt'></td>
  <td colspan=6 class=xl79 align=center style='mso-ignore:colspan'>(Attachment
  to Ringi)</td>
  <td class=xl66></td>
  <td class=xl66>Date</td>
  <td colspan=4 class=xl150 style='border-right:1.0pt solid black'>
  <?php echo date("m-d-Y"); ?>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=21 style='height:21.0pt'>
  <td height=21 class=xl66 style='height:21.0pt'></td>
  <td class=xl81></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66>Department</td>
  <td colspan=4 class=xl152 style='border-right:1.0pt solid black'>
  <textarea wrap="soft" align="center" name="text50" id="text50"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:24.75pt'>
  <td height=24 class=xl66 style='height:24.75pt'></td>
  <td class=xl81></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl78></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl81></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl78></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=19 style='height:19.0pt'>
  <td height=19 class=xl66 style='height:19.0pt'></td>
  <td class=xl84>Project:</td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl86><u style='visibility:hidden;mso-ignore:visibility'></u></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td colspan=12 rowspan=3 class=xl131 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
 <textarea wrap="soft" cols="150" rows="8" align="center" name="text51" id="text51"></textarea>  
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='mso-height-source:userset;height:15.0pt'>
  <td height=15 class=xl66 style='height:15.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=19 style='height:19.0pt'>
  <td height=19 class=xl66 style='height:19.0pt'></td>
  <td class=xl84>Purpose:</td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl85></td>
  <td class=xl86><u style='visibility:hidden;mso-ignore:visibility'></u></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td colspan=12 rowspan=6 class=xl131 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="150" rows="8" align="center" name="text52" id="text52"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='height:15.0pt'>
  <td height=15 class=xl66 style='height:15.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=19 style='height:19.0pt'>
  <td height=19 class=xl66 style='height:19.0pt'></td>
  <td class=xl82 colspan=2 style='mso-ignore:colspan'>Decision Making Process:</td>
  <td class=xl73></td>
  <td class=xl66 colspan=6 style='mso-ignore:colspan'>(provide background
  information, decision making process, and indicate final selection)</td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl83></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td colspan=12 rowspan=17 class=xl131 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="150" rows="15" align="center" name="text53" id="text53"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='height:15.0pt'>
  <td height=15 class=xl66 style='height:15.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=19 style='height:19.0pt'>
  <td height=19 class=xl66 style='height:19.0pt'></td>
  <td class=xl82 colspan=2 style='mso-ignore:colspan'>Schedule / Timing:</td>
  <td class=xl73></td>
  <td class=xl66 colspan=3 style='mso-ignore:colspan'>(provide key dates and
  timing of project)</td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl83></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td colspan=12 rowspan=4 class=xl131 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="150" rows="3" align="center" name="text54" id="text54"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='height:15.0pt'>
  <td height=15 class=xl66 style='height:15.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=18 style='height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td class=xl82>Responsible Party:</td>
  <td class=xl100></td>
  <td class=xl73></td>
  <td class=xl66 colspan=6 style='mso-ignore:colspan'>(provide name of who is
  taking responsibility to oversee the project to conclusion)</td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl83></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=14 style='height:14.0pt'>
  <td height=14 class=xl66 style='height:14.0pt'></td>
  <td colspan=12 rowspan=2 class=xl125 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>
  <textarea wrap="soft" cols="150"  align="center" name="text55" id="text55"></textarea>
  </td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=15 style='height:15.0pt'>
  <td height=15 class=xl66 style='height:15.0pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=18 style='height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=18 style='height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=18 style='height:18.0pt'>
  <td height=18 class=xl66 style='height:18.0pt'></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl73></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
</table>

*/ ?>

</form>

<script>


	raplace();
	changeAtt();


	
</script>