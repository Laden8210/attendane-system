<?php
require_once '../../repository/config.php';
require_once '../../repository/AttendanceRepository.php';
require_once '../../repository/EventRepository.php'; // Assuming you have an EventRepository
require_once '../../vendor/tecnickcom/tcpdf/tcpdf.php';

if (isset($_GET['event_id'])) {
    $eventId = $_GET['event_id'];
    $attendanceRepository = new AttendanceRepository($conn);
    $eventRepository = new EventRepository($conn);

    // Fetch event and attendance data
    $event = $eventRepository->getEventById($eventId);
    $attendances = $attendanceRepository->getAttendanceByEvent($eventId);

    if (!$event) {
        echo json_encode(['status' => 'error', 'message' => 'Event not found.']);
        exit;
    }

    // Create new PDF document
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('School Event System');
    $pdf->SetTitle('Event Attendance Report');
    $pdf->SetSubject('Attendance Report');

    // Set header data
    $pdf->SetHeaderData('', 0, 'Attendance Report', "Event: " . htmlspecialchars($event['event_name']));

    // Set header and footer fonts
    $pdf->setHeaderFont(array('helvetica', '', 10));
    $pdf->setFooterFont(array('helvetica', '', 8));

    // Set margins
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(true, 20);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 10);

    // Title
    $pdf->Cell(0, 10, 'Event Attendance Report', 0, 1, 'C');

    // Add some space
    $pdf->Ln(10);

    // Event details in normal case
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Event Details', 0, 1);

    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 8, 'Event Name: ' . htmlspecialchars($event['event_name']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Description: ' . htmlspecialchars($event['description']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Details: ' . htmlspecialchars($event['details']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Event Date: ' . date('F j, Y', strtotime($event['event_date'])), 0, 'L');

    // Add some space
    $pdf->Ln(10);

    // Table header with border styling
    $table = '
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
    </style>
    <table>
        <thead>
            <tr>
                <th width="10%">Student ID</th>
                <th width="20%">First Name</th>
                <th width="20%">Last Name</th>
                <th width="25%">Attendance Time</th>
                <th width="10%">Session</th>
                <th width="15%">Type</th>
            </tr>
        </thead>
        <tbody>';

    // Table content
    foreach ($attendances as $attendance) {
        $table .= '
        <tr>
            <td>' . htmlspecialchars($attendance['STUDENT_ID']) . '</td>
            <td>' . htmlspecialchars(ucwords(strtolower($attendance['FIRST_NAME']))) . '</td>
            <td>' . htmlspecialchars(ucwords(strtolower($attendance['LAST_NAME']))) . '</td>
            <td>' . $attendance['attendance_time'] . '</td>
            <td>' . strtoupper($attendance['session']) . '</td>
            <td>' . strtoupper($attendance['type']) . '</td>
        </tr>';
    }

    $table .= '</tbody></table>';

    // Output table to PDF
    $pdf->writeHTML($table, true, false, false, false, '');

    // Output the PDF
    $pdf->Output("event_{$eventId}_attendance_report.pdf", 'D');
} else {
    echo json_encode(['status' => 'error', 'message' => 'Event ID missing.']);
}
