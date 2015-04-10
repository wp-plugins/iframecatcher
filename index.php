<?php
/*
 *Plugin Name: iframecatcher
 *Description: iframecatcher ban the spam feedreader sites.
 *Version:2.0
 *Author: Alireza Pagheh
 *Author URI: http://forum.persiantools.com/members/alireza567.241530/
*/
add_action('init', 'checkurls_arsha');
add_action('init', 'checkips_arsha');
add_action('admin_notices', 'set_message_alpha');
function set_message_alpha()
{
	echo '<div class="updated"><p>نسخه جدید افزونه با امکانات بیشتر و آپدیت لیست بسیار راحت منتشر شد.شما میتوانید با مراجعه به <a href="http://parka.ir/buy/">این لینک</a> نسخه جدید را جهت حمایت از ما خریداری کنید.</p></div>';
}

function get_banned_list_ips() {
    $data = '["199.167.138.25","148.251.90.175","178.63.56.19","5.9.222.250","107.152.102.187","46.4.88.42","213.239.220.2","31.22.4.39","64.79.89.110","148.251.78.84","144.76.176.72","199.19.95.11","173.254.28.46","85.10.205.179","148.251.90.175","94.232.169.152","144.76.176.72","91.239.55.196","144.76.168.187","176.9.143.153","144.76.107.176","199.167.138.179","199.167.138.179","5.196.178.195","148.251.0.124","192.99.109.84","46.4.116.14","148.251.78.84","144.76.218.137","108.61.49.229","173.45.240.141","5.144.128.190","148.251.90.175","148.251.90.175","176.9.134.202","5.61.27.215","212.16.76.92","176.9.17.167","94.232.169.10","199.167.138.179","188.40.131.78","46.4.88.42","144.76.176.72","5.196.178.193","209.44.111.206","178.63.56.19","199.26.84.27","199.167.138.179","176.9.157.120","46.4.88.42","78.46.45.151","148.251.78.84","46.4.115.133","46.4.88.42","144.76.168.187","213.239.220.2","108.61.49.229","92.222.97.85","46.4.88.42","199.167.138.179","144.76.176.72","148.251.7.169","46.4.41.195","199.79.63.27","148.251.57.189","91.222.198.18","176.9.66.138","5.196.178.195","144.76.218.137","109.73.75.242","199.167.138.75"]';
    $banned_list_ips = json_decode($data);
    return $banned_list_ips;
}
function get_banned_list_urls(){
    $data = '["jarchi.ir","tazen.ir","parsjo.ir","tejaratgah.com","jostweb.ir","dailylink.ir","khabarjoo24.ir","niniyoo.com","khabardoni.com","abharcity.ir","ofog.ir","press-online.ir","afsos.ir","khabardehi.com","shishlink.com","englishbox.ir","titrane.ir","ibarad.com","toptext.ir","mypc.ir","farnews.ir","googooli.ir","seosabz.in","mashine.ir","he3333.com","mobailha.ir","wikito.ir","lilipad.ir","linkjoor.ir","kaat.in","pop3da.ir","porsyar.com","web.zamzar.ir","freebaner.ir","behjoo.com","shahrekhabar.com","parszine.ir","marisa.ir","host3nter.com","topabzar.ir","tnews.ir","khabarco.com","narniya.ir","behinjoo.ir","m93.ir","goftavard.ir","giftbuy.ir ","hodhodsis.ir","elahee.ir","joostjoo.ir","mashrom.ir","instm.ir","etesalematlab.ir","cult8.org","omranfa.ir","denjcloob.ir","funbazi.ir","fastnews.ir","oglestar.com","hozedrama.ir","evr-ag.de","bjl5005.com","dizain.ir","hyves.tv","new.ganj-music.ir","jurvajur.ir","smsxnet.ir","parsilog.com","cybercap.tv","agile2013.in","bwinnerharbor.com","kholase.com","nixshoes.net","mtcm.ir","gooni.ir","lipop.ir","ccmeifu.com","rsslinker.com","bia2news.com","runevesht.ir","edu-portal.ir","iranianmag.ir","mehrsell.ir","rssyab.ir","khatblog.ir","persianwet.ir","pransit.ir","wikifa.org","ibarad.com"]';
    $banned_list_urls = json_decode($data);
    return $banned_list_urls;
}
function checkurls_arsha(){
    $banned_list_urls = get_option('banned_urls_arsha');
    if (empty($banned_list_urls)) {
        $banned_list_urls = get_banned_list_urls();
        update_option('banned_urls_arsha',$banned_list_urls);
    }
    $itemcheck = $_SERVER['HTTP_REFERER'];
    foreach ($banned_list_urls as $banned_list_url) {
        if(strpos($itemcheck, $banned_list_url)){
            die('You are banned!');
        }
    }
}
function checkips_arsha(){
    $banned_ips_arsha = get_option('banned_ips_arsha');
    if (empty($banned_ips_arsha)) {
        $banned_ips_arsha = get_banned_list_ips();
        update_option('banned_ips_arsha', $banned_ips_arsha);
    }
    $itemcheck = $_SERVER['REMOTE_ADDR'];
    if(in_array($itemcheck, $banned_ips_arsha)){
        die('You are banned!');
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