<?php
/******** Copy all start from line 6 to Bricks Child Theme function.php******/
/******** Any error, just delete the code inserted, your wordpress will back to default ******/


/*** Redirect default wp-login.php to custom login page ***/
add_action( 'login_form_login', function() {
	if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        	$redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;
    
        	if ( is_user_logged_in() ) {
            		redirect_logged_in_user( $redirect_to );
            		exit;
        	}

        	// The rest are redirected to the login page 
        	$login_url = home_url( 'sign-in' ); // change to your custom login page slug
        	if ( ! empty( $redirect_to ) ) {
            		$login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
        	}
        	wp_redirect( $login_url );
        	exit;
    	}
});

/*** Redirect default wp-login.php?action=register to custom register page ***/
add_action( 'login_form_register', function() {
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        	if ( is_user_logged_in() ) {
            		redirect_logged_in_user();
        	} else {
            		wp_redirect( home_url( 'sign-in' ) ); // change to your custom register page slug
        	}
        	exit;
    	}
});

/*** Redirect default wp-login.php?action=lostpassword to custom password lost page ***/
add_action( 'login_form_lostpassword', function() {
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        	if ( is_user_logged_in() ) {
            		redirect_logged_in_user();
            		exit;
        	}
        	wp_redirect( home_url( 'password-lost' ) ); // change to your custom password lost page slug
        	exit;
    	}
});

/*** Redirect default wp-login.php?action=rp&key=xxxxxxxxxxxxx&login=xxxxxxxx to custom password reset page ***/
add_action( 'login_form_rp', 'redirect_to_custom_password_reset' );
add_action( 'login_form_resetpass', 'redirect_to_custom_password_reset' );
function redirect_to_custom_password_reset() {
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        	// Verify key / login combo 
        	$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
		
        	if ( ! $user || is_wp_error( $user ) ) {
            		if ( $user && $user->get_error_code() === 'expired_key' ) {
                		wp_redirect( home_url( 'sign-in?login=expiredkey' ) ); // change to your custom login page slug
            		} else {
                		wp_redirect( home_url( 'sign-in?login=invalidkey' ) ); // change to your custom login page slug
            		}
            		exit;
        	}
		
        	$redirect_url = home_url( 'password-reset' ); // change to your custom password reset page slug
        	$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
        	$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
        	wp_redirect( $redirect_url );
        	exit;
    	}
}

/*** Redirect logged in user to respective page base on user role ***/
function redirect_logged_in_user( $redirect_to = null ) {
	$user = wp_get_current_user();
    	if ( user_can( $user, 'manage_options' ) ) {
        	if ( $redirect_to ) {
         		wp_safe_redirect( $redirect_to );
        	} else {
            		wp_redirect( admin_url() );
        	}
    	} else {
        	wp_redirect( home_url( 'account' ) ); // change to your custom account page slug
		exit;
    	}
}

/*** logout without confirmation and redirect***/
add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result) {
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : 'https://domain.com'; // change redirect url here
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}

/****** redirect after logout to default wordpress logout confirmation page ******/
/*********
add_action( 'wp_logout', function() {
	$redirect_url = home_url( 'sign-in?logged_out=true' ); //change to your custom login page slug
    	wp_safe_redirect( $redirect_url );
    	exit;
});
********/

/*** Registration form password match, email domain blacklist validation ***/
add_filter( 'bricks/form/validate', function( $errors, $form ) {
	$form_settings = $form->get_settings();
  	$form_fields   = $form->get_fields();
  	$form_id       = $form_fields['formId'];
	$form_email    = $form->get_field_value( 'urijhn' ); // change to your registeration form email field ID
	$form_pwd_1    = $form->get_field_value( 'opesmf' ); // change to your registeration form password field ID
	$form_pwd_2    = $form->get_field_value( 'jgdfeb' ); // change to your registeration form confirm password field ID
	
	// Skip validation: Form ID is not 'kfbqso'
  	if ( $form_id !== 'zhddbi' ) { // change to your registeration form ID
    		// Early return the $errors array if it's not target form
    		return $errors;
  	}
	
	if ( $form_pwd_1 == $form_pwd_2 ) {
		if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $form_pwd_1)) {
			$errors[] = esc_html__( 'Password must minimum of 8 charaters, contain at least 1 number, contain at least one uppercase character, contain at least one lowercase character, contain at least one special character', 'bricks' );
		}
	} else {
		$errors[] = esc_html__( 'Password mismatch. Please try again.', 'bricks' );
	}
	/**** optional to validate blacklist email domain 
	$blacklist = [
    		'@gmail.com',
    		'@yahoo.com',
	];
	
	foreach ($blacklist as $blacklist_email) {
    		if (stripos($form_email, $blacklist_email) !== false) {
        		$errors[] = esc_html__( 'Please use your business email domain to register.', 'bricks' );
    		}
	}
	****/	
	return $errors;
}, 10, 2);

