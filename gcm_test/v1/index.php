<?php
 
error_reporting(-1);
ini_set('display_errors', 'On');
 
require_once '../include/db_handler.php';
require '.././libs/Slim/Slim.php';
 
\Slim\Slim::registerAutoloader();
 
$app = new \Slim\Slim();
 
// User login
$app->post('/updateIsScanned', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('stud_id', 'subject_code'));
 
    // reading post params
    $stud_id = $app->request->post('stud_id');
    $subject_code = $app->request->post('subject_code');
 
    $db = new DbHandler();
    $response = $db->updateIsScanned($stud_id,$subject_code);
 
    // echo json response
    //echoRespnse(200, $response);
});

$app->post('/updateAttendanceRecord', function() use ($app){
    verifyRequiredParams(array('student_id', 'course_id'));

    $student_id = $app->request->post('student_id');
    $course_id = $app->request->post('course_id');

    $db = new DbHandler();
    $response = $db->updateAttendanceRecord($student_id, $course_id);

    // echoRespnse(200, $response);
});
 
 // User register
$app->post('/user/register', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('phone', 'email', 'username', 'password'));
 
    // reading post params
    $phone = $app->request->post('phone');
	$email = $app->request->post('email');
    $username = $app->request->post('username');
	$password = $app->request->post('password');
 
    // validating email address
    validateEmail($email);
 
    $db = new DbHandler();
    $response = $db->createUser($phone, $email, $username, $password);
 
    // echo json response
    echoRespnse(200, $response);
});
 
/* * *
 * Updating user
 *  we use this url to update user's gcm registration id
 */
$app->put('/user/:id', function($user_id) use ($app) {
    global $app;
 
    verifyRequiredParams(array('gcm_registration_id'));
 
    $gcm_registration_id = $app->request->put('gcm_registration_id');
 
    $db = new DbHandler();
    $response = $db->updateGcmID($user_id, $gcm_registration_id);
 
    echoRespnse(200, $response);
});
 
/* * *
 * fetching all chat rooms
 */
$app->get('/circles', function() {
    $response = array();
    $db = new DbHandler();
 
    // fetching all user tasks
    $result = $db->getAllCircles();
 
    $response["error"] = false;
    $response["circles"] = array();
 
    // pushing single chat room into array
    /*while ($circle = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["circle_id"] = $circle["circle_id"];
        $tmp["circle_name"] = $circle["circle_name"];
        $tmp["created_at"] = $circle["created_at"];
        array_push($response["circles"], $tmp);
    }*/

    while ($circle = fetchAssocStatement($result)) {
        $tmp = array();
        $tmp["circle_id"] = $circle["circle_id"];
        $tmp["circle_name"] = $circle["circle_name"];
        $tmp["created_at"] = $circle["created_at"];
        array_push($response["circles"], $tmp);
    }
    $result->close();
 
    echoRespnse(200, $response);
});
 
 
/**
 * Messaging in a chat room
 * Will send push notification using Topic Messaging
 *  */
$app->post('/circles/:id/location', function($circle_id) {
    global $app;
    $db = new DbHandler();
 
    verifyRequiredParams(array('user_id', 'current_lat', 'current_lng'));
 
    $user_id = $app->request->post('user_id');
    $current_lat = $app->request->post('current_lat');
	$current_lng = $app->request->post('current_lng');
 
    $response = $db->addLocation($user_id, $circle_id, $current_lat, $current_lng);
 
    if ($response['error'] == false) {
        require_once __DIR__ . '/../libs/gcm/gcm.php';
        require_once __DIR__ . '/../libs/gcm/push.php';
        $gcm = new GCM();
        $push = new Push();
 
        // get the user using userid
        $user = $db->getUser($user_id);
 
        $data = array();
        $data['user'] = $user;
        //$data['current_lat'] = $response['test'];
		//$data['current_lng'] = $response['test2'];
        $data['location'] = $response['location'];
        $data['circle_id'] = $circle_id;
 
        $push->setTitle("Google Cloud Messaging");
        $push->setIsBackground(FALSE);
        $push->setFlag(PUSH_FLAG_CIRCLE);
        $push->setData($data);
         
        // echo json_encode($push->getPush());exit;
 
        // sending push message to a topic
        $gcm->sendToTopic('topic_' . $circle_id, $push->getPush());
 
        $response['user'] = $user;
        $response['error'] = false;
    }
 
    echoRespnse(200, $response);
});
 

 /**
 * Fetching single chat room including all the chat messages
 *  */
