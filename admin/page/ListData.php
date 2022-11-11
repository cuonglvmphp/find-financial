<?php
include "../config.php";
$db = new Database;
$conn = $db->connect();
// Lấy số trag hiện tại
$page = isset($_GET['page']) ? $_GET['page'] : 1; 

/////
$results_per_page = 200;
$page_first_result = ($page-1) * $results_per_page;


$query = "SELECT * FROM contacts";
$result = mysqli_query($conn, $query);
$number_of_result = mysqli_num_rows($result);
//tổng số trang
$number_of_page = ceil ($number_of_result / $results_per_page);

//show data
$query = "SELECT * FROM contacts LIMIT "." $page_first_result , $results_per_page";
$result = mysqli_query($conn, $query);

if($_GET['page']==1) {
    $index = 0;
} else {
    $index = ($_GET['page']-1) * 200;
}
//display the retrieved result on the webpage
echo '<div class="box-table">';
    echo '<table class="table" border="1">';
        echo 
            '<tr>
                <th>Chọn</th>
                <th>STT</th>
                <th>Sub ID</th>
                <th>Transaction Id</th>
                <th>Csv Status</th>
                <th>Fname</th>
                <th>Lname</th>
                <th>Dob</th>
                <th>Gender</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Date</th>
                <th>Postal code</th>
                <th>Device</th>
                <th>CID</th>
                <th>Click success</th>
            </tr>';

        while ($row = mysqli_fetch_array($result)) {

            $index++;

            $date = $row['date'];
            $dt = new DateTime($date);
            $interval = $dt->diff(new DateTime());

            $gender = '';
            if($row['gender']==0){
                $gender = 'Male'; 
            } elseif($row['gender']==1) {
                $gender = 'Female'; 
            } elseif($row['gender']==2) {
                $gender = 'Other'; 
            }

            echo 
            '<tr>
                <td><input name="checkbox" type="checkbox" value=' . $row['user_id'] . '></td>
                <td>' . $index . '</td>
                <td>' . $row['sub_id'] . '</td>
                <td>' . $row['transaction_id'] . '</td>
                <td>' . $row['csv_status'] = 0 ? 'false' : 'true' . '</td>
                <td>' . $row['first_name'] . '</td>
                <td>' . $row['last_name'] . '</td>
                <td>' . $row['dob'] . '</td>
                <td>' . $gender . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $row['city'] . '</td>
                <td>' . $row['state'] . '</td>
                <td>' . '+' . $row['phone'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $dt->format('Y-m-d') . '</td>
                <td>' . $row['code'] . '</td>
                <td>' . $row['device'] . '</td>
                <td></td>
                <td>' . $row['click_success'] = 0 ? 'false' : 'true' . '</td>
            </tr>';


        }
    echo '</table>';
echo '</div>';
////////////
if (isset($_GET['page'])) {
echo '<div class="box-page">';
    for($page = 1; $page<= $number_of_page; $page++) {
        $is_active = '';
        if($_GET['page']==$page) {
            $is_active = 'active';
        }
        echo '<a class="'. $is_active .'" href="/_interate?page='.$page.'">'.$page.'</a>';            
    }
    
echo '</div>';
}