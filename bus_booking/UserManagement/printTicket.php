<?php

    session_start();

    include("./includes/config.php");
    include("./includes/function.php");
    require_once('TCPDF-main/tcpdf.php');

    if (isset($_GET['tprint'])) {
        $tprno = $_GET['tprno'];

        $sql = "SELECT *
                FROM booked 
                INNER JOIN schedule_list ON booked.schedule_id = schedule_list.id
                INNER JOIN bus ON schedule_list.bus_id = bus.id
                WHERE booked.ref_no = '$tprno'";

        $gotResults = mysqli_query($conn, $sql);

        if ($gotResults) {
            if (mysqli_num_rows($gotResults) > 0) {
                while ($row = mysqli_fetch_array($gotResults)) {
                    $from_location = $conn->query("SELECT id,Concat(city) as location FROM location where id = ".$row['from_location'])->fetch_array()['location'];
	                $to_location = $conn->query("SELECT id,Concat(city) as location FROM location where id = ".$row['to_location'])->fetch_array()['location'];
            
                        $bnumber = $row['bus_number'];
                        $bname = $row['name'];
                        $from = $row['from_location'] = $from_location;
                        $to = $row['to_location'] = $to_location;
                        $dtime = $row['departure_time'];
                        $rtime = $row['eta'];
                        $uname = $row['name'] = $_SESSION['username'];
                        $rnum = $row['ref_no'];
                        $qty = $row['qty'];
                        $total = $row['price']*$row['qty'];
                }
            }
        }
    

    /**
     * 
     */
    class PDF extends TCPDF
    {
        
        public function Header() {
            $imageFile = K_PATH_IMAGES.'logob.jpg';
            $this->Image($imageFile, 35, 5, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Ln(15);
            $this->SetFont('helvetica','B',10);
            $this->Cell(75,5,'Zara Online Bus Ticket Booking System',0,1,'C');
            $this->SetFont('helvetica','B',10);
            $this->Ln(-1);
            $this->Cell(75,10,'Ticket',0,1,'C');
            $this->Ln(-4);
            $this->SetFont('helvetica','B',10);
            $this->Cell(75,5,'_______________________________________________',0,1,'C');
        }

        public function Footer() {
            $this->SetY(-15);
            $this->SetFont('helvetica','B',10);
            $this->Cell(75,5,'_______________________________________________',0,1,'C');
            $this->Ln(2);
            $this->SetFont('helvetica','I',8);
            date_default_timezone_set("Asia/Colombo");
            $today = date("F j, Y/ g:i A", time());

            $this->Cell(75,5,'Generated Date and Time: '.$today,0,0,'L');
        }
    }

    // create new PDF document
    $pdf = new PDF('p', 'mm', 'A6', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('');
    $pdf->SetTitle('');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));

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
    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 14, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    
    $pdf->AddPage();
    
    $pdf->Ln(2);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'Bus Number:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$bnumber,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'Bus Type:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$bname,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'From:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$from,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'To:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$to,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'Departure Time:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$dtime,0,0);


    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'Arrival Time:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$rtime,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'User Name:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$uname,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'Reference Number:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$rnum,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'Quantity:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$qty,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',10);
    $pdf->Cell(40,5,'Total Price:',0,0);
    $pdf->SetFont('times','BI',10);
    $pdf->Cell(146,5,$total,0,0);
    }

    

    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('Ticket.pdf', 'I');
?>