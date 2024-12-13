<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\BookingQoute;
use App\Models\Booking;
use App\Models\AcceptedQoute;
use libphonenumber\PhoneNumberUtil;


if (! function_exists('time_to_uae') ) {
    function time_to_uae($date, $format="Y-m-d H:i:s")
    {
        return date($format, strtotime(' +4 hours', strtotime($date)));
    }
}
if (! function_exists('removeExtraSpaces') ) {
    function removeExtraSpaces($string) {
        return trim(preg_replace('/\s+/', ' ', $string));
    }
}

if (! function_exists('extractFirstEmail') ) {
    function extractFirstEmail($data)
    {
        $lines = preg_split('/\R/', $data);

        foreach ($lines as $line) {
            $email = extractEmail($line);
            if (!empty($email)) {
                return $email;
            }
        }

        return "";
    }
}

if (! function_exists('extractEmail') ) {
    function extractEmail($line)
    {
        $matches = [];
        preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $line, $matches);
        return $matches[0] ?? "";
    }
}

function extractDialCodeAndPhone($phoneNumber)
{
    $phoneNumber = str_replace(' ', '', $phoneNumber);
    $phoneNumber = str_replace('(', '', $phoneNumber);
    $phoneNumber = str_replace(')', '', $phoneNumber);
    $phoneNumber = str_replace(':', '', $phoneNumber);
    $phoneNumberUtil = PhoneNumberUtil::getInstance();
    $defaultCountryCode = '971';
    $defaultRegion = 'AE';

    // Extract only the digits from the input
    preg_match('/\d+/', $phoneNumber, $matches);
    $phoneNumberDigits = $matches[0] ?? '';

    try {
        $parsedPhoneNumber = $phoneNumberUtil->parse($phoneNumberDigits, $defaultRegion);

        // Check if the phone number has a country code
        if ($phoneNumberUtil->isValidNumber($parsedPhoneNumber)) {
            // Extract dial code and phone without '+'
            $dialCode = $parsedPhoneNumber->getCountryCode();
            $phone = $parsedPhoneNumber->getNationalNumber();

            return [
                'dial_code' => $dialCode,
                'phone' => $phone,
            ];
        } else {
            // If the phone number is not valid, use the default country code and the entire input as the phone
            return [
                'dial_code' => $defaultCountryCode,
                'phone' => $phoneNumberDigits,
            ];
        }
    } catch (NumberParseException $e) {
        // If there's an error parsing the phone number, use the default country code and the entire input as the phone
        return [
            'dial_code' => $defaultCountryCode,
            'phone' => $phoneNumberDigits,
        ];
    }
}
if (! function_exists('get_storage_path') ) {
    function get_storage_path( $filename='', $dir='' )
    {
        if ( !empty($filename) ) {

            $upload_dir = config('global.upload_path');
            if (! empty($dir) ) {
                $dir= config("global.{$dir}");
            }
            if ( \Storage::disk(config('global.upload_bucket'))->exists($dir.$filename) ) {
               return \Storage::url("{$dir}{$filename}");
           }
        }


        return '';
    }
}
if (! function_exists('get_uploaded_image_url') ) {
    function get_uploaded_image_url( $filename='', $dir='', $default_file='placeholder.png' )
    {

        if ( !empty($filename) ) {

            $upload_dir = config('global.upload_path');
            if (! empty($dir) ) {
                $dir= config("global.{$dir}");
               
            }

            if ( \Storage::disk(config('global.upload_bucket'))->exists($dir.$filename) ) {
                // return 'https://d3k2qvqsrjpakn.cloudfront.net/moda/public'.\Storage::url("{$dir}{$filename}");
                return \Storage::disk(config('global.upload_bucket'))->url($dir.$filename);
                //return asset(\Storage::url("{$dir}{$filename}"));
           }else{

            return asset(\Storage::url("{$dir}{$filename}"));
           }
        }
        if ( !empty($default_file) ) {
            if (! empty($dir) ) {
                $dir= config("global.{$dir}");
            }
            $default_file = asset(\Storage::url("{$dir}{$default_file}"));
        }
        if (! empty($default_file) ) {
            return $default_file;
        }


        return \Storage::url("logo.png");
    }
}
if (! function_exists('time_ago') ) {
    function time_ago( $datetime, $now=NULL, $timezone='Etc/GMT' )
    {
        if (! $now ) {
            $now = time();
        }
        $timezone_user  = new DateTimeZone($timezone);
        $date           = new DateTime($datetime, $timezone_user);
        $timestamp      = $date->getTimestamp();
        $timespan       = explode(', ', timespan($timestamp, $now));
        $timespan       = $timespan[0] ?? '';
        $timespan       = strtolower($timespan);

        if (! empty($timespan) ) {
            if ( stripos($timespan, 'second') !== FALSE ) {
                $timespan = 'few seconds ago';
            } else {
                $timespan .= " ago";
            }
        }

        return $timespan;
    }
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (! function_exists('get_date_in_timezone') ) {
    function get_date_in_timezone($date, $format="d-M-Y h:i a",$timezone='',$server_time_zone="Etc/GMT")
    {
        if($timezone == ''){
            $timezone = config('global.date_timezone');
        }
        try {
            $timezone_server    = new DateTimeZone($server_time_zone);
            $timezone_user      = new DateTimeZone($timezone);
        }
        catch (Exception $e) {
            $timezone_server    = new DateTimeZone($server_time_zone);
            $timezone_user      = new DateTimeZone($server_time_zone);
        }


        $dt = new DateTime($date, $timezone_server);

        $dt->setTimezone($timezone_user);

        return $dt->format($format);
    }
}
function public_url()
{
    if (config('app.url') == 'http://127.0.0.1:8000') {
        return str_replace('/public', '', config('app.url'));
    }
    return config('app.asset_url');
}

function image_upload($request,$model,$file_name, $mb_file_size = 25)
{

    if($request->file($file_name ))
    {
        $file = $request->file($file_name);
        return  file_save($file,$model, $mb_file_size);
    }
    return ['status' =>false,'link'=>null,'message' => 'Unable to upload file'];
}

if (! function_exists('array_combination') ) {
    function array_combination($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = array_combination($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }
}

function file_save($file,$model,$mb_file_size=25)
{
     try {
        $model = str_replace('/','',$model);
        //validateSize
        $precision = 2;
        $size = $file->getSize();
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        $dSize = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

        $aSizeArray = explode(' ', $dSize);
        if ($aSizeArray[0] > $mb_file_size && ($aSizeArray[1] == 'MB' || $aSizeArray[1] == 'GB' || $aSizeArray[1] == 'TB')) {
            return ['status' =>false,'link'=>null,'message' => 'Image size should be less than equal '.$mb_file_size.' MB'];
        }
        // rename & upload files to upload folder
                
        $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($model,$fileName,config('global.upload_bucket'));
        $image_url = $fileName;
            
        return ['status' =>true,'link'=>$image_url,'message' => 'file uploaded'];

    } catch (\Exception $e) {
        return ['status' =>false,'link'=> null ,'message' => $e->getMessage()];
    }
}

function printr($data){
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
}
function url_title($str, $separator = '-', $lowercase = FALSE)
{
    if ($separator == 'dash')
    {
        $separator = '-';
    }
    else if ($separator == 'underscore')
    {
        $separator = '_';
    }

    $q_separator = preg_quote($separator);

    $trans = array(
        '&.+?;'                 => '',
        '[^a-z0-9 _-]'          => '',
        '\s+'                   => $separator,
        '('.$q_separator.')+'   => $separator
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val)
    {
        $str = preg_replace("#".$key."#i", $val, $str);
    }

    if ($lowercase === TRUE)
    {
        $str = strtolower($str);
    }

    return trim($str, $separator);
}

function send_email($to, $subject, $mailbody)
{

    require base_path("vendor/autoload.php");
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = config('app.MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = config('app.MAIL_USERNAME');
        $mail->Password = config('app.MAIL_PASSWORD');
        $mail->SMTPSecure = config('app.MAIL_ENCRYPTION');
        $mail->Port = config('app.MAIL_PORT');
        $mail->setFrom(config('app.MAIL_FROM_ADDRESS'), config('app.MAIL_FROM_NAME'));
        $mail->addAddress($to);
        $mail->addCC('binshambrs@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $mailbody;
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );
        if (!$mail->send()) {
            // dd($e->getMessage());
            return 0;
        } else {
            return 1;
        }
    } catch (Exception $e) {
        return 0;
    }
}

function send_normal_SMS($message, $mobile_numbers, $sender_id = "")
{
    return true;
    $username = "teyaar"; //username
    $password = "06046347"; //password
    $sender_id = "smscntry";
    $message_type = "N";
    $delivery_report = "Y";
    $url = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
    $proxy_ip = "";
    $proxy_port = "";
    $message_type = "N";
    $message = urlencode($message);
    $sender_id = (!empty($sender_id)) ? $sender_id : $sender_id;
    $ch = curl_init();

    if (!$ch) {
        $curl_error = "Couldn't initialize a cURL handle";
        return false;
    }
    $ret = curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "User=" . $username . "&passwd=" . $password . "&mobilenumber=" . $mobile_numbers . "&message=" . $message . "&sid=" . $sender_id . "&mtype=" . $message_type . "&DR=" . $delivery_report);
    $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (!empty($proxy_ip)) {
        $ret = curl_setopt($ch, CURLOPT_PROXY, $proxy_ip . ":" . $proxy_port);
    }
    $curl_response = curl_exec($ch);
   
    if (curl_errno($ch)) {
        $curl_error = curl_error($ch);
    }
    if (empty($ret)) {
        curl_close($ch);
        // dd('1');
        return false;
    } else {
        $curl_info = curl_getinfo($ch);
        curl_close($ch);
        return true;
    }
}

// function send_normal_SMS($message, $receiverNumber, $sender_id = "")
// {
//     try {
//         $receiverNumber = '+'.str_replace("+","",$receiverNumber);
//         $account_sid = getenv("TWILIO_SID");
//         $auth_token = getenv("TWILIO_TOKEN");
//         $twilio_number = getenv("TWILIO_FROM");
//         $client = new Client($account_sid, $auth_token);
//         $client->messages->create($receiverNumber, [
//             'from' => $twilio_number,
//             'body' => $message]
//         );
//         return 1;
//     } catch (TwilioException $e) {
//         return $e->getMessage();
//         // return 0;
//     }
// }

function send_whatsap_message($message, $receiverNumber, $sender_id = "")
{
    try {
        $receiverNumber = '+'.str_replace("+","",$receiverNumber);
        //$account_sid = getenv("TWILIO_SID");
        //$auth_token = getenv("TWILIO_TOKEN");
        $account_sid    = "ACa1c740f7d0d66984b4ac4869fdda207b";
        $auth_token  = "49ab55de1f50e5695fe956780ed93c1f";
        $twilio_number = "whatsapp:+971506359427";
        $client = new Client($account_sid, $auth_token);
        $messages = $client->messages->create('whatsapp:'.$receiverNumber, [
            'from' => $twilio_number,
            'body' => $message]
        );
        printr($messages->sid);
        return 1;
    } catch (TwilioException $e) {
        printr( $e->getMessage());
        // return 0;
    }
}

if (!function_exists('sendWhatsappTemplateMessage')) {
function sendWhatsappTemplateMessage($receiverNumber, $contentId, $data, $MessagingServiceSid = 'MG80f33d764dfb279f3fd0dbd7fa540c46') {

    try {
        $receiverNumber = '+' . str_replace("+", "", $receiverNumber);
        //$account_sid = getenv("TWILIO_SID");
        //$auth_token = getenv("TWILIO_TOKEN");
        $account_sid    = "ACa1c740f7d0d66984b4ac4869fdda207b";
        $auth_token  = "49ab55de1f50e5695fe956780ed93c1f";
        $twilio_number = "whatsapp:+971506359427";
        $client = new Client($account_sid, $auth_token);

        

        $messages = $client->messages->create(
            'whatsapp:' . $receiverNumber,
            [
                "MessagingServiceSid" => $MessagingServiceSid,
                'contentSid' => $contentId,
                'from' => $twilio_number,
                "contentVariables" => json_encode($data)
            ]
        );

        

        //printr($messages->sid);
        return 1;//$messages->sid;

    } catch (TwilioException $e) {
        return $e->getMessage();
    }

}

}

function convert_all_elements_to_string($data=null){
    if($data != null){
        array_walk_recursive($data, function (&$value, $key) {
            if (! is_object($value) ) {
                //echo $value."<br>";
                $value = (string) $value;
            } else {
                $json = json_encode($value);
                $array = json_decode($json, true);

                array_walk_recursive($array, function (&$obj_val, $obj_key) {
                    $obj_val = (string) $obj_val;
                });

                if (! empty($array) ) {
                    $json = json_encode($array);
                    $value = json_decode($json);
                } else {
                    $value = new stdClass();
                }
            }
        });
    }
    return $data;
}
function thousandsCurrencyFormat($num) {

    if( $num > 1000 ) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }

    return $num;
}
function order_status($id)
   {
        $status_string = "Pending";
        if($id == config('global.order_status_pending'))
                {
                   $status_string = "Pending";
                }
                if($id == config('global.order_status_accepted'))
                {
                   $status_string = "Order Placed";
                }
                if($id == config('global.order_status_ready_for_delivery'))
                {
                   $status_string = "Ready for Delivery";
                }
                if($id == config('global.order_status_dispatched'))
                {
                   $status_string = "Dispatched";
                }
                if($id == config('global.order_status_delivered'))
                {
                   $status_string = "Delivered";
                }
                if($id == config('global.order_status_cancelled'))
                {
                   $status_string = "Cancelled";
                }
                if($id == config('global.order_status_returned'))
                {
                   $status_string = "Returned";
                }
    return $status_string;
   }

   
   function encryptor($string) {
    $output = false;

    $encrypt_method = "AES-128-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);


    return $output;
}

