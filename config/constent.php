<?php 

define('BAD_REQUEST', 400);
define('UNAUTHORISED', 401 );
define('NOT_FOUND', 404);
define('STATUS_OK', 200);
define('METHOD_NOT_ALLOW', 405);
define('STATUS_CREATED', 201);
define('LOGIN_SUCCESS', "Login successfully");
define('DATA_UPLOAD', "Data has been uploaded successfully");
define('DATA_STORE', "Record created successfully");
define('DATA_UPDATED', "Record updated successfully");
define('DATA_DELETED', "Record deleted successfully");
define('DATA_RESTORE', "Record restored successfully");
define('DATA_FATCHED', "Record fatched successfully");
define('DATA_EXISTS', "Record already added");
define('CREDANTIAL_MISMATCHED', 'Credantial Mismatched');
define('PASSWORD_MISMATCHED', 'Password mismatched');
define('ACCOUNT_SUSPENDED', 'This Account Has Been Suspended. Please contact the support team.');
define('OTP_SEND', 'OTP send successfully');
define('OTP_WRONG', 'Wrong otp');
define('PASSWORD_RESET', 'Password has been successfully reset');
define('PASSWORD_CHNAGED', 'Password changed successfully');
define('EXISTS_APPLICATION', 'You are already applying for this course in the same college');
define('DATA_NOT_FOUND', "Record not found.");
define('FILE_FORMAT', "File Content is not currect please check again.");
define('USER_START', date('ym'));
define('USER_PRIFIX', "GU");

define('STUDENT_START', date('ym'));
define('STUDENT_PREFIX', "GS");

define('APPLICATION_START', date('ym'));
define('APPLICATION_PREFIX', "GA");

define('ADMIN_ROLE', 'Please create user with another role.');
//define('IMGPREFIX', "public/"); //for live or production mode
define('IMGPREFIX', ""); 
//for local server