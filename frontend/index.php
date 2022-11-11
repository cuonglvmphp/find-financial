<?php include "./layouts/header.html" ?>
<body>
    <div class="wrapper">
        <div id="cover-spin"></div>      
        <!--header-->
        <?php include "./layouts/layout_header.html" ?>
        <!--main-->
        <?php include "./layouts/main/main.html" ?>
        <!--footer-->
        <?php include "./layouts/layout_footer.html" ?>

        <!-- ADSMITH SURVEY START -->

<div id="AS_SURVEY"></div>
<script type="application/javascript">
	
	/* ADSMITH SETTINGS */
	
	var as_plc_id          = '8385';
	
	/* USER DATA */
	
	var as_email           = '';
	var as_fname           = '';
	var as_lname           = '';
	var as_gender          = '';
	var as_phone_1         = '';
	var as_phone_2         = '';
	var as_phone_3         = '';
	var as_addy_street     = '';
	var as_addy_line_2     = '';
	var as_addy_city       = '';
	var as_addy_state      = '';
	var as_addy_zip        = '';
	var as_dob_y           = '';
	var as_dob_m           = '';
	var as_dob_d           = '';
	
	/* USER DEMOS */
	
	var as_home_status     = '';
	var as_marital_status  = '';
	var as_has_kids        = '';
	var as_has_pets        = '';
	var as_credit_rating   = '';
	var as_credit_score    = '';
	
	/* USER CERTIFICATES */
	
	var as_tf_cert         = '';
	
	/* PUBLISHER SETTINGS */
	
	var as_furl            = '';
	var as_subid_a         = '';
	
</script>
<script src="https://www.adsmith.io/load-survey.js"></script>

<!-- ADSMITH SURVEY END -->
    </div>
</body>
<?php include "./layouts/footer.html" ?>
<script src="./assets/js/index.js"></script>
</html>