$app->get('/circles/:id', function($circle_id) {
    global $app;
    $db = new DbHandler();
 
    $result = $db->getCircle($circle_id);
 
    $response["error"] = false;
    $response["users"] = array();
    $response['circle'] = array();
 
    $i = 0;
    // looping through result and preparing tasks array
    /*while ($circle = $result->fetch_assoc()) {
        // adding chat room node
        if ($i == 0) {
            $tmp = array();
            $tmp["circle_id"] = $circle["circle_id"];
            $tmp["circle_name"] = $circle["circle_name"];
            $tmp["created_at"] = $circle["circle_created_at"];
            $response['circle'] = $tmp;
        }*/

        while ($circle = fetchAssocStatement($result)) {
        // adding chat room node
        if ($i == 0) {
            $tmp = array();
            $tmp["circle_id"] = $circle["circle_id"];
            $tmp["circle_name"] = $circle["circle_name"];
            $tmp["created_at"] = $circle["circle_created_at"];
            $response['circle'] = $tmp;
        }
 
        if ($circle['user_id'] != NULL) {
            /*
            // message node
            $cmt = array();
            $cmt["current_lat"] = $circle["current_lat"];
            $cmt["current_lng"] = $circle["current_lng"];
            $cmt["location_id"] = $circle["location_id"];
            $cmt["created_at"] = $circle["created_at"];
 
            // user node
            $user = array();
            $user['user_id'] = $circle['user_id'];
            $user['username'] = $circle['username'];
            $cmt['user'] = $user;
 
            array_push($response["locations"], $cmt);*/

            // message node
            $cmt = array();
            $cmt["current_lat"] = $circle["current_lat"];
            $cmt["current_lng"] = $circle["current_lng"];
            $cmt["location_id"] = $circle["location_id"];
            $cmt["created_at"] = $circle["created_at"];
 
            // user node
            $user = array();
            $user['user_id'] = $circle['user_id'];
            $user['username'] = $circle['username'];
            $user['location'] = $cmt;
 
            array_push($response["users"], $user);
        }
    }
 
    echoRespnse(200, $response);
});

 
/**
 * Sending push notification to a single user
 * We use user's gcm registration id to send the message
 * * */
$app->post('/users/:id/location', function($to_user_id) {
    global $app;
    $db = new DbHandler();
 
    verifyRequiredParams(array('current_lat', 'current_lng'));
 
    $from_user_id = $app->request->post('user_id');
    $current_lat = $app->request->post('current_lat');
	$current_lng = $app->request->post('current_lng');
 
    $response = $db->addLocation($from_user_id, $to_user_id, $current_lat, $current_lng);
 
    if ($response['error'] == false) {
        require_once __DIR__ . '/../libs/gcm/gcm.php';
        require_once __DIR__ . '/../libs/gcm/push.php';
        $gcm = new GCM();
        $push = new Push();
 
        $user = $db->getUser($to_user_id);
 
        $data = array();
        $data['user'] = $user;
        $data['current_lat'] = $response['current_lat'];
		$data['current_lng'] = $response['current_lng'];
        $data['image'] = '';
 
        $push->setTitle("Google Cloud Messaging");
        $push->setIsBackground(FALSE);
        $push->setFlag(PUSH_FLAG_USER);
        $push->setData($data);
 
        // sending push message to single user
        $gcm->send($user['gcm_registration_id'], $push->getPush());
 
        $response['user'] = $user;
        $response['error'] = false;
    }
 
    echoRespnse(200, $response);
});
 
 
/**
 * Sending push notification to multiple users
 * We use gcm registration ids to send notification message
 * At max you can send message to 1000 recipients
 * * */
