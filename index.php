<?php
/*
 *Plugin Name: IframeCatcher
 *Description: IframeCatcher ban the spam feedreader sites.
 *Version:1.0
 *Author: Alireza Pagheh
*/
add_action('init', 'checkurls_arsha');
add_action('init', 'checkips_arsha');
add_action('admin_menu', 'get_banned_ips_arsha');
function get_banned_ips_arsha(){
    $checkemptylist = get_option('banned_ips_arsha');
    if(empty($checkemptylist)){
        $default_banned = get_banned_list_ips();
        $banned_list_urls = get_banned_list_urls();
        update_option('banned_urls_arsha','$banned_list_urls');
        update_option('banned_ips_arsha', $default_banned);
    }
    if(checkupdatebannedlist()){
        $default_banned = get_banned_list_ips();
        $banned_urls_arsha = 
        update_option('banned_ips_arsha', $default_banned);
    }
}
function checkupdatebannedlist(){
    $checkupdatelist = grab_arsha('kamalak2000.tk/anti/checkupdatelist.html');
    if($checkupdatelist==1){
        return TRUE;
    }else{
        return FALSE;
    }
}
function get_banned_list_ips() {
    $url = "http://kamalak2000.tk/anti/bannedlistips.html";
    $banned_list_ips = json_decode(grab_arsha($url));
    return $banned_list_ips;
}
function get_banned_list_urls(){
    $url = "http://kamalak2000.tk/anti/bannedlisturls.html";
    $banned_list_urls = json_decode(grab_arsha($url));
    return $banned_list_urls;
}
function checkurls_arsha(){
    $banned_list_urls = get_option('banned_urls_arsha');
    $itemcheck = $_SERVER['HTTP_REFERER'];
    foreach ($banned_list_urls as $banned_list_url) {
        if(strpos($itemcheck, $banned_list_url)){
            die(get_option('ban_message_arsha'));
        }
    }
}
function checkips_arsha(){
    $banned_ips_arsha = get_option('banned_ips_arsha');
    $itemcheck = $_SERVER['REMOTE_ADDR'];
    if(in_array($itemcheck, $banned_ips_arsha)){
        die(get_option('ban_message_arsha'));
    }
}
function grab_arsha($url) {
    $grab = curl_init();
    curl_setopt($grab, CURLOPT_URL, $url);
    curl_setopt($grab, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 (FM Scene 4.6.1)');
    curl_setopt($grab, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($grab, CURLOPT_CONNECTTIMEOUT, 15);
    return $grabbed = curl_exec($grab);
    curl_close($grab);
}
?>