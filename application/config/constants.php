<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// **
// CUSTOM CONSTANT
// **

if(!defined("SESSION_PREFIX")){
  define("SESSION_PREFIX", "_ALUR_KAS_");
}

if(!defined("APP_NAME")){
  define("APP_NAME", "ALUR KAS");
}

if(!defined("APP_LONG_NAME")){
  define("APP_LONG_NAME", "Pencatatan Alur KAS");
}

if(!defined("APP_SHORT_NAME")){
  define("APP_SHORT_NAME", "AK");
}

if(!defined("MAX_IMAGE_SIZE_IN_BYTE")){
  define("MAX_IMAGE_SIZE_IN_BYTE", 1500000);
}

if(!defined("MAX_IMAGE_SIZE_DESC")){
  define("MAX_IMAGE_SIZE_DESC", "1.5MB");
}

if(!defined("MAX_FILE_SIZE_IN_BYTE")){
  define("MAX_FILE_SIZE_IN_BYTE", 50000000);
}

if(!defined("MAX_FILE_SIZE_DESC")){
  define("MAX_FILE_SIZE_DESC", "50MB");
}

if(!defined("MAX_REGULAR_IMAGE_SIZE")){
  define("MAX_REGULAR_IMAGE_SIZE", 800);
}

if(!defined("MAX_THUMBNAIL_IMAGE_SIZE")){
  define("MAX_THUMBNAIL_IMAGE_SIZE", 128);
}

if(!defined("MAX_THUMBNAIL_IMAGE_SIZE")){
  define("MAX_THUMBNAIL_IMAGE_SIZE", 128);
}

if(!defined("ROWS_PER_PAGE")){
  define("ROWS_PER_PAGE", 500);
}

if(!defined("DEFAULT_ADD_PHOTO_PATH")){
  // define("DEFAULT_ADD_PHOTO_PATH", base_url("assets/img/image-add-button.png"));
}

// ** MAPS ** //
if(!defined("MAP_API_KEY")){
  define("MAP_API_KEY", "your_map_api_key");
}
if(!defined("MAP_ICON_PETUGAS")){
  define("MAP_ICON_PETUGAS", "https://maps.google.com/mapfiles/ms/icons/red-dot.png");
}
if(!defined("MAP_ICON_PELANGGAN")){
  define("MAP_ICON_PELANGGAN", "https://maps.google.com/mapfiles/ms/icons/blue-dot.png");
}

// ** FOTO DEFAULT **/
define("DEFAULT_FOTO_KTP", "assets/images/pelanggan/card.png");
define("DEFAULT_FOTO_TEMPAT_TINGGAL", "assets/images/pelanggan/house.png");
define("DEFAULT_FOTO_PROFIL", "assets/images/pelanggan/profile.png");

// ** EMAIL SMPT  **//
if(!defined("EMAIL_SMTP_USER")){
  define("EMAIL_SMTP_USER", "your@email.address");
}
if(!defined("EMAIL_SMTP_PASSWORD")){
  define("EMAIL_SMTP_PASSWORD", "email_password");
}
if(!defined("EMAIL_FROM")){
  define("EMAIL_FROM", "from@email.address");
}
if(!defined("EMAIL_ALIAS")){
  define("EMAIL_ALIAS", "Email Alias");
}