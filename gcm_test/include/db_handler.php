<?php
 
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 */
class DbHandler {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . '/db_connect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
	
	function isStudentSubjectExists($stud_id, $subject_code) {
        if($stmt = $this->conn->prepare("SELECT location_id from locations WHERE user_id = ? AND circle_id = ?"))
        {
            $stmt->bind_param("ii", $stud_id, $subject_code);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
        }
        else
            echo "Query error";
        return $num_rows > 0;
    }

    function updateAttendanceRecord($student_id, $course_id){
        $response = array();
        $student_ids = (int)$student_id;

        // to check students' checkin or checkout time
        $stmt = $this->conn->prepare("SELECT checkin_time FROM attendance WHERE course_id = ? AND student_id = ?");
        $stmt->bind_param("si", $course_id, $student_ids);
        $status = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($isCheckedIn);
        $rows = $stmt->num_rows;
        if($rows == 0){
            $stmt->close();
            $stmt = $this->conn->prepare("INSERT INTO attendance (course_id, student_id, checkin_time) VALUES ('$course_id', '$student_id', now())");
            $stmt->execute();
            echo "success checkin";
        } else {
            $stmt->close();
            $stmt = $this->conn->prepare("UPDATE attendance SET checkout_time = now() WHERE student_id = ? AND course_id = ?");
            $stmt->bind_param("is", $student_id, $course_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $this->conn->prepare("UPDATE enroll_handler SET ischecked = 1 WHERE student_id = ? AND course_id =?");
            $stmt->bind_param("is", $student_id, $course_id);
            $stmt->execute();
            $stmt->close();
            echo "success checkout";
        }
    }

	
	// messaging in a chat room / to persional message
    public function updateIsScanned($stud_id, $subject_code) {
        $response = array();
 
        // check if student subject already exist
        //if (!$this->isStudentSubjectExists($stud_id, $subject_code)) {

            $stmt = $this->conn->prepare("SELECT ischecked FROM enroll_handler WHERE student_id = ? AND course_id = ?");
            $stmt->bind_param("is", $stud_id, $subject_code);
			
            if ($stmt->execute()) {
				$stmt->bind_result($isScanned);
				$stmt->fetch();
				if(!$isScanned){
					 $stmt->close();
					 $stmt = $this->conn->prepare("UPDATE enroll_handler SET ischecked = 1 WHERE student_id = ? AND course_id = ?");
					 $stmt->bind_param("is", $stud_id, $subject_code);
					 $stmt->execute();
					 echo "Update success";
				} else
					 echo "Already scanned!";
					
			}
            else {
                echo "Update failed";
            }
            
        //}
		//else
		//	echo "no student subject found!";
	}
 
}
 
?>