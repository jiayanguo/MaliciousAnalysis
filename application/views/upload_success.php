<?php echo doctype('html5'); ?>

<html>
	<head>
		<title>Static Analyzer - Report</title>
		<link rel="stylesheet" href="css/report.css" type="text/css" media="screen" charset="utf-8">
		<style>
			@media print 
			{
				* 
				{
					font-family: Verdana;
				}
				table {
					width: 100%;
					font-size: 10px;
					empty-cells: show;
				}
				td {
					font-size: 8px;
					white-space: normal !important;
					word-wrap: break-word;
				}
				#target_list {
					display: none;
				}
				.snippet_anchor {
					display: none;
				}
			}

			@media screen 
			{
				* 
				{
					font-family: Calibri, Verdana;
				}
				body 
				{
					background-color: LightCyan;
				}
				table 
				{
					width: 100%;
					font-size: normal; /* changed from smaller */
					empty-cells: show;
				}
				th 
				{
					background-color: lightyellow;
					color: black;
					font-weight: bold;
					border: 1px solid black;
					padding-left: 2px;
					padding-right: 2px;
					padding-top: 2px;
					padding-bottom: 2px;
				}
				td 
				{
					border: 1px solid black;
					background-color: white;
					color: black;
					padding-left: 4px;
					padding-right: 4px;
					padding-bottom: 2px;
					padding-top: 2px;
					overflow: hidden;
					white-space: nowrap;
					width: auto;
				}
				.faded 
				{
					color: gray;
				}
				.code 
				{
					font-family: 'consolas', 'courier new', monospace;
					color: black;
					overflow: hidden;
				}
				.fixedwidth
				{
					font-family: 'consolas', 'courier new', monospace;
				} 
				a 
				{
					text-decoration: none;
					color: MediumBlue;
				}
				a:hover 
				{
					color: #000066;
				}
				#results 
				{
					width: 100%;
					margin-top: 10px;
					margin-bottom: 0;
					margin-left: 0;
					margin-right: 0;
					padding: 0;
				}
				#code_snippet 
				{
					position:absolute;
					width: 580px;
					height: 103px;
					background-color: white;
					color: black;
					border: 2px ridge brown;
					display: none;
					filter: alpha(opacity=95);
					opacity: 0.95;
					font-family: 'courier new';
					padding: 4px;
					font-size: 11px;
					overflow: hidden;
					white-space: nowrap
				}
				.description_popup h4 
				{
					margin-top: 0;
					margin-bottom: 7px;
				}

				.description_popup 
				{
					position:absolute;
					width: 540px;
					height: auto;
					background-color: white;
					color: black;
					border: 2px ridge brown;
					display: none;
					filter: alpha(opacity=95);
					opacity: 0.95;
					padding: 4px;
					font-size: 11px;
					white-space: normal !important;
					overflow-y: auto;
					word-wrap: break-word;	
				}
				.highlight 
				{
					background-color: yellow;
					font-family: 'courier new';
				}
				.line_number 
				{
					color: gray;
					font-family: verdana;
					font-size: 11px;
					padding-right: 4px;
					border-right: 1px dotted lightgrey;
				}
				#target_list 
				{
					display: none;
					margin-top: 10px;
					background-color: white;
					color: black;
					border: 1px ridge darkgray;
					right: 3%;
					left: 3%;
					padding-left: 5px;
					font-size: 0.8em;
				}
				.header_table td 
				{ 
					border: 0; 
					background-color: LightSkyBlue; 
					font-size: normal;
				}
				.header_table 
				{
					width: 100%;
					background-color: LightSkyBlue;
					border: 1px ridge darkgray;
				}
				.header_title 
				{
					font-size: 34px !important;
					padding-left: 25px !important;
					padding-right: 25px !important;
					border-right:  1px ridge darkgray !important;
					font-family: Candara, Calibri, Verdana, Serif;
					font-weight: bold;
					color: #8a2be2;
					cursor:hand;
					cursor: pointer;
				}
				.header_title:hover 
				{
					color: #000000;
					font-style: italic;
				}
				.header_left 
				{
					font-weight: bold;
					white-space: nowrap;
					width: 130px;
				}
				.header_right 
				{
					width: 100%;
				}
				.severity_critical 
				{
					text-align: center;
					background-color: #EE7700;
				}
				.severity_high 
				{
					text-align: center;
					background-color: orange;
				}
				.severity_warning 
				{
					text-align: center;
					background-color: yellow;
				}
				.severity_low 
				{
					text-align: center;
					background-color: lightskyblue;
				}
				.severity_informational 
				{
					text-align: center;
					background-color: #BDFFAE;
				}
				.snippet_anchor 
				{
					float: right;
					color: MediumBlue;
					cursor: hand;
					cursor: pointer;
					margin-left: 5px;
				}
				.description_anchor 
				{
					float: right;
					color: DarkRed;
					cursor: hand;
					cursor: pointer;
					margin-left: 5px;
				}
				.proposed_fix_anchor 
				{
					float: right;
					color: rgb(200,249,6);
					cursor: hand;
					cursor: pointer;
					margin-left: 5px;
				}

				.message 
				{
					overflow: hidden;
					text-overflow: clip;
					width: 40%;
				}
				#file_base 
				{
					position: absolute;
					width: 220px;
					height: 70px;
					font-size: 12px;
					border: 2px ridge brown;
					background-color: white;
					padding: 4px;
					display: none;
				} 
				#file_base input 
				{
					width: 90%;
					font-size: 10px;
					font-weight: bold;
					padding: 3px;
				}
				.attachment_box 
				{
					background-color: white;
					color: black;
					font-size: small;
					font-family: 'Consolas', 'Courier New', monospace;
					border:2px darkgray ridge;
					padding: 5px;
				} 
				select 
				{
					font-family: Calibri, Verdana;
					color: black;
					font-size: normal; /* changed from smaller */
				}
				.nowrap 
				{
					white-space: nowrap;
				}
				.toggle_snippet_size 
				{
					color: rgb(110,140,190);
					cursor: hand;
					cursor: pointer;
					top: 0;
					left: 0;
					margin-top: 3px;
					padding: 0;
					margin: 1px;
					position:absolute;
				}
				.ignore_finding_anchor 
				{
					float: right;
					color: lightgrey;
					cursor: hand;
					cursor: pointer;
					margin-left: 5px;
				}
				#ignore_list 
				{
					font-family: 'Consolas', 'Courier New', monospace;
					font-size: 11px;
					white-space:pre;
					display: none;
					padding: 4px;
					top: 10%;
					left: 10%;
					height: 80%;
					width: 80%;
					position: absolute;
					border: 2px ridge brown;
					opacity: 95%;
				}
			}
			img#icon 
			{
				width:  15%; 
				height: 50%;
			}
			.changeColor
			{
				color:Indigo;
			}
		</style>
		<script language="javascript">
			function redirectToHome()
			{
				open('/MaliciousAnalysis/','_self','resizable,location,menubar,toolbar,scrollbars,status');
			}
		</script>
	</head>
	<body>
	
	<table class="header_table" cellspacing="0" cellpadding="0">
		<tr>
			<td class="header_title" nowrap onclick="redirectToHome()">Static Analyzer&nbsp;<?php echo img('images/icon.jpg'); ?><!--<img src="icon.jpg" id="icon">-->&nbsp;&nbsp;&nbsp;</img></td>
			<td style="width: 100%;">
			<table style="border:0;">
				<tr><td class= "header_left" nowrap>Report Generated:</td>
					<td class="header_right">	
						<?php
							$filename = $csv_file_path;	
							if( ! ini_get('date.timezone') )
							{
							   date_default_timezone_set('America/Chicago');
							}	
							if (file_exists($filename)) 
							{
								echo date("F d Y H:i:s.", filemtime($filename));
							}
						?>
					</td></tr>
				<tr><td class= "header_left" nowrap>Options:</td>
					<td class="header_right">[<a href="javascript:q=(document.location.href);void(open('/MaliciousAnalysis/','_self','resizable,location,menubar,toolbar,scrollbars,status'));">Home</a>]</td></tr>
			</table>
			</div>
			</td>
		</tr>
	</table>
	
	<table border="1">
	<?php
		$r = 1;
		$categ = "";
		foreach ($csv_data as $row)
		{
			if ($r == 1)
				echo '<thead><tr>';
			else
				echo '<tr>';
				
			for ($c=0; $c < count($row); $c++)
			{
				if (empty($row[$c]))
					$value = "&nbsp;";
				else
					$value = $row[$c];
				
				if ($c == 0 || $c == 4 || $c == 6)
				{
					if ($r == 1)
						echo '<th>'.$value.'</th>';
					else
					{
						if ($c == 0)
						{
							if (strcmp($categ, $row[$c+1]) != 0)
							{
								$categ = $row[$c+1];
								echo '<td class = "changeColor" colspan = "3">'.$categ.'</td>';
								echo '</tr>';
								echo '<tr>';
							}
							
							switch ($row[3])
							{
								case "Critical":
									echo '<td class = "severity_critical">';
									break;
								case "High":
									echo '<td class = "severity_high">';
									break;
								case "Warning":
									echo '<td class = "severity_warning">';
									break;
								case "Low":
									echo '<td class = "severity_low">';
									break;
								case "Informational":
									echo '<td class = "severity_informational">';
									break;
								default:
									echo '<td>';
							}
							
							echo xml_convert($value).'</td>';
						}
						elseif ($c == 4)
						{
							echo '<td><a href = "'.$row[$c+1].'">' ;
							echo xml_convert($value).'</a></td>';
						}
						else
						{
							echo '<td>';
							echo xml_convert($value).'</td>';
						}
					}
				}
			}
			
			if ($r == 1) 
				echo '</tr></thead><tbody>';
			else
				echo '</tr>';
			$r++;
		}
	?>
</tbody>
	</table>
	
	</body>
</html>