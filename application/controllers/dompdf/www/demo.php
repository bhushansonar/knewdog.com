<?php
require_once("../dompdf_config.inc.php");

$html = 

    '<html>

	<style>

		table{

margin-left:10px;

font-size:5px;

font-family:Helvetica;

margin-right:10px;

}

.tablebg

{

background:#000000;

color:#ffffff;

}

img

{

margin-top:10px;

}

body{

maring:0px;

padding:0px;

font-size:5px;

font-family:Helvetica;

}

.style5 {color: #FFFFFF; font-weight: bold; font-size: 12px; }

	</style>

	<body>';

$html .='
<img src="logo.png" />
<img src="php.gif" />
<img id="imageHdr" src="./images/logo.png" style="border-style: none; border-width: 0px;" align="absmiddle">

<table width="100%" border="0" cellpadding="1" cellspacing="0">

  <tr>

    <td style="font-family:Helvetica; font-size:10px; font-weight:bold;">No Credit Check Application <br />Application Date : Tllhis dsf </td>

    <td align="right" style="font-family:Helvetica; font-size:10px; font-weight:bold;">Online Application <br />IP Address : safs asdf asd sdf </td>

  </tr>

</table>';
$html.= '</body></html>';
echo $html; 
$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("8.5x11", "portrait");

$dompdf->render();

// The next call will store the entire PDF as a string in $pdf

$pdf = $dompdf->output();  

// You can now write $pdf to disk, store it in a database or stream it

// to the client.
$dompdf->stream("dompdf_out.pdf");

$filename="../files/test.pdf";

file_put_contents($filename, $pdf);

?>