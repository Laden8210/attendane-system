<?php
require_once '../../repository/config.php';
require_once '../../repository/AttendanceRepository.php';
require_once '../../repository/EventRepository.php'; // Ensure this exists
require_once '../../vendor/tecnickcom/tcpdf/tcpdf.php';
date_default_timezone_set('Asia/Manila');

function convertToTimestamp($timeStr) {
    if (strtoupper($timeStr) === 'N/A' || empty($timeStr)) {
        return null;
    }
    return strtotime($timeStr);
}


function getScheduledTimestamp($attendanceTimeRaw, $scheduledTimeStr) {
    if (strtoupper($attendanceTimeRaw) === 'N/A' || empty($attendanceTimeRaw)) {
        return null;
    }

    $dateStr = date('Y-m-d', strtotime($attendanceTimeRaw));

    $scheduledDateTimeStr = $dateStr . ' ' . $scheduledTimeStr;

    return strtotime($scheduledDateTimeStr);
}

function formatTimeForDisplay($timeStr) {
    if (strtoupper($timeStr) === 'N/A' || empty($timeStr)) {
        return 'N/A';
    }
    return date('g:i A', strtotime($timeStr));
}

if (isset($_GET['event_id'])) {
    $eventId = $_GET['event_id'];
    $attendanceRepository = new AttendanceRepository($conn);
    $eventRepository = new EventRepository($conn);

    $event = $eventRepository->getEventById($eventId);
    $attendances = $attendanceRepository->getAttendanceByEvent($eventId, $_GET['search'] ?? null);

    if (!$event) {
        echo json_encode(['status' => 'error', 'message' => 'Event not found.']);
        exit;
    }


    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('School Event System');
    $pdf->SetTitle('Event Attendance Report');
    $pdf->SetSubject('Attendance Report');
    $pdf->SetHeaderData('', 0, 'Attendance Report', "Date Generated: " . date('Y-m-d'));
    $pdf->setHeaderFont(['helvetica', '', 10]);
    $pdf->setFooterFont(['helvetica', '', 8]);
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);


    $pdf->Cell(0, 10, 'Event Attendance Report', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Event Details', 0, 1);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 8, 'Event Name: ' . htmlspecialchars($event['event_name']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Description: ' . htmlspecialchars($event['description']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Details: ' . htmlspecialchars($event['details']), 0, 'L');
    $pdf->MultiCell(0, 8, 'Event Date: ' . date('F j, Y', strtotime($event['event_date'])), 0, 'L');
    $formattedAmTimeIn = formatTimeForDisplay($event['am_time_in']);
    $formattedAmTimeOut = formatTimeForDisplay($event['am_time_out']);
    $formattedPmTimeIn = formatTimeForDisplay($event['pm_time_in']);
    $formattedPmTimeOut = formatTimeForDisplay($event['pm_time_out']);
    $pdf->MultiCell(0, 8, 'Morning Time: ' . htmlspecialchars($formattedAmTimeIn) . ' - ' . htmlspecialchars($formattedAmTimeOut), 0, 'L');
    $pdf->MultiCell(0, 8, 'Afternoon Time: ' . htmlspecialchars($formattedPmTimeIn) . ' - ' . htmlspecialchars($formattedPmTimeOut), 0, 'L');
    $pdf->Ln(10);


    $table = '<table border="1" cellspacing="0" cellpadding="4">
        <thead>
            <tr style="background-color:#f2f2f2;">
                <th >Student ID</th>
                <th >Name</th>
                <th >Course - Year</th>
                <th >Block</th>
                <th >Morning Time In - Out</th>
                <th >Morning Status</th>
                <th >Afternoon Time In - Out</th>
                <th >Afternoon Status</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($attendances as $attendance) {
        // Raw attendance times from the database
        $morningTimeInRaw = $attendance['morning_time_in'];     
        $morningTimeOutRaw = $attendance['morning_time_out'];     
        $afternoonTimeInRaw = $attendance['afternoon_time_in'];  
        $afternoonTimeOutRaw = $attendance['afternoon_time_out']; 


        $morningInTimestamp = convertToTimestamp($morningTimeInRaw);
        $morningOutTimestamp = convertToTimestamp($morningTimeOutRaw);
        $afternoonInTimestamp = convertToTimestamp($afternoonTimeInRaw);
        $afternoonOutTimestamp = convertToTimestamp($afternoonTimeOutRaw);


        $scheduledAmTimeInTimestamp = getScheduledTimestamp($morningTimeInRaw, $event['am_time_in']);     
        $scheduledAmTimeOutTimestamp = getScheduledTimestamp($morningTimeOutRaw, $event['am_time_out']);  
        $scheduledPmTimeInTimestamp = getScheduledTimestamp($afternoonTimeInRaw, $event['pm_time_in']);   
        $scheduledPmTimeOutTimestamp = getScheduledTimestamp($afternoonTimeOutRaw, $event['pm_time_out']); 


        if (is_null($morningInTimestamp) && is_null($morningOutTimestamp)) {

            $mstatus = 'Absent';
        } elseif (!is_null($morningInTimestamp)) {

            if ($morningInTimestamp > $scheduledAmTimeInTimestamp) {
                $mstatus = 'Late';
            } else {
                $mstatus = 'Present';
            }
        } else {
     
            $mstatus = 'Incomplete';
        }

        if (is_null($afternoonInTimestamp) && is_null($afternoonOutTimestamp)) {

            $fstatus = 'Absent';
        } elseif (!is_null($afternoonInTimestamp)) {

            if ($afternoonInTimestamp > $scheduledPmTimeInTimestamp) {
                $fstatus = 'Late';
            } else {
                $fstatus = 'Present';
            }
        } else {

            $fstatus = 'Incomplete';
        }

        $morningTimeIn = $morningInTimestamp ? date('h:i A', $morningInTimestamp) : 'N/A';
        $morningTimeOut = $morningOutTimestamp ? date('h:i A', $morningOutTimestamp) : 'N/A';
        $afternoonTimeIn = $afternoonInTimestamp ? date('h:i A', $afternoonInTimestamp) : 'N/A';
        $afternoonTimeOut = $afternoonOutTimestamp ? date('h:i A', $afternoonOutTimestamp) : 'N/A';


        $table .= '<tr>
            <td>' . htmlspecialchars($attendance['STUDENT_NUMBER']) . '</td>
            <td>' . htmlspecialchars($attendance['full_name']) . '</td>
            <td>' . htmlspecialchars($attendance['COURSE_NAME'] . ' - ' . $attendance['YEAR']) . '</td>
            <td>' . htmlspecialchars($attendance['BLOCK']) . '</td>
            <td>' . htmlspecialchars($morningTimeIn) . ' - ' . htmlspecialchars($morningTimeOut) . '</td>
            <td>' . htmlspecialchars($mstatus) . '</td>
            <td>' . htmlspecialchars($afternoonTimeIn) . ' - ' . htmlspecialchars($afternoonTimeOut) . '</td>
            <td>' . htmlspecialchars($fstatus) . '</td>
        </tr>';
    }

    $table .= '</tbody></table>';


    $pdf->writeHTML($table, true, false, false, false, '');
    $pdf->Output("event_{$eventId}_attendance_report.pdf", 'D');
} else {
    echo json_encode(['status' => 'error', 'message' => 'Event ID missing.']);
}
?>
