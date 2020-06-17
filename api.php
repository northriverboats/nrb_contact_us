<?php

if ( ! defined( 'ABSPATH' ) ) wp_die( 'restricted access' );

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
use Analog\Logger;

$debug = substr($_SERVER['SERVER_ADDR'],0,9) == '10.10.200';
$debug_console = True;

if ($debug & $debug_console) {
  Analog::handler (Analog\Handler\ChromeLogger::init ());
} else {
  $log_file = dirname(__FILE__).'/tmp/log.txt';
  Analog::handler (Analog\Handler\File::init ($log_file));
}

$nl = "\n";


add_action( 'rest_api_init', 'nrb_contact_us_register_routes' );

/*
 * WP_REST_Server::READABLE   = ‘GET’
 * WP_REST_Server::EDITABLE   = ‘POST, PUT, PATCH’
 * WP_REST_Server::DELETABLE  = ‘DELETE’
 * WP_REST_Server::ALLMETHODS = ‘GET, POST, PUT, PATCH, DELETE’
 *
 * https://code.tutsplus.com/tutorials/wp-rest-api-creating-updating-and-deleting-data--cms-24883
 * https://generatewp.com/snippet/pnkkpve/
 * https://webkul.com/blog/add-custom-rest-api-route-wordpress/
 * https://developer.wordpress.org/reference/functions/register_rest_route/
 *
 */

/**
 * Register the /wp-json/nrb_contact_us/ routes
 *
 *    GET    nrb_contact_us/mail/(?P<dealer>[\s\S]+)/(?P<role>[\s\S]+)
 *    POST   nrb_contact_us/contact
 *    POST   nrb_contact_us/commercial
 *
 */

function nrb_contact_us_register_routes() {
   register_rest_route( 'nrb_contact_us', 'contact', array(
       'methods'  => WP_REST_Server::EDITABLE,
       'callback' => 'nrb_contact_us_serve_route_contact_create'
   ) );

   register_rest_route( 'nrb_contact_us', 'mail/(?P<dealer>[\s\S]+)/(?P<role>[\s\S]+)', array(
       'methods'  => WP_REST_Server::READABLE,
       'callback' => 'nrb_contact_us_serve_route_mail'
     ) );

   register_rest_route( 'nrb_contact_us', 'commercial', array(
       'methods'  => WP_REST_Server::EDITABLE,
       'callback' => 'nrb_contact_us_serve_route_commercial_create'
   ) );

}

/**
 * Generate results for the /wp-json/nrb_contact_us/contact route CREATE.
 *
 * @param WP_REST_Request $request Full details about the request.
 *
 * @return WP_REST_Response|WP_Error The response for the request.
 */
function nrb_contact_us_serve_route_contact_create( WP_REST_Request $request ) {
    global $wpdb;
    $params = array_map('stripslashes_deep',json_decode( file_get_contents( 'php://input' ), true ));
    $params['submitted'] = date("Y-m-d H:i:s");
    if ($params['state'] == 'Not Applicable') {
        $params['dealership'] = 'Factory';
    } else {
        $params['dealership'] = zipcode2dealer($params['zip']);
    }
    if ($wpdb->insert('wp_nrb_contact_us',$params) == 1) {
        $response['status'] = 'success';
        email_contact_form($params);
    } else {
        $response['status'] = 'failed';
        email_error($params);
    }
    return $response;
}


/**
 * Generate results for the /wp-json/nrb_contact_us/commercial route CREATE.
 *
 * @param WP_REST_Request $request Full details about the request.
 *
 * @return WP_REST_Response|WP_Error The response for the request.
 */
function nrb_contact_us_serve_route_commercial_create( WP_REST_Request $request ) {
    global $wpdb;
    $params = array_map('stripslashes_deep',json_decode( file_get_contents( 'php://input' ), true ));
    $params['submitted'] = date("Y-m-d H:i:s");
    $params['hear_about_us'] = implode(", ", $params['hear_about_us']);

    if ($wpdb->insert('wp_nrb_contact_us_comm',$params) == 1) {
        $response['status'] = 'success';
        email_contact_comm_form($params);
    } else {
        $response['status'] = 'failed';
        email_error($params);
    }
    return $response;
}


function nrb_contact_us_serve_route_mail( WP_REST_Request $request ) {
    $result['email'] = dealer2email($request['dealer'],$request['role']);
    return $result;
}


