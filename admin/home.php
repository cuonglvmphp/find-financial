<?php
session_start();
if (! empty($_SESSION["username"])) {
    $name = $_SESSION["username"];
} else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
}
session_write_close();
?>
<HTML>
<head>
	<TITLE>Lead Data</TITLE>
	<link rel="stylesheet" href="/library/css/bootstrap.min.css" crossorigin="anonymous">
	<link href="assets/css/style.css"rel="stylesheet">
</head>
<body>
<div class="container-fluid">
	<nav class="navbar navbar-light bg-light justify-content-between">
		<a class="navbar-brand">Danh Sách Lead</a>
	</nav>
	<form class="form-inline d-flex justify-content-end mt-3">
		<div class="form-group mx-sm-3 mb-2">
			<label for="inputPassword2" class="sr-only">Chuyển đổi</label>
			<input type="password" class="form-control" placeholder="Chuyển đổi">
		</div>
		<button type="submit" class="btn btn-primary mb-2">Lưu</button>
	</form>
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/page/ListData.php" ?>
	<div class="d-flex justify-content-end">
		<ul class="pagination">
			<li class="page-item">
				<a class="page-link" href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			<li class="page-item"><a class="page-link" href="#">1</a></li>
			<li class="page-item"><a class="page-link" href="#">2</a></li>
			<li class="page-item"><a class="page-link" href="#">3</a></li>
			<li class="page-item">
				<a class="page-link" href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</div>
</div>
</body>
</HTML>
