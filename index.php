<?php
// https://gomakethings.com/how-to-create-your-own-api-endpoints-with-php/

$config = parse_ini_file('bd.ini');
$conn = mysqli_connect($config['dbhost'], $config['username'], $config['password']);
mysqli_select_db($conn, $config['db']);

 /**
 * Get the API method
 * @return String The API method
 */
function get_method () {
	return $_SERVER['REQUEST_METHOD'];
}

/**
 * Get data object from API data
 * @return Object The data object
 */
function get_request_data () {
	return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

/**
 * Send an API response
 * @param  *       $response The API response
 * @param  integer $code     The response code
 * @param  boolean $encode   If true, encode response
 */
function send_response ($response, $code = 200) {
	http_response_code($code);
	die(json_encode($response));
}

// Get the API method
$method = get_method();

// Get any data sent with the request
// Includes query parameters, post data, and body content
$data = get_request_data();

// GET request
// Get some data and respond with it
if ($method === 'GET') {

    $sql = "SELECT * FROM `project1`.`person`"; // WHERE id='{$data['id']}';";
    $get_data_query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        if(mysqli_num_rows($get_data_query)!=0){
        $result = array();
        
        while($r = mysqli_fetch_array($get_data_query)){
            extract($r);
            $result[] = array("id" => $id, "name" => $name, 'birthdate' => $birthdate,
                            "gender" => $gender, "maritalstatus" => $maritalstatus, 
                            "taxid" => $taxid, "phone" => $phone, "email" => $email,
                            "created_at" => $created_at );
        }
        send_response([
            'status' => 'success',
            'message' => $result,
        ]);
    }
    else{
        send_response([
            'status' => 'failed',
            'message' => 'Not found',
        ], 400);
    }    
}

// POST request
// Store some data or something
if ($method === 'POST') {

    $sql = "INSERT INTO person (name, birthdate, gender, maritalstatus, taxid, phone, email) VALUES ('{$data['name']}', '{$data['birthdate']}', '{$data['gender']}', '{$data['maritalstatus']}', '{$data['taxid']}', '{$data['phone']}', '{$data['email']}')";
    if(mysqli_query($conn, $sql)) {
        send_response([
            'status' => 'success',
            'message' => 'Created successfully',
        ]);
    }
    else {
        send_response([
            'status' => 'failed',
            'message' => 'Error when creating',
        ], 400);
    }
}

// DELETE request
// Delete some data
if ($method === 'DELETE') {

    $sql = "DELETE FROM person WHERE id ='{$data['id']}'";
    if(mysqli_query($conn, $sql)) {
        send_response([
            'status' => 'success',
            'message' => 'Deleted successfully',
        ]);
    }
    else {
        send_response([
            'status' => 'failed',
            'message' => 'Error when deleting',
        ], 400);
    }
}

// PUT request
// Update some data
if ($method === 'PUT') {

    $sql = "UPDATE person SET name = '{$data['name']}', birthdate = '{$data['birthdate']}', gender = '{$data['gender']}', maritalstatus = '{$data['maritalstatus']}', taxid = '{$data['taxid']}', phone = '{$data['phone']}', email = '{$data['email']}' WHERE id = '{$data['id']}'";
    if(mysqli_query($conn, $sql)) {
        send_response([
            'status' => 'success',
            'message' => 'Updated successfully',
        ]);
    }
    else {
        send_response([
            'status' => 'failed',
            'message' => 'Error when updating',
        ], 400);
    }
}

@mysqli_close($conn);
