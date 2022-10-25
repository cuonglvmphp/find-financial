<?php
ini_set('display_errors',0);
header('Content-type: application/json');
include('config.php');

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

function htmlCharConvert($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}

try{
    if($_POST){
        //get form submit variables
        $email = htmlCharConvert($_POST["email"]);
        $firstname = htmlCharConvert($_POST["firstname"]);
        $lastname = htmlCharConvert($_POST["lastname"]);
        $address = htmlCharConvert($_POST["address"]);
        $city = htmlCharConvert($_POST["city"]);
        $state = htmlCharConvert($_POST["state"]);
        $zip = htmlCharConvert($_POST["zip"]);
        $phone = str_replace(['(', ')', ' ', '-'], "", htmlCharConvert($_POST["phone"]));
        $gender = htmlCharConvert($_POST["gender"]);
        $day = htmlCharConvert($_POST["day"]);
        $month = htmlCharConvert($_POST["month"]);
        $year = htmlCharConvert($_POST["year"]);
        $birth = htmlCharConvert($_POST["dob"]);
        $transactionID = htmlCharConvert($_POST["t_id"]);
        $aff_id = htmlCharConvert($_POST["utm_source"]);
        $cid = htmlCharConvert($_POST["c_id"]);
        $currentDate = date("Y/m/d h:i:s");
        $response = [];
        //create connection
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conne = $conn;
        
        //check database connection
        if (!$conne) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check IF user have signed up
        $query_user = $conne -> query("SELECT mail FROM contacts WHERE mail = '$email' and phone = '$phone' and firstname = '$firstname' and lastname = '$lastname' LIMIT 1");
        if($query_user->num_rows > 0){
            $response['message'] = 'Lead has signed';
            echo json_encode($response);
            exit();
        }

        // Check IF transactionID EXIST in database
        $query_transaction_id = $conne->query("SELECT transaction_id FROM contacts WHERE transaction_id = '$transactionID' LIMIT 1");
        if ( $query_transaction_id->num_rows > 0 && $transactionID != 0 ) {
            $response['message'] = 'Transaction already exists';
            echo json_encode($response);
            exit();
        }

        // Check IF mail EXIST in DB
        $query_email = $conne->query("SELECT mail FROM contacts WHERE mail = '$email' LIMIT 1");
        if ( $query_email->num_rows > 0 ) {
            $response['message'] = 'Email already exists';
            echo json_encode($response);
            exit();
        }

        // check IF phone number EXIST in DB
        $query_phone = $conne->query("SELECT phone FROM contacts WHERE phone = '$phone' LIMIT 1");
        if ( $query_phone->num_rows > 0 ) {
            $response['message'] = 'Phone already exists';
            echo json_encode($response);
            exit();
        }

        $line_type = 'landline';
        $carrier = 'none';
        $location = 'USA';  
        $increment = $conne->query("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'lifegewe_leads' AND TABLE_NAME = 'contacts'");
        $row = $increment->fetch_assoc();

        $uid = gen_uuid();
        // Prepare and bind sql querry
        $stmt = $conne->prepare("INSERT INTO contacts (cid, 
        uid,
         mail, 
         firstname, 
         lastname, 
         address,
         city,
         state,
         zip,
         phone,
         line_type,
         carrier,
         location,
         gender,
         transaction_id, 
         aff_id, 
         birth,
         currentDate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssissssssss",$cid,$uid,$email, $firstname, $lastname, $address, $city, $state, $zip, $phone,$line_type,$carrier,$location, $gender, $transactionID, $aff_id, $birth, $currentDate);

        if ($stmt->execute()) {
            $response['message'] = 'success';
            $percent = rand(1,30);
            error_log(print_r('percent: '.$percent,TRUE));
            $pbjson = 'Not accepted (50% random)';
            if ($percent >= 16) {
                // Tune postback CURL
                $offer_id = 3015;
                $pb = curl_init('https://dynuinmedia.go2cloud.org/aff_lsr?offer_id='.$offer_id.'&transaction_id='.$transactionID.'');
                curl_setopt($pb, CURLOPT_RETURNTRANSFER, true);
                $pbjson = curl_exec($pb);
                curl_close($pb);
            } else{
                error_log(print_r($pbjson,TRUE));
            }

            // Prepare update postback status to database
            $update = $conne->prepare("UPDATE contacts SET postback=?, log=? WHERE mail='$email'");

            // Check if postback success
            $a = 2;

            if ( $pbjson=="success=true;" ) {
                $a = 1;
            } else {
                $a = 0;
            }

            $update->bind_param('is', $a, $pbjson);
            // Update postback status
            $update->execute();
            $update->close();
            echo json_encode($response);
            exit();
        }else{
            $response['message'] = 'serverError';
            $stmterror = "Error: " . $stmt . "<br>" . $conne->error;
            error_log(print_r($stmterror,TRUE));
            echo json_encode($response);
            exit();
        }
        $stmt->close();
        $conne->close();
    }
}catch(Exception $e){
    error_log(print_r($e,TRUE));
    echo json_encode($e);
    exit();
}
?>

