<?php
use Phppot\Member;
if (! empty($_POST["login-btn"])) {
    require_once '../services/Member.php';
    $member = new Member();
    $loginResult = $member->loginMember();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/library/css/bootstrap.min.css" crossorigin="anonymous">
<link href="assets/css/style.css"rel="stylesheet">
</head>
<body>
<?php
require_once __DIR__ . '/page/login.php';
?>
</body>
</html>