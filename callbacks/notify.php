<?
global $clickatell_settings;

$field = 'sms_phone_number';
if(isset($clickatell_settings['field_names'][$to->klass])) $field = $clickatell_settings['field_names'][$to->klass];
if($to->$field && $template->is_enabled_for($to, 'clickatell') && (!isset($template->data['types']) || in_array('clickatell', $template->data['types'])))
{   
    
    global $run_mode, $debug_sms;
    $t = get_clickatell_template_for($template);
    
    $options[CURLOPT_URL] = "http://api.clickatell.com/http/sendmsg";
    $options[CURLOPT_RETURNTRANSFER] = true;
    $var = '';
    
    $var .= "api_id={$clickatell_settings['api_id']}";
    $var .= "&user={$clickatell_settings['user']}";
    $var .= "&password={$clickatell_settings['password']}";
    $phone_number = $to->$field;
    if ($run_mode == RUN_MODE_DEVELOPMENT && isset($clickatell_settings['debug_sms']))
    {
      $phone_number = $clickatell_settings['debug_sms'];
    }
    $numeric = ereg_replace("[^0-9]", "", $phone_number);
    if (strlen($numeric) <= 10)
    {
        $phone_number = "1".$numeric;
    }
    
    $var .= "&to=".urlencode($phone_number);
    $var .= "&text=".urlencode($template->apply_vars($t->body_text));
    //$var .= "&from=";
    
    $options[CURLOPT_POSTFIELDS] = $var;
    $options[CURLOPT_POST] = true;
    
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    if(preg_match("/ERR/", $response)) click_error("SMS gateway error", array('response'=>$response));
}
