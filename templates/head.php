<head>
  <meta charset="utf-8">
  <META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/dist/img/favicon.png">
  <?php 
  	// Form validation
	// Google recaptcha

  	echo '<script>var submitted = false, formType = "";</script>';

	if( isset($_POST['g-recaptcha-response']) ){

		$postTo = 'https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
		$formQuery = http_build_query($_POST);

		// var_dump($formQuery);

		$captcha = $_POST['g-recaptcha-response'];

	    $privatekey = "6Le22yAUAAAAANuYyHyHwKQJ1ldrA3jr0zE2fUZ4";
	    $url = 'https://www.google.com/recaptcha/api/siteverify';
	    $data = array(
	        'secret' => $privatekey,
	        'response' => $captcha,
	        'remoteip' => $_SERVER['REMOTE_ADDR']
	    );

	    $curlConfig = array(
	        CURLOPT_URL => $url,
	        CURLOPT_POST => true,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_POSTFIELDS => $data
	    );

	    $ch = curl_init();
	    curl_setopt_array($ch, $curlConfig);
	    $response = curl_exec($ch);
	    curl_close($ch);	    

	    $response = json_decode($response, true);	    

	    echo '<script>submitted = true, formType = "'.$_POST['formType'].'";</script>';

	}	

	if ($response["success"] == true) {
		echo '<script>var formAction = "'. $postTo .'", formQuery = "'. $formQuery .'";</script>';
	}
	else {
		echo '<script>var formAction = "", formQuery = "";</script>';
	}

  	wp_head(); 
  ?>
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/patch/v1.css">
  <script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"></script>
  <script src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer></script>
    <script>
      var recaptcha1;
      var recaptcha2;
      var myCallBack = function() {
        //Render the recaptcha1 on the element with ID "recaptcha1"
        recaptcha1 = grecaptcha.render('recaptcha1', {
          'sitekey' : '6Le22yAUAAAAACbltukt3mh589GVq3ou6NFPePB6', //Replace this with your Site key
          'theme' : 'light'
        });
        
        //Render the recaptcha2 on the element with ID "recaptcha2"
        recaptcha2 = grecaptcha.render('recaptcha2', {
          'sitekey' : '6Le22yAUAAAAACbltukt3mh589GVq3ou6NFPePB6', //Replace this with your Site key
          'theme' : 'light'
        });
      };
    </script>
</head>