/*** Custom form action for custom password lost page ***/
/*** Action to get user password reset link, send email, redirect and error handling ***/
add_action( 'bricks/form/custom_action', 'custom_password_lost_request', 10, 1 );
function custom_password_lost_request($form) {
	$fields = $form->get_fields();
	$formId = $fields['formId'];
	$formEmail = $form->get_field_value( '33ac0d' ); // change to your password lost form email field ID
	
	if ( $formId !== 'uxrwnz' ) { // change to your password lost form ID
		return;
	}
	
	if ( email_exists( $formEmail )) { 
		$user = get_user_by( 'email', $formEmail );
		$username = $user->user_login;
		$resetpasskey = get_password_reset_key(get_user_by('email', $formEmail )); 
		
		$to = $formEmail;
		$from = 'support@domain.com'; // change to your email address
		$subject = 'Password Reset'; // change to your prefer subject
		
		$message  = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
		$message .= __('Site Name: Any') . "\r\n\r\n"; // change to your Site Name
		$message .= __('Username: ' . $username . '') . "\r\n\r\n";
		$message .= __('If this was a mistake, ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= site_url("wp-login.php?action=rp&key=" . $resetpasskey . "&login=" . $username . "&wp_lang=en_US"). "\r\n\r\n";
		$message .= __( 'Thanks!' ) . "\r\n";
		
		$headers[] = 'From: Support <'.$from.'>';
		$headers[] = 'Reply-to: '. $from;
		
		$result = wp_mail( $to, $subject, $message, $headers );
		
    		$redirect_url = home_url( 'sign-in' ); // change to your custom login page slug
   		$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
        
		$form->set_result(
			[
				'action'          => 'request_password_reset_redirect',
				'type'            => 'redirect',
				'redirectTo'      => $redirect_url,
				'redirectTimeout' => 5000, // change to your prefer time delay for redirect
			],
		);	
		
	} else {
		$form->set_result(
			[
				'action'        => 'request_password_reset_error',
				'type'          => 'error',
				'message' 	=> esc_html__('Invalid Email Address. Make sure you fill in your registered email address correctly.', 'bricks'),
			]
		);
	} 
}

/*** Custom form action to for custom password reset page ***/
/*** Action to reset and update user password, send email, redirect, error handling ***/
add_action( 'bricks/form/custom_action', 'do_password_reset', 10, 1 );
function do_password_reset($form) {
	$fields = $form->get_fields();
	$formId = $fields['formId'];
	$formPwd = $form->get_field_value( '2a4170' ); // change to your password reset form first password field ID
	
	if ( $formId !== 'viuilm' ) { // change to your password reset form ID
		return;
	}
		
	$rp_key = $form->get_field_value( 'evilvc' ); // change to your password reset form hidden reset key field ID
	$rp_login = $form->get_field_value( 'ujmqee' ); // change to your password reset form hidden login field ID
	$user = check_password_reset_key( $rp_key, $rp_login );
		
	if ( ! $user || is_wp_error( $user ) ) {
		if ( $user && $user->get_error_code() === 'expired_key' ) {
			wp_redirect( home_url( 'sign-in?login=expiredkey' ) ); // Cchange to your custom login page slug
		} else {
			wp_redirect( home_url( 'sign-in?login=invalidkey' ) ); // Cchange to your custom login page slug
		}
		exit;
	}
	
	if ( !empty( $formPwd ) ) { 
		if ( $formPwd != $form->get_field_value( 'pfktcj' ) ) { // change to your password reset form second password field ID
			// Passwords don't match 
			$form->set_result(
				[
					'action'          => 'password_resetted_error',
					'type'            => 'error',
					'message' 	  => esc_html__('Password mismatch! Please try again.', 'bricks'),
				]
			);
		} else if ( $formPwd == $form->get_field_value( 'pfktcj' ) ) { // change to your password reset form second password field ID
			// Passwords don't meet minimum requirement
			if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $formPwd)) {
				$form->set_result(
					[
						'action'          => 'password_resetted_error',
						'type'            => 'error',
						'message' 	  => esc_html__('Password must minimum of 8 charaters, contain at least 1 number, contain at least one uppercase character, contain at least one lowercase character, contain at least one special character', 'bricks'),
					]
				);
			} else {
			
				// Parameter checks OK, reset password 
				reset_password( $user, $formPwd );

    				$to = $user->user_email;
				$from = 'support@domain.com'; // change to your email address
				$subject = 'Password Changed'; // change to your prefer subject
	
	  			$message  = __('You had successfully change your Weblab account password.') . "\r\n\r\n";
	  			$message .= __('New password: ' . $formPwd . '') . "\r\n\r\n";
	  			$message .= __( 'Thanks!' ) . "\r\n";
			
	  			$headers[] = 'From: Support <'.$from.'>';
	  			$headers[] = 'Reply-to: '. $from;
		
	  			$result = wp_mail( $to, $subject, $message, $headers );
			}
		}
	} else {
		$form->set_result(
			[
				'action'          => 'password_resetted_error',
				'type'            => 'error',
				'message' 	  => esc_html__('Invalid request! Please try again.', 'bricks'),
			]
		);
	}
}