$app->post('/users/location', function() use ($app) {
 
    $response = array();
    verifyRequiredParams(array('user_id', 'to', 'current_lat', 'current_lng'));
 
    require_once __DIR__ . '/../libs/gcm/gcm.php';
    require_once __DIR__ . '/../libs/gcm/push.php';
 
    $db = new DbHandler();
 
    $user_id = $app->request->post('user_id');
    $to_user_ids = array_filter(explode(',', $app->request->post('to')));
	$current_lat = $app->request->post('current_lat');
	$current_lng = $app->request->post('current_lng');
 
    $user = $db->getUser($user_id);
    $users = $db->getUsers($to_user_ids);
 
    $registration_ids = array();
 
    // preparing gcm registration ids array
    foreach ($users as $u) {
        array_push($registration_ids, $u['gcm_registration_id']);
    }
 
    // insert messages in db
    // send push to multiple users
    $gcm = new GCM();
    $push = new Push();
 
    // creating tmp message, skipping database insertion
    $msg = array();
    $msg['current_lat'] = $current_lat;
	$msg['current_lng'] = $current_lng;
    $msg['location_id'] = '';
    $msg['circle_id'] = '';
    $msg['created_at'] = date('Y-m-d G:i:s');
 
    $data = array();
    $data['user'] = $user;
    $data['current_lat'] = $current_lat;
	$data['current_lng'] = $current_lng;
    $data['image'] = '';
 
    $push->setTitle("Google Cloud Messaging");
    $push->setIsBackground(FALSE);
    $push->setFlag(PUSH_FLAG_USER);
    $push->setData($data);
 
    // sending push message to multiple users
    $gcm->sendMultiple($registration_ids, $push->getPush());
 
    $response['error'] = false;
 
    echoRespnse(200, $response);
});
 
$app->post('/users/send_to_all', function() use ($app) {
 
    $response = array();
    verifyRequiredParams(array('user_id', 'current_lat', 'current_lng'));
 
    require_once __DIR__ . '/../libs/gcm/gcm.php';
    require_once __DIR__ . '/../libs/gcm/push.php';
 
    $db = new DbHandler();
 
    $user_id = $app->request->post('user_id');
	$current_lat = $app->request->post('current_lat');
	$current_lng = $app->request->post('current_lng');
 
    require_once __DIR__ . '/../libs/gcm/gcm.php';
    require_once __DIR__ . '/../libs/gcm/push.php';
    $gcm = new GCM();
    $push = new Push();
 
    // get the user using userid
    $user = $db->getUser($user_id);
     
    // creating tmp message, skipping database insertion
    $msg = array();
    $msg['current_lat'] = $current_lat;
	$msg['current_lng'] = $current_lng;
    $msg['location_id'] = '';
    $msg['circle_id'] = '';
    $msg['created_at'] = date('Y-m-d G:i:s');
 
    $data = array();
    $data['user'] = $user;
    $data['current_lat'] = $current_lat;
	$data['current_lng'] = $current_lng;
    $data['image'] = 'http://www.androidhive.info/wp-content/uploads/2016/01/Air-1.png';
 
    $push->setTitle("Google Cloud Messaging");
    $push->setIsBackground(FALSE);
    $push->setFlag(PUSH_FLAG_USER);
    $push->setData($data);
 
    // sending message to topic `global`
    // On the device every user should subscribe to `global` topic
    $gcm->sendToTopic('global', $push->getPush());
 
    $response['user'] = $user;
    $response['error'] = false;
 
    echoRespnse(200, $response);
});
 

function fetchAssocStatement($stmt)
{
    if($stmt->num_rows>0)
    {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if($stmt->fetch())
            return $result;
    }

    return null;
}
 
/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}
 
/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}
 
function IsNullOrEmptyString($str) {
    return (!isset($str) || trim($str) === '');
}
 
/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
 
    echo json_encode($response);
}
 
$app->run();
?>