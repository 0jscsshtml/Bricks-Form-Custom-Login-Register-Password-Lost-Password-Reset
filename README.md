# Custom Login/Register/Password Lost/Password Reset Page with Bricks Builder Form Element
# Credit to Jarkko Laine on article https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-1-replace-the-login-page--cms-23627

#1 Create Login/Register/Password Lost/Password Reset Page as usual

#2 Import each form section template and assign to page respectively

#3 Copy all the code in function.php to Bricks Child theme function.php. Im not suggest to use WPCode or other code snippets plugin. If you lock out from dashboard, you still can access the function.php file and remove all the code inserted to get back to your dashboard.
  - Change all commented fields accordingly.

#4 Not tested:
  - Lack of login remember me functionailty.
  - WooCommerce

#5 Test Environment
  - Wordpress v6.2
  - Bricks v1.7.3
  - Localwp v6.7.1+6369
  - PHP v8.1.9
  - MySQL v8.0.16