function decryptor( $string) {
    $output = false;

    $encrypt_method = "AES-128-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);


        //decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);


    return $output;
}


   

function generate_otp(){
    return 1111;
    //return rand(1111,9999);
}

function namespacedXMLToArray($xml)
{
    // One function to both clean the XML string and return an array
    return json_decode(json_encode(simplexml_load_string(removeNamespaceFromXML($xml))), true);
}
function check_permission($module,$permission){
    $userid = Auth::user()->id;
    $privilege = 0;
    if ($userid > 1) {
        $privileges = \App\Models\UserPrivileges::privilege();
        $privileges = json_decode($privileges, true);
        if (!empty($privileges[$module][$permission])) {
            if ($privileges[$module][$permission] == 1) {
                $privilege = 1;
            }
        }
    } else {
        $privilege = 1;
    }
    return $privilege;
}
function retrive_hash_tags($data=''){
    $d = explode(" ",$data);
    $words=[];
    foreach($d as $k){
        if(substr($k,0,1) == '#'){
          $words[]=ltrim($k,'#');
        }

    }
    return $words;
}
function GetDrivingDistance($lat1, $lat2, $long1, $long2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&key=AIzaSyCtugJ9XvE2MvkXCBeynQDFKq-XN_5xsxM";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = '-';
        $time = '-';
        if(isset($response_a['rows'][0]['elements'][0]['distance']['text'])){
            $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
            $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
        }
        return array('distance' => $dist, 'time' => $time);
    }
    function GetDrivingDistanceToMultipleLocations($from_latlong, $destinations)
    {
        $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$from_latlong.'&destinations='.$destinations.'&mode=driving&key=AIzaSyCtugJ9XvE2MvkXCBeynQDFKq-XN_5xsxM');
        return json_decode($distance_data, true);
    }

    function set_menu_active($menu_type='sub',$check=''){
        $route = \Request::route()->getName();
        $route_list = explode(".",$route);
        if($menu_type == 'main'){
            $result=array_intersect($route_list,$check);
            if(!empty($result)){
                return ' active open';
            }
        }else{
            if(in_array($check,$route_list)){
                return ' active';
            }
        }
     }
    
     function get_user_permission($model,$operation='r'){
        
        $return = false;
        if(Auth::user()->role_id == '1'){
            $return = true;
        }else if(Auth::user()->is_admin_access == 1)
        {   
            $user_permissions = \Session::get('user_permissions');
           
            if(isset($user_permissions[strtolower($model)])){
                $permissions = json_decode($user_permissions[strtolower($model)]??'');
                if(in_array($operation,$permissions)){
                    $return = true;
                }
            }
        }
        return $return;
     }
    
     function all_permission_check($needed_permissions=[],$operation='r'){
        $return  = false;
        foreach($needed_permissions as $permission){
            $resp = get_user_permission($permission,$operation);
            if($resp == true && $return == false){
                $return = true;
            }
        }
        return $return;
     }
     function create_plink($text) {
        $ptext = preg_replace('#[ -]+#', '-', trim(strtolower($text))); 
        $ptext = str_replace("&", "and", $ptext);
    
        $ptext = preg_replace('/[^A-Za-z0-9\-]/', '', $ptext);
    
        $ptext = preg_replace('/-+/', '-', $ptext); // Replaces multiple hyphens with single one.
        return $ptext;
    }

    function get_countries(){
        $countries = DB::table('countries')->where('country_status',1)->where('deleted_at',null)->pluck('country_name');
        if(count($countries) > 0){
            $countries = $countries->toArray();
        }else{
            $countries = [];
        }
        return $countries;
    }

    function get_cities(){
        $cities = DB::table('cities')->where('city_status',1)->pluck('city_name');
        if(count($cities) > 0){
            $cities = $cities->toArray();
        }else{
            $cities = [];
        }
        return $cities;
    }

    function dial_codes(){
        // data from https://gist.github.com/andyj/7108917

        return $array = [
            '44' => 'UK (+44)',
            '1' => 'USA (+1)',
            '213' => 'Algeria (+213)',
            '376' => 'Andorra (+376)',
            '244' => 'Angola (+244)',
            '1264' => 'Anguilla (+1264)',
            '1268' => 'Antigua & Barbuda (+1268)',
            '54' => 'Argentina (+54)',
            '374' => 'Armenia (+374)',
            '297' => 'Aruba (+297)',
            '61' => 'Australia (+61)',
            '43' => 'Austria (+43)',
            '994' => 'Azerbaijan (+994)',
            '1242' => 'Bahamas (+1242)',
            '973' => 'Bahrain (+973)',
            '880' => 'Bangladesh (+880)',
            '1246' => 'Barbados (+1246)',
            '375' => 'Belarus (+375)',
            '32' => 'Belgium (+32)',
            '501' => 'Belize (+501)',
            '229' => 'Benin (+229)',
            '1441' => 'Bermuda (+1441)',
            '975' => 'Bhutan (+975)',
            '591' => 'Bolivia (+591)',
            '387' => 'Bosnia Herzegovina (+387)',
            '267' => 'Botswana (+267)',
            '55' => 'Brazil (+55)',
            '673' => 'Brunei (+673)',
            '359' => 'Bulgaria (+359)',
            '226' => 'Burkina Faso (+226)',
            '257' => 'Burundi (+257)',
            '855' => 'Cambodia (+855)',
            '237' => 'Cameroon (+237)',
            '1' => 'Canada (+1)',
            '238' => 'Cape Verde Islands (+238)',
            '1345' => 'Cayman Islands (+1345)',
            '236' => 'Central African Republic (+236)',
            '56' => 'Chile (+56)',
            '86' => 'China (+86)',
            '57' => 'Colombia (+57)',
            '269' => 'Comoros (+269)',
            '242' => 'Congo (+242)',
            '682' => 'Cook Islands (+682)',
            '506' => 'Costa Rica (+506)',
            '385' => 'Croatia (+385)',
            '53' => 'Cuba (+53)',
            '90392' => 'Cyprus North (+90392)',
            '357' => 'Cyprus South (+357)',
            '42' => 'Czech Republic (+42)',
            '45' => 'Denmark (+45)',
            '253' => 'Djibouti (+253)',
            '1809' => 'Dominica (+1809)',
            '1809' => 'Dominican Republic (+1809)',
            '593' => 'Ecuador (+593)',
            '20' => 'Egypt (+20)',
            '503' => 'El Salvador (+503)',
            '240' => 'Equatorial Guinea (+240)',
            '291' => 'Eritrea (+291)',
            '372' => 'Estonia (+372)',
            '251' => 'Ethiopia (+251)',
            '500' => 'Falkland Islands (+500)',
            '298' => 'Faroe Islands (+298)',
            '679' => 'Fiji (+679)',
            '358' => 'Finland (+358)',
            '33' => 'France (+33)',
            '594' => 'French Guiana (+594)',
            '689' => 'French Polynesia (+689)',
            '241' => 'Gabon (+241)',
            '220' => 'Gambia (+220)',
            '7880' => 'Georgia (+7880)',
            '49' => 'Germany (+49)',
            '233' => 'Ghana (+233)',
            '350' => 'Gibraltar (+350)',
            '30' => 'Greece (+30)',
            '299' => 'Greenland (+299)',
            '1473' => 'Grenada (+1473)',
            '590' => 'Guadeloupe (+590)',
            '671' => 'Guam (+671)',
            '502' => 'Guatemala (+502)',
            '224' => 'Guinea (+224)',
            '245' => 'Guinea - Bissau (+245)',
            '592' => 'Guyana (+592)',
            '509' => 'Haiti (+509)',
            '504' => 'Honduras (+504)',
            '852' => 'Hong Kong (+852)',
            '36' => 'Hungary (+36)',
            '354' => 'Iceland (+354)',
            '92' => 'Pakistan (+92)',
            '91' => 'India (+91)',
            '62' => 'Indonesia (+62)',
            '98' => 'Iran (+98)',
            '964' => 'Iraq (+964)',
            '353' => 'Ireland (+353)',
            '972' => 'Israel (+972)',
            '39' => 'Italy (+39)',
            '1876' => 'Jamaica (+1876)',
            '81' => 'Japan (+81)',
            '962' => 'Jordan (+962)',
            '7' => 'Kazakhstan (+7)',
            '254' => 'Kenya (+254)',
            '686' => 'Kiribati (+686)',
            '850' => 'Korea North (+850)',
            '82' => 'Korea South (+82)',
            '965' => 'Kuwait (+965)',
            '996' => 'Kyrgyzstan (+996)',
            '856' => 'Laos (+856)',
            '371' => 'Latvia (+371)',
            '961' => 'Lebanon (+961)',
            '266' => 'Lesotho (+266)',
            '231' => 'Liberia (+231)',
            '218' => 'Libya (+218)',
            '417' => 'Liechtenstein (+417)',
            '370' => 'Lithuania (+370)',
            '352' => 'Luxembourg (+352)',
            '853' => 'Macao (+853)',
            '389' => 'Macedonia (+389)',
            '261' => 'Madagascar (+261)',
            '265' => 'Malawi (+265)',
            '60' => 'Malaysia (+60)',
            '960' => 'Maldives (+960)',
            '223' => 'Mali (+223)',
            '356' => 'Malta (+356)',
            '692' => 'Marshall Islands (+692)',
            '596' => 'Martinique (+596)',
            '222' => 'Mauritania (+222)',
            '269' => 'Mayotte (+269)',
            '52' => 'Mexico (+52)',
            '691' => 'Micronesia (+691)',
            '373' => 'Moldova (+373)',
            '377' => 'Monaco (+377)',
            '976' => 'Mongolia (+976)',
            '1664' => 'Montserrat (+1664)',
            '212' => 'Morocco (+212)',
            '258' => 'Mozambique (+258)',
            '95' => 'Myanmar (+95)',
            '264' => 'Namibia (+264)',
            '674' => 'Nauru (+674)',
            '977' => 'Nepal (+977)',
            '31' => 'Netherlands (+31)',
            '687' => 'New Caledonia (+687)',
            '64' => 'New Zealand (+64)',
            '505' => 'Nicaragua (+505)',
            '227' => 'Niger (+227)',
            '234' => 'Nigeria (+234)',
            '683' => 'Niue (+683)',
            '672' => 'Norfolk Islands (+672)',
            '670' => 'Northern Marianas (+670)',
            '47' => 'Norway (+47)',
            '968' => 'Oman (+968)',
            '680' => 'Palau (+680)',
            '507' => 'Panama (+507)',
            '675' => 'Papua New Guinea (+675)',
            '595' => 'Paraguay (+595)',
            '51' => 'Peru (+51)',
            '63' => 'Philippines (+63)',
            '48' => 'Poland (+48)',
            '351' => 'Portugal (+351)',
            '1787' => 'Puerto Rico (+1787)',
            '974' => 'Qatar (+974)',
            '262' => 'Reunion (+262)',
            '40' => 'Romania (+40)',
            '7' => 'Russia (+7)',
            '250' => 'Rwanda (+250)',
            '378' => 'San Marino (+378)',
            '239' => 'Sao Tome & Principe (+239)',
            '966' => 'Saudi Arabia (+966)',
            '221' => 'Senegal (+221)',
            '381' => 'Serbia (+381)',
            '248' => 'Seychelles (+248)',
            '232' => 'Sierra Leone (+232)',
            '65' => 'Singapore (+65)',
            '421' => 'Slovak Republic (+421)',
            '386' => 'Slovenia (+386)',
            '677' => 'Solomon Islands (+677)',
            '252' => 'Somalia (+252)',
            '27' => 'South Africa (+27)',
            '34' => 'Spain (+34)',
            '94' => 'Sri Lanka (+94)',
            '290' => 'St. Helena (+290)',
            '1869' => 'St. Kitts (+1869)',
            '1758' => 'St. Lucia (+1758)',
            '249' => 'Sudan (+249)',
            '597' => 'Suriname (+597)',
            '268' => 'Swaziland (+268)',
            '46' => 'Sweden (+46)',
            '41' => 'Switzerland (+41)',
            '963' => 'Syria (+963)',
            '886' => 'Taiwan (+886)',
            '7' => 'Tajikstan (+7)',
            '66' => 'Thailand (+66)',
            '228' => 'Togo (+228)',
            '676' => 'Tonga (+676)',
            '1868' => 'Trinidad & Tobago (+1868)',
            '216' => 'Tunisia (+216)',
            '90' => 'Turkey (+90)',
            '7' => 'Turkmenistan (+7)',
            '993' => 'Turkmenistan (+993)',
            '1649' => 'Turks & Caicos Islands (+1649)',
            '688' => 'Tuvalu (+688)',
            '256' => 'Uganda (+256)',
            '380' => 'Ukraine (+380)',
            '971' => 'United Arab Emirates (+971)',
            '598' => 'Uruguay (+598)',
            '7' => 'Uzbekistan (+7)',
            '678' => 'Vanuatu (+678)',
            '379' => 'Vatican City (+379)',
            '58' => 'Venezuela (+58)',
            '84' => 'Vietnam (+84)',
            '84' => 'Virgin Islands - British (+1284)',
            '84' => 'Virgin Islands - US (+1340)',
            '681' => 'Wallis & Futuna (+681)',
            '969' => 'Yemen (North)(+969)',
            '967' => 'Yemen (South)(+967)',
            '260' => 'Zambia (+260)',
            '263' => 'Zimbabwe (+263)',
        ];
    }

    function get_driver_types(){
        $driver_types = DB::table('driver_types')->get();
        return $driver_types;
    }

    function deligate_attributes(){

       return [
            'truck' => [
                'name' => 'truck',
                'label' => 'Truck'
            ],
            'weight' => [
                 'input_type' => 'text',
                 'placeholder' => 'Weight   kg',
                 'label' => 'Weight   kg',
                 'name'       => 'weight',
                 'fields'     => '1',   
                ],

            'no_of_crtns' => [
                 'input_type' => 'text',
                 'placeholder' => 'No of Cartns',
                 'label' => 'No of Cartns',
                 'name'       => 'no_of_crts',
                 'fields'     => '1',   
                ],

            'crt_dimension' => [
                 'input_type' => 'text',
                 'placeholder' => 'Cartn Dimension',
                 'label' => 'Cartn Dimension',
                 'name'       => 'crt_dimension',
                 'fields'     => '1',   
                ],

            'no_of_pallets' => [
                 'input_type' => 'text',
                 'placeholder' => 'No of Pallets',
                 'label' => 'No of Pallets',
                 'name'       => 'no_of_pallets',
                 'fields'     => '1',   
                ],

            'item' => [
                 'input_type' => 'text',
                 'placeholder' => 'Item',
                 'label' => 'Item',
                 'name'       => 'item',
                 'fields'     => '1',   
                ],

            'weight_pallet' => [
                 'input_type' => 'text',
                 'placeholder' => 'Weight Pallet  kg',
                 'label' => 'Weight Pallet  kg',
                 'name'       => 'weight_pallet',
                 'fields'     => '1',   
                ],            

            'total_weight' => [
                 'input_type' => 'text',
                 'placeholder' => 'Total Weight   kg',
                 'label' => 'Total Weight   kg',
                 'name'       => 'total_weight',
                 'fields'     => '1',   
                ],

            'total_item_value' => [
                 'input_type' => 'text',
                 'placeholder' => 'Total Item Value',
                 'label' => 'Total Item Value',
                 'name'       => 'total_item_value',
                 'fields'     => '1',   
                ],                    

            'pallet_dimension' => [
                 'input_type' => 'text',
                 'placeholder' => 'Pallet Dimensions',
                 'label' => 'Pallet Dimensions',
                 'name'       => 'pallet_dimension',
                 'fields'     => '1',   
                ],

            'size' => [
                 'input_type' => 'text',
                 'placeholder' => '',
                 'label' => 'Size',
                 'name'       => 'size[]',
                 'fields'     => '3',   
                ],        

        ];
    }

    function deligate_attribute_values($attribute){

       $attributes = [
            'truck' => [
                'name' => 'truck',
                'label' => 'Truck'
            ],
            'weight' => [
                 'input_type' => 'text',
                 'placeholder' => 'Weight   kg',
                 'label' => 'Weight   kg',
                 'name'       => 'weight',
                 'fields'     => '1',   
                ],

            'no_of_crtns' => [
                 'input_type' => 'text',
                 'placeholder' => 'No of Cartns',
                 'label' => 'No of Cartns',
                 'name'       => 'no_of_crts',
                 'fields'     => '1',   
                ],

            'crt_dimension' => [
                 'input_type' => 'text',
                 'placeholder' => 'Cartn Dimension',
                 'label' => 'Cartn Dimension',
                 'name'       => 'crt_dimension',
                 'fields'     => '1',   
                ],

            'no_of_pallets' => [
                 'input_type' => 'text',
                 'placeholder' => 'No of Pallets',
                 'label' => 'No of Pallets',
                 'name'       => 'no_of_pallets',
                 'fields'     => '1',   
                ],

            'item' => [
                 'input_type' => 'text',
                 'placeholder' => 'Item',
                 'label' => 'Item',
                 'name'       => 'item',
                 'fields'     => '1',   
                ],

            'weight_pallet' => [
                 'input_type' => 'text',
                 'placeholder' => 'Weight Pallet  kg',
                 'label' => 'Weight Pallet  kg',
                 'name'       => 'weight_pallet',
                 'fields'     => '1',   
                ],            

            'total_weight' => [
                 'input_type' => 'text',
                 'placeholder' => 'Total Weight   kg',
                 'label' => 'Total Weight   kg',
                 'name'       => 'total_weight',
                 'fields'     => '1',   
                ],

            'total_item_value' => [
                 'input_type' => 'text',
                 'placeholder' => 'Total Item Value',
                 'label' => 'Total Item Value',
                 'name'       => 'total_item_value',
                 'fields'     => '1',   
                ],                    

            'pallet_dimension' => [
                 'input_type' => 'text',
                 'placeholder' => 'Pallet Dimensions',
                 'label' => 'Pallet Dimensions',
                 'name'       => 'pallet_dimension',
                 'fields'     => '1',   
                ],

            'size' => [
                 'input_type' => 'text',
                 'placeholder' => '',
                 'label' => 'Size',
                 'name'       => 'size[]',
                 'fields'     => '3',   
                ],        
        ];

        return $attributes[$attribute] ?? array();

    }

    function get_earned_amount($qouted_amount,$comission){
        $commission_amout = ($qouted_amount * $comission)/100;
        return $commission_amout; 
    }

    function get_commission_amount($qouted_amount,$comission){
        $commission_amout = ($qouted_amount * $comission)/100;
        return $commission_amout; 
    }

    function get_total_calculate($qouted_amount,$comission){
        $commission_amout = ($qouted_amount * $comission)/100;
        $total = $commission_amout + $qouted_amount;
        return $total; 
    }

    function get_total_amount($qouted_amount,$comission){
        $commission_amout = ($qouted_amount * $comission)/100;
        $total = $commission_amout + $qouted_amount;
        return $total;
       
    }    

    // function get_booking_status($admin_response,$booking_status){
    
    //     $status = '';
    //     $status_color = '';

    //     $data['booking_status'] = $booking_status;
    //     $data['admin_response'] = $admin_response;

    //     $statuses = ['accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered'];

    //     if($data['admin_response'] == 'approved_by_admin' && in_array($data['booking_status'],$statuses)){

    //         if($data['booking_status'] == 'accepted'){
    //             $status = 'Quote Accepted';
    //             $status_color = 'success';
    //         }
    //         else if($data['booking_status'] == 'journey_started'){
    //             $status = 'Journey Started';
    //             $status_color = 'info';
    //         }
    //         else if($data['booking_status'] == 'item_collected'){
    //             $status = 'Item Collected';
    //             $status_color = 'info';
    //         }
    //         else if($data['booking_status'] == 'on_the_way'){
    //             $status = 'On The Way';
    //             $status_color = 'info';
    //         }
    //         else if($data['booking_status'] == 'border_crossing'){
    //             $status = 'Border Crossing';
    //             $status_color = 'info';
    //         }
    //         else if($data['booking_status'] == 'custom_clearance'){
    //             $status = 'Custom Clearance';
    //             $status_color = 'info';
    //         }
    //         else if($data['booking_status'] == 'delivered'){
    //             $status = 'Delivered';
    //             $status_color = 'primary';
    //         }
    //     }
    //     else{
    //         if($data['admin_response'] == 'pending'){
    //             $status = 'Pending';
    //             $status_color = 'secondary';
    //         }
    //         else if($data['admin_response'] == 'ask_for_qoute'){
    //             $status = 'Drivers Assigned';
    //             $status_color = 'success';
    //         }
    //         else if($data['admin_response'] == 'driver_qouted'){
    //             $status = 'Qoutes Received';
    //             $status_color = 'info';
    //         }
    //         else if($data['admin_response'] == 'approved_by_admin'){
    //             $status = 'Admin Approved Quotes';
    //             $status_color = 'primary';
    //         }
    //     }    
    //     $html = '';   

    //     $html .=  '<span class="badge badge-'.$status_color.'">
    //                         '. $status.'</span>';
    //     return $html;
    // }
    
    function get_booking_truck_status($booking_status){
    
            $status = '';
            $status_color = '';
    
            $data['booking_status'] = $booking_status;
            
            $statuses = ['accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered'];
    
            if(in_array($data['booking_status'],$statuses)){
    
                if($data['booking_status'] == 'accepted'){
                    $status = 'Proceeding';
                    $status_color = 'primary';
                }
                else if($data['booking_status'] == 'journey_started'){
                    $status = 'Journey Started';
                    $status_color = 'info';
                }
                else if($data['booking_status'] == 'item_collected'){
                    $status = 'Item Collected';
                    $status_color = 'info';
                }
                else if($data['booking_status'] == 'on_the_way'){
                    $status = 'On The Way';
                    $status_color = 'info';
                }
                else if($data['booking_status'] == 'border_crossing'){
                    $status = 'Border Crossing';
                    $status_color = 'info';
                }
                else if($data['booking_status'] == 'custom_clearance'){
                    $status = 'Custom Clearance';
                    $status_color = 'info';
                }
                else if($data['booking_status'] == 'delivered'){
                    $status = 'Completed';
                    $status_color = 'success';
                }
            }

            $html = '';   
    
            $html .=  '<span class="badge badge-'.$status_color.'">
                                '. $status.'</span>';
            return $html;
    }    
    
    function get_booking_truck_status_for_app($booking_status){
    
        $status = '';

        $data['booking_status'] = $booking_status;
        
        $statuses = ['accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered','collected_from_shipper','cargo_cleared_at_origin_border','cargo_tracking','cargo_reached_destination_border','cargo_cleared_destination_customs','delivery_completed','items_received_in_warehouse','items_stored'];

        if(in_array($data['booking_status'],$statuses)){

            if($data['booking_status'] == 'accepted'){
                $status = 'Proceeding';
            }
            else if($data['booking_status'] == 'journey_started'){
                $status = 'Journey Started';
            }
            else if($data['booking_status'] == 'item_collected'){
                $status = 'Item Collected';
            }
            else if($data['booking_status'] == 'on_the_way'){
                $status = 'On The Way';
            }
            else if($data['booking_status'] == 'border_crossing'){
                $status = 'Border Crossing';
            }
            else if($data['booking_status'] == 'custom_clearance'){
                $status = 'Custom Clearance';
            }
            else if($data['booking_status'] == 'delivered'){
                $status = 'Delivered';
            }
             else if($data['booking_status'] == 'collected_from_shipper'){
                $status = 'Collected From Shipper';
            }
            else if($data['booking_status'] == 'cargo_cleared_at_origin_border'){
                $status = 'Cargo Cleared at Origin Border';
            }
            else if($data['booking_status'] == 'cargo_tracking'){
                $status = 'Cargo Tracking';
            }
            else if($data['booking_status'] == 'cargo_reached_destination_border'){
                $status = 'Cargo Reached Destination Border';
            }
            else if($data['booking_status'] == 'cargo_cleared_destination_customs'){
                $status = 'Cargo Cleared Destination Customs';
            }
            else if($data['booking_status'] == 'delivery_completed'){
                $status = 'Delivery Completed';
            }
            else if($data['booking_status'] == 'items_received_in_warehouse'){
                $status = 'Items Received In Warehouse';
            }
             else if($data['booking_status'] == 'items_stored'){
                $status = 'Items Stored';
            }
        }

        return $status;
    }

    function get_driver_tracking_status($booking_status){
    
        $status = '';

        $data['booking_status'] = $booking_status;
        
        $statuses = ['request_created','accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered','collected_from_shipper','cargo_cleared_at_origin_border','cargo_tracking','cargo_reached_destination_border','cargo_cleared_destination_customs','delivery_completed','items_received_in_warehouse','items_stored'];

        if(in_array($data['booking_status'],$statuses)){

            if($data['booking_status'] == 'request_created'){
                $status = 'Request Submitted';
            }
            else if($data['booking_status'] == 'accepted'){
                $status = 'Quote Accepted';
            }
            else if($data['booking_status'] == 'journey_started'){
                $status = 'Journey Started';
            }
            else if($data['booking_status'] == 'item_collected'){
                $status = 'Item Collected';
            }
            else if($data['booking_status'] == 'on_the_way'){
                $status = 'On The Way';
            }
            else if($data['booking_status'] == 'border_crossing'){
                $status = 'Border Crossing';
            }
            else if($data['booking_status'] == 'custom_clearance'){
                $status = 'Custom Clearance';
            }
            else if($data['booking_status'] == 'delivered'){
                $status = 'Completed';
            }
             else if($data['booking_status'] == 'collected_from_shipper'){
                $status = 'Collected From Shipper';
            }
            else if($data['booking_status'] == 'cargo_cleared_at_origin_border'){
                $status = 'Cargo Cleared at Origin Border';
            }
            else if($data['booking_status'] == 'cargo_tracking'){
                $status = 'Cargo Tracking';
            }
            else if($data['booking_status'] == 'cargo_reached_destination_border'){
                $status = 'Cargo Reached Destination Border';
            }
            else if($data['booking_status'] == 'cargo_cleared_destination_customs'){
                $status = 'Cargo Cleared Destination Customs';
            }
            else if($data['booking_status'] == 'delivery_completed'){
                $status = 'Delivery Completed';
            }
            else if($data['booking_status'] == 'items_received_in_warehouse'){
                $status = 'Items Received In Warehouse';
            }
             else if($data['booking_status'] == 'items_stored'){
                $status = 'Items Stored';
            }
        }

        return $status;
    }


    function get_booking_status($admin_response,$booking_status){
    
        $status = '';
        $status_color = '';

        $data['booking_status'] = $booking_status;
        $data['admin_response'] = $admin_response;

        $statuses = ['on_process','cancelled','completed','collected_from_shipper','cargo_cleared_at_origin_border','cargo_tracking','cargo_reached_destination_border','cargo_cleared_destination_customs','delivery_completed','items_received_in_warehouse','items_stored'];
        if($data['booking_status'] == 'completed'){
            $status = 'Completed';
            $status_color = 'success';
        } else if($data['booking_status'] == 'cancelled'){
            $status = 'Cancelled';
            $status_color = 'danger';
        }   else 
        if($data['admin_response'] == 'approved_by_admin' && in_array($data['booking_status'],$statuses)){

            if($data['booking_status'] == 'on_process'){
                $status = 'On Process';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'completed'){
                $status = 'Completed';
                $status_color = 'success';
            }
            else if($data['booking_status'] == 'cancelled'){
                $status = 'Cancelled';
                $status_color = 'danger';
            }

            else if($data['booking_status'] == 'collected_from_shipper'){
                $status = 'Collected From Shipper';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'cargo_cleared_at_origin_border'){
                $status = 'Cargo Cleared at Origin Border';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'cargo_tracking'){
                $status = 'Cargo Tracking';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'cargo_reached_destination_border'){
                $status = 'Cargo Reached Destination Border';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'cargo_cleared_destination_customs'){
                $status = 'Cargo Cleared Destination Customs';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'delivery_completed'){
                $status = 'Delivery Completed';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'items_received_in_warehouse'){
                $status = 'Items Received In Warehouse';
                $status_color = 'info';
            }
             else if($data['booking_status'] == 'items_stored'){
                $status = 'Items Stored';
                $status_color = 'info';
            }

            
        }
        else{
            if($data['admin_response'] == 'pending'){
                $status = 'Pending';
                $status_color = 'secondary';
            }
            else if($data['admin_response'] == 'ask_for_qoute'){
                $status = 'Drivers Assigned';
                $status_color = 'success';
            }
            else if($data['admin_response'] == 'driver_qouted'){
                $status = 'Quotes Received';
                $status_color = 'info';
            }
            else if($data['admin_response'] == 'approved_by_admin'){
                $status = 'Admin Approved Quotes';
                $status_color = 'primary';
            }
        }    
        $html = '';   

        $html .=  '<span class="badge badge-'.$status_color.'">
                            '. $status.'</span>';
        return $html;
    }

    function driver_company($company_id){
        $company = DB::table('users')->where('id',$company_id)->first();
        return $company;
    }

    function get_truck_drivers($truck_id,$booking_id = null){

        $exist_drivers = [];
        if($booking_id){
            $exist_drivers = BookingQoute::where('booking_id',$booking_id)->pluck('driver_id')->toArray();
        }
         
       $drivers = User::join('driver_details','driver_details.user_id','=','users.id')->where('role_id',2)->where('truck_type_id',$truck_id)->where('users.status','active')->whereNotIn('users.id',$exist_drivers)->get();
       return $drivers;
    }

    function make_booking_total($id){
        $booking = Booking::find($id);
        $total_commission_amount = $booking->total_commission_amount;
        $commission_amount = (($booking->total_commission_amount/100) * $booking->total_qoutation_amount);
        $sub_total = ($commission_amount + $booking->total_qoutation_amount);
        $booking->sub_total = $sub_total;
        $booking->grand_total = $sub_total;
        $booking->save();
        
    }


    //Booking Status name
    function booking_status_name($booking_status){
        
        $status = 'pending';
        if($booking_status == 'pending'){
            $status = 'Pending';
        }
        else if($booking_status == 'qoutes_received'){
            $status = 'Quotes Received';
        }
        else if($booking_status == 'on_process'){
            $status = 'On Process';
        }
        else if($booking_status == 'completed'){
            $status = 'Completed';
        }
        else if($booking_status == 'cancelled'){
            $status = 'Cancelled';
        }


        else if($booking_status == 'collected_from_shipper'){
            $status = 'Collected From Shipper';
        }
        else if($booking_status == 'cargo_cleared_at_origin_border'){
            $status = 'Cargo Cleared at Origin Border';
        }
        else if($booking_status == 'cargo_tracking'){
            $status = 'Cargo Tracking';
        }
        else if($booking_status == 'cargo_reached_destination_border'){
            $status = 'Cargo Reached Destination Border';
        }
        else if($booking_status == 'cargo_cleared_destination_customs'){
            $status = 'Cargo Cleared Destination Customs';
        }
        else if($booking_status == 'delivery_completed'){
            $status = 'Delivery Completed';
        }
        else if($booking_status == 'items_received_in_warehouse'){
            $status = 'Items Received In Warehouse';
        }
        else if($booking_status == 'items_stored'){
            $status = 'Items Stored';
        }

        return $status;
    }

    //Customer side show
    function qoute_status_name($qoute_status){
        
        $status = 'pending';
        if($qoute_status == 'pending'){
            $status = 'Pending';
        }
        else if($qoute_status == 'qouted'){
            $status = 'Accept';
        }
        else if($qoute_status == 'accepted'){
            $status = 'Accepted';
        }
        else if($qoute_status == 'rejected'){
            $status = 'Rejected';
        }

        return $status;
    }
    
    
    if (!function_exists('api_date_in_timezone')) {
        function api_date_in_timezone($date, $format, $timezone, $server_time_zone = "Asia/Dubai")
        {
            if (empty($format)) $format = "d M Y h:i A";
            $timezone_server    = new DateTimeZone($server_time_zone);
            $timezone_user      = new DateTimeZone($timezone);
            $dt = new DateTime($date, $timezone_server);
            $dt->setTimezone($timezone_user);
            return $dt->format($format);
        }
    }

    function price_with_commission($item){
        $commission_amount = (($item->comission_amount/100) * $item->price);
        $price = ($item->price + $commission_amount);
        return $price;
    }

    function do_booking_totals($id){
        $booking = Booking::find($id);
        $accepted_qoutes = AcceptedQoute::where('booking_id',$id)->get();
        $total_commission_amount = 0;
        $total_qouted_amount = 0; 
        foreach($accepted_qoutes as $accepted_qoute){
            $total_commission_amount += (($accepted_qoute->commission_amount/100) * $accepted_qoute->qouted_amount);
            $total_qouted_amount += $accepted_qoute->qouted_amount;
        }
        $booking->total_commission_amount = $total_commission_amount;
        $booking->total_qoutation_amount = $total_qouted_amount;
    
        $booking->sub_total = ($total_qouted_amount + $total_commission_amount);    
        $booking->grand_total = ($total_qouted_amount + $total_commission_amount);
        $booking->save();
    }

    //These Statuses are driver to show
    function driver_quote_status_name($qoute_status){
        
        $status = '';
        if($qoute_status == 'pending'){
            $status = 'Make a Quote';
        }
        else if($qoute_status == 'qouted'){
            $status = 'Pending';
        }
        else if($qoute_status == 'accepted'){
            $status = 'Accepted';
        }
        else if($qoute_status == 'rejected'){
            $status = 'Rejected';
        }
        else if($qoute_status == 'journey_started'){
            $status = 'Journey Started';
        }
        else if($qoute_status == 'item_collected'){
            $status = 'Item Collected';
        }
        else if($qoute_status == 'on_the_way'){
            $status = 'On The Way';
        }
        else if($qoute_status == 'border_crossing'){
            $status = 'Border Crossing';
        }
        else if($qoute_status == 'custom_clearance'){
            $status = 'Custom Clearance';
        }
        else if($qoute_status == 'delivered'){
            $status = 'Delivered';
        }
        return $status;

    }

    function next_status($status){
        
        $statuses = ['pending','qouted','accepted','journey_started','item_collected','on_the_way','border_crossing','custom_clearance','delivered'];

        $current_index = array_search($status,$statuses);
        $next_status = '';
        if(isset($statuses[$current_index + 1])){
            $next_status = $statuses[$current_index + 1];
        }else{
            $next_status = '';
        }

        return $next_status;
    }


    //notification 
    function headers() {
  return array(
      "Authorization: key=".env('FIREBASE_AUTH_KEY'),
      "Content-Type: application/json",
      "project_id:".env('FIREBASE_PROJECT_ID')

  );
}
 function send_single_notification($fcm_token, $notification, $data, $priority = 'high') {
    $fields = array(
        'notification' => $notification,
        'data'=>$data,
        'content_available' => true,
        'priority' =>  $priority,
        'to' => $fcm_token
    );

    if ( $curl_response =  send(json_encode($fields), "https://fcm.googleapis.com/fcm/send") ) {
        return json_decode($curl_response);
    }
    else
        return false;
}

 function send_multicast_notification($fcm_tokens, $notification, $data, $priority = 'high') {
    $fields = array(
        'notification' => $notification,
        'data'=>$data,
        'content_available' => true,
        'priority' =>  $priority,
        'registration_ids' => $fcm_tokens
    );

    if ( $curl_response=send(json_encode($fields), "https://fcm.googleapis.com/fcm/send") ) {
        return json_decode($curl_response);
    }
    else
        return false;
}

 function send_notification($notification_key, $notification, $data, $priority = 'high') {
    $fields = array(
        'notification' => $notification,
        'data'=>$data,
        'content_available' => true,
        'priority' =>  $priority ,
        'to' => $notification_key
    );

    if ( $curl_response=send(json_encode($fields), "https://fcm.googleapis.com/fcm/send") ) {
        return json_decode($curl_response);
   }
   else
        return false;

}

 function send($fields,  $url ="", $headers = array() ) {

    if(empty($url)) $url = FIREBASE_URL;

    $headers = array_merge(headers(), $headers);

    $ch = curl_init();

    if (!$ch)  {
        $curl_error = "Couldn't initialize a cURL handle";
        return false;
    }

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $curl_response = curl_exec($ch);

    if(curl_errno($ch))
        $curl_error = curl_error($ch);

    if ($curl_response == FALSE) {
        return false;
    }
    else {
        $curl_info = curl_getinfo($ch);
        //printr($curl_info);
        curl_close($ch);
        return $curl_response;
    }

}

function getChildBooking($parent)
{   
    if($parent) {
        $i = 1;
        $checkExist = \App\Models\Booking::where('booking_number',$parent->booking_number.'-'.$i)->count(); 
        $new_number = $parent->booking_number.'-'.$i;
        while($checkExist != 0 ) {
            $i++;
            $checkExist = \App\Models\Booking::where('booking_number',$parent->booking_number.'-'.$i)->count(); 
            $new_number = $parent->booking_number.'-'.$i;
        }
        return $new_number ;
    }
}

function clearCart($sender_id)
{
    $bookingCart = \App\Models\BookingCart::where('sender_id',$sender_id)->get();
    foreach($bookingCart as $ech) {
         \App\Models\BookingTruckCart::where('booking_cart_id',$ech->id)->delete();

    }
    \App\Models\BookingCart::where('sender_id',$sender_id)->delete();
    return true;
}

function driverExpiry($driver_id)
{
    $driverDetails = \App\Models\DriverDetail::where('user_id',$driver_id)->first();
    $is_expire = 0;
    if(strtotime(date('Y-m-d',strtotime($driverDetails->driving_license_expiry))) < strtotime(date('Y-m-d'))) {
        $is_expire = 1;
    }
    return $is_expire;
}

?>
