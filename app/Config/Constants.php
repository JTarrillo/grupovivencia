<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
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
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//cuztomize

defined('BACKOFFICE')           || define('BACKOFFICE', 'backoffice_new'); // no errors
defined('PANEL')                || define('PANEL', 'Panel'); // no errors
defined('PERFIL')               || define('PERFIL', 'Perfil'); // no errors
defined('SETTING')              || define('SETTING', 'Configuración'); // no errors
defined('KYC')                  || define('KYC', 'KYC'); // no errors
defined('PIN')                  || define('PIN', 'PIN'); // no errors
defined('PLAN')                 || define('PLAN', 'Planes'); // no errors
defined('DOCUMENTS')            || define('DOCUMENTS', 'Documentos'); // no errors
defined('BINARY')               || define('BINARY', 'Binario'); // no errors
defined('UNILEVEL')             || define('UNILEVEL', 'Unilevel'); // no errors
defined('REFERRED')             || define('REFERRED', 'Referidos Directos'); // no errors
defined('HISTORY')              || define('HISTORY', 'Historial'); // no errors
defined('CARRERA')              || define('CARRERA', 'Carrera'); // no errors
defined('SUPPORTS')             || define('SUPPORTS', 'Soporte'); // no errors
defined('HELP')                 || define('HELP', 'Centro de Ayuda'); // no errors
defined('TUTORIAL')             || define('TUTORIAL', 'Tutoriales'); // no errors
defined('FAQ')                  || define('FAQ', 'FAQ'); // no errors
defined('INVOICE')              || define('INVOICE', 'Facturas'); // no errors
defined('TRANSFER')              || define('TRANSFER', 'Transferencias'); // no errors
defined('RANGES')               || define('RANGES', 'Rangos'); // no errors
defined('PAYS')                  || define('PAYS', 'Pagos'); // no errors
defined('RECHARGE')               || define('RECHARGE', 'Recarga'); // no errors
defined('ADS')               || define('ADS', 'Anuncios'); // no errors

//message

defined('SEND_SUGGEST')          || define('SEND_SUGGEST', 'Sugerencia Enviada'); // no errors
defined('SEND_RECHARGE')          || define('SEND_RECHARGE', 'Recarga Enviada'); // no errors
defined('SEND_TICKET')          || define('SEND_TICKET', 'Ticket Enviado'); // no errors
defined('SEND_PIN')          || define('SEND_PIN', 'PIN Enviado'); // no errors
defined('WRONG_PIN')          || define('WRONG_PIN', 'PIN Incorrecto'); // no errors
defined('WELCOME')              || define('WELCOME', 'Bienvenido'); // no errors
defined('BUYED_SUCCESS')        || define('BUYED_SUCCESS', 'Compra con Éxito'); // no errors
defined('SAVED')              || define('SAVED', 'Cambio Guardado'); // no errors
defined('PAYED')              || define('PAYED', 'Cobro Solicitado'); // no errors
defined('DELETED')              || define('DELETED', 'Registro Eliminado'); // no errors
defined('ERROR')              || define('ERROR', 'Hubo un error, vuelva a intentarlo'); // no errors
defined('AMOUNT_INVALID')      || define('AMOUNT_INVALID', 'Importe Incorrecto'); // no errors
defined('ENTER_WALLET')       || define('ENTER_WALLET', 'Ingrese Wallet'); // no errors
defined('WRONG_PASSWORD')       || define('WRONG_PASSWORD', 'Password Incorrecto'); // no errors
defined('PASS_NO_EQUAL')       || define('PASS_NO_EQUAL', 'Password no son iguales'); // no errors
defined('USER_TAKEN')       || define('USER_TAKEN', 'Username no disponible'); // no errors
defined('EMAIL_TAKEN')       || define('EMAIL_TAKEN', 'Email no disponible'); // no errors
defined('DNI_TAKEN')       || define('DNI_TAKEN', 'DNI no disponible'); // no errors
defined('INSUFFICIENT_BALANCE')       || define('INSUFFICIENT_BALANCE', 'Balance Insuficiente'); // no errors
defined('USER_NO_EXIT')       || define('USER_NO_EXIT', 'Usuario no registrado'); // no errors
defined('SEND')       || define('SEND', 'Mensaje enviado al email'); // no errors
defined('PASS_CHANGE')       || define('PASS_CHANGE', 'Password Cambiado'); // no errors




