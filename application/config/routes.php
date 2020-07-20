<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'verification/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//////////////////////Main controller routes start/////////////////////

//view my profile routes
$route['profile'] = 'main/profile';
$route['remove-profile-picture'] = 'main/remove_profile_pic';

// Home/Dashboard page routes
$route['dashboard'] = 'main/get_dashboard';
$route['get-events'] = 'main/get_cal_events';
$route['add-event'] = 'main/add_cal_event';
$route['remove-event'] = 'main/delete_cal_event';
$route['update-event'] = 'main/update_cal_event';


// Routes used for the Enrolled list 
$route['enrolled-list'] = 'main/view_enrolled_list';
$route['register-applicant'] = 'main/add_client';
$route['unenroll-client'] = 'main/unenroll_client';

// Route used for grades
$route['view-client-grade/(:any)/(:num)'] = 'main/view_client_grade/$1/$2';
$route['manage-client-grade/(:any)/(:num)'] = 'main/manage_client_grade/$1/$2';
$route['update-grades'] = 'main/update_client_grade';


// Routes used for the Client List
$route['client-list'] = 'main/view_clients';

//Routes for client management
$route['manage-client/(:any)/(:num)'] = 'main/manage_client/$1/$2';
$route['client-program-update'] = 'main/update_client_program_data';
// Routes for client file management
$route['remove-file'] = 'main/remove_client_doc/';
// $route['get-files/(:any)/(:num)'] = 'main/get_client_doc/$1/$2';
$route['upload-file/(:any)/(:num)/(:num)'] = 'main/upload_client_doc/$1/$2/$3';


//Route for comments
$route['enter-comment'] = 'main/create_comment';
$route['remove-comment'] = 'main/delete_comment';
$route['update-comment'] = 'main/update_comment';

//route for js session check
$route['session-check'] = 'main/js_session_check';


//routes are used in both Client list and Enrolled list
$route['client-info/(:num)'] = 'main/view_client_profile/$1';
$route['edit-client-info/(:num)'] = 'main/update_client/$1';
$route['update-client-info/(:num)'] = 'main/update_client/$1';

// Adding a user route
$route['add-user'] = 'main/add_user';

// Routes used for User List
$route['user-list'] = 'main/view_users';
$route['user-info/(:num)'] = 'main/view_user_profile/$1';
$route['remove-user/(:num)'] = 'main/remove_user/$1';
$route['update-user-profile'] = 'main/update_user_profile';

// routes used for viewing my profile
$route['update-profile'] = 'main/update_my_profile';
$route['change-my-password'] = 'main/change_pass';
$route['update-profile-picture'] = 'main/change_profile_pic';

// routes for creating report
$route['report'] = 'main/report_settings';
$route['program-summary-report'] = 'main/generate_program_report';
$route['delete-existing-report'] = 'main/remove_existing_report';
$route['save-report'] = 'main/save_report';

//Additional routes
$route['activate-user'] = 'main/activate_user';
$route['autocomplete'] = 'main/auto_complete';

//autocomplete route
$route['search'] = 'main/autocomplete_search';

//advance search route
$route['advance-search'] = 'main/advance_search';


////////////////////// Main controller routes end///////////////////////

//program setup page routes
$route['program-setup'] = 'main/program_setup';
// $route['save-program-setup'] = 'main/save_program_settings';
$route['save-event-labels'] = 'main/save_calendar_events_labels';
$route['save-assesment-names'] = 'main/save_program_assesment_names';

//verification routes start//

//routes for login UI
$route['login'] = 'verification/login';
$route['logout'] = 'verification/logout';
$route['reset-password'] = 'verification/reset_password';
$route['change-password/(:num)/(:any)'] = 'verification/change_password/$1/$2';

//verification routes end//

//email controller routes
$route['forgot-password'] = 'verification/request_email';
$route['reset-request'] = 'verification/send_reset_request';