function email_error($params) {
  $body = nl2br(print_r($params,true));
  $mail = new PHPMailer(true);
  $mail->setFrom('webmaster@northriverboats.com', 'North River Website');
  $mail->addAddress('fredw@northriverboats.com', 'Fred Warren');
  $mail->Subject = 'Errors in NRB Customer Contact - ' . $params['name'];
  $mail->msgHTML($body);

  try {
      $mail->send();
      // echo 'Message has been sent';
  } catch (Exception $e) {
      // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  }
}


function email_contact_form($params) {
    $nl = "\r";
    $body  ='<table width="640" border="0" cellpadding="0" cellspacing="0" bordercolor="#999">'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td width="17" align="left" valign="top" style="background-color:#0066cc"></td>'.$nl;
    $body .='<td width="123" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#FFF; background-color:#0066cc"><img src="https://www.northriverboats.com/logo-white2.png" width="205" height="75" /></td>'.$nl;
    $body .='<td width="561" style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#FFF; background-color:#0066cc; padding-left:15px;">NRB Customer Contact</td>'.$nl;
    $body .='<td width="17" align="left" valign="top" style="background-color:#0066cc"></td>'.$nl;
    $body .='</tr>'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td height="33" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:9px; padding:8px; background-color:#0066cc">&nbsp;</td>'.$nl;
    $body .='<td height="33" colspan="2" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:9px; padding:8px; background-color:#ffffff"><table width="650" border="0" cellpadding="3" cellspacing="0">'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td colspan="3" align="left" valign="top" bgcolor="#99FFFF" style="width:190px; background:#99FFFF; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; margin-left:10px;">NRB Customer Contact' . ' :: ' . date("m/d/Y") . '</td>'.$nl;
    $body .='</tr>'.$nl;

    $body .='<!-- Spacer Row -->'.$nl;
    $body .='<tr>'.$nl;
    $body .='<td colspan="3" align="left" valign="top" style="height:5px;"></td>'.$nl;
    $body .='</tr>'.$nl;

    foreach ($params as $title => $data) {
        switch( $data ){
            case 'override':
                break;
            default: // by default echo everything
                $body .='<tr>'.$nl
                  . '<td width="25%" align="left" valign="middle" bgcolor="#eef0f3" style="background-color:#eef0f3; Font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; margin-left:10px; border-top:thin; border-top-color:#999; border-top-style:solid; border-left:thin; border-left-color:#999; border-left-style:solid;">' . $title .'</td>'.$nl
                  . '<td colspan="2" align="left" valign="middle" bgcolor="#eef0f3" style="height:22px; height:22px; background-color:#eef0f3; font-family:Arial, Helvetica, sans-serif; font-size:11px; margin-left:10px; border-top:thin; border-top-color:#999; border-top-style:solid; border-left:thin; border-left-color:#999; border-left-style:solid; border-right:thin; border-right-color:#999; border-right-style:solid;">' . nl2br($data) . '</td>'.$nl
                  . '</tr>'.$nl
                  . '<!-- Spacer Row -->'.$nl
                  . '<tr>'.$nl
                  . '<td colspan="3" align="left" valign="top" style="height:5px; border-top:thin; border-top-color:#999; border-top-style:solid"></td>'.$nl
                  . '</tr>'.$nl;
        }
    }


    $body .='</table></td>'.$nl;
    $body .='<td height="33" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:9px; padding:8px; background-color:#0066cc">&nbsp;</td>'.$nl;
    $body .='</tr>'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td height="20" colspan="4" align="left" valign="middle" style="background-color:#0066cc; color:#CCC; font-family:Verdana, Geneva, sans-serif; font-size:9px; padding-left:10px; text-decoration:none;"></td>'.$nl;
    $body .='</tr>'.$nl;
    $body .='</table>'.$nl;

    $mail = new PHPMailer(true);
    $mail->setFrom('webmaster@northriverboats.com', 'North River Website');
    $persons = explode(" ; ",dealer2email($params['dealership'],$params['subject']));
    foreach ($persons as $person) {
        $mail->addAddress($person);
    }
    $mail->Subject = 'NRB Customer Contact - ' . $params['name'];
    $mail->msgHTML($body);

    try {
        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

function email_contact_comm_form($params) {
    $nl = "\r";
    $body  ='<table width="640" border="0" cellpadding="0" cellspacing="0" bordercolor="#999">'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td width="17" align="left" valign="top" style="background-color:#0066cc"></td>'.$nl;
    $body .='<td width="123" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#FFF; background-color:#0066cc"><img src="https://www.northriverboats.com/logo-white2.png" width="205" height="75" /></td>'.$nl;
    $body .='<td width="561" style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#FFF; background-color:#0066cc; padding-left:15px;">NRB Commercial Contact</td>'.$nl;
    $body .='<td width="17" align="left" valign="top" style="background-color:#0066cc"></td>'.$nl;
    $body .='</tr>'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td height="33" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:9px; padding:8px; background-color:#0066cc">&nbsp;</td>'.$nl;
    $body .='<td height="33" colspan="2" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:9px; padding:8px; background-color:#ffffff"><table width="650" border="0" cellpadding="3" cellspacing="0">'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td colspan="3" align="left" valign="top" bgcolor="#99FFFF" style="width:190px; background:#99FFFF; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; margin-left:10px;">NRB Customer Contact' . ' :: ' . date("m/d/Y") . '</td>'.$nl;
    $body .='</tr>'.$nl;

    $body .='<!-- Spacer Row -->'.$nl;
    $body .='<tr>'.$nl;
    $body .='<td colspan="3" align="left" valign="top" style="height:5px;"></td>'.$nl;
    $body .='</tr>'.$nl;

    foreach ($params as $title => $data) {
        switch( $data ){
            case 'override':
                break;
            default: // by default echo everything
                if ($data) {
                    $body .='<tr>'.$nl
                      . '<td width="25%" align="left" valign="middle" bgcolor="#eef0f3" style="background-color:#eef0f3; Font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; margin-left:10px; border-top:thin; border-top-color:#999; border-top-style:solid; border-left:thin; border-left-color:#999; border-left-style:solid;">' . $title .'</td>'.$nl
                      . '<td colspan="2" align="left" valign="middle" bgcolor="#eef0f3" style="height:22px; height:22px; background-color:#eef0f3; font-family:Arial, Helvetica, sans-serif; font-size:11px; margin-left:10px; border-top:thin; border-top-color:#999; border-top-style:solid; border-left:thin; border-left-color:#999; border-left-style:solid; border-right:thin; border-right-color:#999; border-right-style:solid;">' . nl2br($data) . '</td>'.$nl
                     . '</tr>'.$nl
                     . '<!-- Spacer Row -->'.$nl
                     . '<tr>'.$nl
                     . '<td colspan="3" align="left" valign="top" style="height:5px; border-top:thin; border-top-color:#999; border-top-style:solid"></td>'.$nl
                     . '</tr>'.$nl;
                }
        }
    }


    $body .='</table></td>'.$nl;
    $body .='<td height="33" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:9px; padding:8px; background-color:#0066cc">&nbsp;</td>'.$nl;
    $body .='</tr>'.$nl;

    $body .='<tr>'.$nl;
    $body .='<td height="20" colspan="4" align="left" valign="middle" style="background-color:#0066cc; color:#CCC; font-family:Verdana, Geneva, sans-serif; font-size:9px; padding-left:10px; text-decoration:none;"></td>'.$nl;
    $body .='</tr>'.$nl;
    $body .='</table>'.$nl;

    $mail = new PHPMailer(true);
    $mail->setFrom('webmaster@northriverboats.com', 'North River Website');
    $mail->addAddress('mikeb@northriverboats.com', 'Mike Blocher');
    $mail->addAddress('jordan@northriverboats.com', 'Jordan Allen');
    $mail->addAddress('fredw@northriverboats.com', 'Fred Warren');
    $mail->Subject = 'NRB Commercial Contact - ' . $params['name'];
    $mail->msgHTML($body);

    try {
        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

function zipcode2dealer($postal) {

    if (substr($postal,3,1) == ' ' || substr($postal,3,1) =='-') {
        $postal = substr($postal,0,3) . substr($postal,4,3);
    }

    if (preg_match('/[jJ][09][a-zA-Z](-| |)[0-9][a-zA-Z][0-9]/',$postal) or preg_match('/[xX][0][a-cA-C](-| |)[0-9][a-zA-Z][0-9]/',$postal)) {
        return "Avataa Outdoor Sports";
    }

    if (preg_match('/[vV][2][kKlLmMnN](-| |)[0-9]/',$postal)) {
        return "Prince George Motorsports";
    }

    if (preg_match('/[a-zA-Z][0-9][a-zA-Z](-| |)[0-9][a-zA-Z][0-9]/',$postal)) {
        return "Port Boat House";
    }

    $zip = array(
        array(43000,"Factory"),
        array(50000,"Riverfront Marina"),
        array(60000,"Factory"),
        array(66000,"Riverfront Marina"),
        array(70000,"Factory"),
        array(73000,"Riverfront Marina"),
        array(83200,"Factory"),
        array(83500,"Idaho Marine"),
        array(83600,"Elephant Boys"),
        array(83800,"Idaho Marine"),
        array(84000,"Elephant Boys"),
        array(90000,"Clemens Marina"),
        array(96200,"Boat Country"),
        array(97400,"Clemens Marina"),
        array(97406,"Clemens Eugene"),
        array(97408,"Y-Marina"),
        array(97411,"Clemens Eugene"),
        array(97412,"Y-Marina"),
        array(97414,"Clemens Eugene"),
        array(97416,"Y-Marina"),
        array(97420,"Clemens Eugene"),
        array(97421,"Y-Marina"),
        array(97423,"Clemens Eugene"),
        array(97424,"Y-Marina"),
        array(97430,"Clemens Eugene"),
        array(97431,"Y-Marina"),
        array(97439,"Clemens Eugene"),
        array(97440,"Y-Marina"),
        array(97441,"Clemens Eugene"),
        array(97442,"Y-Marina"),
        array(97444,"Clemens Eugene"),
        array(97445,"Y-Marina"),
        array(97449,"Clemens Eugene"),
        array(97451,"Y-Marina"),
        array(97453,"Clemens Eugene"),
        array(97454,"Y-Marina"),
        array(97458,"Clemens Eugene"),
        array(97460,"Y-Marina"),
        array(97464,"Clemens Eugene"),
        array(97468,"Y-Marina"),
        array(97473,"Clemens Eugene"),
        array(97474,"Y-Marina"),
        array(97476,"Clemens Eugene"),
        array(97477,"Y-Marina"),
        array(97480,"Clemens Eugene"),
        array(97481,"Y-Marina"),
        array(97491,"Clemens Eugene"),
        array(97493,"Y-Marina"),
        array(98000,"Clemens Eugene"),
        array(98068,"3Rivers Marine"),
        array(98069,"Valley Marine"),
        array(98600,"3Rivers Marine"),
        array(98602,"Clemens Marina"),
        array(98603,"Valley Marine"),
        array(98605,"Clemens Marina"),
        array(98606,"Valley Marine"),
        array(98613,"Clemens Marina"),
        array(98614,"Valley Marine"),
        array(98617,"Clemens Marina"),
        array(98618,"Valley Marine"),
        array(98619,"Clemens Marina"),
        array(98621,"Valley Marine"),
        array(98623,"Clemens Marina"),
        array(98624,"Valley Marine"),
        array(98628,"Clemens Marina"),
        array(98629,"Valley Marine"),
        array(98635,"Clemens Marina"),
        array(98636,"Valley Marine"),
        array(98650,"Clemens Marina"),
        array(98651,"Valley Marine"),
        array(98670,"Clemens Marina"),
        array(98671,"Valley Marine"),
        array(98672,"Clemens Marina"),
        array(98674,"Valley Marine"),
        array(98700,"Clemens Marina"),
        array(98801,"3Rivers Marine"),
        array(98803,"Valley Marine"),
        array(98807,"3Rivers Marine"),
        array(98808,"Valley Marine"),
        array(98811,"3Rivers Marine"),
        array(98818,"Valley Marine"),
        array(98819,"3Rivers Marine"),
        array(98820,"Valley Marine"),
        array(98821,"3Rivers Marine"),
        array(98825,"Valley Marine"),
        array(98826,"3Rivers Marine"),
        array(98835,"Valley Marine"),
        array(98836,"3Rivers Marine"),
        array(98838,"Valley Marine"),
        array(98840,"3Rivers Marine"),
        array(98842,"Valley Marine"),
        array(98843,"3Rivers Marine"),
        array(98854,"Valley Marine"),
        array(98855,"3Rivers Marine"),
        array(98861,"Valley Marine"),
        array(98862,"3Rivers Marine"),
        array(98863,"Valley Marine"),
        array(98901,"3Rivers Marine"),
        array(98905,"Valley Marine"),
        array(98907,"3Rivers Marine"),
        array(98910,"Valley Marine"),
        array(98920,"3Rivers Marine"),
        array(98924,"Valley Marine"),
        array(98925,"3Rivers Marine"),
        array(98927,"Valley Marine"),
        array(98930,"3Rivers Marine"),
        array(98931,"Valley Marine"),
        array(98932,"3Rivers Marine"),
        array(98933,"Valley Marine"),
        array(98945,"Valley Marine"),
        array(98946,"3Rivers Marine"),
        array(98949,"Valley Marine"),
        array(98950,"3Rivers Marine"),
        array(98954,"Valley Marine"),
        array(99115,"3Rivers Marine"),
        array(99117,"Valley Marine"),
        array(99123,"3Rivers Marine"),
        array(99125,"Valley Marine"),
        array(99133,"3Rivers Marine"),
        array(99134,"Valley Marine"),
        array(99135,"3Rivers Marine"),
        array(99136,"Valley Marine"),
        array(99155,"3Rivers Marine"),
        array(99156,"Valley Marine"),
        array(99300,"Elephant Boys"),
        array(99301,"3Rivers Marine"),
        array(99303,"Valley Marine"),
        array(99320,"3Rivers Marine"),
        array(99325,"Valley Marine"),
        array(99326,"3Rivers Marine"),
        array(99327,"Valley Marine"),
        array(99329,"3Rivers Marine"),
        array(99331,"Valley Marine"),
        array(99335,"3Rivers Marine"),
        array(99339,"Valley Marine"),
        array(99343,"3Rivers Marine"),
        array(99344,"Valley Marine"),
        array(99345,"3Rivers Marine"),
        array(99347,"Valley Marine"),
        array(99348,"3Rivers Marine"),
        array(99351,"Valley Marine"),
        array(99352,"3Rivers Marine"),
        array(99355,"Valley Marine"),
        array(99356,"3Rivers Marine"),
        array(99358,"Valley Marine"),
        array(99360,"3Rivers Marine"),
        array(99364,"Valley Marine"),
        array(99500,"3Rivers Marine"),
        array(100000,"Factory")
    );

    if (! preg_match('/(^\d{5}$)|(^\d{5}-\d{4}$)/',$postal)) {
        return "Factory";
    }

    for ($index = 0; $index < count($zip); $index++) {
        if($postal < $zip[$index][0]) {
            return $zip[$index][1];
        }
    }
    return "Factory";
} // zipcode2dealer


/**
 * Generate a list of email address to contact at a dealership
 *   the store manager is always added to the list of email addresses
 *
 * @param String $dealer Dealer for whom we want contact information.
 *
 * @param String $role Role at dealerhip we want addresses for
 *
 * @return Sting list of email addresses seperated with ;
 */
function dealer2email($dealer, $role) {
    global $wpdb;
    $sql = (
        "SELECT DISTINCT dealer_group , email_sales, email_parts, email_service, email_manager, email_admin, email_warranty
        FROM wp_nrb_dealers ORDER BY dealer_group"
    );
    $response = $wpdb->get_results($sql);
    $mylist = array();
    foreach($response as $item) {
        $manager = explode(" ; ", $item->email_manager);
        $admin = implode(" ; ", array_unique(array_merge(explode(" ; ", $item->email_admin), $manager)));
        $parts = implode(" ; ", array_unique(array_merge(explode(" ; ", $item->email_parts), $manager)));
        $sales = implode(" ; ", array_unique(array_merge(explode(" ; ", $item->email_sales), $manager)));
        $service = implode(" ; ", array_unique(array_merge(explode(" ; ", $item->email_service), $manager)));
        $warranty = implode(" ; ", array_unique(array_merge(explode(" ; ", $item->email_warranty), $manager)));
        $mylist[$item->dealer_group] = array("Parts" => $parts, "Sales" => $sales, "Service" => $service,
          "Admin" => $admin, "Warranty" => $warranty, "Manager" => implode(" ; ", $manager));
    }
    $result = $mylist[$dealer][$role];
    if ($result !== '') {
      if ($dealer !== 'Factory') {
        if ($role == 'Parts') {
          return $result . ' ; kene@northriverboats.com';
        }
        if ($role == 'Sales') {
          return $result . ' ; joed@northriverboats.com ; mikeb@northriverboats.com ; jordana@northriverboats.com';
        }
        return $result . ' ; joed@northriverboats.com ; saral@northriverboats.com';
      }
      return $result;
    }
    return 'fredw@northriverboats.com';
}

