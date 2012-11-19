<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';


/* agregando routers de lenguage */

// para la URI normal cuando llamamos a un controlador

// para URI cuando llamamos a un controlador por defecto

//$route['^es/(.+)$'] = "$1";
//$route['^en/(.+)$'] = "$1";
//peticiones ajax
//terminar sesion
$route['^(es|en)/inicio/cerrar-session'] = "users/closeSession";

$route['^(es|en)/inicio/validar'] = "users/validar";
$route['^(es|en)/inicio/getCaptcha'] = "users/getCaptcha";
$route['^(es|en)/inicio/validarEmailSendCode'] = "users/validarEmailSendCode";
$route['^(es|en)/inicio/validarEmailCode']="users/validarEmailCode";


$route['^(es|en)/ingresos/registro'] = "ingresos/registro";
$route['^(es|en)/ingresos/nuevo-tipo-ingreso'] = "ingresos/nuevotipo";
$route['^(es|en)/ingresos/cargar-ingreso'] = "ingresos/ingreso";
$route['^(es|en)/ingresos/lista-ingresos'] = "ingresos/listaingresos";

$route['^(es|en)/registro-ingresos-diarios/guardar-egresos'] = "egresos/saveEgresos";
$route['^(es|en)/registro-ingresos-diarios/listar-egresos'] = "egresos/loadEgresos";

$route['^es$'] = $route['default_controller'];
$route['^en$'] = $route['default_controller'];

// '/en' and '/es' -> use default controller

$route['^(es|en)/login']="welcome";
$route['^(es|en)/registro']="registro";
$route['^(es|en)/portal-control-economico'] = "inicio";
$route['^(es|en)/registro-ingresos-diarios'] = "ingresos";
$route['^(es|en)/registro-egresos-diarios'] = "egresos";
$route['^(es|en)/registro-prestamos-diarios'] = "prestamos";
$route['^(es|en)/mis-datos-personales'] = "micuenta";
$route['^(es|en)/reporte-cuentas'] = "reportes";







/* end routers de lenguage */
/* End of file routes.php */
/* Location: ./application/config/routes.php */


