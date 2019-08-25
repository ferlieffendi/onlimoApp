<?php

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ONLIMO');
$pdf->SetTitle($judul);
$pdf->SetSubject('Rekap Pelaporan');
$pdf->SetKeywords('Rekap, Pelaporan, Operator, Stasiun, Admin');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 11);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(3, 3, 3, 3);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 127);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

$title = "<h2>".$judul."</h2>";
$pdf->WriteHTMLCell(0, 0, '', '', $title, 0, 1, 0, true,'C', true);
if (!$status) {
	$notice = "<h4>".$laporan."</h4>";
	$pdf->WriteHTMLCell(0, 0, '', '', $notice, 0, 1, 0, true,'C', true);

}else{
	$table = '<table style="border:1px solid #000;">';
	$table .= '<tr style="text-align: center;">
                <th style="border:1px solid #000; font-weight: bold;" width="6.5%">No</th>
                <th style="border:1px solid #000; font-weight: bold;" width="20%">Nama Operator</th>
                <th style="border:1px solid #000; font-weight: bold;" width="20%">Stasiun</th>
                <th style="border:1px solid #000; font-weight: bold;" width="15%">Waktu Pelaporan</th>
                <th style="border:1px solid #000; font-weight: bold;" width="20.5%">Isi Pelaporan</th>
                <th style="border:1px solid #000; font-weight: bold;" width="18%">Bukti Pelaporan</th>
              </tr>';
    $i = 0;
    foreach ($laporan as $row) {
    	$i++;
		$table .='<tr>
				<td align="center" style="border:1px solid #000;">'.$i.'</td>
				<td style="border:1px solid #000;">'.$row['nama'].'</td>
				<td style="border:1px solid #000;">'.$row['nama_stasiun'].'</td>
		        <td style="border:1px solid #000;">'.$row['waktu_pelaporan'].'</td>
		        <td style="border:1px solid #000;"><b style="text-transform: uppercase;">'.$row['jenis_laporan'].'</b> : '.$row['kondisi'].'<br>'.$row['keterangan'].'</td>
		        <td style="border:1px solid #000;"><img src="'.site_url('/uploads/PelaporanOperator/'.$row['foto']).'" style="width: 80px; height: 80px; "/></td>
			</tr>';
    }
    $table .= '</table>';
	
	
	$pdf->WriteHTMLCell(0, 0, '', '', $table, 0, 1, 0, true,'', true);
}


// move pointer to last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_clean();
$judulpdf=$judul."_".time().".pdf";
$pdf->Output($judulpdf, 'I');

//============================================================+
// END OF FILE
//============================================================+
?>