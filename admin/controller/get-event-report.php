<?php
require_once '../../repository/config.php';
require_once '../../repository/AttendanceRepository.php';
require_once '../../repository/EventRepository.php'; // Assuming you have an EventRepository
require_once '../../vendor/tecnickcom/tcpdf/tcpdf.php';

if (isset($_GET['event_id'])) {
    $eventId = $_GET['event_id'];
    $attendanceRepository = new AttendanceRepository($conn);
    $eventRepository = new EventRepository($conn);

    $event = $eventRepository->getEventById($eventId);
    $attendances = $attendanceRepository->getAttendanceByEvent($eventId);

    if (!$event) {
        echo json_encode(['status' => 'error', 'message' => 'Event not found.']);
        exit;
    }

    $pdf = new TCPDF();

    
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('School Event System');
    $pdf->SetTitle('Event Attendance Report');
    $pdf->SetSubject('Attendance Report');

  
    $pdf->SetHeaderData('', 0, 'Attendance Report', "Event: " . htmlspecialchars($event['event_name']));

    $pdf->setHeaderFont(array('helvetica', '', 10));
    $pdf->setFooterFont(array('helvetica', '', 8));

    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);

    $pdf->SetAutoPageBreak(true, 20);

    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 10);

    $pdf->Cell(0, 10, 'Event Attendance Report', 0, 1, 'C');

    $pdf->Ln(10);


    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Event Details', 0, 1);

    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 8, 'Event Name: ' . htmlspecialchars($event['event_name']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Description: ' . htmlspecialchars($event['description']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Details: ' . htmlspecialchars($event['details']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Event Date: ' . date('F j, Y', strtotime($event['event_date'])), 0, 'L');

    $pdf->Ln(10);

    $table = '
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th >Name</th>

                <th >Course - Year</th>
                <th >Attendance Time</th>
                <th >Session</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>';
    
    // Populate the table rows with attendance data
    foreach ($attendances as $attendance) {
        $type = $attendance['type'] == 1 ? 'Time In' : ($attendance['type'] == 2 ? 'Time Out' : 'Unknown');

        $table .= '
        <tr>
            <td>' . htmlspecialchars($attendance['STUDENT_NUMBER']) . '</td>
            <td>' . htmlspecialchars(ucwords(strtolower($attendance['FIRST_NAME']))) . ' '. htmlspecialchars(ucwords(strtolower($attendance['LAST_NAME']))). '</td>

            <td>' . htmlspecialchars($attendance['COURSE_NAME'] . ' - ' . $attendance['YEAR']) . '</td>
            <td>' . htmlspecialchars($attendance['attendance_time']) . '</td>
            <td>' . strtoupper(htmlspecialchars($attendance['session'])) . '</td>

            
            <td>' .  strtoupper(htmlspecialchars($type)) . '</td>
        </tr>';
    }
    
    $table .= '</tbody></table>';

    
    $pdf->writeHTML($table, true, false, false, false, '');

    $pdf->Output("event_{$eventId}_attendance_report.pdf", 'D');
} else {
    echo json_encode(['status' => 'error', 'message' => 'Event ID missing.']);
}
