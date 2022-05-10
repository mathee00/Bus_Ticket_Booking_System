<?php

    session_start();

    include("./includes/config.php");
    include("./includes/function.php");
    require_once('TCPDF-main/tcpdf.php');

    if (isset($_GET['report'])) {
        $ruserid = $_GET['ruserid'];

        $select = "SELECT * FROM user WHERE id = '$ruserid'";

        $query = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($query)) {
            $rfirstname = $row['firstname'];
            $rlastname = $row['lastname'];
            $rusername = $row['username'];
            $remail = $row['email'];
            $rgender = $row['gender'];
            $rdob = $row['dob'];
        }
    

    /**
     * 
     */
    class PDF extends TCPDF
    {
        
        public function Header() {
            $imageFile = K_PATH_IMAGES.'logob.jpg';
            $this->Image($imageFile, 110, 8, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Ln(15);
            $this->SetFont('helvetica','B',16);
            $this->Cell(225,5,'Zara Online Bus Ticket Booking System',0,1,'C');
            $this->SetFont('helvetica','B',14);
            $this->Ln(2);
            $this->Cell(225,10,'User Report',0,1,'C');
            $this->Ln(0);
            $this->SetFont('helvetica','B',10);
            $this->Cell(225,5,'_____________________________________________________________________________________________________________________',0,1,'C');
        }

        public function Footer() {
            $this->SetY(-20);
            $this->SetFont('helvetica','B',10);
            $this->Cell(225,5,'_____________________________________________________________________________________________________________________',0,1,'C');
            $this->Ln(5);
            $this->SetFont('helvetica','I',8);
            date_default_timezone_set("Asia/Colombo");
            $today = date("F j, Y/ g:i A", time());

            $this->Cell(225,5,'Generated Date and Time: '.$today,0,0,'L');
            $this->Cell(10,5,'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(),0,false,'R',0,'',0,false,'T','M');
        }
    }

    // create new PDF document
    $pdf = new PDF('l', 'mm', 'B5', true, 'UTF-8', false);

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
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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
    
    $pdf->Ln(28);

    $pdf->SetFont('times','B',13);
    $pdf->Cell(225,3,'User Details',0,1,'C');
    $pdf->Ln(-5);
    $pdf->Cell(225,3,'___________',0,0,'C');

    $pdf->Ln(18);
    $pdf->SetFont('times','B',12);
    $pdf->Cell(40,5,'First Name:',0,0);
    $pdf->SetFont('times','BI',12);
    $pdf->Cell(146,5,$rfirstname,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',12);
    $pdf->Cell(40,5,'Last Name:',0,0);
    $pdf->SetFont('times','BI',12);
    $pdf->Cell(146,5,$rlastname,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',12);
    $pdf->Cell(40,5,'Username:',0,0);
    $pdf->SetFont('times','BI',12);
    $pdf->Cell(146,5,$rusername,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',12);
    $pdf->Cell(40,5,'Email:',0,0);
    $pdf->SetFont('times','BI',12);
    $pdf->Cell(146,5,$remail,0,0);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',12);
    $pdf->Cell(40,5,'Gender:',0,0);
    $pdf->SetFont('times','BI',12);
    $pdf->Cell(146,5,$rgender,0,0);


    $pdf->Ln(10);
    $pdf->SetFont('times','B',12);
    $pdf->Cell(40,5,'Date of Birth:',0,0);
    $pdf->SetFont('times','BI',12);
    $pdf->Cell(146,5,$rdob,0,0);
    }

    $pdf->AddPage();
    $pdf->Ln(28);

    $pdf->SetFont('times','B',13);
    $pdf->Cell(225,3,'My Booking List',0,1,'C');
    $pdf->Ln(-5);
    $pdf->Cell(225,3,'__________________',0,0,'C');
    $pdf->Ln(5);

    $pdf->Ln(10);
    $pdf->SetFont('times','B',11);
    $pdf->Cell(20,5,'Number',0,0);
    $pdf->Cell(20,5,'Type',0,0);
    $pdf->Cell(20,5,'From',0,0);
    $pdf->Cell(20,5,'To',0,0);
    $pdf->Cell(40,5,'Departure Time',0,0);
    $pdf->Cell(40,5,'Arrival Time',0,0);
    $pdf->Cell(25,5,'User Name',0,0);
    $pdf->Cell(25,5,'Quantity',0,0);
    $pdf->Cell(15,5,'Total',0,0);

    $sql = "SELECT *
            FROM booked 
            INNER JOIN schedule_list ON booked.schedule_id = schedule_list.id
            INNER JOIN bus ON schedule_list.bus_id = bus.id
            WHERE booked.name = '".$_SESSION['username']."'";

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
                $qty = $row['qty'];
                $total = $row['price']*$row['qty'];

        $pdf->Ln(10);
        $pdf->SetFont('times','B',11);
        $pdf->Cell(20,5,$bnumber,0,0);
        $pdf->Cell(20,5,$bname,0,0);
        $pdf->Cell(20,5,$from,0,0);
        $pdf->Cell(20,5,$to,0,0);
        $pdf->Cell(40,5,$dtime,0,0);
        $pdf->Cell(40,5,$rtime,0,0);
        $pdf->Cell(25,5,$uname,0,0);
        $pdf->Cell(25,5,$qty,0,0);
        $pdf->Cell(15,5,$total,0,0);
            }
        }
    }

    

    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('User_Report.pdf', 'I');
?>