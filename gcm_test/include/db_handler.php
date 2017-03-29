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

    function updateAttendanceRecord($student_id, $course_id, $staff_id, $style_id){
        $response = array();
        $student_ids = (int)$student_id;

        // to check students' checkin or checkout time
        $stmt = $this->conn->prepare("SELECT checkin_time FROM enroll_handler WHERE course_id = ? AND student_id = ?");
        $stmt->bind_param("si", $course_id, $student_ids);
        $stmt->execute();
        $stmt->bind_result($isCheckedIn);
        $status = $stmt->fetch();
        $stmt->store_result();
        // var_dump($isCheckedIn);
        // $rows = $stmt->num_rows;
        // var_dump($rows);
        if($isCheckedIn == NULL){
            $stmt->close();
            $stmt = $this->conn->prepare("UPDATE enroll_handler 
                SET checkin_time = now(), checkin_staffID = ?, checkin_style_id = ? WHERE student_id = ? AND course_id = ?");
            $stmt->bind_param("iiis", $staff_id, $style_id, $student_id, $course_id);
            $stmt->execute();
            $stmt->close();
            echo "success checkin";
        } else {
            $stmt->close();
            $stmt = $this->conn->prepare("UPDATE enroll_handler 
                SET checkout_time = now(), checkout_staffID = ?, checkout_style_id = ? WHERE student_id = ? AND course_id = ?");
            $stmt->bind_param("iiis", $staff_id, $style_id, $student_id, $course_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $this->conn->prepare("UPDATE enroll_handler SET ischecked = 1 WHERE student_id = ? AND course_id =?");
            $stmt->bind_param("is", $student_id, $course_id);
            $stmt->execute();
            $stmt->close();
            echo "success checkout";
        }
    }

    function syncsAttendance($student_data){

    $data = json_decode($student_data);
    $response = array();

    foreach($data as $json)
    {
        $stmt = $this->conn->prepare("UPDATE enroll_handler 
            SET ischecked = ?, 
            checkin_time = ?, 
            checkout_time = ?,
            checkin_staffID = ?,
            checkout_staffID = ?,
            checkin_style_id = ?,
            checkout_style_id = ? WHERE student_id = ? AND course_id = ?");
        
        $checkinTime = $json->checkin_time == "null" ? NULL : $json->checkin_time;
        // if($json->checkin_time == "null")
        //     echo "string";
        $checkoutTime = $json->checkout_time == "null" ? NULL : $json->checkout_time;

        $stmt->bind_param("issiiiiis", 
            $json->ischecked, 
            $checkinTime,
            $checkoutTime,
            $json->checkin_staffID, 
            $json->checkout_staffID, 
            $json->checkin_style_id,
            $json->checkout_style_id,
            $json->student_id, 
            $json->course_id);

        if($stmt->execute()){
            array_push($response, ["student_id" => $json->student_id, "course_id" => $json->course_id, "status" => "success"]);
        }
        else {
            array_push($response, ["status" => "fail"]);
        }
        $stmt->close();
        }    
        return json_encode($response);
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