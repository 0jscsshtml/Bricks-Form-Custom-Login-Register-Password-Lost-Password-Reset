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

# 1. Create custom login/register, password lost, password reset page, import form templates.
  - Create login/register, password lost and password reset page as usual.
  - Import form section template, assign each form template to respective page.
  - Change your redirect url, email content accordingly.
  - Upload password visibility icons(included). 

# 2. Copy code from function.php(included) to Bricks Child Theme function.php
# Reminder/Warning
Copy all the code(from line 6) in function.php to Bricks Child theme function.php. Im not recommend to use WPCode or other code snippets plugin in this case. If you are locked out from dashboard, you still can access to the child theme function.php file via ftp and remove all the code inserted to revert back to wordpress default. Please test it on your staging/local before deploy on production.
  - Please cross check all the fields IDs and make sure is match to your form field IDs.
  - Please cross check all the page slug/ID and make sure is match to to your custom form page slug/ID.
  - Change redirect url to your preferred page url.
  - Change your own form message and email content.

# 3. Reference
  - https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-1-replace-the-login-page--cms-23627
  - https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-2-new-user-registration--cms-23810
  - https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811
  - https://academy.bricksbuilder.io/article/form-element/

# 4 Not tested:
  - WooCommerce
  - Multisite

# 5 Test Environment
  - Wordpress v6.2
  - Bricks v1.7.3
  - Localwp v6.7.1+6369
  - PHP v8.1.9
  - MySQL v8.0.16
