<?php 
use Jenssegers\Agent\Agent;

function getDevice($device = null)
{
    if(isset($device)) {
        return $device;
    }
    //agent check tablet mobile desktop
    $agent = new Agent();
    if($agent->isMobile() || $agent->isTablet()) {
        return MOBILE;
    } else {
        return PC;
    }
}
function trimRequest($request)
{
    $input = $request->all();
    // use a closure here because array_walk_recursive passes
    // two params to the callback, the item + the key. If you were to just
    // call trim directly, you could end up inadvertently trimming things off
    // your array values, and pulling your hair out to figure out why.
    array_walk_recursive($input, function(&$in) {
        $in = trim($in);
    });
    $request->merge($input);
}
// show 0 for null
function getZero($number = null)
{
	if($number != '') {
		return $number;
	}
	return 0;
}
//cut trim text
function limit_text($text, $len) {
    if (strlen($text) < $len) {
        return $text;
    }
    $text_words = explode(' ', $text);
    $out = null;
    foreach ($text_words as $word) {
        if ((strlen($word) > $len) && $out == null) {

            return substr($word, 0, $len) . "...";
        }
        if ((strlen($out) + strlen($word)) > $len) {
            return $out . "...";
        }
        $out.=" " . $word;
    }
    return $out;
}
//check current menu
function checkCurrent($url, $home=null)
{
    $currentUrl = Request::url();
    if($home != null) {
        if ($currentUrl == $url) {
            return 'class=current';
        }
    } else {
        $segment1 = Request::segment(1);
        if ($currentUrl == $url && $segment1 != null) {
            return 'class=current';
        }
    }
    return;
}
