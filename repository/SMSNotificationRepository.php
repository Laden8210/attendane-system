<?php

class SMSNotificationRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function addSMSNotification($recipientPhone, $studentId, $message)
    {
        $sql = "INSERT INTO sms_notifications (recipient_phone, student_id, message, sent_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $recipientPhone, $studentId, $message); 
        return $stmt->execute();
    }





    public function getSMSNotificationsByStudent($studentId)
    {
        $sql = "SELECT * FROM sms_notifications WHERE student_id = ? ORDER BY sent_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllSMSNotifications($search = '', $course)
    {
        $sql = "SELECT * FROM sms_notifications 
        JOIN students on students.GUARDIAN_PHONE_NO = sms_notifications.recipient_phone        
        WHERE recipient_phone LIKE ? OR message LIKE ? ORDER BY sent_at DESC";
        $searchTerm = '%' . $search . '%';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function deleteSMSNotification($smsId)
    {
        $sql = "DELETE FROM sms_notifications WHERE sms_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $smsId);
        return $stmt->execute();
    }
}
