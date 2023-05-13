# Custom Login/Register/Password Lost/Password Reset Page with Bricks Builder Form Element
# Credit to Jarkko Laine on article https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-1-replace-the-login-page--cms-23627

# Custom Login Form
  - Redirect default https://your-domain/?wp-login.php to your custom Login page
  - Password Visibility Toggle
  - Remember Me functionality. If checked, default 14 days cookie created, else by session.
  - Form Action:
    - Custom Action ( Login and Remember me )
    - Default Email Action
    - Default Redirect Action

# Custom Registration Form
  - Redirect default https://your-domain/?wp-login.php?action=register to your custom Register page
  - Optional Email Domain Blacklist Validation
  - Password Visibility Toggle
  - Password strength and match validation
  - Form Action:
    - Default User Registration Action
    - Default Email Action
    - Default Redirect Action

# Custom Password Lost Form
  - Redirect default https://your-domain/?wp-login.php?action=lostpassword to your custom password lost page
  - Valid Email Validation
  - Form Action:
    - Custom Action ( Retrieve user password reset link and email )
    - Default Redirect Action

# Custom Password Reset Form
  - Redirect default https://your-domain/?wp-login.php?action=rp&key=xxxxxxxxxxxxx&login=xxxxxxxx to your custom password reset page
  - Redirect on direct access to your custom password reset page
  - Password reset token/url/key Validation
  - Password Visibility Toggle
  - Password strength and match validation
  - Form Action:
    - Custom Action ( Update user password and email )
    - Default Redirect Action


# Reminder/Warning
Copy all the code in function.php to Bricks Child theme function.php. Im not recommend to use WPCode or other code snippets plugin in this case. If you are locked out from dashboard, you still can access the child theme function.php file via ftp and remove all the code inserted to get back to your dashboard.
  - Please cross check all the fields IDs with your form field IDs.
  - Please cross check all the page slug/ID with your custom form page slug/ID.

#3 Not tested:
  - WooCommerce
  - Multisite

#4 Test Environment
  - Wordpress v6.2
  - Bricks v1.7.3
  - Localwp v6.7.1+6369
  - PHP v8.1.9
  - MySQL v8.0.16
