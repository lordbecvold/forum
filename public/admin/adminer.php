<?php // check if user logged in
    
    session_start(); // start session
    
    ini_set('display_errors','Off'); // disable error report
    
    // include config
    require_once("../../config.php");
        
    // init config
    $configOBJ = new becwork\config\PageConfig();
    
    // get config value
    $session = $configOBJ->config["loginCookie"];
    $session_value = $configOBJ->config["loginValue"];
    
    // check if user logged in
    if (!isset($_SESSION[$session]) || !($_SESSION[$session] == $session_value)) {
        die("'<script type='text/javascript'>window.location.replace('/ErrorHandlerer.php?code=403');</script>'");
    } else {

        // check if role seted
        if (isset($_SESSION["role"])) {
            
            // check if user not admin
            if (($_SESSION["role"] != "Owner") && ($_SESSION["role"] != "Admin")) {
                die("'<script type='text/javascript'>window.location.replace('/ErrorHandlerer.php?code=403');</script>'");
            }

        } else {
            die("'<script type='text/javascript'>window.location.replace('/ErrorHandlerer.php?code=403');</script>'");
        }
    }
?>

<?php
/** Adminer - Compact database management
 * @link https://www.adminer.org/
 * @author Jakub Vrana, https://www.vrana.cz/
 * @copyright 2007 Jakub Vrana
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 * @version 4.8.1
 */
function adminer_errors($cc, $ec)
{
    return !!preg_match('~^(Trying to access array offset on value of type null|Undefined array key)~', $ec);
}
error_reporting(6135);
set_error_handler('adminer_errors', E_WARNING);
$wc = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($wc || ini_get("filter.default_flags")) {
    foreach (array(
        '_GET',
        '_POST',
        '_COOKIE',
        '_SERVER'
    ) as $X) {
        $ch = filter_input_array(constant("INPUT$X"), FILTER_UNSAFE_RAW);
        if ($ch)
            $$X = $ch;
    }
}
if (function_exists("mb_internal_encoding"))
    mb_internal_encoding("8bit");
function connection()
{
    global $e;
    return $e;
}
function adminer()
{
    global $b;
    return $b;
}
function version()
{
    global $ga;
    return $ga;
}
function idf_unescape($Wc)
{
    if (!preg_match('~^[`\'"]~', $Wc))
        return $Wc;
    $td = substr($Wc, -1);
    return str_replace($td . $td, $td, substr($Wc, 1, -1));
}
function escape_string($X)
{
    return substr(q($X), 1, -1);
}
function number($X)
{
    return preg_replace('~[^0-9]+~', '', $X);
}
function number_type()
{
    return '((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}
function remove_slashes($hf, $wc = false)
{
    if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) {
        while (list($z, $X) = each($hf)) {
            foreach ($X as $md => $W) {
                unset($hf[$z][$md]);
                if (is_array($W)) {
                    $hf[$z][stripslashes($md)] = $W;
                    $hf[] =& $hf[$z][stripslashes($md)];
                } else
                    $hf[$z][stripslashes($md)] = ($wc ? $W : stripslashes($W));
            }
        }
    }
}
function bracket_escape($Wc, $_a = false)
{
    static $Pg = array(':' => ':1', ']' => ':2', '[' => ':3', '"' => ':4');
    return strtr($Wc, ($_a ? array_flip($Pg) : $Pg));
}
function min_version($rh, $Fd = "", $f = null)
{
    global $e;
    if (!$f)
        $f = $e;
    $Pf = $f->server_info;
    if ($Fd && preg_match('~([\d.]+)-MariaDB~', $Pf, $C)) {
        $Pf = $C[1];
        $rh = $Fd;
    }
    return (version_compare($Pf, $rh) >= 0);
}
function charset($e)
{
    return (min_version("5.5.3", 0, $e) ? "utf8mb4" : "utf8");
}
function script($Yf, $Og = "\n")
{
    return "<script" . nonce() . ">$Yf</script>$Og";
}
function script_src($hh)
{
    return "<script src='" . h($hh) . "'" . nonce() . "></script>\n";
}
function nonce()
{
    return ' nonce="' . get_nonce() . '"';
}
function target_blank()
{
    return ' target="_blank" rel="noreferrer noopener"';
}
function h($ig)
{
    return str_replace("\0", "&#0;", htmlspecialchars($ig, ENT_QUOTES, 'utf-8'));
}
function nl_br($ig)
{
    return str_replace("\n", "<br>", $ig);
}
function checkbox($E, $Y, $Na, $qd = "", $qe = "", $Ra = "", $rd = "")
{
    $K = "<input type='checkbox' name='$E' value='" . h($Y) . "'" . ($Na ? " checked" : "") . ($rd ? " aria-labelledby='$rd'" : "") . ">" . ($qe ? script("qsl('input').onclick = function () { $qe };", "") : "");
    return ($qd != "" || $Ra ? "<label" . ($Ra ? " class='$Ra'" : "") . ">$K" . h($qd) . "</label>" : $K);
}
function optionlist($ue, $Kf = null, $lh = false)
{
    $K = "";
    foreach ($ue as $md => $W) {
        $ve = array(
            $md => $W
        );
        if (is_array($W)) {
            $K .= '<optgroup label="' . h($md) . '">';
            $ve = $W;
        }
        foreach ($ve as $z => $X)
            $K .= '<option' . ($lh || is_string($z) ? ' value="' . h($z) . '"' : '') . (($lh || is_string($z) ? (string) $z : $X) === $Kf ? ' selected' : '') . '>' . h($X);
        if (is_array($W))
            $K .= '</optgroup>';
    }
    return $K;
}
function html_select($E, $ue, $Y = "", $pe = true, $rd = "")
{
    if ($pe)
        return "<select name='" . h($E) . "'" . ($rd ? " aria-labelledby='$rd'" : "") . ">" . optionlist($ue, $Y) . "</select>" . (is_string($pe) ? script("qsl('select').onchange = function () { $pe };", "") : "");
    $K = "";
    foreach ($ue as $z => $X)
        $K .= "<label><input type='radio' name='" . h($E) . "' value='" . h($z) . "'" . ($z == $Y ? " checked" : "") . ">" . h($X) . "</label>";
    return $K;
}
function select_input($wa, $ue, $Y = "", $pe = "", $Ue = "")
{
    $xg = ($ue ? "select" : "input");
    return "<$xg$wa" . ($ue ? "><option value=''>$Ue" . optionlist($ue, $Y, true) . "</select>" : " size='10' value='" . h($Y) . "' placeholder='$Ue'>") . ($pe ? script("qsl('$xg').onchange = $pe;", "") : "");
}
function confirm($D = "", $Lf = "qsl('input')")
{
    return script("$Lf.onclick = function () { return confirm('" . ($D ? js_escape($D) : 'Are you sure?') . "'); };", "");
}
function print_fieldset($u, $yd, $uh = false)
{
    echo "<fieldset><legend>", "<a href='#fieldset-$u'>$yd</a>", script("qsl('a').onclick = partial(toggle, 'fieldset-$u');", ""), "</legend>", "<div id='fieldset-$u'" . ($uh ? "" : " class='hidden'") . ">\n";
}
function bold($Ga, $Ra = "")
{
    return ($Ga ? " class='active $Ra'" : ($Ra ? " class='$Ra'" : ""));
}
function odd($K = ' class="odd"')
{
    static $t = 0;
    if (!$K)
        $t = -1;
    return ($t++ % 2 ? $K : '');
}
function js_escape($ig)
{
    return addcslashes($ig, "\r\n'\\/");
}
function json_row($z, $X = null)
{
    static $xc = true;
    if ($xc)
        echo "{";
    if ($z != "") {
        echo ($xc ? "" : ",") . "\n\t\"" . addcslashes($z, "\r\n\t\"\\/") . '": ' . ($X !== null ? '"' . addcslashes($X, "\r\n\"\\/") . '"' : 'null');
        $xc = false;
    } else {
        echo "\n}\n";
        $xc = true;
    }
}
function ini_bool($bd)
{
    $X = ini_get($bd);
    return (preg_match('~^(on|true|yes)$~i', $X) || (int) $X);
}
function sid()
{
    static $K;
    if ($K === null)
        $K = (SID && !($_COOKIE && ini_bool("session.use_cookies")));
    return $K;
}
function set_password($qh, $O, $V, $G)
{
    $_SESSION["pwds"][$qh][$O][$V] = ($_COOKIE["adminer_key"] && is_string($G) ? array(
        encrypt_string($G, $_COOKIE["adminer_key"])
    ) : $G);
}
function get_password()
{
    $K = get_session("pwds");
    if (is_array($K))
        $K = ($_COOKIE["adminer_key"] ? decrypt_string($K[0], $_COOKIE["adminer_key"]) : false);
    return $K;
}
function q($ig)
{
    global $e;
    return $e->quote($ig);
}
function get_vals($I, $c = 0)
{
    global $e;
    $K = array();
    $J = $e->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_row())
            $K[] = $L[$c];
    }
    return $K;
}
function get_key_vals($I, $f = null, $Sf = true)
{
    global $e;
    if (!is_object($f))
        $f = $e;
    $K = array();
    $J = $f->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_row()) {
            if ($Sf)
                $K[$L[0]] = $L[1];
            else
                $K[] = $L[0];
        }
    }
    return $K;
}
function get_rows($I, $f = null, $k = "<p class='error'>")
{
    global $e;
    $fb = (is_object($f) ? $f : $e);
    $K  = array();
    $J  = $fb->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_assoc())
            $K[] = $L;
    } elseif (!$J && !is_object($f) && $k && defined("PAGE_HEADER"))
        echo $k . error() . "\n";
    return $K;
}
function unique_array($L, $w)
{
    foreach ($w as $v) {
        if (preg_match("~PRIMARY|UNIQUE~", $v["type"])) {
            $K = array();
            foreach ($v["columns"] as $z) {
                if (!isset($L[$z]))
                    continue 2;
                $K[$z] = $L[$z];
            }
            return $K;
        }
    }
}
function escape_key($z)
{
    if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $z, $C))
        return $C[1] . idf_escape(idf_unescape($C[2])) . $C[3];
    return idf_escape($z);
}
function where($Z, $m = array())
{
    global $e, $y;
    $K = array();
    foreach ((array) $Z["where"] as $z => $X) {
        $z   = bracket_escape($z, 1);
        $c   = escape_key($z);
        $K[] = $c . ($y == "sql" && is_numeric($X) && preg_match('~\.~', $X) ? " LIKE " . q($X) : ($y == "mssql" ? " LIKE " . q(preg_replace('~[_%[]~', '[\0]', $X)) : " = " . unconvert_field($m[$z], q($X))));
        if ($y == "sql" && preg_match('~char|text~', $m[$z]["type"]) && preg_match("~[^ -@]~", $X))
            $K[] = "$c = " . q($X) . " COLLATE " . charset($e) . "_bin";
    }
    foreach ((array) $Z["null"] as $z)
        $K[] = escape_key($z) . " IS NULL";
    return implode(" AND ", $K);
}
function where_check($X, $m = array())
{
    parse_str($X, $Ma);
    remove_slashes(array(
        &$Ma
    ));
    return where($Ma, $m);
}
function where_link($t, $c, $Y, $re = "=")
{
    return "&where%5B$t%5D%5Bcol%5D=" . urlencode($c) . "&where%5B$t%5D%5Bop%5D=" . urlencode(($Y !== null ? $re : "IS NULL")) . "&where%5B$t%5D%5Bval%5D=" . urlencode($Y);
}
function convert_fields($d, $m, $N = array())
{
    $K = "";
    foreach ($d as $z => $X) {
        if ($N && !in_array(idf_escape($z), $N))
            continue;
        $ua = convert_field($m[$z]);
        if ($ua)
            $K .= ", $ua AS " . idf_escape($z);
    }
    return $K;
}
function cookie($E, $Y, $Ad = 2592000)
{
    global $ba;
    return header("Set-Cookie: $E=" . urlencode($Y) . ($Ad ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $Ad) . " GMT" : "") . "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) . ($ba ? "; secure" : "") . "; HttpOnly; SameSite=lax", false);
}
function restart_session()
{
    if (!ini_bool("session.use_cookies"))
        session_start();
}
function stop_session($zc = false)
{
    $kh = ini_bool("session.use_cookies");
    if (!$kh || $zc) {
        session_write_close();
        if ($kh && @ini_set("session.use_cookies", false) === false)
            session_start();
    }
}
function &get_session($z)
{
    return $_SESSION[$z][DRIVER][SERVER][$_GET["username"]];
}
function set_session($z, $X)
{
    $_SESSION[$z][DRIVER][SERVER][$_GET["username"]] = $X;
}
function auth_url($qh, $O, $V, $i = null)
{
    global $Kb;
    preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($Kb)) . "|username|" . ($i !== null ? "db|" : "") . session_name()), $C);
    return "$C[1]?" . (sid() ? SID . "&" : "") . ($qh != "server" || $O != "" ? urlencode($qh) . "=" . urlencode($O) . "&" : "") . "username=" . urlencode($V) . ($i != "" ? "&db=" . urlencode($i) : "") . ($C[2] ? "&$C[2]" : "");
}
function is_ajax()
{
    return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}
function redirect($B, $D = null)
{
    if ($D !== null) {
        restart_session();
        $_SESSION["messages"][preg_replace('~^[^?]*~', '', ($B !== null ? $B : $_SERVER["REQUEST_URI"]))][] = $D;
    }
    if ($B !== null) {
        if ($B == "")
            $B = ".";
        header("Location: $B");
        exit;
    }
}
function query_redirect($I, $B, $D, $pf = true, $jc = true, $qc = false, $Dg = "")
{
    global $e, $k, $b;
    if ($jc) {
        $eg = microtime(true);
        $qc = !$e->query($I);
        $Dg = format_time($eg);
    }
    $ag = "";
    if ($I)
        $ag = $b->messageQuery($I, $Dg, $qc);
    if ($qc) {
        $k = error() . $ag . script("messagesPrint();");
        return false;
    }
    if ($pf)
        redirect($B, $D . $ag);
    return true;
}
function queries($I)
{
    global $e;
    static $kf = array();
    static $eg;
    if (!$eg)
        $eg = microtime(true);
    if ($I === null)
        return array(
            implode("\n", $kf),
            format_time($eg)
        );
    $kf[] = (preg_match('~;$~', $I) ? "DELIMITER ;;\n$I;\nDELIMITER " : $I) . ";";
    return $e->query($I);
}
function apply_queries($I, $S, $fc = 'table')
{
    foreach ($S as $Q) {
        if (!queries("$I " . $fc($Q)))
            return false;
    }
    return true;
}
function queries_redirect($B, $D, $pf)
{
    list($kf, $Dg) = queries(null);
    return query_redirect($kf, $B, $D, $pf, false, !$pf, $Dg);
}
function format_time($eg)
{
    return sprintf('%.3f s', max(0, microtime(true) - $eg));
}
function relative_uri()
{
    return str_replace(":", "%3a", preg_replace('~^[^?]*/([^?]*)~', '\1', $_SERVER["REQUEST_URI"]));
}
function remove_from_uri($Ie = "")
{
    return substr(preg_replace("~(?<=[?&])($Ie" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', relative_uri() . "&"), 0, -1);
}
function pagination($F, $qb)
{
    return " " . ($F == $qb ? $F + 1 : '<a href="' . h(remove_from_uri("page") . ($F ? "&page=$F" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($F + 1) . "</a>");
}
function get_file($z, $yb = false)
{
    $uc = $_FILES[$z];
    if (!$uc)
        return null;
    foreach ($uc as $z => $X)
        $uc[$z] = (array) $X;
    $K = '';
    foreach ($uc["error"] as $z => $k) {
        if ($k)
            return $k;
        $E  = $uc["name"][$z];
        $Lg = $uc["tmp_name"][$z];
        $gb = file_get_contents($yb && preg_match('~\.gz$~', $E) ? "compress.zlib://$Lg" : $Lg);
        if ($yb) {
            $eg = substr($gb, 0, 3);
            if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $eg, $vf))
                $gb = iconv("utf-16", "utf-8", $gb);
            elseif ($eg == "\xEF\xBB\xBF")
                $gb = substr($gb, 3);
            $K .= $gb . "\n\n";
        } else
            $K .= $gb;
    }
    return $K;
}
function upload_error($k)
{
    $Ld = ($k == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0);
    return ($k ? 'Unable to upload a file.' . ($Ld ? " " . sprintf('Maximum allowed file size is %sB.', $Ld) : "") : 'File does not exist.');
}
function repeat_pattern($Re, $zd)
{
    return str_repeat("$Re{0,65535}", $zd / 65535) . "$Re{0," . ($zd % 65535) . "}";
}
function is_utf8($X)
{
    return (preg_match('~~u', $X) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X));
}
function shorten_utf8($ig, $zd = 80, $mg = "")
{
    if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $zd) . ")($)?)u", $ig, $C))
        preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $zd) . ")($)?)", $ig, $C);
    return h($C[1]) . $mg . (isset($C[2]) ? "" : "<i>â€¦</i>");
}
function format_number($X)
{
    return strtr(number_format($X, 0, ".", ','), preg_split('~~u', '0123456789', -1, PREG_SPLIT_NO_EMPTY));
}
function friendly_url($X)
{
    return preg_replace('~[^a-z0-9_]~i', '-', $X);
}
function hidden_fields($hf, $Xc = array(), $af = '')
{
    $K = false;
    foreach ($hf as $z => $X) {
        if (!in_array($z, $Xc)) {
            if (is_array($X))
                hidden_fields($X, array(), $z);
            else {
                $K = true;
                echo '<input type="hidden" name="' . h($af ? $af . "[$z]" : $z) . '" value="' . h($X) . '">';
            }
        }
    }
    return $K;
}
function hidden_fields_get()
{
    echo (sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : ''), (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : ""), '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}
function table_status1($Q, $rc = false)
{
    $K = table_status($Q, $rc);
    return ($K ? $K : array(
        "Name" => $Q
    ));
}
function column_foreign_keys($Q)
{
    global $b;
    $K = array();
    foreach ($b->foreignKeys($Q) as $n) {
        foreach ($n["source"] as $X)
            $K[$X][] = $n;
    }
    return $K;
}
function enum_input($U, $wa, $l, $Y, $Yb = null)
{
    global $b;
    preg_match_all("~'((?:[^']|'')*)'~", $l["length"], $Gd);
    $K = ($Yb !== null ? "<label><input type='$U'$wa value='$Yb'" . ((is_array($Y) ? in_array($Yb, $Y) : $Y === 0) ? " checked" : "") . "><i>" . 'empty' . "</i></label>" : "");
    foreach ($Gd[1] as $t => $X) {
        $X  = stripcslashes(str_replace("''", "'", $X));
        $Na = (is_int($Y) ? $Y == $t + 1 : (is_array($Y) ? in_array($t + 1, $Y) : $Y === $X));
        $K .= " <label><input type='$U'$wa value='" . ($t + 1) . "'" . ($Na ? ' checked' : '') . '>' . h($b->editVal($X, $l)) . '</label>';
    }
    return $K;
}
function input($l, $Y, $q)
{
    global $Xg, $b, $y;
    $E = h(bracket_escape($l["field"]));
    echo "<td class='function'>";
    if (is_array($Y) && !$q) {
        $ta = array(
            $Y
        );
        if (version_compare(PHP_VERSION, 5.4) >= 0)
            $ta[] = JSON_PRETTY_PRINT;
        $Y = call_user_func_array('json_encode', $ta);
        $q = "json";
    }
    $xf = ($y == "mssql" && $l["auto_increment"]);
    if ($xf && !$_POST["save"])
        $q = null;
    $Fc = (isset($_GET["select"]) || $xf ? array(
        "orig" => 'original'
    ) : array()) + $b->editFunctions($l);
    $wa = " name='fields[$E]'";
    if ($l["type"] == "enum")
        echo h($Fc[""]) . "<td>" . $b->editInput($_GET["edit"], $l, $wa, $Y);
    else {
        $Nc = (in_array($q, $Fc) || isset($Fc[$q]));
        echo (count($Fc) > 1 ? "<select name='function[$E]'>" . optionlist($Fc, $q === null || $Nc ? $q : "") . "</select>" . on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1) . script("qsl('select').onchange = functionChange;", "") : h(reset($Fc))) . '<td>';
        $dd = $b->editInput($_GET["edit"], $l, $wa, $Y);
        if ($dd != "")
            echo $dd;
        elseif (preg_match('~bool~', $l["type"]))
            echo "<input type='hidden'$wa value='0'>" . "<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $Y) ? " checked='checked'" : "") . "$wa value='1'>";
        elseif ($l["type"] == "set") {
            preg_match_all("~'((?:[^']|'')*)'~", $l["length"], $Gd);
            foreach ($Gd[1] as $t => $X) {
                $X  = stripcslashes(str_replace("''", "'", $X));
                $Na = (is_int($Y) ? ($Y >> $t) & 1 : in_array($X, explode(",", $Y), true));
                echo " <label><input type='checkbox' name='fields[$E][$t]' value='" . (1 << $t) . "'" . ($Na ? ' checked' : '') . ">" . h($b->editVal($X, $l)) . '</label>';
            }
        } elseif (preg_match('~blob|bytea|raw|file~', $l["type"]) && ini_bool("file_uploads"))
            echo "<input type='file' name='fields-$E'>";
        elseif (($Bg = preg_match('~text|lob|memo~i', $l["type"])) || preg_match("~\n~", $Y)) {
            if ($Bg && $y != "sqlite")
                $wa .= " cols='50' rows='12'";
            else {
                $M = min(12, substr_count($Y, "\n") + 1);
                $wa .= " cols='30' rows='$M'" . ($M == 1 ? " style='height: 1.2em;'" : "");
            }
            echo "<textarea$wa>" . h($Y) . '</textarea>';
        } elseif ($q == "json" || preg_match('~^jsonb?$~', $l["type"]))
            echo "<textarea$wa cols='50' rows='12' class='jush-js'>" . h($Y) . '</textarea>';
        else {
            $Nd = (!preg_match('~int~', $l["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $l["length"], $C) ? ((preg_match("~binary~", $l["type"]) ? 2 : 1) * $C[1] + ($C[3] ? 1 : 0) + ($C[2] && !$l["unsigned"] ? 1 : 0)) : ($Xg[$l["type"]] ? $Xg[$l["type"]] + ($l["unsigned"] ? 0 : 1) : 0));
            if ($y == 'sql' && min_version(5.6) && preg_match('~time~', $l["type"]))
                $Nd += 7;
            echo "<input" . ((!$Nc || $q === "") && preg_match('~(?<!o)int(?!er)~', $l["type"]) && !preg_match('~\[\]~', $l["full_type"]) ? " type='number'" : "") . " value='" . h($Y) . "'" . ($Nd ? " data-maxlength='$Nd'" : "") . (preg_match('~char|binary~', $l["type"]) && $Nd > 20 ? " size='40'" : "") . "$wa>";
        }
        echo $b->editHint($_GET["edit"], $l, $Y);
        $xc = 0;
        foreach ($Fc as $z => $X) {
            if ($z === "" || !$X)
                break;
            $xc++;
        }
        if ($xc)
            echo script("mixin(qsl('td'), {onchange: partial(skipOriginal, $xc), oninput: function () { this.onchange(); }});");
    }
}
function process_input($l)
{
    global $b, $j;
    $Wc = bracket_escape($l["field"]);
    $q  = $_POST["function"][$Wc];
    $Y  = $_POST["fields"][$Wc];
    if ($l["type"] == "enum") {
        if ($Y == -1)
            return false;
        if ($Y == "")
            return "NULL";
        return +$Y;
    }
    if ($l["auto_increment"] && $Y == "")
        return null;
    if ($q == "orig")
        return (preg_match('~^CURRENT_TIMESTAMP~i', $l["on_update"]) ? idf_escape($l["field"]) : false);
    if ($q == "NULL")
        return "NULL";
    if ($l["type"] == "set")
        return array_sum((array) $Y);
    if ($q == "json") {
        $q = "";
        $Y = json_decode($Y, true);
        if (!is_array($Y))
            return false;
        return $Y;
    }
    if (preg_match('~blob|bytea|raw|file~', $l["type"]) && ini_bool("file_uploads")) {
        $uc = get_file("fields-$Wc");
        if (!is_string($uc))
            return false;
        return $j->quoteBinary($uc);
    }
    return $b->processInput($l, $Y, $q);
}
function fields_from_edit()
{
    global $j;
    $K = array();
    foreach ((array) $_POST["field_keys"] as $z => $X) {
        if ($X != "") {
            $X                     = bracket_escape($X);
            $_POST["function"][$X] = $_POST["field_funs"][$z];
            $_POST["fields"][$X]   = $_POST["field_vals"][$z];
        }
    }
    foreach ((array) $_POST["fields"] as $z => $X) {
        $E     = bracket_escape($z, 1);
        $K[$E] = array(
            "field" => $E,
            "privileges" => array(
                "insert" => 1,
                "update" => 1
            ),
            "null" => 1,
            "auto_increment" => ($z == $j->primary)
        );
    }
    return $K;
}
function search_tables()
{
    global $b, $e;
    $_GET["where"][0]["val"] = $_POST["query"];
    $Nf                      = "<ul>\n";
    foreach (table_status('', true) as $Q => $R) {
        $E = $b->tableName($R);
        if (isset($R["Engine"]) && $E != "" && (!$_POST["tables"] || in_array($Q, $_POST["tables"]))) {
            $J = $e->query("SELECT" . limit("1 FROM " . table($Q), " WHERE " . implode(" AND ", $b->selectSearchProcess(fields($Q), array())), 1));
            if (!$J || $J->fetch_row()) {
                $df = "<a href='" . h(ME . "select=" . urlencode($Q) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$E</a>";
                echo "$Nf<li>" . ($J ? $df : "<p class='error'>$df: " . error()) . "\n";
                $Nf = "";
            }
        }
    }
    echo ($Nf ? "<p class='message'>" . 'No tables.' : "</ul>") . "\n";
}
function dump_headers($Vc, $Ud = false)
{
    global $b;
    $K  = $b->dumpHeaders($Vc, $Ud);
    $Fe = $_POST["output"];
    if ($Fe != "text")
        header("Content-Disposition: attachment; filename=" . $b->dumpFilename($Vc) . ".$K" . ($Fe != "file" && preg_match('~^[0-9a-z]+$~', $Fe) ? ".$Fe" : ""));
    session_write_close();
    ob_flush();
    flush();
    return $K;
}
function dump_csv($L)
{
    foreach ($L as $z => $X) {
        if (preg_match('~["\n,;\t]|^0|\.\d*0$~', $X) || $X === "")
            $L[$z] = '"' . str_replace('"', '""', $X) . '"';
    }
    echo implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $L) . "\r\n";
}
function apply_sql_function($q, $c)
{
    return ($q ? ($q == "unixepoch" ? "DATETIME($c, '$q')" : ($q == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$q(")) . "$c)") : $c);
}
function get_temp_dir()
{
    $K = ini_get("upload_tmp_dir");
    if (!$K) {
        if (function_exists('sys_get_temp_dir'))
            $K = sys_get_temp_dir();
        else {
            $vc = @tempnam("", "");
            if (!$vc)
                return false;
            $K = dirname($vc);
            unlink($vc);
        }
    }
    return $K;
}
function file_open_lock($vc)
{
    $p = @fopen($vc, "r+");
    if (!$p) {
        $p = @fopen($vc, "w");
        if (!$p)
            return;
        chmod($vc, 0660);
    }
    flock($p, LOCK_EX);
    return $p;
}
function file_write_unlock($p, $sb)
{
    rewind($p);
    fwrite($p, $sb);
    ftruncate($p, strlen($sb));
    flock($p, LOCK_UN);
    fclose($p);
}
function password_file($g)
{
    $vc = get_temp_dir() . "/adminer.key";
    $K  = @file_get_contents($vc);
    if ($K || !$g)
        return $K;
    $p = @fopen($vc, "w");
    if ($p) {
        chmod($vc, 0660);
        $K = rand_string();
        fwrite($p, $K);
        fclose($p);
    }
    return $K;
}
function rand_string()
{
    return md5(uniqid(mt_rand(), true));
}
function select_value($X, $A, $l, $Cg)
{
    global $b;
    if (is_array($X)) {
        $K = "";
        foreach ($X as $md => $W)
            $K .= "<tr>" . ($X != array_values($X) ? "<th>" . h($md) : "") . "<td>" . select_value($W, $A, $l, $Cg);
        return "<table cellspacing='0'>$K</table>";
    }
    if (!$A)
        $A = $b->selectLink($X, $l);
    if ($A === null) {
        if (is_mail($X))
            $A = "mailto:$X";
        if (is_url($X))
            $A = $X;
    }
    $K = $b->editVal($X, $l);
    if ($K !== null) {
        if (!is_utf8($K))
            $K = "\0";
        elseif ($Cg != "" && is_shortable($l))
            $K = shorten_utf8($K, max(0, +$Cg));
        else
            $K = h($K);
    }
    return $b->selectVal($K, $A, $l, $X);
}
function is_mail($Vb)
{
    $va = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $Jb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    $Re = "$va+(\\.$va+)*@($Jb?\\.)+$Jb";
    return is_string($Vb) && preg_match("(^$Re(,\\s*$Re)*\$)i", $Vb);
}
function is_url($ig)
{
    $Jb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    return preg_match("~^(https?)://($Jb?\\.)+$Jb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $ig);
}
function is_shortable($l)
{
    return preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $l["type"]);
}
function count_rows($Q, $Z, $jd, $s)
{
    global $y;
    $I = " FROM " . table($Q) . ($Z ? " WHERE " . implode(" AND ", $Z) : "");
    return ($jd && ($y == "sql" || count($s) == 1) ? "SELECT COUNT(DISTINCT " . implode(", ", $s) . ")$I" : "SELECT COUNT(*)" . ($jd ? " FROM (SELECT 1$I GROUP BY " . implode(", ", $s) . ") x" : $I));
}
function slow_query($I)
{
    global $b, $T, $j;
    $i  = $b->database();
    $Eg = $b->queryTimeout();
    $Wf = $j->slowQuery($I, $Eg);
    if (!$Wf && support("kill") && is_object($f = connect()) && ($i == "" || $f->select_db($i))) {
        $od = $f->result(connection_id());
        echo '<script', nonce(), '>
var timeout = setTimeout(function () {
	ajax(\'', js_escape(ME), 'script=kill\', function () {
	}, \'kill=', $od, '&token=', $T, '\');
}, ', 1000 * $Eg, ');
</script>
';
    } else
        $f = null;
    ob_flush();
    flush();
    $K = @get_key_vals(($Wf ? $Wf : $I), $f, false);
    if ($f) {
        echo script("clearTimeout(timeout);");
        ob_flush();
        flush();
    }
    return $K;
}
function get_token()
{
    $nf = rand(1, 1e6);
    return ($nf ^ $_SESSION["token"]) . ":$nf";
}
function verify_token()
{
    list($T, $nf) = explode(":", $_POST["token"]);
    return ($nf ^ $_SESSION["token"]) == $T;
}
function lzw_decompress($Da)
{
    $Gb = 256;
    $Ea = 8;
    $Ta = array();
    $yf = 0;
    $zf = 0;
    for ($t = 0; $t < strlen($Da); $t++) {
        $yf = ($yf << 8) + ord($Da[$t]);
        $zf += 8;
        if ($zf >= $Ea) {
            $zf -= $Ea;
            $Ta[] = $yf >> $zf;
            $yf &= (1 << $zf) - 1;
            $Gb++;
            if ($Gb >> $Ea)
                $Ea++;
        }
    }
    $Fb = range("\0", "\xFF");
    $K  = "";
    foreach ($Ta as $t => $Sa) {
        $Ub = $Fb[$Sa];
        if (!isset($Ub))
            $Ub = $_h . $_h[0];
        $K .= $Ub;
        if ($t)
            $Fb[] = $_h . $Ub[0];
        $_h = $Ub;
    }
    return $K;
}
function on_help($Za, $Uf = 0)
{
    return script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $Za, $Uf) }, onmouseout: helpMouseout});", "");
}
function edit_form($Q, $m, $L, $fh)
{
    global $b, $y, $T, $k;
    $rg = $b->tableName(table_status1($Q, true));
    page_header(($fh ? 'Edit' : 'Insert'), $k, array(
        "select" => array(
            $Q,
            $rg
        )
    ), $rg);
    $b->editRowPrint($Q, $m, $L, $fh);
    if ($L === false)
        echo "<p class='error'>" . 'No rows.' . "\n";
    echo '<form action="" method="post" enctype="multipart/form-data" id="form">
';
    if (!$m)
        echo "<p class='error'>" . 'You have no privileges to update this table.' . "\n";
    else {
        echo "<table cellspacing='0' class='layout'>" . script("qsl('table').onkeydown = editingKeydown;");
        foreach ($m as $E => $l) {
            echo "<tr><th>" . $b->fieldName($l);
            $zb = $_GET["set"][bracket_escape($E)];
            if ($zb === null) {
                $zb = $l["default"];
                if ($l["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $zb, $vf))
                    $zb = $vf[1];
            }
            $Y = ($L !== null ? ($L[$E] != "" && $y == "sql" && preg_match("~enum|set~", $l["type"]) ? (is_array($L[$E]) ? array_sum($L[$E]) : +$L[$E]) : (is_bool($L[$E]) ? +$L[$E] : $L[$E])) : (!$fh && $l["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $zb)));
            if (!$_POST["save"] && is_string($Y))
                $Y = $b->editVal($Y, $l);
            $q = ($_POST["save"] ? (string) $_POST["function"][$E] : ($fh && preg_match('~^CURRENT_TIMESTAMP~i', $l["on_update"]) ? "now" : ($Y === false ? null : ($Y !== null ? '' : 'NULL'))));
            if (!$_POST && !$fh && $Y == $l["default"] && preg_match('~^[\w.]+\(~', $Y))
                $q = "SQL";
            if (preg_match("~time~", $l["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
                $Y = "";
                $q = "now";
            }
            input($l, $Y, $q);
            echo "\n";
        }
        if (!support("table"))
            echo "<tr>" . "<th><input name='field_keys[]'>" . script("qsl('input').oninput = fieldChange;") . "<td class='function'>" . html_select("field_funs[]", $b->editFunctions(array(
                "null" => isset($_GET["select"])
            ))) . "<td><input name='field_vals[]'>" . "\n";
        echo "</table>\n";
    }
    echo "<p>\n";
    if ($m) {
        echo "<input type='submit' value='" . 'Save' . "'>\n";
        if (!isset($_GET["select"])) {
            echo "<input type='submit' name='insert' value='" . ($fh ? 'Save and continue edit' : 'Save and insert next') . "' title='Ctrl+Shift+Enter'>\n", ($fh ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . 'Saving' . "â€¦', this); };") : "");
        }
    }
    echo ($fh ? "<input type='submit' name='delete' value='" . 'Delete' . "'>" . confirm() . "\n" : ($_POST || !$m ? "" : script("focus(qsa('td', qs('#form'))[1].firstChild);")));
    if (isset($_GET["select"]))
        hidden_fields(array(
            "check" => (array) $_POST["check"],
            "clone" => $_POST["clone"],
            "all" => $_POST["all"]
        ));
    echo '<input type="hidden" name="referer" value="', h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]), '">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="', $T, '">
</form>
';
}
if (isset($_GET["file"])) {
    if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365 * 24 * 60 * 60) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: immutable");
    if ($_GET["file"] == "favicon.ico") {
        header("Content-Type: image/x-icon");
        echo lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃþÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ýÀ/(%Œ\0");
    } elseif ($_GET["file"] == "default.css") {
        header("Content-Type: text/css; charset=utf-8");
        echo lzw_decompress("\n1Ì‡“ÙŒÞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Þn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1ÌŽs˜´ç-4™‡fÓ	ÈÎi7†³¹¤Èt4…¦ÓyèZf4°i–AT«VVéf:Ï¦,:1¦QÝ¼ñb2`Ç#þ>:7Gï—1ÑØÒs°™L—XD*bv<ÜŒ#£e@Ö:4ç§!fo·Æt:<¥Üå’¾™oâÜ\niÃÅð',é»a_¤:¹iï…´ÁBvø|Nû4.5Nfi¢vpÐh¸°l¨ê¡ÖšÜO¦‰î= £OFQÐÄk\$¥Óiõ™ÀÂd2Tã¡pàÊ6„‹þ‡¡-ØZ€Žƒ Þ6½£€ðh:¬aÌ,Ž£ëî2#8Ð±#’˜6nâî†ñJˆ¢h«t…Œ±Šä4O42ô½okÞ¾*r ©€@p@†!Ä¾ÏÃôþ?Ð6À‰r[ðLÁð‹:2Bˆj§!HbóÃPä=!1V‰\"ˆ²0…¿\nSÆÆÏD7ÃìDÚ›ÃC!†!›à¦GÊŒ§ È+’=tCæ©.C¤À:+ÈÊ=ªªº²¡±å%ªcí1MR/”EÈ’4„© 2°ä± ã`Â8(áÓ¹[WäÑ=‰ySb°=Ö-Ü¹BS+É¯ÈÜý¥ø@pL4Ydã„qŠøã¦ðê¢6£3Ä¬¯¸AcÜŒèÎ¨Œk‚[&>ö•¨ZÁpkm]—u-c:Ø¸ˆNtæÎ´pÒŒŠ8è=¿#˜á[.ðÜÞ¯~ mËy‡PPá|IÖ›ùÀìQª9v[–Q•„\n–Ùrô'g‡+áTÑ2…­VÁõzä4£8÷(	¾Ey*#j¬2]­•RÒÁ‘¥)ƒÀ[N­R\$Š<>:ó­>\$;–> Ì\r»„ÎHÍÃTÈ\nw¡N åwØ£¦ì<ïËGwàöö¹\\Yó_ Rt^Œ>Ž\r}ŒÙS\rzé4=µ\nL”%Jã‹\",Z 8¸ž™i÷0u©?¨ûÑô¡s3#¨Ù‰ :ó¦ûã½–ÈÞE]xÝÒs^8Ž£K^É÷*0ÑÞwÞàÈÞ~ãö:íÑiØþv2w½ÿ±û^7ãò7£cÝÑu+U%Ž{PÜ*4Ì¼éLX./!¼‰1CÅßqx!H¹ãFdù­L¨¤¨Ä Ï`6ëè5®™f€¸Ä†¨=Høl ŒV1“›\0a2×;Ô6†àöþ_Ù‡Ä\0&ôZÜS d)KE'’€nµ[X©³\0ZÉŠÔF[P‘Þ˜@àß!‰ñYÂ,`É\"Ú·Â0Ee9yF>ËÔ9bº–ŒæF5:üˆ”\0}Ä´Š‡(\$žÓ‡ë€37Hö£è M¾A°²6R•ú{MqÝ7G ÚC™Cêm2¢(ŒCt>[ì-tÀ/&C›]êetGôÌ¬4@r>ÇÂå<šSq•/åú”QëhmšÀÐÆôãôLÀÜ#èôKË|®™„6fKPÝ\r%tÔÓV=\" SH\$} ¸)w¡,W\0F³ªu@Øb¦9‚\rr°2Ã#¬DŒ”Xƒ³ÚyOIù>»…n†Ç¢%ãù'‹Ý_Á€t\rÏ„zÄ\\1˜hl¼]Q5Mp6k†ÐÄqhÃ\$£H~Í|ÒÝ!*4ŒñòÛ`Sëý²S tíPP\\g±è7‡\n-Š:è¢ªp´•”ˆl‹Bž¦î”7Ó¨cƒ(wO0\\:•Ðw”Áp4ˆ“ò{TÚújO¤6HÃŠ¶rÕ¥q\n¦É%%¶y']\$‚”a‘ZÓ.fcÕq*-êFWºúk„zƒ°µj‘Ž°lgáŒ:‡\$\"ÞN¼\r#ÉdâÃ‚ÂÿÐscá¬Ì „ƒ\"jª\rÀ¶–¦ˆÕ’¼Ph‹1/‚œDA) ²Ý[ÀknÁp76ÁY´‰R{áM¤Pû°ò@\n-¸a·6þß[»zJH,–dl B£ho³ìò¬+‡#Dr^µ^µÙeš¼E½½– ÄœaP‰ôõJG£zàñtñ 2ÇXÙ¢´Á¿V¶×ßàÞÈ³‰ÑB_%K=E©¸bå¼¾ßÂ§kU(.!Ü®8¸œüÉI.@ŽKÍxnþ¬ü:ÃPó32«”míH		C*ì:vâTÅ\nR¹ƒ•µ‹0uÂíƒæîÒ§]Î¯˜Š”P/µJQd¥{L–Þ³:YÁ2b¼œT ñÊ3Ó4†—äcê¥V=¿†L4ÎÐrÄ!ßBðY³6Í­MeLŠªÜçœöùiÀoÐ9< G”¤Æ•Ð™Mhm^¯UÛNÀŒ·òTr5HiM”/¬nƒí³T [-<__î3/Xr(<‡¯Š†®Éô“ÌuÒ–GNX20å\r\$^‡:'9è¶O…í;×k¼†µf –N'a¶”Ç­bÅ,ËV¤ô…«1µïHI!%6@úÏ\$ÒEGÚœ¬1(mUªå…rÕ½ïßå`¡ÐiN+Ãœñ)šœä0lØÒf0Ã½[UâøVÊè-:I^ ˜\$Øs«b\re‡‘ugÉhª~9Ûßˆb˜µôÂÈfä+0¬Ô hXrÝ¬©!\$—e,±w+„÷ŒëŒ3†Ì_âA…kšù\nkÃrõÊ›cuWdYÿ\\×={.óÄ˜¢g»‰p8œt\rRZ¿vJ:²>þ£Y|+Å@À‡ƒÛCt\r€jt½6²ð%Â?àôÇŽñ’>ù/¥ÍÇðÎ9F`×•äòv~K¤áöÑRÐW‹ðz‘êlmªwLÇ9Y•*q¬xÄzñèSe®Ý›³è÷£~šDàÍá–÷x˜¾ëÉŸi7•2ÄøÑOÝ»’û_{ñú53âút˜›_ŸõzÔ3ùd)‹C¯Â\$?KÓªP%ÏÏT&þ˜&\0P×NAŽ^­~¢ƒ pÆ öÏœ“Ôõ\r\$ÞïÐÖìb*+D6ê¶¦ÏˆÞíJ\$(ÈolÞÍh&”ìKBS>¸‹ö;z¶¦xÅoz>íœÚoÄZð\nÊ‹[Ïvõ‚ËÈœµ°2õOxÙVø0fû€ú¯Þ2BlÉbkÐ6ZkµhXcdê0*ÂKTâ¯H=­•Ï€‘p0ŠlVéõèâ\r¼Œ¥nŽm¦ï)((ô:#¦âòE‰Ü:C¨CàÚâ\r¨G\rÃ©0÷…iæÚ°þ:`Z1Q\n:€à\r\0àçÈq±°ü:`¿-ÈM#}1;èþ¹‹q‘#|ñS€¾¢hl™DÄ\0fiDpëL ``™°çÑ0y€ß1…€ê\rñ=‘MQ\\¤³%oq–­\0Øñ£1¨21¬1°­ ¿±§Ñœbi:“í\r±/Ñ¢› `)šÄ0ù‘@¾Â›±ÃI1«NàCØàŠµñO±¢Zñã1±ïq1 òÑüà,å\rdIÇ¦väjí‚1 tÚBø“°â’0:…0ðð“1 A2V„ñâ0 éñ%²fi3!&Q·Rc%Òq&w%Ñì\ràVÈ#Êø™Qw`‹% ¾„Òm*r…Òy&iß+r{*²»(rg(±#(2­(ðå)R@i›-  ˆž•1\"\0Û²Rêÿ.e.rëÄ,¡ry(2ªCàè²bì!BÞ3%Òµ,R¿1²Æ&èþt€äbèa\rL“³-3á Ö ó\0æóBp—1ñ94³O'R°3*²³=\$à[£^iI;/3i©5Ò&’}17²# Ñ¹8 ¿\"ß7Ñå8ñ9*Ò23™!ó!1\\\0Ï8“­rk9±;S…23¶àÚ“*Ó:q]5S<³Á#383Ý#eÑ=¹>~9Sèž³‘rÕ)€ŒT*aŸ@Ñ–ÙbesÙÔ£:-ó€éÇ*;, Ø™3!i´›‘LÒ²ð#1 +nÀ «*²ã@³3i7´1©ž´_•F‘S;3ÏF±\rA¯é3õ>´x:ƒ \r³0ÎÔ@’-Ô/¬ÓwÓÛ7ñ„ÓS‘J3› ç.Fé\$O¤B’±—%4©+tÃ'góLq\rJt‡JôËM2\rôÍ7ñÆT@“£¾)â“£dÉ2€P>Î°€Fià²´þ\nr\0ž¸bçk(´D¶¿ãKQƒ¤´ã1ã\"2t”ôôºPè\rÃÀ,\$KCtò5ôö#ôú)¢áP#Pi.ÎU2µCæ~Þ\"ä");
    } elseif ($_GET["file"] == "functions.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ÐÊx:\nOg#)Ðêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ðhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜Ý©U*fz¹är0žEÆÀØyŽ¸ñfŽY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ªŽ‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0ŽhR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$ŽrZZË2Ü‰.Éƒ(\\Ž5Ã|\nC(Î\"€P…ðø.ÐNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ÐOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(¹/¡ì¬6KUœÊ‡¡<2‰pOI„ôÕ`Ôäâ³ˆdOH Þ5-üÆ4ŒãpX25-Ò¢òÛˆ°z7£¸\"(°P \\32:]UÚèíâß…!]¸<·AÛÛ¤’ÐßiÚ°‹l\rÔ\0v²Î#J8«ÏwmžíÉ¤¨<ŠÉ æü%m;p#ã`XDŒø÷iZøN0Œ•È9ø¨å Áè`…ŽwJD¿¾2Ò9tŒ¢*øÎyìËNiIh\\9ÆÕèÐ:ƒ€æáxï­µyl*šÈˆÎæY Ü‡øê8’W³â?µŽÞ›3ÙðÊ!\"6å›n[¬Ê\r­*\$¶Æ§¾nzxÆ9\rì|*3×£pÞï»¶ž:(p\\;ÔËmz¢ü§9óÐÑÂŒü8N…Áj2½«Î\rÉHîH&Œ²(Ãz„Á7iÛk£ ‹Š¤‚c¤‹eòžý§tœÌÌ2:SHóÈ Ã/)–xÞ@éåt‰ri9¥½õëœ8ÏÀËïyÒ·½°ŽVÄ+^WÚ¦­¬kZæY—l·Ê£Œ4ÖÈÆ‹ª¶À¬‚ð\\EÈ{î7\0¹p†€•D€„i”-TæþÚû0l°%=Á ÐËƒ9(„5ð\n\n€n,4‡\0èa}Üƒ.°öRsï‚ª\02B\\Ûb1ŸS±\0003,ÔXPHJspåd“Kƒ CA!°2*WŸÔñÚ2\$ä+Âf^\n„1Œ´òzEƒ Iv¤\\äœ2É .*A°™”E(d±á°ÃbêÂÜ„Æ9‡‚â€ÁDh&­ª?ÄH°sQ˜2’x~nÃJ‹T2ù&ãàeRœ½™GÒQŽTwêÝ‘»õPˆâã\\ )6¦ôâœÂòsh\\3¨\0R	À'\r+*;RðHà.“!Ñ[Í'~­%t< çpÜK#Â‘æ!ñlßÌðLeŒ³œÙ,ÄÀ®&á\$	Á½`”–CXš‰Ó†0Ö­å¼û³Ä:Méh	çÚœGäÑ!&3 D<!è23„Ã?h¤J©e Úðhá\r¡m•˜ðNi¸£´Ž’†ÊNØHl7¡®v‚êWIå.´Á-Ó5Ö§ey\rEJ\ni*¼\$@ÚRU0,\$U¿E†¦ÔÔÂªu)@(tÎSJkáp!€~­‚àd`Ì>¯•\nÃ;#\rp9†jÉ¹Ü]&Nc(r€ˆ•TQUª½S·Ú\08n`«—y•b¤ÅžLÜO5‚î,¤òž‘>Ž‚†xââ±fä´’âØ+–\"ÑI€{kMÈ[\r%Æ[	¤eôaÔ1! èÿí³Ô®©F@«b)RŸ£72ˆî0¡\nW¨™±L²ÜœÒ®tdÕ+íÜ0wglø0n@òêÉ¢ÕiíM«ƒ\nA§M5nì\$E³×±NÛál©ÝŸ×ì%ª1 AÜûºú÷ÝkñrîiFB÷Ïùol,muNx-Í_ Ö¤C( fél\r1p[9x(i´BÒ–²ÛzQlüº8CÔ	´©XU Tb£ÝIÝ`•p+V\0î‹Ñ;‹CbÎÀXñ+Ï’sïü]H÷Ò[ák‹x¬G*ô†]·awnú!Å6‚òâÛÐmSí¾“IÞÍKË~/Ó¥7ÞùeeNÉòªS«/;dåA†>}l~žÏê ¨%^´fçØ¢pÚœDEîÃa·‚t\nx=ÃkÐŽ„*dºêðT—ºüûj2ŸÉjœ\n‘ É ,˜e=‘†M84ôûÔa•j@îTÃsÔänf©Ý\nî6ª\rdœ¼0ÞíôYŠ'%Ô“íÞ~	Ò¨†<ÖË–Aî‹–H¿G‚8ñ¿Îƒ\$z«ð{¶»²u2*†àa–À>»(wŒK.bP‚{…ƒoý”Â´«zµ#ë2ö8=É8>ª¤³A,°e°À…+ìCè§xõ*ÃáÒ-b=m‡™Ÿ,‹a’Ãlzkï\$Wõ,mJiæÊ§á÷+‹èý0°[¯ÿ.RÊsKùÇäXçÝZLËç2`Ì(ïCàvZ¡ÜÝÀ¶è\$×¹,åD?H±ÖNxXôó)’îŽM¨‰\$ó,Í*\nÑ£\$<qÿÅŸh!¿¹S“âƒÀŸxsA!˜:´K¥Á}Á²“ù¬£œRþšA2k·XŽp\n<÷þ¦ýëlì§Ù3¯ø¦È•VV¬}£g&YÝ!†+ó;<¸YÇóŸYE3r³ÙŽñ›Cío5¦Åù¢Õ³Ïkkþ…ø°ÖÛ£«Ït÷’Uø…­)û[ýßÁî}ïØu´«lç¢:DŸø+Ï _oãäh140ÖáÊ0ø¯bäK˜ã¬’ öþé»lGª„#ªš©êŽ†¦©ì|Udæ¶IK«êÂ7à^ìà¸@º®O\0HÅðHiŠ6\r‡Û©Ü\\cg\0öãë2ŽBÄ*eà\n€š	…zr!nWz& {H–ð'\$X  w@Ò8ëDGr*ëÄÝHå'p#ŽÄ®€¦Ô\ndü€÷,ô¥—,ü;g~¯\0Ð#€ÌŽ²EÂ\rÖI`œî'ƒð%EÒ. ]`ÊÐ›…î%&Ðîm°ý\râÞ%4S„vð#\n žfH\$%ë-Â#­ÆÑqBâíæ ÀÂQ-ôc2Š§‚&ÂÀÌ]à™ èqh\rñl]à®s ÐÑhä7±n#±‚‚Ú-àjE¯Frç¤l&dÀØÙåzìF6¸ˆÁ\" ž“|¿§¢s@ß±®åz)0rpÚ\0‚X\0¤Ùè|DL<!°ôo„*‡D¶{.B<Eª‹‹0nB(ï Ž|\r\nì^©à h³!‚Öêr\$§’(^ª~èÞÂ/pq²ÌB¨ÅOšˆðú,\\µ¨#RRÎ%ëäÍdÐHjÄ`Â ô®Ì­ Vå bS’d§iŽE‚øïoh´r<i/k\$-Ÿ\$o”¼+ÆÅ‹ÎúlÒÞO³&evÆ’¼iÒjMPA'u'ŽÎ’( M(h/+«òWD¾So·.n·.ðn¸ìê(œ(\"­À§hö&p†¨/Ë/1DÌŠçjå¨¸EèÞ&â¦€,'l\$/.,Äd¨…‚W€bbO3óB³sH :J`!“.€ª‚‡Àû¥ ,FÀÑ7(‡ÈÔ¿³û1Šlås ÖÒŽ‘²—Å¢q¢X\rÀš®ƒ~Ré°±`®Òžó®Y*ä:R¨ùrJ´·%LÏ+n¸\"ˆø\r¦ÎÍ‡H!qb¾2âLi±%ÓÞÎ¨Wj#9ÓÔObE.I:…6Á7\0Ë6+¤%°.È…Þ³a7E8VSå?(DG¨Ó³Bë%;ò¬ùÔ/<’´ú¥À\r ì´>ûMÀ°@¶¾€H DsÐ°Z[tH£Enx(ðŒ©R xñû@¯þGkjW”>ÌÂÚ#T/8®c8éQ0Ëè_ÔIIGII’!¥ðŠYEdËE´^tdéthÂ`DV!Cæ8Ž¥\r­´Ÿb“3©!3â@Ù33N}âZBó3	Ï3ä30ÚÜM(ê>‚Ê}ä\\Ñtê‚f fŒËâI\r®€ó337 XÔ\"tdÎ,\nbtNO`Pâ;­Ü•Ò­ÀÔ¯\$\n‚žßäZÑ­5U5WUµ^hoýàætÙPM/5K4Ej³KQ&53GX“Xx)Ò<5D…\rûVô\nßr¢5bÜ€\\J\">§è1S\r[-¦ÊDuÀ\rÒâ§Ã)00óYõÈË¢·k{\nµÄ#µÞ\r³^·‹|èuÜ»Uå_nïU4ÉUŠ~YtÓ\rIšÃ@ä³™R ó3:ÒuePMSè0TµwW¯XÈòòD¨ò¤KOUÜà•‡;Uõ\n OYéYÍQ,M[\0÷_ªDšÍÈW ¾J*ì\rg(]à¨\r\"ZC‰©6uê+µYóˆY6Ã´0ªqõ(Ùó8}ó3AX3T h9j¶jàfõMtåPJbqMP5>ðÈø¶©Y‡k%&\\‚1d¢ØE4À µYnÊí\$<¥U]Ó‰1‰mbÖ¶^Òõš ê\"NVéßp¶ëpõ±eMÚÞ×WéÜ¢î\\ä)\n Ë\nf7\n×2´õr8‹—=Ek7tVš‡µž7P¦¶LÉía6òòv@'‚6iàïj&>±â;­ã`Òÿa	\0pÚ¨(µJÑë)«\\¿ªnûòÄ¬m\0¼¨2€ôeqJö­PôtŒë±fjüÂ\"[\0¨·†¢X,<\\Œî¶×â÷æ·+md†å~âàš…Ñs%o°´mn×),×„æÔ‡²\r4¶Â8\r±Î¸×mE‚H]‚¦˜üÖHW­M0Dïß€—å~Ë˜K˜îE}ø¸´à|fØ^“Ü×\r>Ô-z]2s‚xD˜d[s‡tŽS¢¶\0Qf-K`­¢‚tàØ„wT¯9€æZ€à	ø\nB£9 Nb–ã<ÚBþI5o×oJñpÀÏJNdåË\rhÞÃ2\"àxæHCàÝ–:øý9Yn16Æôzr+z±ùþ\\’÷•œôm Þ±T öò ÷@Y2lQ<2O+¥%“Í.Óƒhù0AÞñ¸ŠÃZ‹2R¦À1£Š/¯hH\r¨X…ÈaNB&§ ÄM@Ö[xŒ‡Ê®¥ê–â8&LÚVÍœvà±*šj¤ÛšGHåÈ\\Ù®	™²¶&sÛ\0Qš \\\"èb °	àÄ\rBs›Éw‚	ÙážBN`š7§Co(ÙÃà¨\nÃ¨“¨1š9Ì*E˜ ñS…ÓU0Uº tš'|”m™°Þ?h[¢\$.#É5	 å	p„àyBà@Rô]£…ê@|„§{™ÀÊP\0xô/¦ w¢%¤EsBd¿§šCUš~O×·àPà@Xâ]Ô…¨Z3¨¥1¦¥{©eLY‰¡ŒÚ¢\\’(*R` 	à¦\n…ŠàŽºÌQCFÈ*Ž¹¹àéœ¬Úp†X|`N¨‚¾\$€[†‰’@ÍU¢àð¦¶àZ¥`Zd\"\\\"…‚¢£)«‡Iˆ:ètšìoDæ\0[²¨à±‚-©“ gí³‰™®*`hu%£,€”¬ãIµ7Ä«²Hóµm¤6Þ}®ºNÖÍ³\$»MµUYf&1ùŽÀ›e]pz¥§ÚI¤Åm¶G/£ ºw Ü!•\\#5¥4I¥d¹EÂhq€å¦÷Ñ¬kçx|Úk¥qDšb…z?§º‰>úƒ¾:†“[èLÒÆ¬Z°Xš®:ž¹„·ÚÇjßw5	¶Y¾0 ©Â“­¯\$\0C¢†dSg¸ë‚ {@”\n`ž	ÀÃüC ¢·»Mºµâ»²# t}xÎN„÷º‡{ºÛ°)êûCƒÊFKZÞj™Â\0PFY”BäpFk–›0<Ú>ÊD<JE™šg\rõ.“2–ü8éU@*Î5fkªÌJDìÈÉ4•TDU76É/´è¯@·‚K+„ÃöJ®ºÃÂí@Ó=ŒÜWIOD³85MšNº\$Rô\0ø5¨\ràù_ðªœìEœñÏI«Ï³Nçl£Òåy\\ô‘ˆÇqU€ÐQû ª\n@’¨€ÛºÃpš¬¨PÛ±«7Ô½N\rýR{*qmÝ\$\0R”×Ô“ŠÅåqÐÃˆ+U@ÞB¤çOf*†CË¬ºMCŽä`_ èüò½ËµNêæTâ5Ù¦C×»© ¸à\\WÃe&_XŒ_Øhå—ÂÆBœ3ÀŒÛ%ÜFW£û|™GÞ›'Å[¯Å‚À°ÙÕV Ð#^\rç¦GR€¾˜€P±ÝFg¢ûî¯ÀYi û¥Çz\nâ¨Þ+ß^/“¨€‚¼¥½\\•6èßb¼dmh×â@qíÕAhÖ),J­×W–Çcm÷em]ŽÓeÏkZb0ßåþžYñ]ymŠè‡fØe¹B;¹ÓêOÉÀwŸapDWûŒÉÜÓ{›\0˜À-2/bN¬sÖ½Þ¾Ra“Ï®h&qt\n\"ÕiöRmühzÏeø†àÜFS7µÐPPòä–¤âÜ:B§ˆâÕsm¶­Y düÞò7}3?*‚túòéÏlTÚ}˜~€„€ä=cžý¬ÖÞÇ	žÚ3…;T²LÞ5*	ñ~#µA•¾ƒ‘sŽx-7÷Žf5`Ø#\"NÓb÷¯G˜Ÿ‹õ@Üeü[ïø¤Ìs‘˜€¸-§˜M6§£qqš h€e5…\0Ò¢À±ú*àbøISÜÉÜFÎ®9}ýpÓ-øý`{ý±É–kP˜0T<„©Z9ä0<Õš\r­€;!Ãˆgº\r\nKÔ\n•‡\0Á°*½\nb7(À_¸@,îe2\rÀ]–K…+\0Éÿp C\\Ñ¢,0¬^îMÐ§šº©“@Š;X\r•ð?\$\r‡j’+ö/´¬BöæP ½‰ù¨J{\"aÍ6˜ä‰œ¹|å£\n\0»à\\5“Ð	156ÿ† .Ý[ÂUØ¯\0dè²8Yç:!Ñ²‘=ºÀX.²uCªŠŒö!Sº¸‡o…pÓBÝüÛ7¸­Å¯¡Rh­\\h‹E=úy:< :u³ó2µ80“si¦ŸTsBÛ@\$ Íé@Çu	ÈQº¦.ô‚T0M\\/ê€d+Æƒ\n‘¡=Ô°dŒÅëA¢¸¢)\r@@Âh3€–Ù8.eZa|.â7YkÐcÀ˜ñ–'D#‡¨Yò@Xq–=M¡ï44šB AM¤¯dU\"‹Hw4î(>‚¬8¨²ÃC¸?e_`ÐÅX:ÄA9Ã¸™ôp«GÐä‡Gy6½ÃF“Xr‰¡l÷1¡½Ø»B¢Ã…9Rz©õhB„{ž€™\0ëå^‚Ã-â0©%Dœ5F\"\"àÚÜÊÂ™úiÄ`ËÙnAf¨ \"tDZ\"_àV\$Ÿª!/…D€áš†ð¿µ‹´ˆÙ¦¡Ì€F,25Éj›Tëá—y\0…N¼x\rçYl¦#‘ÆEq\nÍÈB2œ\nìà6·…Ä4Ó×”!/Â\nóƒ‰Q¸½*®;)bR¸Z0\0ÄCDoŒËžŽ48À•´µ‡Ðe‘\nã¦S%\\úPIk‡(0ÁŒu/™‹G²Æ¹ŠŒ¼\\Ë} 4Fp‘žGû_÷G?)gÈotº[vžÖ\0°¸?bÀ;ªË`(•ÛŒà¶NS)\nãx=èÐ+@êÜ7ƒjú0—,ð1Ã…z™“­>0ˆ‰GcðãL…VXôƒ±ÛðÊ%À…Á„Q+øŽéoÆFõÈéÜ¶Ð>Q-ãc‘ÚÇl‰¡³¤wàÌz5G‘ê‚@(h‘cÓHõÇr?ˆšNbþ@É¨öÇø°îlx3‹U`„rwª©ÔUÃÔôtØ8Ô=Àl#òõlÿä¨‰8¥E\"Œƒ˜™O6\n˜Â1e£`\\hKf—V/Ð·PaYKçOÌý éàx‘	‰Oj„ór7¥F;´êB»‘ê£íÌ’‡¼>æÐ¦²V\rÄ–Ä|©'Jµz«¼š”#’PBä’Y5\0NC¤^\n~LrR’Ô[ÌŸRÃ¬ñgÀeZ\0x›^»i<Qã/)Ó%@Ê’™fB²HfÊ{%Pà\"\"½ø@ªþ)ò’‘“DE(iM2‚S’*ƒyòSÁ\"âñÊeÌ’1Œ«×˜\n4`Ê©>¦Q*¦Üy°n”’ž¥TäuÔâä”Ñ~%+W²XK‹Œ£Q¡[Ê”žàlPYy#DÙ¬D<«FLú³Õ@Á6']Æ‹‡û\rFÄ`±!•%\n0cÐôÀË©%c8WrpGƒ.TœDo¾UL2Ø*é|\$¬:çXt5ÆXYâIˆp#ñ ²^\nê„:‚#Dú@Ö1\r*ÈK7à@D\0Ž¸C’C£xBhÉEnKè,1\"õ*y[á#!ó×™âÙ™©Ê°l_¢/€öxË\0àÉÚ5ÐZÇÿ4\0005JÆh\"2ˆŒ‡%Y…¦a®a1SûO4ˆÊ%niøšPŒàß´qî_Ê½6¤š•~ŠÈI\\¾š‘d‰údÑøŒ®—DÜÈ”€µ3g^ãü@^6Õ„îå_ÀHD·.ksL´Ô@ÂùÉˆæn­I¦ÄÑ~Ä\r“b @¸Ó€•Nžt\0séÂ]:uðÎX€b@^°1\0½©¥2?èTÀó6dLNeÉ›+ê\0Ç:©Ð²l¡ƒz6q=Ìºx“§çN6 ÜO,%@s›0\næ\\)ÒL<òCÊ|·ž¦P¶b¢˜¼ÎA>I‹…á\"	ŒÜ^K4ü‹gIXi@P…jE©&/1@æfÜ	ÔNáºx0coaß§Áª‰ó,C'Üy#6F@¡Ð ‰H0Ç{z3t–|cXMJ.*BÐ)ZDQðå\0°ñ“T-v¥Xža*”Ý,*Ã<bÁ•Ë#xÑ˜Ýd€PÆòKG8—Æ y“K	\\#=è)ígÈ‘hŒ&È8])½CÅ\nÃ´ñÀ9¼zˆW\\’gþM 7Šˆ!Ê•¡óÆŠ–¬,Åò9ñ²Š©©\$T\"£,Š¨%.F!Ëš A»-àé”ø¹-àg¨âŠ\0002R>KEˆ'ØUÙ_IÐ÷ì³9³Ë¼¡j(Q°@Ë@ò4/¬7ô˜“'J.â‡RT…\0]KS¹D‡–Ap5¼\rÂH0!ä›Â´e	d@RÒÒà¸´Ê9¢S©;7žH‘BÀbxóJèÖ_žviÑU`@ˆµÃSAM…¯XËÏGØXiÙÓU*¬Úö€ÊõûÍ'øÝ:VòWJv£D¾ÿN'\$ìzh\$d_y§œ“Z]•™­óYÊ°³8Ø”þ¡æ]¨Pìœ*hžÔÖ§e;€ºpeû¢\$kæw§ì*7N²DTx_ÔÔ§½Giô&PÿÔ†žtÍ†¨bè\\EÆH\$iE\"cr½å0l‰?>ÁñŒ‘C(ŠW@3ÈÁ•22a´“IÁà¹Õ¡{¥B`ÜÚ³iÅ¸Go^6E\r¡ºG˜M¤p1iÙI¼¤Xª\0003Ž2ÇKü§ÓôÝzl&Ö†‰'ILÖ\\Î\"’7¤>¬j(>ãjôFG_âä& 10IÆA31=h q\0ÆFŠ«–„Ä·ŠÝ_ÂJªŒ„Ô³VÎ–º‡Ü†qÙÕš¢Ù	Âà(/¾dOC_sm§<g˜x\0’°\"ð\n@EkH\0¡Jˆ­®8€(¬¨¯km[‰‘ì¿ÁS4ð\nY40›«+L\nŠ¦À“‘ì#BÓ«bçÀ%RÖ–°µ×­‘ÀR:Æ<\$!Û¥r;œ…Ç	%|Ê¨á(€|«H‡\0àð‘ÁÐŒ°…]ÂcÒ¡=0¯íZá¨\"\"=ÖX•˜)½fëNŸ6V}FÕÚ=[Éžà§¢huô-ø±\0t¥åbW~ºõQ•ÕiJŠö—Lñ5×­q#kbž ÝWn««ÍQøTƒ!ëÂeõncSÑ[+Ö´E¯<-‡–a]ÅƒˆìYbÓ\n\nJ~ä|JÉƒ8® ìLpŸ™Áæoñ €Nä©Ü¨…J.ùÅƒSÈ¡2c9Ãj©yŸ-`a\0Äö*ìÖˆ@\0+´ØmgÉÚ6°1¤ÔMe\0ªËQ ‰_„}!Iö’GL€f)ÃXño,“ShxÂ\0000\"hð+L¥MÔÉ ªÑ˜±ÊZ	j—\0¶ µ/˜\$’¨>u*—Z9”îZå®eõ«+Jœ‰™¸tzÈËûÈþR¨KÔ¯ÐÑâDyŽÞÙqá0C—-f¢Åm‚¶¹ªBIí|’¹HB‰œsQlÀX°ƒ.ÝÅöÔ|¸cˆªÀ[–óZhZåÃl˜¨ÛxÂ@'µ ml²KrQ¶26½•]¯Ò·n§d[ÝöñŽ©‡dþ€‘\"GJ9uòûBƒo“©Zß–Õa¥²n@Áªn°lW|*gX´\nn2åF¬|x`Dk›„uPP!Q\rr‹™`W/¹ŒŸ	1æ[-o,71bUs˜¢©çN¸7²ËÉÛGq¸.\\Q\"CCT\"æ‘à–ÄÒ*?u¨ts¶‰”°Ç]áÙ©Pz[¥[YFÏ¹¢›FD3¤\"–ºÇ]uÛ)wz­:#¶ÍÝIiwŠêpÉ›»ñ{¯oÖ0nð¶Û;Õâ\\éx¸°Ø\0q·måãíª&Ø~Âîî—”7²øÀ¹9[¤HéqdL•Oº2´v|B¯tæŠ\\Æ¤‰Hd¦ëâH‘\" òìN\n\0·©GÅgÎF ¸Fˆ}\"ì­&QEK¾‘{}\ryÇŽ¾˜r×›t›Àž„ï†7ÔNuÃ³[Aøgh;S¥.Ò ‚š±Â¥|yùÏ[Õ†_bòÈ¨¬!+RñèZXù@0NééþÁP€Þì%¡jD£Â¯z	þà—[øU\"¶{e’8ôŸ>”EL4JÐ½…0›¡¦è7 €´d·¬ ÀQ^`0`œ•¯]cð<g@Ž²hy8˜íp.ef\nóÎeh‡ƒaXÚÃømSßßjBÚ˜Q\"‡\rë×ÇK3†=>ÇªAX”[,,\"'<µ›–%¶a€«Ó´Ãµ.\$ñ\0ç%\0ásV¤îËp M\$¼@já×ð>¤­}VeÄ\$@—Í„#§ªÐ(3:ø`‚UðšYÌ¶uæ¨ûˆÏâÎ@ÄV#E‰G/¸üXD\$ˆhµƒav–¼xS\"]k18a¯Ñ9dJROÓŠs‘`EJ°½§øUo³m{l¹B8¥ˆÁ(\n}ei±büø, ; N”ªÍ‡øQØ\\èÇ¸I5yR¼\$!>\\Ê‰ŒgÂuj*?n°MÓÞ²hÝø\r%Á³àU(d€¦Nµd#}špA:¬¨ý•-\\èA»*Ä4€2I€®è\rÖ£»… 0h@\\ÔµÉÀ8ð3‚rq]òùd8\"ðQ ŒÿîÆ™:cÆàyÇ4	Ïá‘šdaÂ€‡Î 6>UÛAÚÑ:½@˜2‹Ûÿ\$òeh2´ûF»§É™Ná+’ŒŸ\rþÔ€(îAr‚°d*ü\0[®#cjŠû´>!(SðÈéLˆeýTÉÆM	9\0W:™BDýø‚3JŒ¬Õ_@sÇárue‡ø¦ð»ý¬ +º'B«É}\"B\"üz2Žî‹rël»xF[èLÙË²Ea9 Êcdb½¾^,ÔUC=/2»×ò¼øì/\$CÆ#Ú÷8¡}DÀÛ×6Ï`^;6B0U7ó·_=	,ª1âj1V[¨.	H9(1ï±Æ±ÒLz¢C¸	Ç\$.AÊfhã–«¾ÍàïDrY	ýHØe~o—r19æ—Ù…\\šß„P’)\"ÃQ¹´,ÑeòöL¾”w0Ï\0§—š–Ï;wìX³Ç¨‰çqo¹ï¾~Ÿ«öçø>9ô>}²òºdc¿\0åÊg¾¶fÎùq–&9—¹-ýJ#¤Š¸ª3^4m/Ì™¯\0\0006À¦n8£·>äˆ´.Ó—é’cph±ËÙù•››º_A@[‰•7«|9\$pMh >‰ŒÁ5°K¥úÃE=hþšAÒtŠ^âV×	©\"	c£B;¤öÞi…ÕQÒ t¬›òé@,\nØ)­óˆsÓ`Ÿ™°°;Ñ4´—‚„Ií£©‘íùèy€ -¤0yeÊ¨—U‚”Bî©v³¥3H™PÇGË5êï’s|·º\rðžÐ\$0ãèò•ò1½©l3€é(*oF~PK´ª.ý,'·J/Ó²tð‹d:š—n§\n©ðj†Y«zê(Æó’ü“w°Ý Zì#ZÊ	Io•@1ÆÎ»\$ïò±¦=VWz•	nŽBøaú›A»µqª@™´I€p	@Ñ5Ó–lH{UºÜoXõ¿fðŽÓ¿\\zµ×.§š²,-\\Ú—^y n^Å×ÊBq·þ…¤zXã‰¡ƒ\$¨*J72ÕD4.†Õ…!¤M0¶óDëìFŠàóã G¡ÏLˆmØc*mïcI£å5ÉŒ»^—t¿ª’jlŒ7æ›¿S¶Q ¢.i’éÖÔh¨õLÐÚ±B6Ô„h˜&ïJ …l\\‰ðWeªcÎf%kj™Á ¦pÃR=Œäi’@.õ¥(ä2klHUW\"™o¥j½§’p!S5Æè­pL'`\0¤O *¦Q3XÂ“‰ÞlJ\08\n…\r·²¸*€añüë–ž¼ûr™`<¤&ÚXBhÖ8!xš®&äBht¥\$ÿ‡þ]Énß†éóÉcL€€[Æµ©d¸á<`œ®\0œ€¢Ï‚ÞawæO%;‘õBC»…Q’\rÌ­ÓìŒì€pŠ¤«ØPQ¶Z’¸úZÁAu=N&Ðia\nÑmK6I}Ñ×n	šÅt\nd)í®ÐÈ÷bpÎ€\"žðg'¦0œ7ÃuÈ&@â7å8X NÀxÄáö­ú\$BùßZB/¶M¯gB»i¦ÖÑ§¶\\âmƒmIÌÄ€Êç;5=#&4˜ÌçþPÕ‰½éðqí’A™ä›\\…,q¤cÞŸ\ncâB–‚¾×úw\0BgjD‹@;=0m“k®Ä\rÄ²‹`À¤'5¤•¶k-Œ{¢‰\0¯_›Muîøƒ2“Ò×†§»£Àqø‰¬ð>)9ÈW\näd+…ÔÔ§ÀG\rýÃn4„‹äOØ:5ö†Þ8»1µ:Îš?¥‡(yGgWK\rÝ7­²“—m5.œ‚eŒHÙhJ«Ak#»ÓL¶..›\\Î=ÕñUÙÐ„˜ƒÓ:Ð>7ºW+^yD‚“œb­üG¡‘OZÍ4ïŠr(|xµÆýPr¸£,yŽ©Ð8qaÜ©O2µkªn˜Š#p2¾ûÇˆºØ”.¼£c’–U—c”öäëÅ‚jó\$ôí8Ä¬~š7ZR:ð×†8­9Î¨w(a”L¤%­-,ÔÈì¿Œ#ôfƒ%8þÉ|Þc‡‘¬œÚ×%X‘WÂ\n}6’‘HìÿñæËž¤¡#¹&J,'z“MüM…¢‰Œààº‘Ü†² ‘˜®/y6YQ¯‘ì¶ÚºdÓ™dÁÞóÏ:õãô£EƒŒp2gŸgÁ/î,ÒËäÚÕˆ'8ì^;´UWN…ÑÅÞÕ{ÉOCò…Ñ¤ô¢zÉiKX¢’Ú”NŒdG£RCJYõ’‘i²’×y#>zS²MUc£õƒ¨ûÿêRORÔ¾¡0)Ø0Êú]:=Ïž™tƒ‘Áëé'\$™sÒrFŽöÙ67	=\$BÄÓ!qs	1\"ü¬vÆ÷%‘ŒI•l<Êb!Û®6(Cd-Ê^<H`~2¹KìÍzKÝÙœ€Ô±­ÙÕy,qAá*º\0}‚ÝC¨pb€\\ÓSå5ÝßùÚ'(›áÓí|»Mëð„ÀWÚÀ5;\$5µT|ºò;kõñÈtîñ@ò‘â;9³)½ò;i.Û;›·í_¥ê×ÌF¶=ñœDä¥M`HÞ“ƒ\0ˆ	 N @°%w‡ªdèPbð\$H|kÆ[¾ÜdCI!:lÅü,§¨ý<÷”uòt”ô¼NeÏW^¡wè'6•ŒD¿áfýu ¬ihI÷Z:ŸÑ~ý÷Ï£r¾…ÈzÄ3õ+¯uoC·s2ÕbÆua”XðwWK£	HÔ¶27>âWÏÍÝyÃ£¬ÝMëJ£rpT¼”Lð‰|`f™…:ÊõšA²täŠd|i½³[wüèj„ŠW˜ 7‘¤£au‹© úëe ò•šA5­Q' Ê\0È 3‹Ò¾\$ÂçýŒ\rk)a; óæH=ù™Ö~óIGŠIæ°<ù´•\"ù¬ÉI1'è ™¢Gcm\0P\nïwèü#Í>Œ½ÛxB\"ñÒEm|…ù2Š\$}<3PYXgo£dß¶€<Ôþ£¿qE\"`×úÈ4ág«8r£]\nˆ¡—õ:ø›qVbTì£Òm°•…9K&Ò“Ä¤ÃmÔ7)@¨ÀQz›ÃÓ=¢½ßµÅ±íŸH\nÔëö}Oçi}»\rÙ£.¢¹v‹®p¾JW&ßu×550	Ô5ÀîPËIŒÁ\n½Ûí¸³Ææ­l\0O5*=Þú	…P-¢éÊH\0óf×%Ìtãº*¥S:±tÏ› €€?øÈ‚Hâñ÷ºq4ˆÐKÍ”§@€Ô¬»Ü‚.O(±ëü Z¡\$ÏÊÓ]¼‚Åo¿€n‹z«A±!€t85<WñR2[„8ò‚¶ùn5\$IÝµæµ•Z¤Àéó]'}ET\nŸú†Šä.˜í¤&ä7¦ÏVË@¤_ÀD”oÈý&J6°ß4iÃj\$ÈÒEL¢äþu“Üt¢‰Ëä+I¡Ð¢¢šûØ£~üS±SZTXÒ ¾PYz½Å\"\$VÇ_]ÿM(§ã7òƒºü·ÚÌáÃÀ‡t_´S‰óˆÃê/­ßt…½“Ä‚ü¿âmHä:\0»5à- _Z'#ö¥Á1‡P¿é´,}(Ÿ°~¸\0ì‹þ!Ò–`-þP\neùy (¿Êˆ `9OËú!Á;5‰\n½\$ê{úŸ¯þðìUAü¨7ùá!¿çò€[ý ¸Yý¿ÅFæ¿´ÿƒý¯ð>è8&€›Þÿ!CLà¦ÿH€¯õ(”\0'Ç2ûìd\r%‚;àkæŠ4ûÀ_OÏ>þ5³öà@DýÒ¼ÏÞ\0VÃA€6' AY¬¢¶ýS°¿‚££rÔ¾´4š+h@bÿãõ­¾´þ‚Oá”M\0Àå˜ÀrÌ›ú@ÿ\rJùÓm0\08ùOò€ìÿ;kÓ ÊëþA(6£|	`8 ß\0ˆ°&¿²EÐVÏå\0VþãñÏï€wk…NÀ°KùÁ—¡xdpÀÒÿsìAL§â«A¾Xëkÿ‘u\0Œïþ„Ít ÀÔ¢ò.‰>(N’ÅK'flï¢ªdúAŠ‚â?++ðN“Œ~‚ ÿ²˜úkæ€¾²€ªPR\0èúx¡ØãûèÊ‘ô”‹BK]¦bUÃÑ\\Ì›¸€„d\0S@¿ä«QÀïÍ‰šb™\0\0b„„Ö\0_\\¡@\nN—î äOÎA„PfÁ„€ Œ¶ôÔAj ¨ÂM4<¤9“°Ú+çÀ¿¨Ÿ`S‰‹ ìü”Èw3Tð¬„7âX»Â†T!\0eïPAIÈb 1!\0€ž4³åà'¹ @ ! 8\0’Ë/ïˆ º!:K•,ØCASðX‘f®e©ÎMùý.:˜¼:òÆtŸ»¡àÃÌ._ºd„ÿ‹°81v`B\"ä‚Å!.^Ú*åáN.^‡š\n„&\r(Ÿš.Á©§îO0Š«@÷ÙPŠ¹njÒàŽÚ—#¡¼îäÓå&¹‚rHØ<¨†  ¢!à’3¶Ü(i @ÜAaÁÅ{õ Â¬#ÉS©½†6ð¨˜¶F@©Ô¦ãY[Oœƒ( .‡¬/„BüËñÇó)L02BØˆÌ-ÁÆ€Øùqp¹‹J<¤.Ð‘\0\nçï\0ÐÔ/@8C¤4PÀÇ\r	PÂ•°)üðFâå\$q.]¬\"B#‹Å	œ#\\£Â84\$Ãs:.(*Oi>™|#T'`—Bu«a/ˆ€ãCÀÂTØKaêX8Î`p ¸ÚÕÁ\0`Ê\0");
    } elseif ($_GET["file"] == "jush.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo lzw_decompress("v0œF£©ÌÐ==˜ÎFS	ÐÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xð¸?Ä'ƒi°SANN‘ùðxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\nŽ?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYŽÌèy6GFmYŽ8o7\n\r³0¤÷\0DbcÓ!¾Q7Ð¨d8‹Áì~‘¬N)ùEÐ³`ôNsßð`ÆS)ÐOé—·ç/º<xÆ9Žo»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿŽŽpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êÝê{n7ÀÃ¡ƒAðNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sð\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+ŽäÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XÐ]µÝY XÁeåzWâü Ž7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Þ3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ð`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆÞ±ÅáÐÝã&/¦O‚ðL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ðÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Þír_sËP‡hà¼àÐ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàýUþ„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšðÜlAüV…¨4 hà£Sq<žà@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒÐÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯Ý¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ÐÒ\nÁX; ‹ìŽêCaA¬\ráÝñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\ržP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çŽÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëÐæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàžœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gðÒö]«ÜyRÔ7\"ðæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!Ýf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ýøæ8PE5-	Ð_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²Ý‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âÐiTð1ªORäl«,5[Ý˜\$¹·)¬ôjLÆU`£SË`Z^ð|€‡r½=Ð÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”ž­tÆ*3%k›YÜ²T*Ý|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×þÙDÜ_Œ‡.6Ð¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xþ¥mh8:êûc‹þ0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òý¯Ì·°^]­±NÑv¹ç#Ç,ëvð×ÃOÏiÏ–©>·Þ<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼ÝE÷úÿë¹gÒÜ/¡øžUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúað\" žçØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùŽi:RŽÎëP2êmµ\0/vìOX÷ðøFÊ³ÏˆîŒè®\"ñ®êöî¸÷0õ0ö‚¬©í0bËÐgjðð\$ñné0}°	î@ø=MÆ‚0nîPŸ/pæotì€÷°¨ð.ÌÌ½g\0Ð)o—\n0È÷‰\rF¶é€ b¾i¶Ão}\n°Ì¯…	NQ°'ðxòFaÐJîÎôLõéðÐàÆ\rÀÍ\r€Öö‘0Åñ'ð¬Éd	oepÝ°4DÐÜÊ¦q(~ÀÌ ê\r‚E°ÛprùQVFHœl£‚Kj¦¿äN&­j!ÍH`‚_bh\r1Ž ºn!ÍÉŽ­z™°¡ð¥Í\\«¬\rŠíŠÃ`V_kÚÃ\"\\×‚'Vˆ«\0Ê¾`ACúÀ±Ï…¦VÆ`\r%¢’ÂÅì¦\rñâƒ‚k@NÀ°üBñíš™¯ ·!È\n’\0Z™6°\$d Œ,%à%laíH×\n‹#¢S\$!\$@¶Ý2±„I\$r€{!±°J‡2HàZM\\ÉÇhb,‡'||cj~gÐr…`¼Ä¼º\$ºÄÂ+êA1ðœE€ÇÀÙ <ÊL¨Ñ\$âY%-FDªŠd€Lç„³ ª\n@’bVfè¾;2_(ëôLÄÐ¿Â²<%@Úœ,\"êdÄÀN‚erô\0æƒ`Ä¤Z€¾4Å'ld9-ò#`äóÅ–…à¶Öãj6ëÆ£ãv ¶àNÕÍf Ö@Ü†“&’B\$å¶(ðZ&„ßó278I à¿àP\rk\\§—2`¶\rdLb@Eöƒ2`P( B'ã€¶€º0²& ô{Â•“§:®ªdBå1ò^Ø‰*\r\0c<K|Ý5sZ¾`ºÀÀO3ê5=@å5ÀC>@ÂW*	=\0N<g¿6s67Sm7u?	{<&LÂ.3~DÄê\rÅš¯x¹í),rîinÅ/ åO\0o{0kÎ]3>m‹”1\0”I@Ô9T34+Ô™@e”GFMCÉ\rE3ËEtm!Û#1ÁD @‚H(‘Ón ÃÆ<g,V`R]@úÂÇÉ3Cr7s~ÅGIói@\0vÂÓ5\rVß'¬ ¤ Î£PÀÔ\râ\$<bÐ%(‡Ddƒ‹PWÄîÐÌbØfO æx\0è} Üâ”lb &‰vj4µLS¼¨Ö´Ô¶5&dsF Mó4ÌÓ\".HËM0ó1uL³\"ÂÂ/J`ò{Çþ§€ÊxÇYu*\"U.I53Q­3Qô»J„”g ’5…sàúŽ&jÑŒ’Õu‚Ù­ÐªGQMTmGBƒtl-cù*±þ\rŠ«Z7Ôõó*hs/RUV·ðôªBŸNËˆ¸ÃóãêÔŠài¨Lk÷.©´Ätì é¾©…rYi”Õé-Sµƒ3Í\\šTëOM^­G>‘ZQjÔ‡™\"¤Ž¬i”ÖMsSãS\$Ib	f²âÑuæ¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ë^óHÅM‰_Õ¼ŠuÀ™UÊz`ZJ	eçºÝ@Ceíëa‰\"mób„6Ô¯JRÂÖ‘T?Ô£XMZÜÍÐ†ÍòpèÒ¶ªQv¯jÿjV¶{¶¼ÅCœ\rµÕ7‰TÊžª úí5{Pö¿]’\rÓ?QàAAÀèŽ‹’Í2ñ¾ “V)Ji£Ü-N99f–l JmÍò;u¨@‚<FþÑ ¾e†j€ÒÄ¦I‰<+CW@ðçÀ¿Z‘lÑ1É<2ÅiFý7`KG˜~L&+NàYtWHé£‘w	Ö•ƒòl€Òs'gÉãq+Lézbiz«ÆÊÅ¢Ð.ÐŠÇzW²Ç ùzd•W¦Û÷¹(y)vÝE4,\0Ô\"d¢¤\$Bã{²Ž!)1U†5bp#Å}m=×È@ˆwÄ	P\0ä\rì¢·‘€`O|ëÆö	œÉüÅõûYôæJÕ‚öE×ÙOuž_§\n`F`È}MÂ.#1á‚¬fì*´Õ¡µ§  ¿zàucû€—³ xfÓ8kZR¯s2Ê‚-†’§Z2­+ŽÊ·¯(åsUõcDòÑ·Êì˜ÝX!àÍuø&-vPÐØ±\0'LïŒX øLÃ¹Œˆo	Ýô>¸ÕŽÓ\r@ÙPõ\rxF×üE€ÌÈ­ï%Àãì®ü=5NÖœƒ¸?„7ùNËÃ…©wŠ`ØhX«98 Ìø¯q¬£zãÏd%6Ì‚tÍ/…•˜ä¬ëLúÍl¾Ê,ÜKa•N~ÏÀÛìú,ÿ'íÇ€M\rf9£w˜!x÷x[ˆÏ‘ØG’8;„xA˜ù-IÌ&5\$–D\$ö¼³%…ØxÑ¬Á”ÈÂ´ÀÂŒ]›¤õ‡&o‰-39ÖLù½zü§y6¹;u¹zZ èÑ8ÿ_•Éx\0D?šX7†™«’y±OY.#3Ÿ8 ™Ç€˜e”Q¨=Ø€*˜™GŒwm ³Ú„Y‘ù ÀÚ]YOY¨F¨íšÙ)„z#\$eŠš)†/Œz?£z;™—Ù¬^ÛúFÒZg¤ù• Ì÷¥™§ƒš`^Úe¡­¦º#§“Øñ”©Žú?œ¸e£€M£Ú3uÌåƒ0¹>Ê\"?Ÿö@×—Xv•\"ç”Œ¹¬¦*Ô¢\r6v~‡ÃOV~&×¨^gü šÄ‘Ùž‡'Î€f6:-Z~¹šO6;zx²;&!Û+{9M³Ù³d¬ \r,9Öí°ä·WÂÆÝ­:ê\rúÙœùã@ç‚+¢·]œÌ-ž[gž™Û‡[s¶[ižÙiÈq››y›éxé+“|7Í{7Ë|w³}„¢›£E–ûW°€Wk¸|JØ¶å‰xmˆ¸q xwyjŸ»˜#³˜e¼ø(²©‰¸ÀßžÃ¾™†ò³ {èßÚ y“ »M»¸´@«æÉ‚“°Y(gÍš-ÿ©º©äí¡š¡ØJ(¥ü@ó…;…yÂ#S¼‡µY„Èp@Ï%èsžúoŸ9;°ê¿ôõ¤¹+¯Ú	¥;«ÁúˆZNÙ¯Âº§„š k¼V§·u‰[ñ¼x…|q’¤ON?€ÉÕ	…`uœ¡6|­|X¹¤­—Ø³|Oìx!ë:¨œÏ—Y]–¬¹Ž™c•¬À\r¹hÍ9nÎÁ¬¬ë€Ï8'—ù‚êà Æ\rS.1¿¢USÈ¸…¼X‰É+ËÉz]ÉµÊ¤?œ©ÊÀCË\r×Ë\\º­¹ø\$Ï`ùÌ)UÌ|Ë¤|Ñ¨x'ÕœØÌäÊ<àÌ™eÎ|êÍ³ç—â’Ìé—LïÏÝMÎy€(Û§ÐlÐº¤O]{Ñ¾×FD®ÕÙ}¡yu‹ÑÄ’ß,XL\\ÆxÆÈ;U×ÉWt€vŸÄ\\OxWJ9È’×R5·WiMi[‡Kˆ€f(\0æ¾dÄšÒè¿©´\rìMÄáÈÙ7¿;ÈÃÆóÒñçÓ6‰KÊ¦Iª\rÄÜÃxv\r²V3ÕÛßÉ±.ÌàRùÂþÉá|Ÿá¾^2‰^0ß¾\$ QÍä[ã¿D÷áÜ£å>1'^X~t1\"6Lþ›+þ¾Aàžeá“æÞåI‘ç~Ÿåâ³â³@ßÕ­õpM>Óm<´ÒSKÊç-HÉÀ¼T76ÙSMfg¨=»ÅGPÊ°›PÖ\r¸é>Íö¾¡¥2Sb\$•C[Ø×ï(Ä)žÞ%Q#G`uð°ÇGwp\rkÞKe—zhjÓ“zi(ôèrO«óÄÞÓþØT=·7³òî~ÿ4\"ef›~íd™ôíVÿZ‰š÷U•-ëb'VµJ¹Z7ÛöÂ)T‘£8.<¿RMÿ\$‰žôÛØ'ßbyï\n5øƒÝõ_ŽàwñÎ°íUð’`eiÞ¿J”b©gðuSÍë?Íå`öážì+¾Ïï Mïgè7`ùïí\0¢_Ô-ûŸõ_÷–?õF°\0“õ¸X‚å´’[²¯Jœ8&~D#Áö{P•Øô4Ü—½ù\"›\0ÌÀ€‹ý§ý@Ò“–¥\0F ?* ^ñï¹å¯wëÐž:ð¾uàÏ3xKÍ^ów“¼¨ß¯‰y[Ôž(žæ–µ#¦/zr_”g·æ?¾\0?€1wMR&M¿†ù?¬St€T]Ý´Gõ:I·à¢÷ˆ)‡©Bïˆ‹ vô§’½1ç<ôtÈâ6½:W{ÀŠôx:=Èî‘ƒŒÞšóø:Â!!\0x›Õ˜£÷q&áè0}z\"]ÄÞo•z¥™ÒjÃw×ßÊÚÁ6¸ÒJ¢PÛž[\\ }ûª`S™\0à¤qHMë/7B’€P°ÂÄ]FTã•8S5±/IÑ\rŒ\n îO¯0aQ\n >Ã2­j…;=Ú¬ÛdA=­p£VL)Xõ\nÂ¦`e\$˜TÆ¦QJÎk´7ª*Oë .‰ˆ…òÄ¡\röµš\$#pÝWT>!ªªv|¿¢}ë× .%˜Á,;¨ê›å…­Úf*?«ç„˜ïô„\0¸ÄpD›¸! ¶õ#:MRcúèB/06©­®	7@\0V¹vg€ ØÄhZ\nR\"@®ÈF	‘Êä¼+Êš°EŸIÞ\n8&2ÒbXþPÄ¬€Í¤=h[§¥æ+ÕÊ‰\r:ÄÍFû\0:*åÞ\r}#úˆ!\"¤c;hÅ¦/0ƒ·Þ’òEj®íÁ‚Î]ñZ’Žˆ‘—\0Ú@iW_–”®h›;ŒVRb°ÚP%!­ìb]SBšƒ’õUl	åâ³érˆÜ\rÀ-\0 À\"Q=ÀIhÒÍ€´	 F‘ùþLèÎFxR‚Ñ@œ\0*Æj5Œük\0Ï0'	@El€O˜ÚÆH CxÜ@\"G41Ä`Ï¼P(G91«Ž\0„ð\"f:QÊ¸@¨`'>7ÑÈŽädÀ¨ˆíÇR41ç>ÌrIHõGt\n€RH	ÀÄbÒ€¶71»ìfãh)Dª„8 B`À†°(V<Q§8c? 2€´€EŽ4j\0œ9¼\r‚Íÿ@‹\0'FúDš¢,Å!ÓÿH=Ò* ˆEí(×ÆÆ?Ñª&xd_H÷Ç¢E²6Ä~£uÈßG\0RXýÀZ~P'U=Çß @žèÏÈl+A­\n„h£IiÆ”ü±ŸPG€Z`\$ÈP‡þ‘À¤Ù.Þ;ÀEÀ\0‚}€ §¸Q±¤“äÓ%èÑÉjA’W’Ø¥\$»!ýÉ3r1‘ {Ó‰%i=IfK”!Œe\$àžé8Ê0!üh#\\¹HF|Œi8tl\$ƒðÊlÀìläi*(ïG¸ñçL	 ß\$€—xØ.èq\"Wzs{8d`&ðWô©\0&E´¯Íì15jWäb¬öÄ‡ÊÞV©R„³™¿-#{\0ŠXi¤²Äg*÷š7ÒVF3‹`å¦©p@õÅ#7°	å†0€æ[Ò®–¬¸[øÃ©hË–\\áo{ÈáÞT­ÊÒ]²ï—Œ¼Å¦á‘€8l`f@—reh·¥\nÊÞW2Å*@\0€`K(©L•Ì·\0vTƒË\0åc'L¯ŠÀ:„” 0˜¼@L1×T0b¢àhþWÌ|\\É-èïÏDN‡óž€\ns3ÀÚ\"°€¥°`Ç¢ùè‚’2ªå€&¾ˆ\rœU+™^ÌèR‰eS‹n›i0ÙuËšb	J˜’€¹2s¹Ípƒs^n<¸¥òâ™±Fl°aØ\0¸š´\0’mA2›`|ØŸ6	‡¦nrÁ›¨\0DÙ¼Íì7Ë&mÜß§-)¸ÊÚ\\©ÆäÝŒ\n=â¤–à;* ‚Þb„è“ˆÄT“‚y7cú|o /–Ôßß:‹ît¡P<ÙÀY: žK¸&C´ì'G/Å@ÎàQ *›8çv’/‡À&¼üòWí6p.\0ªu3«žŒñBq:(eOPáp	”é§²üÙã\rœ‹á0ž(ac>ºNö|£º	“t¹Ó\n6vÀ_„îeÝ;yÕÎè6fügQ;yúÎ²[Sø	äëgöÇ°èO’ud¡dH€Hð= Z\ræ'ÚÊùqC*€) žœîgÂÇEêO’€ \" ð¨!kÐ('€`Ÿ\nkhTùÄ*ösˆÄ5R¤Eöa\n#Ö!1¡œ¿‰×\0¡;ÆÇSÂiÈ¼@(àl¦Á¸I× Ìv\rœnj~ØçŠ63¿ÎˆôI:h°ÔÂƒ\n.‰«2plÄ9Btâ0\$bº†p+”Ç€*‹tJ¢ðÌ¾s†JQ8;4P(ý†Ò§Ñ¶!’€.Ppk@©)6¶5ý”!µ(ø“\n+¦Ø{`=£¸H,É\\Ñ´€4ƒ\"[²Cø»º1“´Œ-èÌluoµä¸4•[™±â…EÊ%‡\"‹ôw] Ù(ã ÊTe¢)êK´A“E={ \n·`;?Ýôœ-ÀGŠ5I¡í­Ò.%Á¥²þéq%EŸ—ýs¢é©gFˆ¹s	‰¦¸žŠKºGÑøn4i/,­i0·uèx)73ŒSzgŒâÁV[¢¯hãDp'ÑL<TM¤äjP*oœâ‰´‘\nHÎÚÅ\n 4¨M-W÷NÊA/î†@¤8mH¢‚Rp€tžp„V”=h*0ºÁ	¥1;\0uG‘ÊT6’@s™\0)ô6À–Æ£T\\…(\"ŽèÅU,ò•C:‹¥5iÉKšl«ì‚Û§¡E*Œ\"êrà¦ÔÎ.@jRâJ–QîŒÕ/¨½L@ÓSZ”‘¥Põ)(jjžJ¨««ŽªÝL*ª¯Ä\0§ªÛ\r¢-ˆñQ*„QÚœgª9é~P@…ÕÔH³‘¬\n-e»\0êQw%^ ETø< 2Hþ@Þ´îe¥\0ð e#;öÖI‚T’l“¤Ý+A+C*’YŒ¢ªh/øD\\ð£!é¬š8“Â»3AÐ™ÄÐEðÍE¦/}0tµJ|™ÀÝ1Qm«Øn%(¬p´ë!\nÈÑÂ±UË)\rsEXú‚’5u%B- ´Àw]¡*•»E¢)<+¾¦qyV¸@°mFH òÔšBN#ý]ÃYQ1¸Ö:¯ìV#ù\$“æ þô<&ˆX„€¡úÿ…x« tš@]GðíÔ¶¥j)-@—qÐˆL\nc÷I°Y?qC´\ràv(@ØËX\0Ov£<¬Rå3X©µ¬Q¾Jä–Éü9Ö9ÈlxCuÄ«d±± vT²Zkl\rÓJíÀ\\o›&?”o6EÐq °³ªÉÐ\r–÷«'3úËÉª˜J´6ë'Y@È6ÉFZ50‡VÍT²yŠ¬˜C`\0äÝVS!ýš‹&Û6”6ÉÑ³rD§f`ê›¨Jvqz„¬àF¿ ÂÂò´@è¸Ýµ…šÒ…Z.\$kXkJÚ\\ª\"Ë\"àÖi°ê«:ÓEÿµÎ\roXÁ\0>P–¥Pðmi]\0ªöö“µaV¨¸=¿ªÈI6¨´°ÎÓjK3ÚòÔZµQ¦m‰EÄèðbÓ0:Ÿ32ºV4N6³´à‘!÷lë^Ú¦Ù@hµhUÐ>:ú	˜ÐE›>jäèÐú0g´\\|¡Shâ7yÂÞ„\$•†,5aÄ—7&¡ë°:[WX4ÊØqÖ ‹ìJ¹Æä×‚Þc8!°H¸àØVD§ÄŽ­+íDŠ:‘¡¥°9,DUa!±X\$‘ÕÐ¯ÀÚ‹GÁÜŒŠBŠt9-+oÛt”L÷£}Ä­õqK‹‘x6&¯¯%x”ÏtR¿–éð\"ÕÏ€èR‚IWA`c÷°È}l6€Â~Ä*¸0vkýp«Ü6Àë›8z+¡qúXöäw*·EƒªIN›¶ªå¶ê*qPKFO\0Ý,ž(Ð€|œ•‘”°k *YF5”åå;“<6´@ØQU—\"×ð\rbØOAXÃŽvè÷v¯)H®ôo`STÈpbj1+Å‹¢e²Á™ Ê€Qx8@¡‡ÐÈç5\\Q¦,Œ‡¸Ä‰NëÝÞ˜b#Y½H¥¯p1›ÖÊøkB¨8NüoûX3,#UÚ©å'Ä\"†é”€ÂeeH#z›­q^rG[¸—:¿\r¸m‹ngòÜÌ·5½¥V]«ñ-(ÝWð¿0âëÑ~kh\\˜„ZŠå`ïél°êÄÜk ‚oÊjõWÐ!€.¯hFŠÔå[tÖA‡wê¿e¥Mà««¡3!¬µÍæ°nK_SF˜j©¿þ-S‚[rœÌ€wä´ø0^Áh„fü-´­ý°?‚›ýXø5—/±©Š€ëëIY ÅV7²a€d ‡8°bq·µbƒn\n1YRÇvT±õ•,ƒ+!Øýü¶NÀT£î2IÃß·ÄÄ÷„ÇòØ‡õ©K`K\"ð½ô£÷O)\nY­Ú4!}K¢^²êÂàD@á…÷naˆ\$@¦ ƒÆ\$AŠ”jÉËÇø\\‹D[=Ë	bHpùSOAG—ho!F@l„UËÝ`Xn\$\\˜Íˆ_†¢Ë˜`¶âHBÅÕ]ª2ü«¢\"z0i1‹\\”ÞÇÂÔwù.…fyÞ»K)£îíÂ‡¸ pÀ0ä¸XÂS>1	*,]’à\r\"ÿ¹<cQ±ñ\$t‹„qœ.‹ü	<ð¬ñ™Ž+t,©]Lò!È{€gŽüãX¤¶\$¤6v…˜ùÇ ¡Žš£%GÜHõ–ÄØœÈEŽ ÒXÃÈ*Á‚0ÛŠ)q¡nCØ)I›ûà\"µåÚÅÞíˆ³¬`„KFçÁ’@ïd»5Œê»AÈÉp€{“\\äÓÀpÉ¾Nòrì'£S(+5®ÐŠ+ \"´Ä€£U0ÆiËÜ›úæ!nMˆùbrKÀðä6Ãº¡r–ì¥â¬|aüÊÀˆ@Æx|®²kaÍ9WR4\"?5Ê¬pýÛ“•ñk„rÄ˜«¸¨ýß’ðæ¼7Â—Hp†‹5YpW®¼ØG#ÏrÊ¶AWD+`¬ä=Ê\"ø}Ï@HÑ\\Žp°“Ð€©ß‹Ì)C3Í!ŽsO:)Ùè_F/\r4éÀç<A¦…\nn /Tæ3f7P1«6ÓÄÙýOYÐ»Ï²‡¢óqì×;ìØÀæaýXtS<ã¼9Ânws²x@1ÎžxsÑ?¬ï3Åž@¹…×54„®oÜÈƒ0»ÞÐïpR\0Øà¦„†Îù·óâyqßÕL&S^:ÙÒQð>\\4OInƒZ“nçòvà3¸3ô+P¨…L(÷Ä”ð…Àà.x \$àÂ«Cå‡éCnªAžkçc:LÙ6¨ÍÂr³w›ÓÌh°½ÙÈnr³Zêã=è»=jÑ’˜³‡6}MŸGýu~3ùšÄbg4Åùôs6sóQé±#:¡3g~v3¼ó€¿<¡+Ï<ô³Òa}Ï§=Îe8£'n)ÓžcCÇzÑ‰4L=hýŒ{i´±Jç^~çƒÓwg‹Dà»jLÓéÏ^šœÒÁ=6Î§NÓ”êÅÁ¢\\éÛDóÆÑN”†êEý?hÃ:SÂ*>„ô+¡uúhhÒ…´W›E1j†x²Ÿôí´ŠtÖ'Îtà[ îwS²¸ê·9š¯Tö®[«,ÕjÒv“òÕîžt£¬A#T™¸Ôæž‚9ìèj‹K-õÒÞ ³¿¨Yèi‹Qe?®£4ÓžÓÁë_WzßÎéó‹@JkWYêhÎÖpu®­çj|z4×˜õ	èi˜ðm¢	àO5à\0>ç|ß9É×–«µè½ öëgVyÒÔu´»¨=}gs_ºãÔV¹sÕ®{çk¤@r×^—õÚ(ÝwÏ…øH'°Ýaì=i»ÖNÅ4µ¨‹ë_{Ï6ÇtÏ¨ÜöÏ—e [Ðh-¢“Ul?Jîƒ0O\0^ÛHlõ\0.±„Z‚’œ¼âÚxu€æð\"<	 /7ÁŠ¨Ú û‹ïi:Ò\nÇ ¡´à;íÇ!À3ÚÈÀ_0`ž\0H`ž€Â2\0€ŒHò#h€[¶P<í¦†‘×¢g¶Ü§m@~ï(þÕ\0ßµkâY»vÚæâ#>¥ù„\nz\n˜@ÌQñ\n(àGÝ\nöüàŽ'kóš¦èº5“n”5Û¨Ø@_`Ð‡_l€1Üþèwp¿Pî›w›ªÞ\0…ŽcµÐoEl{ÅÝ¾é7“»¼¶o0ÐÛÂôIbÏên‹zÛÊÞÎï·›¼ ‹ç{Ç8øwŽ=ëîŸ| /yê3aíß¼#xqŸÛØò¿»@ï÷kaà!ÿ\08dîmˆäR[wvÇ‹RGp8øŸ vñ\$Zü½¸mÈûtÜÞÝÀ¥·½íôºÜû·Ç½Ôîûu€oÝp÷`2ðãm|;#x»mñnç~;ËáVëE£ÂíØðÄü3OŸ\r¸,~o¿w[òáNêø}ºþ ›clyá¾ñ¸OÄÍÞñ;…œ?á~ì€^j\"ñWz¼:ß'xWÂÞ.ñ	Áu’(¸ÅÃäq—‹<gâçv¿hWq¿‰\\;ßŸ8¡Ã)M\\³š5vÚ·x=h¦iºb-ÀÞ|bÎðàpyŽDÐ•Hh\rceà˜y7·p®îxþÜG€@D=ð Öù§1Œÿ!4Ra\r¥9”!\0'ÊYŒŸ¥@>iS>æ€Ö¦Ÿo°óoòÎfsO 9 .íþéâ\"ÐF‚…ló20åðE!Qšá¦çËD9dÑBW4ƒ›\0û‚y`RoF>FÄa„‰0‘ùÊƒó0	À2ç<‚IÏP'\\ñçÈIÌ\0\$Ÿœ\n R aUÐ.‚sÐ„«æ\"ùŽš1Ð†…eºYç ¢„Zêqœñ1 |Ç÷#¯G!±P’P\0|‰HÇFnp>Wü:¢ž`YP%”ÄâŸ\nÈa8‰ÃP>‘ÁÁè–™`]‘‹4œ`<Ðr\0ùÃŽ›ç¨û¡–z–4Ù‡¥Ë8€ùÎÐ4ó`mãh:¢Îª¬HDªãÀjÏ+p>*ä‹ÃÄê8äŸÕ 08—A¸È:€À»Ñ´]wêÃºùz>9\n+¯ççÍÀñØ:Ž—°ii“PoG0°Öö1þ¬)ìŠZ°Ú–èn¤È’ì×eRÖ–Üí‡g£M¢à”ÀŒgs‰LC½rç8Ð€!°†À‚Œ3R)Îú0³0Œôs¨IéJˆVPpK\n|9e[á•ÖÇË‘²’D0¡Õ àz4Ï‘ªo¥Ôéáèà´,N8nåØsµ#{è“·z3ð>¸BSý\";Àe5VD0±¬š[\$7z0¬ºøÃËã=8þ	T 3÷»¨Q÷'R’±—’ØnÈ¼LÐyÅ‹ìö'£\0oäÛ,»‰\0:[}(’¢ƒ|×ú‡X†>xvqWá“?tBÒE1wG;ó!®Ý‹5Î€|Ç0¯»JI@¯¨#¢ˆÞuÅ†Iážø\\p8Û!'‚]ß®šl-€låSßBØð,Ó—·»ò]èñ¬1‡Ô•HöÿNÂ8%%¤	Å/;FGSôòôhé\\Ù„ÓcÔt²¡á2|ùWÚ\$tøÎ<ËhÝOŠ¬+#¦BêaN1ùç{ØÐyÊwòš°2\\Z&)½d°b'ž,XxmÃ~‚Hƒç@:d	>=-Ÿ¦lK¯ŒÜþJí€\0ŸÌÌó@€rÏ¥²@\"Œ(AÁñïªýZ¼7Åh>¥÷­½\\Íæú¨#>¬õø\0­ƒXrã—YøïYxÅæq=:žšÔ¹ó\rlŠoæm‡gbööÀ¿À˜ï„D_àTx·C³ß0.Šôy€†R]Ú_ÝëÇZñÇ»WöIàëGÔï	MÉª(®É|@\0SO¬ÈsÞ {î£”ˆø@k}äFXSÛb8àå=¾È_ŠÔ”¹l²\0å=ÈgÁÊ{ HÿÉyGüÕáÛ sœ_þJ\$hkúF¼q„àŸ÷¢Éd4Ï‰ø»æÖ'ø½>vÏ¬ !_7ùVq­Ó@1zë¤uSe…õjKdyuëÛÂS©.‚2Œ\"¯{úÌKþØË?˜s·ä¬Ë¦h’ßRíd‚é`:y—ÙåûGÚ¾\nQéý·Ùßow’„'öïhS—î>ñ©¶‰LÖX}ðˆe·§¸G¾â­@9ýãíŸˆüWÝ|íøÏ¹û@•_ˆ÷uZ=©‡,¸åÌ!}¥ÞÂ\0äI@ˆä#·¶\"±'ãY`¿Ò\\?Ìßpó·ê,Gú¯µý×œ_®±'åGúÿ²Ð	ŸT†‚#ûoŸÍH\rþ‡\"Êëúoã}§ò?¬þOé¼”7ç|'ÎÁ´=8³M±ñQ”yôaÈH€?±…ß®‡ ž³ÿ\0ÿ±öbUdè67þÁ¾I Oöäïû\"-¤2_ÿ0\rõ?øÿ«–ÿ hO×¿¶t\0\0002°~þÂ° 4²¢ÌK,“Öoh¼Î	Pc£ƒ·z`@ÚÀ\"îœâŒàÇH; ,=Ì 'S‚.bËÇS„¾øàCc—ƒêìšŒ¡R,~ƒñXŠ@ '…œ8Z0„&í(np<pÈ£ð32(ü«.@R3ºÐ@^\r¸+Ð@ , öò\$	ÏŸ¸„E’ƒèt«B,²¯¤âª€Ê°h\r£><6]#ø¥ƒ;‚íC÷.ÒŽ€¢ËÐ8»Pð3þ°;@æªL,+>½‰p(#Ð-†f1Äz°Áª,8»ß ÆÆPà:9ÀŒï·RðÛ³¯ƒ¹†)e\0Ú¢R²°!µ\nr{Æîe™ÒøÎGA@*ÛÊnDöŠ6ÁŽ»ðòóíN¸\rŽR™Ôø8QK²0»àé¢½®À>PN°Ü©IQ=r<á;&À°fÁNGJ;ðUAžõÜ¦×A–P€&žþõØã`©ÁüÀ€);‰ø!Ðs\0î£Áp†p\r‹¶à‹¾n(ø•@…%&	S²dY«ÞìïuCÚ,¥º8O˜#ÏÁ„óòoªšêRè¬v,€¯#è¯|7Ù\"Cp‰ƒ¡Bô`ìj¦X3«~ïŠ„RÐ@¤ÂvÂø¨£À9B#˜¹ @\nð0—>Tíõá‘À-€5„ˆ/¡=è€ ¾‚ÝE¯ž—Ç\nç“Âˆd\"!‚;ÞÄp*n¬¼Z²\08/ŒjX°\r¨>F	PÏe>À•OŸ¢LÄ¯¡¬O0³\0Ù)kÀÂºã¦ƒ[	ÀÈÏ³Âêœ'L€Ù	Ãåñƒ‚é›1 1\0ø¡Cë 1Tº`©„¾ìRÊz¼Äš£îÒp®¢°ÁÜ¶ìÀ< .£>î¨5ŽÝ\0ä»¹>Ÿ BnËŠ<\"he•>ÐººÃ®£çsõ!ºHý{Ü‘!\rÐ\rÀ\"¬ä| ‰>Rš1dàö÷\"U@ÈD6ÐåÁ¢3£çðŸ>o\r³çá¿vžL:K„2å+Æ0ì¾€>°È\0äí ®‚·Bé{!r*Hî¹§’y;®`8\0ÈËØ¯ô½dþ³ûé\rÃ0ÿÍÀ2AþÀ£î¼?°õ+û\0ÛÃ…\0AŽ¯ŽƒwSû‡lÁ²¿°\r[Ô¡ª6ôcoƒ=¶ü¼ˆ0§z/J+ê†ŒøW[·¬~C0‹ùeü30HQP÷DPY“}‡4#YDö…ºp)	º|û@Ž¥&ã-À†/F˜	á‰T˜	­«„¦aH5‘#ƒëH.ƒA>Ðð0;.¬­þY“Ä¡	Ã*ûD2 =3·	pBnuDw\n€!ÄzûCQ \0ØÌHQ4DË*Žñ7\0‡JÄñ%Ä±pŽuD (ôO=!°>®u,7»ù1†ãTMŽ+—3ù1:\"P¸Ä÷”RQ?¿“üP°Š¼+ù11= ŒM\$ZÄ×lT7Å,Nq%E!ÌS±2Å&öŒU*>GDS&¼ªéó›ozh8881\\:ÑØZ0hŠÁÈT •C+#Ê±A%¤¤D!\0ØïòñÁXDAÀ3\0•!\\í#h¼ªí9bÏ‚T€!dª—ˆÏÄY‘j2ôSëÈÅÊ\nA+Í½¤šHÈwD`íŠ(AB*÷ª+%ÕEï¬X.Ë Bé#ºƒÈ¿Œ¸&ÙÄXe„EoŸ\"×è|©r¼ª8ÄW€2‘@8Daï|ƒ‚ø÷‘Š”Núhô¥ÊJ8[¬Û³öÂö®WzØ{Z\"L\0¶\0ž€È†8ØxŒÛ¶X@”À E£Íïë‘h;¿af˜¼1Âþ;nÃÎhZ3¨E™Â«†0|¼ ì˜‘­öAà’£tB,~ôŠW£8^»Ç ×ƒ‚õ<2/	º8¢+´¨Û”‚O+ %P#Î®\n?»ß‰?½þeË”ÁO\\]Ò7(#û©DÛ¾(!c) NöˆºÑMF”E£#DXîgï)¾0Aª\0€:ÜrBÆ×``  ÚèQ’³H>!\rB‡¨\0€‰V%ce¡HFH×ñ¤m2€B¨2IêµÄÙë`#ú˜ØD>¬ø³n\n:LŒýÉ9CñÊ˜0ãë\0“x(Þ©(\nþ€¦ºLÀ\"GŠ\n@éø`[Ãó€Š˜\ni'\0œð)ˆù€‚¼y)&¤Ÿ(p\0€Nˆ	À\"€®N:8±é.\r!'4|×œ~¬ç§ÜÙÊ€ê´·\"…cúÇDlt‘Ó¨Ÿ0c«Å5kQQ×¨+‹ZŽGkê!F€„cÍ4ˆÓRx@ƒ&>z=Ž¹\$(?óŸïÂ(\nì€¨>à	ëÒµ‚ÔéCqÛŒ¼Œt-}ÇG,tòGW ’xqÛHf«b\0ž\0zÕìƒÁT9zwÐ…¢Dmn'îccb H\0z…‰ñ3¹!¼€ÑÔÅ HóÚHz×€Iy\",ƒ- \0Û\"<†2ˆî Ð'’#H`†d-µ#clŽjÄž`³­i(º_¤ÈdgÈŽíÇ‚*Ój\rª\0ò>Â 6¶ºà6É2ókjã·<ÚCq‘Ð9àÄ†ÉI\r\$C’AI\$x\r’H¶È7Ê8 Ü€Z²pZrR£òà‚_²U\0äl\r‚®IRXi\0<²äÄÌr…~xÃS¬é%™Ò^“%j@^ÆôT3…3É€GH±z€ñ&\$˜(…Éq\0Œšf&8+Å\rÉ—%ì–2hCüx™¥ÕI½šlbÉ€’(hòSƒY&àBªÀŒ•’`”f•òxÉv n.L+þ›/\"=I 0«d¼\$4¨7rŒæ¼A£„õ(4 2gJ(D˜á=F„¡â´Èå(«‚û-'Ä òXGô29Z=˜’Ê,ÊÀr`);x\"Éä8;²–>û&…¡„ó',—@¢¤2Ãpl²—ä:0ÃlI¡¨\rrœJDˆÀúÊ»°±’hAÈz22pÎ`O2hˆ±8H‚´Ä„wt˜BF²Œg`7ÉÂä¥2{‘,Kl£ð›Œß°%C%úomû€¾àÀ’´ƒ‘+X£íûÊ41ò¹¸Ž\nÈ2pŠÒ	ZB!ò=VÆÜ¨èÈ€Ø+H6²ÃÊ*èª\0ækÕà—%<² øK',3ØrÄI ;¥ 8\0Z°+EÜ­Ò`Ðˆ²½Êã+l¯ÈÏËW+¨YÒµ-t­fËb¡Qò·Ë_-Ó€Þ…§+„· 95ŠLjJ.GÊ©,\\·òÔ….\$¯2ØJè\\„- À1ÿ-c¨²‚Ë‡.l·fŒxBqK°,d·èË€â8äA¹Ko-ô¸²îÃæ²°3KÆ¯r¾¸/|¬ÊËå/\\¸r¾Ëñ,¡HÏ¤¸!ðYÀ1¹0¤@­.Â„&|˜ÿËâ+ÀéJ\0ç0P3JÍ-ZQ³	»\r&„‘Ãá\nÒLÑ*ÀËÞj‘Ä‰|—ÒåËæ#Ô¾ª\"Ëº“AÊï/ä¹òû8)1#ï7\$\"È6\n>\nô¢Ã7L1à‹òh9Î\0B€Z»d˜#©b:\0+A¹¾©22ÁÓ'Ì•\nt ’ÄÌœÉOÄç2lÊ³.L¢”HC\0™é2 ó+L¢\\¼™r´Kk+¼¹³Ë³.êŒ’êº;(DÆ€¢Êù1s€ÕÌòdÏs9Ìú•¼ P4ÊìŒœÏó@‹.ìÄáAäÅnhJß1²3óKõ0„Ñ3J\$\0ìÒ2íLk3ãˆáQÍ;3”Ñn\0\0Ä,ÔsIÍ@Œûu/VAÅ1œµ³UMâ<ÆLe4DÖ2þÍV¢% ¨Ap\nÈ¬2ÉÍ35ØòÐA-´“TÍu5š3òÛ¹1+fL~ä\nô°ƒ	„õ->£° ÖÒ¡M—4XLóS†õdÙ²ÖÍŸ*\\Ú@Í¨€˜YÓk¤Š¤ÛSDM»5 Xf° ¬ªD³s¤äÀUs%	«Ì±p+Ké6ÄÞ/ÍÔüÝ’ñ8XäÞ‚=K»6pHà†’ñ%è3ƒÍ«7lØI£K0ú¤ÉLíÎD»³uƒêõ`±½P\rüÙSOÍ™&(;³L@Œ£ÏˆN>Sü¸2€Ë8(ü³Ò`J®E°€r­F	2üåSE‰”M’†MÈá\$qÎE¶Ÿ\$ÔÃ£/I\$\\“ãáIDå\" †\nä±º½w.tÏS	€æ„Ñ’Pðò#\nWÆõ-\0CÒµÎ:jœRíÍ^Süí„Å8;dì`”£ò5ÔªaÊ–ÇôE¹+(XröMë;Œì3±;´•ó¼B,Œ˜*1&î“ÃÎË2XåS¼ˆõ)<Í ­L9;òRSN¼Þ£ÁgIs+ÜëÓ°Kƒ<¬ñsµLY-Z’:A<áÓÂOO*œõ2vÏW7¹¹+|ô €Ë»<TÖóÕ9 h’“²Ïy\$<ôÎ#Ï;ÔöÓá›v±\$öOé\0­ ¬,Hkòü-äõàÏš\rÜú²ŸÏ£;„”¹O•>ìù“·Ë7>´§3@O{.4öpO½?TübÃÏË.ë.~O…4ôÏSïÏì>1SS€Ï*4¶PÈ£ó>ü·ÁÏï3í\0ÒWÏ>´ô2å><ëóßP?4€Û@Œôt\nNÀÇùAŒxpÜû%=P@ÅÒCÏ@…RÇËŸ?x°ó\n˜´Œ0NòwÐO?ÕTJC@õÎ#„	.dþ“·MêÌt¯&=¹\\ä4èÄAÈå:L“¥€í\$ÜéÒNƒ­:Œ’\rÎÉI'Å²–AÕráŒ;\r /€ñCôÈåBåÓ®Œi>LèŠ7:9¡¡€ö|©C\$ÊË)Ñù¡­¹z@´tlÇ:>€úCê\n²Bi0GÚ,\0±FD%p)o\0Š°©ƒ\n>ˆú`)QZIéKGÚ%M\0#\0DÐ ¦Q.Hà'\$ÍE\n «\$Ü%4IÑD°3o¢:LÀ\$£Îm ±ƒ0¨	ÔB£\\(Ž«¨8üÃé€š…hÌ«D½ÔCÑsDX4TK€¦Œ{ö£xì`\n€,…¼\nE£ê:Òp\nÀ'€–> ê¡o\0¬“ýtIÆ` -\0‹D½À/€®KPú`/¤êøH×\$\n=‰€†>´U÷FP0£ëÈUG}4B\$?EýÛÑž%”T€WD} *©H0ûT„\0tõ´†‚ÂØ\"!o\0Eâ7±ïR.“€útfRFu!ÔDð\nï\0‡F-4V€QHÅ%4„Ñ0uN\0ŸDõQRuEà	)ÍI\n &Q“m€)Çš’m ‰#\\˜“ÒD½À(\$Ì“x4€€WFM&ÔœR5Hå%qåÒ[F…+ÈùÑIF \nT«R3DºLÁo°Œ¼y4TQ/E´[Ñž<­t^ÒËFü )Qˆå+4°Q—IÕ#´½‰IF'TiÑªXÿÀ!Ñ±FÐ*ÔnRÊ>ª5ÔpÑÇKm+ÔsÇÜ û£ïÒáIåôŸREý+Ô©¤ÙM\0ûÀ(R°?+HÒ€¥Jí\"TÃDˆª\$˜Œà	4wQà}Tz\0‹Gµ8|ÒxçÍ©R¢õ6ÀRæ	4XR6\nµ4yÑmNôãQ÷NMà&RÓH&É2Q/ª7#èÒ›Ü{©'ÒÒ,|”’ÇÎ\n°	.·\0˜>Ô{Áo#1D…;ÀÂÐ?Uô‘Ò•Jò9€*€š¸j”ý€¯F’N¨ÒÑ‰Jõ #Ñ~%-?CôÇßL¨3Õ@EP´{`>QÆÈ”µÔ%Oí)4ïR%IŠ@Ôô%,\"ÕÓùIÕ<‘ëÓÏå\$Ô‰TP>Ð\nµ\0QP5DÿÓkOFÕTYµ<ÁoýQ…=T‰\0¬“x	5©D¥,Â0?ÍiÎ?xþ  ºmE}>Î|¤ÀŒÀ[Èç\0žŽ€•&RL€ú”H«S9•G›I›§1ä€–Ž…M4V­HþoT-S)QãGÇF [ÃùTQRjN±ã#x]N(ÌU8\nuU\n?5,TmÔž?Ðÿ’Ü?€þ@ÂU\nµu-€‹Rê9ãðU/S \nU3­IEStQYJu.µQÒõF´o\$&ŒÀûi	ÜKPCó6Â>å5µG\0uR€ÿu)U'R¨0”Ð€¡DuIU…J@	Ô÷:åV8*ÕRf%&µ\\¿RÈõMU9RøüfUAU[T°UQSe[¤µ\0KeZUa‚­UhúµmS<»®À,Rès¨`&Tj@ˆçGÇ!\\xô^£0>¨þ\0&ÀpÿÎ‚Q¿Q)T˜UåPs®@%\0ŸW€	`\$Ôò(1éQ?Õ\$CïQp\nµOÔJ¹ñX#ƒýV7Xu;Ö!YBî°ÓSåcþÑ+V£ÎÃñ#MUÕW•HÍUýR²Ç…U-+ôðVmY}\\õ€ÈOK¥Mƒì\$ÉSíeToV„ŒÍHTùÑ!!<{´RÓÍZA5œRÁ!=3U™¤(’{@*Ratz\0)QƒP5HØÒ“ÎÕ°­N5+•–ÏP[Ôí9óV%\"µ²ÖØ\n°ýñäG•SL•µÔò9”ùÇÌë•lÀ£ˆ‘\rVˆØ¤Í[•ouºUIY…R_T©Y­p5OÖ§\\q`«U×[ÕBu'Uw\\mRUÇÔ­\\Es5ÓK\\úƒïVÉ\\ÅS•{×AZ%Oõ¼\$Ü¥FµÔ¬>ý5E×WVm`õ€Wd]& \$ÑÎŒÅ•ÛÓ!R¥Z}Ô…]}v5À€§ZUgôÔQ^y` Ñ!^=F•áRÁ^¥vëUÅKex@+¤Þr5À#×@?=”uÎ“s •¤×¥YšNµsS!^c5ð\$.“u`µÜ\0«XE~1ï9Ò…JóUZ¢@²#1_[­4JÒ2à\nà\$VI²4n»\0˜?ò4aªRç!U~)&ÓòB>t’RßIÕ0ÀÔ_EkTUSØœ|µýUk_Â8€&€›E°ü(â€˜?â@õ××JÒ5Ò½JU†BQT}HVÖ‘j€¤Qx\neÖVsU=ƒÔýV‘N¢4Õ²Ø—\\xèÒÖïR34ÝG¿D\":	KQþ>˜[Õ\rÕY_å#!ª#][j<6Ø®X	¨ìÍc‰•Ø#KL}>`'\0Ž¨5”XÑcU[\0õ(ÔÙÑWt|tô€R]pÀ/£]H2I€QO‹­1âS©Qj•Z€¨¸´Hº´m¨ÌÙ)dµ^SXCY\rtu@Jëpüµ%ÓÿM¸ø€¨óµ“Ö?ÙUQ°\nö=Råar:Ô¿Eí‘À¥-G€\0\$ÑÇd½“ö]Òmeh*ÃìQ‰Wt„öc€¡`•˜AªY=S\r®¯«	m-´‚¤=MwÖH£]Jå\"ä´Ä õþ­fõ\"´{#9Teœ‰ÙÍMÔc¹ñNêI£òÙßD¥œõÙÜçUœ6ÙñgÑ2Ù×Ý¶eƒa­L´€Q&&uTåX51Y >£óûSýÖŠQ#êIµ¥Õj\0ûœ£ÅW PÑþ?ub5FUóLn¶)V5R¢@ãë\$!%o¶ÔPúÉ'€‰EµUÁÔP-†¶š¤Bp\nµF\$ŸS4…t±UF|{–qÖÈ“0û•ÎUmjsÎÃü€²øý\$´Ú›j…cëÚå¦Ö«€¿aZI5X€ƒj26®¤&>vŽÑ\n\r)2Õ_kîG¶®TJÚÁeQ-cîZñVM­Ö½£z>õ]•a¹c£Ëcìß`t„”HÚÑjÝ6¹£+kŠM–\0Œ>Œ„€##3l=à'´¥^6Í\0¨Ã¨v¦Z9Se£€\"×ÊêbÎ¡ÔB>)•/TÁ=ö9\0ù`Pà\$\0¿]í/0Úª•«äµ½k-š6ÝÛ{küÖá[F\r|´SÑ¿J¥õMQ¿D=õ/ÈWX¢öœV—a¬'¶¹éa¨to€©lå†¶ÐXj}C@\"ÀKPÛÎÖÚom’3\0#HV”µ…v÷Ñ~“{žµÖ?gx	n|[Ø?U¶äµ[rê½h¶ÞG¸`õ3#Gk%L£ê\0¿I`CùDÞê¸	 \"\0ˆŒÅ§¶°#cN«6ßÚ¹fÂÔzÛŽêº;Ñ¤ÃeeF–7Ù/N\r:ôâQñGÕ9	\$ÔóIøÕ¼ºß]£®TÝØWGs«ÔdWõMÚIãèÑÙf’BcêÛ¤êõÂ÷!#cnu&(ÞSã_Õw£ùSfë&TšZ:…0CóSÙLN`Ü³Yj=·¶>Å²ÃñZ!=€rV]gû	Ó£rµ ËXlŒÉ-.¹UÄ'uJuJ\0ƒs­J¶'W%·¶­\\>?òBöëV­j4µÏJ}I/-ÒrRLºSè3\0,RgqÓ­ôÇTf>Ý1Õï\0¥_•”Ç\\V8õ¡ZÛt…Ácè€†ú<^\\ùll´j\0¾˜þT¥]CÝÔw×Î“zI¶ÙZwN…¶¶pVW…jv»Y¶>2Ó	o\$|U‡WÃL%{toX3_õ¶òR‰J5~6\"×ãZl}´`Ôkc­ÑîÛeR=^UÔŽ•¥1òÑ½w7eØdµÝvŽÙb=á\0ùf €,³må)ÕéGpûÕ-Ó¼½)9Lý“š>|Ôë \"Ì@èû¤5§`†:›ô\0é,€ñt@ºÄxº“òlÃJÈŽ»b¨6 à…½‰ÝaŽÞA\0Ø»ARì[A»Ã0\$qo—AàÊSÒü@Ìø¬<@ÓyÄÐ\"as.âÎä÷V^„•è®¥^õ›…—œ\0ÜÈHÁ·[H@’bK—©Þ)zÀ\r·¨¤¤=éÁ^¿zˆB\0º¿’¤äNéo<Ì‡t<xî£\0Ú¬0*R ºI{¥í®´^æEµî·¸:{KÕ§1Eˆ0²ÓYº•›à/ÕÑcêÀ\"\0„ê¸4øÉF7'€†˜\nÕ0ÝÉ`U£Tù¤?MPÔÀÓlµÈ4ŒÓr(	´ÁZ¿|„€&†©t\"Iµ¿ÖÛL w+Òm}…§÷€Wi\r>ÖU__uÅ÷63ßy[¢8µT-÷ÙVÏ}¤xãô_~è%ø7Ùß{jMáo_šEù÷ØÓë~]ôP\$ßJõCaXGŠ9„\0007Åƒ5óA#á\0.‹Àä\rË´Žž_Ö¢áÀßÚ%þáÀÀ\n€\r#<MÅxØJËù±|¸Ø2ð\0¨–;oŒ^a+F€í¸Îç¬€LkúÁ;À_ÛÝê#€¾M\\“¬€¤pr@ä“ÃµÆÔøÂþOR€¿ñ–~zÇûAÁNE°YÁO	(1N×‰ˆRø¨8Ø€C¼Ž¦ë¨Én?O)ƒ¶1AçDo\0ä\r»Ç¢?àkJâî‘“„\"â,ŽOFÈÌa…›ùª-bà6]PSø)Æ™ 5xCâ=@j°€ÇL”ÁèÈLî˜:\"èƒ»ÎŠ¤l#¢ÀéBèk£“ˆ›ž€ÖË@ •Nº:ê>ï|BéžŽ9î	«Èî”:Nýñ\$èéS¥ CB:j6î—Þé•àÎ‰Jk”†uKð_W›Í¢Ã˜I =@TvãÒ\n0^o…\\¿Ó ?/Á‡&uê.ÞØ_˜æ\r®î¥Cæì+Úøc†~±J¸b†6ÓüØe\0ÍyóÑ¡\0wxêhÁ8j%S›À–VH@N'\\Û¯‡ÆN¥`n\r‹ÒuÞn‰KèqUÃBé+í˜f>G‡°\r¸»ˆ=@G¤Åädç‚†\nã)¬ÐFOÅ hÊ·›†ÃˆfC‡É…X|˜‡I…]æð3auyàUi^â9yÖ\no^rt\r8ÀÍ‡#óîØâN	VÈâY†;Êc*â%Và<›‰#Øh9r \rxcâv(\raŸá¨æ(xja¡`g¸0çVÌ¼°Œ¿Q†©x(ÇëƒÀglÕ°{—Ægh`sW<Kj°'¿;)°Gnq\$¨pæ+ÎÉŒ_ŠÉdø¶^& ¯Š˜DÂxà!bèvÞ!EjPV¤' ââÁ(”=ÏbÂ\rˆ\"–b¦ÝL¼\0€¿Ìbtá‚\n>J¬Ôã1;üù¼ÖîÛˆ¿4^s¨QÁp`Öfr`7‚ˆ«xª»E<lÑÏã	8sþ¯'PT°øÖºæËƒ¸°z_ÊT[>Ð€:Ïó`³1.î¾°;7ó@[ÑÞ>ºž6!¡*\$`²•\0À„æ`,€“øÇàÝÁ@°àáå?Ìm˜>ƒ>\0êLCÇ¸ñˆR¸În™°/+½`;CŠ£Õø\0ê½*€<F“„ö+ëƒâ„q MŒÁþ;1ºK\nÀ:b3j1™Ôl–:c>áYøhôìžÞŽ¾#Ô;ã´Ü3Öº”8à5Ç:ï\\Þï¨\0XH·Â…¶«aþŽ®¸™M1ä\\æL[YC…£vN’·\0+\0Ôät#ø\$¬ÆØØà!@*©l¦„	F»dhdÝýùF›‘à&˜˜Æ˜fó¹)=˜¦0¡ 4…x\0004ED6KÍòä¢£±…”\0ònN¨];qº4sj-Ê=-8½ê†\0æsÇ¨ûˆ¹D§f5p4Œàé©Jè^Öí’'Ó”[úùH^·NR F˜Kw¼z¢Ò ÜÐE”º“ágF|!Èc©ôäo•dbÁêùxß\0ì-åà6ß,Eí„_†íê3uåp ÇÂ/åwz¨( ØexžRaºH¼YùceŠš5ê9d\0ó–0@2@ÒÖYùfey–ŽYÙcM×•ºhÙÃ•Ö[¹ez\rv\\0Áeƒ•ö\\¹cÊƒ†î[Ùue“—NY`•åÛ–Î]9hå§—~^Yqe±–¦]™qe_|6!ŽÞóuï`ŽfÕî™Jæ{è7¸ºM{¶YÙ‡©øj‚eÆÌC»¢S6\0DuasFL}º\$È‡à(å”Mb…ÈàÆ¤,0BuÎ¯…ì¥Ñ‚2ögxFÑ™{a¸n:i\rPjýeÏñ˜rÈrØÏGýBY ˆM+qïçiY”dË™é`0ŽÀ,>6®foš0ù©†o™ó æXf¢äù\0ÀVÝL!“«f…†láœ6 Å/ëæ£1eƒ•\0‰>kbfé\r˜!ïufò<%ä(rË›ùa&	ý™¨àY€Þ!¡Òñ–mBg=@ƒÐ\rç; \rÞ5phI 9bm›\$BYË‹ÿšÄgxç#‰@QEOÇæm9–®Ë0\"€ºç!t¨˜ê†Ë‰¸®Ð‡çO* Ååÿ\0ÂÝ>%Ö\$éoîrN&s9¿f£ž4çù™gŠä~jMùf›wyèg›yí\\`X1y5xÿŒùž^zï_,& kÑæ¢é|¡€À¦1xçÏA‘6ð \nîoè”»Œ&xÙïgg™{r…?ç·›ü-°½…®|tä3±šˆÈÍ}gHgK¢9¿¿¨õJÀ<C C° 1„î9þ7‡g÷š‚ïh6!0Hâí›cdy´fÿ¡DA;ƒ‚9…Tæ¢ÿ®0¬Ä\0ÆpØàù†!‡ 6^ã.øSÂ²?ÆØ¦E(P­Îˆ .æÂ 5€ÄhŠéˆEPJv‰ .‹•¢+—\$ç5Œ>P+µ?~‰¡gŒ6\r³öh¢¼p«z(è†WÙÄ`Â•¨±\"y¯ñÏ:ÐFadÅ¬6:ù¡f˜Þi\0ì˜ÝØàA;áe¢°àì¬ç^ÊÖwf„ >yÍŽŠËõ`-\rŠÚ…á\0­hr\rÎr£8i\"_Ú	££¼9¡CI¹fXËˆ2¦‰š\"ÍÅ¢‰… øh¢L~Š\"ö…š%V•:!%Šžxyèizyg„vxÚ]‚žÆ}qgžÄÃZiŒä|Œ`Ç+ _úgèòú†™Ù£¾úªÂÀÂè­ž6PA€Ê€\$¶=9¢ŒùàÍh‹¢|p’ ÿ¢ˆé˜íè!¢Ž.ø!”þ¶žüiç§^œøÚiË¢Ž8zVCÌùöŒZ\"€æäØ(Ä¥›¹°9èU)û¥!DgU\0Ãjÿã¿?`Çð4ãLTo@•B¤§úN†aš{Ãrç:\nÌŸ“E„»8Ã¦&=êE¨*Z:\n?˜¨g¢èÌŠ£‹h¢õ.•˜’ Nþ5(ˆSƒhÑôi2Ö*c„fý@•“ÑÞ7¦œz\"áƒ|ÖúrP†.Ç€ÊL8T'¿¸k¢ˆß:(¹q2&œÆED±2~žÿ¿Ø±þœŒ¬Ã9ûÒÂv£©¼8ÿƒ©– @úé^X=X`ªqZºÐQ«Ö®`9jø5^ˆ¹å@ç«¸În¼qvž±á¨3±ÚÇèŠ(I6ðªjšdT±ÚÂ\\Š ‚Ÿ3¢,™Ïhék¢3ú(ë3¬‘‘PÒu•VÏ|\0ï§†Uâk;¢ÌJQ¶ã é. Ú	:J\rŽŠ1ŸênìBI\r\0É¬h@˜¼?ÒN±\nsh—®å\"ë’ò;¦r~7O§\$ ú(ã5¤RÅèÆ	èÊ½jÂîšØFYF šÜ”£«~‰xÞ¾©f º\"ã†vÛ“ošëË¨ººÂº#ŒÜaÒèŠõ¶®P“„Ë<ãáh£-3éº/Gx®õ²nÇi@\"’G…?ó¤,ïZpÖxX`v¦4XÆõóàû„[ƒI¶œ7žÃ¥Xc	îÅ!¡bç¢}ÚjŒ_¾¥9á5qti¦6f»ž’°¸ÝÙž5ÿûç FÆ¹ãiÑ±©pX'ø2¡Žrƒ„®0ÆÆºé§D,#GëU2€ÌØâIè\rl(£— €ì±£¦¨=ÐA¸a€ì©³-8›dbSþˆûõ4~‚ô—H;°Â­0à6Çbé{ª„ÞºRæèÃs3zë¯ÃÀüNðÞ„Ž`ÆË†+ò¦­ 4<ø^aƒy°¬”	}r°Âây´õãáû¸kŒ&4@ˆÁ?~ÔäÅcE´ÂÈ­@ˆLS@€Œéz^qqN¦°</H‚j^sCâ`èæsbgGy¹¤Ö^\nÈNó\n:G¶N}¼c\nîÚÕí¤ +£†ï=†pÙ1º’NµTB[dÀÿ¶–š¶Ð‹¢¾Ü¹ñ`³nÚoj;žjÄ›whØõž€c9ƒ‚pÌ¡[y4«¨¶05œÍ‹NßÁ+Î¿·Ð`Xdaáæ/zn*öPÀ‡êÁ¸#tíèµ¸~à9Wî	šVâò~=¸#Ùùn)¨î´î	2ÜÉ;…j:õ°Ják„C¸!>xîù5š£==¦2»—‚. ã|¿'¨îä[€Ì'—;üÚv½ù«–“¸„®÷ÎëÎ;:SA	º&Ð[£me†êãn±ëúûªî™«Ëµ¦Ä•<Ÿº6ma‘=Y.ç¥žÀÅ:g¶ÔþÉè…€ù°žÐ;«Iß»xÅ[”éI¡J\0÷~ÂzaY®íºîüwT\\`–íV\nÆ~P)ézJ¾©æ½üñðQ@Ýà[¶{rÊ‰µDîB„v—ï|i-¹EæøKŒ;^n»{êó½å:Nh;–—Ú2Á¨Æ€pçÑ´6“úƒ»ç½˜9§9¡¥öÖXÂhQœ~—ÛÛiAŸ@D šj‡¥î}ÑozLV÷ïçÑ³~ù•ž	8B?â#F}F¾Td­ë»áÐe±ÃzcîçŸFÅÀŠg‚7Î—Ûêà€ 6ý#.EÂ£¼áÀÖÂ£¥ðS£.J3¥ö5»¯KÉ¥óJ™§¸;¤—„n5¾¾:ySï‘ÀCÛvoÕ½.˜{ñð	d\\0ë?W\0!)ð'šû¼èEgá;à+»\0üY NtŽbp+À†cŒø“þ£\0©B=\"ùc†Tñ:Bœ±Áž¤úcðïˆþîÆï¸P‘IÜÈD¸ÂV0ÊÇ!ROl‰O˜N~aFþ|%Éßº³¸¬…ò)Où¿	Wìo´û‡Qðw¨È:ÙŸlé0h@:ƒ«ÀÖ…8îQ£&™[Ànç¹FïÛp,Ã¦å@‡ºJTöw°9½„(þ†œ<é{ÃÆO\rñ	¥àùÚ‚\$m…/HnP\$o^®U¡Ì\"»¿ã{Ä–…<.îç¡‹n¥q8\rÕ\0;³n£ÄÞÔÛðç¡Ÿˆ+ÎÞ³3¢¼n{ÃD\$7¬,Ez7\0…“l!{˜é8÷á¶xÒ‚°.s8‡PA¹FxÛrðÄÓôQÛ®€¹†1Ì…¸p+@ØdÔÞ9OP5¼lKÂ/¾‘·¾˜\\mæú¸Äs‡q» îvºQí/§ÿÜ	„!»¶åz¼7¾oœ¿EÇ†Ò:qàV 5˜?G¡HO®âO†\$ül¾š+â,òœ\r;ãç°¾¤’~ÎAÄéŒ³é{È`7|‡ÿÄ‚Äàër'‰°Ji\rc+¢|—#+<&Ò›¹<W,Ã>¢»^òPð&nÂJhÐe‡%d¶æìèÏÜCƒi¶zXÃAÿ'DÍ>ÉÎˆ¡Ek£Ê¬@©Bòw(€.–¾\n99Aê¯hNæcîkN¾d`£ÐÂp`Âò°%2ö¦½\0");
    } else {
        header("Content-Type: image/gif");
        switch ($_GET["file"]) {
            case "plus.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";
                break;
            case "cross.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";
                break;
            case "up.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôža8ŠyšaÅ¶®\0Çò\0;";
                break;
            case "down.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wþ\\¢ÇL&ÙœÆ¶•\0Çò\0;";
                break;
            case "arrow.gif":
                echo "GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹ž”ªÓ²Þ»\0\0;";
                break;
        }
    }
    exit;
}
if ($_GET["script"] == "version") {
    $p = file_open_lock(get_temp_dir() . "/adminer.version");
    if ($p)
        file_write_unlock($p, serialize(array(
            "signature" => $_POST["signature"],
            "version" => $_POST["version"]
        )));
    exit;
}
global $b, $e, $j, $Kb, $Rb, $bc, $k, $Fc, $Jc, $ba, $cd, $y, $ca, $sd, $oe, $Te, $jg, $Oc, $T, $Rg, $Xg, $eh, $ga;
if (!$_SERVER["REQUEST_URI"])
    $_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "")
    $_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
if ($_SERVER["HTTP_X_FORWARDED_PREFIX"])
    $_SERVER["REQUEST_URI"] = $_SERVER["HTTP_X_FORWARDED_PREFIX"] . $_SERVER["REQUEST_URI"];
$ba = ($_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off")) || ini_bool("session.cookie_secure");
@ini_set("session.use_trans_sid", false);
if (!defined("SID")) {
    session_cache_limiter("");
    session_name("adminer_sid");
    $Je = array(
        0,
        preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]),
        "",
        $ba
    );
    if (version_compare(PHP_VERSION, '5.2.0') >= 0)
        $Je[] = true;
    call_user_func_array('session_set_cookie_params', $Je);
    session_start();
}
remove_slashes(array(
    &$_GET,
    &$_POST,
    &$_COOKIE
), $wc);
if (function_exists("get_magic_quotes_runtime") && get_magic_quotes_runtime())
    set_magic_quotes_runtime(false);
@set_time_limit(0);
@ini_set("zend.ze1_compatibility_mode", false);
@ini_set("precision", 15);
function get_lang()
{
    return 'en';
}
function lang($Qg, $fe = null)
{
    if (is_array($Qg)) {
        $We = ($fe == 1 ? 0 : 1);
        $Qg = $Qg[$We];
    }
    $Qg = str_replace("%d", "%s", $Qg);
    $fe = format_number($fe);
    return sprintf($Qg, $fe);
}
if (extension_loaded('pdo')) {
    class Min_PDO
    {
        var $_result, $server_info, $affected_rows, $errno, $error, $pdo;
        function __construct()
        {
            global $b;
            $We = array_search("SQL", $b->operators);
            if ($We !== false)
                unset($b->operators[$We]);
        }
        function dsn($Ob, $V, $G, $ue = array())
        {
            $ue[PDO::ATTR_ERRMODE]         = PDO::ERRMODE_SILENT;
            $ue[PDO::ATTR_STATEMENT_CLASS] = array(
                'Min_PDOStatement'
            );
            try {
                $this->pdo = new PDO($Ob, $V, $G, $ue);
            }
            catch (Exception $hc) {
                auth_error(h($hc->getMessage()));
            }
            $this->server_info = @$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        }
        function quote($ig)
        {
            return $this->pdo->quote($ig);
        }
        function query($I, $Yg = false)
        {
            $J           = $this->pdo->query($I);
            $this->error = "";
            if (!$J) {
                list(, $this->errno, $this->error) = $this->pdo->errorInfo();
                if (!$this->error)
                    $this->error = 'Unknown error.';
                return false;
            }
            $this->store_result($J);
            return $J;
        }
        function multi_query($I)
        {
            return $this->_result = $this->query($I);
        }
        function store_result($J = null)
        {
            if (!$J) {
                $J = $this->_result;
                if (!$J)
                    return false;
            }
            if ($J->columnCount()) {
                $J->num_rows = $J->rowCount();
                return $J;
            }
            $this->affected_rows = $J->rowCount();
            return true;
        }
        function next_result()
        {
            if (!$this->_result)
                return false;
            $this->_result->_offset = 0;
            return @$this->_result->nextRowset();
        }
        function result($I, $l = 0)
        {
            $J = $this->query($I);
            if (!$J)
                return false;
            $L = $J->fetch();
            return $L[$l];
        }
    }
    class Min_PDOStatement extends PDOStatement
    {
        var $_offset = 0, $num_rows;
        function fetch_assoc()
        {
            return $this->fetch(PDO::FETCH_ASSOC);
        }
        function fetch_row()
        {
            return $this->fetch(PDO::FETCH_NUM);
        }
        function fetch_field()
        {
            $L            = (object) $this->getColumnMeta($this->_offset++);
            $L->orgtable  = $L->table;
            $L->orgname   = $L->name;
            $L->charsetnr = (in_array("blob", (array) $L->flags) ? 63 : 0);
            return $L;
        }
    }
}
$Kb = array();
function add_driver($u, $E)
{
    global $Kb;
    $Kb[$u] = $E;
}
class Min_SQL
{
    var $_conn;
    function __construct($e)
    {
        $this->_conn = $e;
    }
    function select($Q, $N, $Z, $s, $we = array(), $_ = 1, $F = 0, $df = false)
    {
        global $b, $y;
        $jd = (count($s) < count($N));
        $I  = $b->selectQueryBuild($N, $Z, $s, $we, $_, $F);
        if (!$I)
            $I = "SELECT" . limit(($_GET["page"] != "last" && $_ != "" && $s && $jd && $y == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $N) . "\nFROM " . table($Q), ($Z ? "\nWHERE " . implode(" AND ", $Z) : "") . ($s && $jd ? "\nGROUP BY " . implode(", ", $s) : "") . ($we ? "\nORDER BY " . implode(", ", $we) : ""), ($_ != "" ? +$_ : null), ($F ? $_ * $F : 0), "\n");
        $eg = microtime(true);
        $K  = $this->_conn->query($I);
        if ($df)
            echo $b->selectQuery($I, $eg, !$K);
        return $K;
    }
    function delete($Q, $lf, $_ = 0)
    {
        $I = "FROM " . table($Q);
        return queries("DELETE" . ($_ ? limit1($Q, $I, $lf) : " $I$lf"));
    }
    function update($Q, $P, $lf, $_ = 0, $Of = "\n")
    {
        $oh = array();
        foreach ($P as $z => $X)
            $oh[] = "$z = $X";
        $I = table($Q) . " SET$Of" . implode(",$Of", $oh);
        return queries("UPDATE" . ($_ ? limit1($Q, $I, $lf, $Of) : " $I$lf"));
    }
    function insert($Q, $P)
    {
        return queries("INSERT INTO " . table($Q) . ($P ? " (" . implode(", ", array_keys($P)) . ")\nVALUES (" . implode(", ", $P) . ")" : " DEFAULT VALUES"));
    }
    function insertUpdate($Q, $M, $cf)
    {
        return false;
    }
    function begin()
    {
        return queries("BEGIN");
    }
    function commit()
    {
        return queries("COMMIT");
    }
    function rollback()
    {
        return queries("ROLLBACK");
    }
    function slowQuery($I, $Eg)
    {
    }
    function convertSearch($Wc, $X, $l)
    {
        return $Wc;
    }
    function value($X, $l)
    {
        return (method_exists($this->_conn, 'value') ? $this->_conn->value($X, $l) : (is_resource($X) ? stream_get_contents($X) : $X));
    }
    function quoteBinary($Ff)
    {
        return q($Ff);
    }
    function warnings()
    {
        return '';
    }
    function tableHelp($E)
    {
    }
}
class Adminer
{
    var $operators;
    function name()
    {
        return "<a href='https://www.adminer.org/'" . target_blank() . " id='h1'>Adminer</a>";
    }
    function credentials()
    {
        return array(
            SERVER,
            $_GET["username"],
            get_password()
        );
    }
    function connectSsl()
    {
    }
    function permanentLogin($g = false)
    {
        return password_file($g);
    }
    function bruteForceKey()
    {
        return $_SERVER["REMOTE_ADDR"];
    }
    function serverName($O)
    {
        return h($O);
    }
    function database()
    {
        return DB;
    }
    function databases($yc = true)
    {
        return get_databases($yc);
    }
    function schemas()
    {
        return schemas();
    }
    function queryTimeout()
    {
        return 2;
    }
    function headers()
    {
    }
    function csp()
    {
        return csp();
    }
    function head()
    {
        return true;
    }
    function css()
    {
        $K  = array();
        $vc = "adminer.css";
        if (file_exists($vc))
            $K[] = "$vc?v=" . crc32(file_get_contents($vc));
        return $K;
    }
    function loginForm()
    {
        global $Kb;
        echo "<table cellspacing='0' class='layout'>\n", $this->loginFormField('driver', '<tr><th>' . 'System' . '<td>', html_select("auth[driver]", $Kb, DRIVER, "loginDriver(this);") . "\n"), $this->loginFormField('server', '<tr><th>' . 'Server' . '<td>', '<input name="auth[server]" value="' . h(SERVER) . '" title="hostname[:port]" placeholder="localhost" autocapitalize="off">' . "\n"), $this->loginFormField('username', '<tr><th>' . 'Username' . '<td>', '<input name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">' . script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")), $this->loginFormField('password', '<tr><th>' . 'Password' . '<td>', '<input type="password" name="auth[password]" autocomplete="current-password">' . "\n"), $this->loginFormField('db', '<tr><th>' . 'Database' . '<td>', '<input name="auth[db]" value="' . h($_GET["db"]) . '" autocapitalize="off">' . "\n"), "</table>\n", "<p><input type='submit' value='" . 'Login' . "'>\n", checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], 'Permanent login') . "\n";
    }
    function loginFormField($E, $Qc, $Y)
    {
        return $Qc . $Y;
    }
    function login($Cd, $G)
    {
        if ($G == "")
            return sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.', target_blank());
        return true;
    }
    function tableName($qg)
    {
        return h($qg["Name"]);
    }
    function fieldName($l, $we = 0)
    {
        return '<span title="' . h($l["full_type"]) . '">' . h($l["field"]) . '</span>';
    }
    function selectLinks($qg, $P = "")
    {
        global $y, $j;
        echo '<p class="links">';
        $Bd = array(
            "select" => 'Select data'
        );
        if (support("table") || support("indexes"))
            $Bd["table"] = 'Show structure';
        if (support("table")) {
            if (is_view($qg))
                $Bd["view"] = 'Alter view';
            else
                $Bd["create"] = 'Alter table';
        }
        if ($P !== null)
            $Bd["edit"] = 'New item';
        $E = $qg["Name"];
        foreach ($Bd as $z => $X)
            echo " <a href='" . h(ME) . "$z=" . urlencode($E) . ($z == "edit" ? $P : "") . "'" . bold(isset($_GET[$z])) . ">$X</a>";
        echo doc_link(array(
            $y => $j->tableHelp($E)
        ), "?"), "\n";
    }
    function foreignKeys($Q)
    {
        return foreign_keys($Q);
    }
    function backwardKeys($Q, $pg)
    {
        return array();
    }
    function backwardKeysPrint($Aa, $L)
    {
    }
    function selectQuery($I, $eg, $qc = false)
    {
        global $y, $j;
        $K = "</p>\n";
        if (!$qc && ($wh = $j->warnings())) {
            $u = "warnings";
            $K = ", <a href='#$u'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "$K<div id='$u' class='hidden'>\n$wh</div>\n";
        }
        return "<p><code class='jush-$y'>" . h(str_replace("\n", " ", $I)) . "</code> <span class='time'>(" . format_time($eg) . ")</span>" . (support("sql") ? " <a href='" . h(ME) . "sql=" . urlencode($I) . "'>" . 'Edit' . "</a>" : "") . $K;
    }
    function sqlCommandQuery($I)
    {
        return shorten_utf8(trim($I), 1000);
    }
    function rowDescription($Q)
    {
        return "";
    }
    function rowDescriptions($M, $Ac)
    {
        return $M;
    }
    function selectLink($X, $l)
    {
    }
    function selectVal($X, $A, $l, $De)
    {
        $K = ($X === null ? "<i>NULL</i>" : (preg_match("~char|binary|boolean~", $l["type"]) && !preg_match("~var~", $l["type"]) ? "<code>$X</code>" : $X));
        if (preg_match('~blob|bytea|raw|file~', $l["type"]) && !is_utf8($X))
            $K = "<i>" . lang(array(
                '%d byte',
                '%d bytes'
            ), strlen($De)) . "</i>";
        if (preg_match('~json~', $l["type"]))
            $K = "<code class='jush-js'>$K</code>";
        return ($A ? "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : "") . ">$K</a>" : $K);
    }
    function editVal($X, $l)
    {
        return $X;
    }
    function tableStructurePrint($m)
    {
        echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr><th>" . 'Column' . "<td>" . 'Type' . (support("comment") ? "<td>" . 'Comment' : "") . "</thead>\n";
        foreach ($m as $l) {
            echo "<tr" . odd() . "><th>" . h($l["field"]), "<td><span title='" . h($l["collation"]) . "'>" . h($l["full_type"]) . "</span>", ($l["null"] ? " <i>NULL</i>" : ""), ($l["auto_increment"] ? " <i>" . 'Auto Increment' . "</i>" : ""), (isset($l["default"]) ? " <span title='" . 'Default value' . "'>[<b>" . h($l["default"]) . "</b>]</span>" : ""), (support("comment") ? "<td>" . h($l["comment"]) : ""), "\n";
        }
        echo "</table>\n", "</div>\n";
    }
    function tableIndexesPrint($w)
    {
        echo "<table cellspacing='0'>\n";
        foreach ($w as $E => $v) {
            ksort($v["columns"]);
            $df = array();
            foreach ($v["columns"] as $z => $X)
                $df[] = "<i>" . h($X) . "</i>" . ($v["lengths"][$z] ? "(" . $v["lengths"][$z] . ")" : "") . ($v["descs"][$z] ? " DESC" : "");
            echo "<tr title='" . h($E) . "'><th>$v[type]<td>" . implode(", ", $df) . "\n";
        }
        echo "</table>\n";
    }
    function selectColumnsPrint($N, $d)
    {
        global $Fc, $Jc;
        print_fieldset("select", 'Select', $N);
        $t     = 0;
        $N[""] = array();
        foreach ($N as $z => $X) {
            $X = $_GET["columns"][$z];
            $c = select_input(" name='columns[$t][col]'", $d, $X["col"], ($z !== "" ? "selectFieldChange" : "selectAddRow"));
            echo "<div>" . ($Fc || $Jc ? "<select name='columns[$t][fun]'>" . optionlist(array(
                -1 => ""
            ) + array_filter(array(
                'Functions' => $Fc,
                'Aggregation' => $Jc
            )), $X["fun"]) . "</select>" . on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1) . script("qsl('select').onchange = function () { helpClose();" . ($z !== "" ? "" : " qsl('select, input', this.parentNode).onchange();") . " };", "") . "($c)" : $c) . "</div>\n";
            $t++;
        }
        echo "</div></fieldset>\n";
    }
    function selectSearchPrint($Z, $d, $w)
    {
        print_fieldset("search", 'Search', $Z);
        foreach ($w as $t => $v) {
            if ($v["type"] == "FULLTEXT") {
                echo "<div>(<i>" . implode("</i>, <i>", array_map('h', $v["columns"])) . "</i>) AGAINST", " <input type='search' name='fulltext[$t]' value='" . h($_GET["fulltext"][$t]) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), checkbox("boolean[$t]", 1, isset($_GET["boolean"][$t]), "BOOL"), "</div>\n";
            }
        }
        $Ka = "this.parentNode.firstChild.onchange();";
        foreach (array_merge((array) $_GET["where"], array(
            array()
        )) as $t => $X) {
            if (!$X || ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators))) {
                echo "<div>" . select_input(" name='where[$t][col]'", $d, $X["col"], ($X ? "selectFieldChange" : "selectAddRow"), "(" . 'anywhere' . ")"), html_select("where[$t][op]", $this->operators, $X["op"], $Ka), "<input type='search' name='where[$t][val]' value='" . h($X["val"]) . "'>", script("mixin(qsl('input'), {oninput: function () { $Ka }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ""), "</div>\n";
            }
        }
        echo "</div></fieldset>\n";
    }
    function selectOrderPrint($we, $d, $w)
    {
        print_fieldset("sort", 'Sort', $we);
        $t = 0;
        foreach ((array) $_GET["order"] as $z => $X) {
            if ($X != "") {
                echo "<div>" . select_input(" name='order[$t]'", $d, $X, "selectFieldChange"), checkbox("desc[$t]", 1, isset($_GET["desc"][$z]), 'descending') . "</div>\n";
                $t++;
            }
        }
        echo "<div>" . select_input(" name='order[$t]'", $d, "", "selectAddRow"), checkbox("desc[$t]", 1, false, 'descending') . "</div>\n", "</div></fieldset>\n";
    }
    function selectLimitPrint($_)
    {
        echo "<fieldset><legend>" . 'Limit' . "</legend><div>";
        echo "<input type='number' name='limit' class='size' value='" . h($_) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), "</div></fieldset>\n";
    }
    function selectLengthPrint($Cg)
    {
        if ($Cg !== null) {
            echo "<fieldset><legend>" . 'Text length' . "</legend><div>", "<input type='number' name='text_length' class='size' value='" . h($Cg) . "'>", "</div></fieldset>\n";
        }
    }
    function selectActionPrint($w)
    {
        echo "<fieldset><legend>" . 'Action' . "</legend><div>", "<input type='submit' value='" . 'Select' . "'>", " <span id='noindex' title='" . 'Full table scan' . "'></span>", "<script" . nonce() . ">\n", "var indexColumns = ";
        $d = array();
        foreach ($w as $v) {
            $rb = reset($v["columns"]);
            if ($v["type"] != "FULLTEXT" && $rb)
                $d[$rb] = 1;
        }
        $d[""] = 1;
        foreach ($d as $z => $X)
            json_row($z);
        echo ";\n", "selectFieldChange.call(qs('#form')['select']);\n", "</script>\n", "</div></fieldset>\n";
    }
    function selectCommandPrint()
    {
        return !information_schema(DB);
    }
    function selectImportPrint()
    {
        return !information_schema(DB);
    }
    function selectEmailPrint($Wb, $d)
    {
    }
    function selectColumnsProcess($d, $w)
    {
        global $Fc, $Jc;
        $N = array();
        $s = array();
        foreach ((array) $_GET["columns"] as $z => $X) {
            if ($X["fun"] == "count" || ($X["col"] != "" && (!$X["fun"] || in_array($X["fun"], $Fc) || in_array($X["fun"], $Jc)))) {
                $N[$z] = apply_sql_function($X["fun"], ($X["col"] != "" ? idf_escape($X["col"]) : "*"));
                if (!in_array($X["fun"], $Jc))
                    $s[] = $N[$z];
            }
        }
        return array(
            $N,
            $s
        );
    }
    function selectSearchProcess($m, $w)
    {
        global $e, $j;
        $K = array();
        foreach ($w as $t => $v) {
            if ($v["type"] == "FULLTEXT" && $_GET["fulltext"][$t] != "")
                $K[] = "MATCH (" . implode(", ", array_map('idf_escape', $v["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$t]) . (isset($_GET["boolean"][$t]) ? " IN BOOLEAN MODE" : "") . ")";
        }
        foreach ((array) $_GET["where"] as $z => $X) {
            if ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators)) {
                $af = "";
                $db = " $X[op]";
                if (preg_match('~IN$~', $X["op"])) {
                    $Zc = process_length($X["val"]);
                    $db .= " " . ($Zc != "" ? $Zc : "(NULL)");
                } elseif ($X["op"] == "SQL")
                    $db = " $X[val]";
                elseif ($X["op"] == "LIKE %%")
                    $db = " LIKE " . $this->processInput($m[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "ILIKE %%")
                    $db = " ILIKE " . $this->processInput($m[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "FIND_IN_SET") {
                    $af = "$X[op](" . q($X["val"]) . ", ";
                    $db = ")";
                } elseif (!preg_match('~NULL$~', $X["op"]))
                    $db .= " " . $this->processInput($m[$X["col"]], $X["val"]);
                if ($X["col"] != "")
                    $K[] = $af . $j->convertSearch(idf_escape($X["col"]), $X, $m[$X["col"]]) . $db;
                else {
                    $Ya = array();
                    foreach ($m as $E => $l) {
                        if ((preg_match('~^[-\d.' . (preg_match('~IN$~', $X["op"]) ? ',' : '') . ']+$~', $X["val"]) || !preg_match('~' . number_type() . '|bit~', $l["type"])) && (!preg_match("~[\x80-\xFF]~", $X["val"]) || preg_match('~char|text|enum|set~', $l["type"])) && (!preg_match('~date|timestamp~', $l["type"]) || preg_match('~^\d+-\d+-\d+~', $X["val"])))
                            $Ya[] = $af . $j->convertSearch(idf_escape($E), $X, $l) . $db;
                    }
                    $K[] = ($Ya ? "(" . implode(" OR ", $Ya) . ")" : "1 = 0");
                }
            }
        }
        return $K;
    }
    function selectOrderProcess($m, $w)
    {
        $K = array();
        foreach ((array) $_GET["order"] as $z => $X) {
            if ($X != "")
                $K[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X) ? $X : idf_escape($X)) . (isset($_GET["desc"][$z]) ? " DESC" : "");
        }
        return $K;
    }
    function selectLimitProcess()
    {
        return (isset($_GET["limit"]) ? $_GET["limit"] : "50");
    }
    function selectLengthProcess()
    {
        return (isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
    }
    function selectEmailProcess($Z, $Ac)
    {
        return false;
    }
    function selectQueryBuild($N, $Z, $s, $we, $_, $F)
    {
        return "";
    }
    function messageQuery($I, $Dg, $qc = false)
    {
        global $y, $j;
        restart_session();
        $Rc =& get_session("queries");
        if (!$Rc[$_GET["db"]])
            $Rc[$_GET["db"]] = array();
        if (strlen($I) > 1e6)
            $I = preg_replace('~[\x80-\xFF]+$~', '', substr($I, 0, 1e6)) . "\nâ€¦";
        $Rc[$_GET["db"]][] = array(
            $I,
            time(),
            $Dg
        );
        $cg                = "sql-" . count($Rc[$_GET["db"]]);
        $K                 = "<a href='#$cg' class='toggle'>" . 'SQL command' . "</a>\n";
        if (!$qc && ($wh = $j->warnings())) {
            $u = "warnings-" . count($Rc[$_GET["db"]]);
            $K = "<a href='#$u' class='toggle'>" . 'Warnings' . "</a>, $K<div id='$u' class='hidden'>\n$wh</div>\n";
        }
        return " <span class='time'>" . @date("H:i:s") . "</span>" . " $K<div id='$cg' class='hidden'><pre><code class='jush-$y'>" . shorten_utf8($I, 1000) . "</code></pre>" . ($Dg ? " <span class='time'>($Dg)</span>" : '') . (support("sql") ? '<p><a href="' . h(str_replace("db=" . urlencode(DB), "db=" . urlencode($_GET["db"]), ME) . 'sql=&history=' . (count($Rc[$_GET["db"]]) - 1)) . '">' . 'Edit' . '</a>' : '') . '</div>';
    }
    function editRowPrint($Q, $m, $L, $fh)
    {
    }
    function editFunctions($l)
    {
        global $Rb;
        $K  = ($l["null"] ? "NULL/" : "");
        $fh = isset($_GET["select"]) || where($_GET);
        foreach ($Rb as $z => $Fc) {
            if (!$z || (!isset($_GET["call"]) && $fh)) {
                foreach ($Fc as $Re => $X) {
                    if (!$Re || preg_match("~$Re~", $l["type"]))
                        $K .= "/$X";
                }
            }
            if ($z && !preg_match('~set|blob|bytea|raw|file|bool~', $l["type"]))
                $K .= "/SQL";
        }
        if ($l["auto_increment"] && !$fh)
            $K = 'Auto Increment';
        return explode("/", $K);
    }
    function editInput($Q, $l, $wa, $Y)
    {
        if ($l["type"] == "enum")
            return (isset($_GET["select"]) ? "<label><input type='radio'$wa value='-1' checked><i>" . 'original' . "</i></label> " : "") . ($l["null"] ? "<label><input type='radio'$wa value=''" . ($Y !== null || isset($_GET["select"]) ? "" : " checked") . "><i>NULL</i></label> " : "") . enum_input("radio", $wa, $l, $Y, 0);
        return "";
    }
    function editHint($Q, $l, $Y)
    {
        return "";
    }
    function processInput($l, $Y, $q = "")
    {
        if ($q == "SQL")
            return $Y;
        $E = $l["field"];
        $K = q($Y);
        if (preg_match('~^(now|getdate|uuid)$~', $q))
            $K = "$q()";
        elseif (preg_match('~^current_(date|timestamp)$~', $q))
            $K = $q;
        elseif (preg_match('~^([+-]|\|\|)$~', $q))
            $K = idf_escape($E) . " $q $K";
        elseif (preg_match('~^[+-] interval$~', $q))
            $K = idf_escape($E) . " $q " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y) ? $Y : $K);
        elseif (preg_match('~^(addtime|subtime|concat)$~', $q))
            $K = "$q(" . idf_escape($E) . ", $K)";
        elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $q))
            $K = "$q($K)";
        return unconvert_field($l, $K);
    }
    function dumpOutput()
    {
        $K = array(
            'text' => 'open',
            'file' => 'save'
        );
        if (function_exists('gzencode'))
            $K['gz'] = 'gzip';
        return $K;
    }
    function dumpFormat()
    {
        return array(
            'sql' => 'SQL',
            'csv' => 'CSV,',
            'csv;' => 'CSV;',
            'tsv' => 'TSV'
        );
    }
    function dumpDatabase($i)
    {
    }
    function dumpTable($Q, $kg, $ld = 0)
    {
        if ($_POST["format"] != "sql") {
            echo "\xef\xbb\xbf";
            if ($kg)
                dump_csv(array_keys(fields($Q)));
        } else {
            if ($ld == 2) {
                $m = array();
                foreach (fields($Q) as $E => $l)
                    $m[] = idf_escape($E) . " $l[full_type]";
                $g = "CREATE TABLE " . table($Q) . " (" . implode(", ", $m) . ")";
            } else
                $g = create_sql($Q, $_POST["auto_increment"], $kg);
            set_utf8mb4($g);
            if ($kg && $g) {
                if ($kg == "DROP+CREATE" || $ld == 1)
                    echo "DROP " . ($ld == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($Q) . ";\n";
                if ($ld == 1)
                    $g = remove_definer($g);
                echo "$g;\n\n";
            }
        }
    }
    function dumpData($Q, $kg, $I)
    {
        global $e, $y;
        $Id = ($y == "sqlite" ? 0 : 1048576);
        if ($kg) {
            if ($_POST["format"] == "sql") {
                if ($kg == "TRUNCATE+INSERT")
                    echo truncate_sql($Q) . ";\n";
                $m = fields($Q);
            }
            $J = $e->query($I, 1);
            if ($J) {
                $ed = "";
                $Ia = "";
                $nd = array();
                $mg = "";
                $tc = ($Q != '' ? 'fetch_assoc' : 'fetch_row');
                while ($L = $J->$tc()) {
                    if (!$nd) {
                        $oh = array();
                        foreach ($L as $X) {
                            $l    = $J->fetch_field();
                            $nd[] = $l->name;
                            $z    = idf_escape($l->name);
                            $oh[] = "$z = VALUES($z)";
                        }
                        $mg = ($kg == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $oh) : "") . ";\n";
                    }
                    if ($_POST["format"] != "sql") {
                        if ($kg == "table") {
                            dump_csv($nd);
                            $kg = "INSERT";
                        }
                        dump_csv($L);
                    } else {
                        if (!$ed)
                            $ed = "INSERT INTO " . table($Q) . " (" . implode(", ", array_map('idf_escape', $nd)) . ") VALUES";
                        foreach ($L as $z => $X) {
                            $l     = $m[$z];
                            $L[$z] = ($X !== null ? unconvert_field($l, preg_match(number_type(), $l["type"]) && !preg_match('~\[~', $l["full_type"]) && is_numeric($X) ? $X : q(($X === false ? 0 : $X))) : "NULL");
                        }
                        $Ff = ($Id ? "\n" : " ") . "(" . implode(",\t", $L) . ")";
                        if (!$Ia)
                            $Ia = $ed . $Ff;
                        elseif (strlen($Ia) + 4 + strlen($Ff) + strlen($mg) < $Id)
                            $Ia .= ",$Ff";
                        else {
                            echo $Ia . $mg;
                            $Ia = $ed . $Ff;
                        }
                    }
                }
                if ($Ia)
                    echo $Ia . $mg;
            } elseif ($_POST["format"] == "sql")
                echo "-- " . str_replace("\n", " ", $e->error) . "\n";
        }
    }
    function dumpFilename($Vc)
    {
        return friendly_url($Vc != "" ? $Vc : (SERVER != "" ? SERVER : "localhost"));
    }
    function dumpHeaders($Vc, $Ud = false)
    {
        $Fe = $_POST["output"];
        $nc = (preg_match('~sql~', $_POST["format"]) ? "sql" : ($Ud ? "tar" : "csv"));
        header("Content-Type: " . ($Fe == "gz" ? "application/x-gzip" : ($nc == "tar" ? "application/x-tar" : ($nc == "sql" || $Fe != "file" ? "text/plain" : "text/csv") . "; charset=utf-8")));
        if ($Fe == "gz")
            ob_start('ob_gzencode', 1e6);
        return $nc;
    }
    function importServerPath()
    {
        return "adminer.sql";
    }
    function homepage()
    {
        echo '<p class="links">' . ($_GET["ns"] == "" && support("database") ? '<a href="' . h(ME) . 'database=">' . 'Alter database' . "</a>\n" : ""), (support("scheme") ? "<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? 'Alter schema' : 'Create schema') . "</a>\n" : ""), ($_GET["ns"] !== "" ? '<a href="' . h(ME) . 'schema=">' . 'Database schema' . "</a>\n" : ""), (support("privileges") ? "<a href='" . h(ME) . "privileges='>" . 'Privileges' . "</a>\n" : "");
        return true;
    }
    function navigation($Td)
    {
        global $ga, $y, $Kb, $e;
        echo '<h1>
', $this->name(), ' <span class="version">', $ga, '</span>
<a href="https://www.adminer.org/#download"', target_blank(), ' id="version">', (version_compare($ga, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : ""), '</a>
</h1>
';
        if ($Td == "auth") {
            $Fe = "";
            foreach ((array) $_SESSION["pwds"] as $qh => $Qf) {
                foreach ($Qf as $O => $mh) {
                    foreach ($mh as $V => $G) {
                        if ($G !== null) {
                            $xb = $_SESSION["db"][$qh][$O][$V];
                            foreach (($xb ? array_keys($xb) : array(
                                ""
                            )) as $i)
                                $Fe .= "<li><a href='" . h(auth_url($qh, $O, $V, $i)) . "'>($Kb[$qh]) " . h($V . ($O != "" ? "@" . $this->serverName($O) : "") . ($i != "" ? " - $i" : "")) . "</a>\n";
                        }
                    }
                }
            }
            if ($Fe)
                echo "<ul id='logins'>\n$Fe</ul>\n" . script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
        } else {
            $S = array();
            if ($_GET["ns"] !== "" && !$Td && DB != "") {
                $e->select_db(DB);
                $S = table_status('', true);
            }
            echo script_src(preg_replace("~\\?.*~", "", ME) . "?file=jush.js&version=4.8.1");
            if (support("sql")) {
                echo '<script', nonce(), '>
';
                if ($S) {
                    $Bd = array();
                    foreach ($S as $Q => $U)
                        $Bd[] = preg_quote($Q, '/');
                    echo "var jushLinks = { $y: [ '" . js_escape(ME) . (support("table") ? "table=" : "select=") . "\$&', /\\b(" . implode("|", $Bd) . ")\\b/g ] };\n";
                    foreach (array(
                        "bac",
                        "bra",
                        "sqlite_quo",
                        "mssql_bra"
                    ) as $X)
                        echo "jushLinks.$X = jushLinks.$y;\n";
                }
                $Pf = $e->server_info;
                echo 'bodyLoad(\'', (is_object($e) ? preg_replace('~^(\d\.?\d).*~s', '\1', $Pf) : ""), '\'', (preg_match('~MariaDB~', $Pf) ? ", true" : ""), ');
</script>
';
            }
            $this->databasesPrint($Td);
            if (DB == "" || !$Td) {
                echo "<p class='links'>" . (support("sql") ? "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"]) && !isset($_GET["import"])) . ">" . 'SQL command' . "</a>\n<a href='" . h(ME) . "import='" . bold(isset($_GET["import"])) . ">" . 'Import' . "</a>\n" : "") . "";
                if (support("dump"))
                    echo "<a href='" . h(ME) . "dump=" . urlencode(isset($_GET["table"]) ? $_GET["table"] : $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . ">" . 'Export' . "</a>\n";
            }
            if ($_GET["ns"] !== "" && !$Td && DB != "") {
                echo '<a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . ">" . 'Create table' . "</a>\n";
                if (!$S)
                    echo "<p class='message'>" . 'No tables.' . "\n";
                else
                    $this->tablesPrint($S);
            }
        }
    }
    function databasesPrint($Td)
    {
        global $b, $e;
        $h = $this->databases();
        if (DB && $h && !in_array(DB, $h))
            array_unshift($h, DB);
        echo '<form action="">
<p id="dbs">
';
        hidden_fields_get();
        $vb = script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
        echo "<span title='" . 'database' . "'>" . 'DB' . "</span>: " . ($h ? "<select name='db'>" . optionlist(array(
            "" => ""
        ) + $h, DB) . "</select>$vb" : "<input name='db' value='" . h(DB) . "' autocapitalize='off'>\n"), "<input type='submit' value='" . 'Use' . "'" . ($h ? " class='hidden'" : "") . ">\n";
        foreach (array(
            "import",
            "sql",
            "schema",
            "dump",
            "privileges"
        ) as $X) {
            if (isset($_GET[$X])) {
                echo "<input type='hidden' name='$X' value=''>";
                break;
            }
        }
        echo "</p></form>\n";
    }
    function tablesPrint($S)
    {
        echo "<ul id='tables'>" . script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
        foreach ($S as $Q => $fg) {
            $E = $this->tableName($fg);
            if ($E != "") {
                echo '<li><a href="' . h(ME) . 'select=' . urlencode($Q) . '"' . bold($_GET["select"] == $Q || $_GET["edit"] == $Q, "select") . " title='" . 'Select data' . "'>" . 'select' . "</a> ", (support("table") || support("indexes") ? '<a href="' . h(ME) . 'table=' . urlencode($Q) . '"' . bold(in_array($Q, array(
                    $_GET["table"],
                    $_GET["create"],
                    $_GET["indexes"],
                    $_GET["foreign"],
                    $_GET["trigger"]
                )), (is_view($fg) ? "view" : "structure")) . " title='" . 'Show structure' . "'>$E</a>" : "<span>$E</span>") . "\n";
            }
        }
        echo "</ul>\n";
    }
}
$b  = (function_exists('adminer_object') ? adminer_object() : new Adminer);
$Kb = array(
    "server" => "MySQL"
) + $Kb;
if (!defined("DRIVER")) {
    define("DRIVER", "server");
    if (extension_loaded("mysqli")) {
        class Min_DB extends MySQLi
        {
            var $extension = "MySQLi";
            function __construct()
            {
                parent::init();
            }
            function connect($O = "", $V = "", $G = "", $ub = null, $Ve = null, $Xf = null)
            {
                global $b;
                mysqli_report(MYSQLI_REPORT_OFF);
                list($Tc, $Ve) = explode(":", $O, 2);
                $dg = $b->connectSsl();
                if ($dg)
                    $this->ssl_set($dg['key'], $dg['cert'], $dg['ca'], '', '');
                $K = @$this->real_connect(($O != "" ? $Tc : ini_get("mysqli.default_host")), ($O . $V != "" ? $V : ini_get("mysqli.default_user")), ($O . $V . $G != "" ? $G : ini_get("mysqli.default_pw")), $ub, (is_numeric($Ve) ? $Ve : ini_get("mysqli.default_port")), (!is_numeric($Ve) ? $Ve : $Xf), ($dg ? 64 : 0));
                $this->options(MYSQLI_OPT_LOCAL_INFILE, false);
                return $K;
            }
            function set_charset($La)
            {
                if (parent::set_charset($La))
                    return true;
                parent::set_charset('utf8');
                return $this->query("SET NAMES $La");
            }
            function result($I, $l = 0)
            {
                $J = $this->query($I);
                if (!$J)
                    return false;
                $L = $J->fetch_array();
                return $L[$l];
            }
            function quote($ig)
            {
                return "'" . $this->escape_string($ig) . "'";
            }
        }
    } elseif (extension_loaded("mysql") && !((ini_bool("sql.safe_mode") || ini_bool("mysql.allow_local_infile")) && extension_loaded("pdo_mysql"))) {
        class Min_DB
        {
            var $extension = "MySQL", $server_info, $affected_rows, $errno, $error, $_link, $_result;
            function connect($O, $V, $G)
            {
                if (ini_bool("mysql.allow_local_infile")) {
                    $this->error = sprintf('Disable %s or enable %s or %s extensions.', "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");
                    return false;
                }
                $this->_link = @mysql_connect(($O != "" ? $O : ini_get("mysql.default_host")), ("$O$V" != "" ? $V : ini_get("mysql.default_user")), ("$O$V$G" != "" ? $G : ini_get("mysql.default_password")), true, 131072);
                if ($this->_link)
                    $this->server_info = mysql_get_server_info($this->_link);
                else
                    $this->error = mysql_error();
                return (bool) $this->_link;
            }
            function set_charset($La)
            {
                if (function_exists('mysql_set_charset')) {
                    if (mysql_set_charset($La, $this->_link))
                        return true;
                    mysql_set_charset('utf8', $this->_link);
                }
                return $this->query("SET NAMES $La");
            }
            function quote($ig)
            {
                return "'" . mysql_real_escape_string($ig, $this->_link) . "'";
            }
            function select_db($ub)
            {
                return mysql_select_db($ub, $this->_link);
            }
            function query($I, $Yg = false)
            {
                $J           = @($Yg ? mysql_unbuffered_query($I, $this->_link) : mysql_query($I, $this->_link));
                $this->error = "";
                if (!$J) {
                    $this->errno = mysql_errno($this->_link);
                    $this->error = mysql_error($this->_link);
                    return false;
                }
                if ($J === true) {
                    $this->affected_rows = mysql_affected_rows($this->_link);
                    $this->info          = mysql_info($this->_link);
                    return true;
                }
                return new Min_Result($J);
            }
            function multi_query($I)
            {
                return $this->_result = $this->query($I);
            }
            function store_result()
            {
                return $this->_result;
            }
            function next_result()
            {
                return false;
            }
            function result($I, $l = 0)
            {
                $J = $this->query($I);
                if (!$J || !$J->num_rows)
                    return false;
                return mysql_result($J->_result, 0, $l);
            }
        }
        class Min_Result
        {
            var $num_rows, $_result, $_offset = 0;
            function __construct($J)
            {
                $this->_result  = $J;
                $this->num_rows = mysql_num_rows($J);
            }
            function fetch_assoc()
            {
                return mysql_fetch_assoc($this->_result);
            }
            function fetch_row()
            {
                return mysql_fetch_row($this->_result);
            }
            function fetch_field()
            {
                $K            = mysql_fetch_field($this->_result, $this->_offset++);
                $K->orgtable  = $K->table;
                $K->orgname   = $K->name;
                $K->charsetnr = ($K->blob ? 63 : 0);
                return $K;
            }
            function __destruct()
            {
                mysql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_mysql")) {
        class Min_DB extends Min_PDO
        {
            var $extension = "PDO_MySQL";
            function connect($O, $V, $G)
            {
                global $b;
                $ue = array(
                    PDO::MYSQL_ATTR_LOCAL_INFILE => false
                );
                $dg = $b->connectSsl();
                if ($dg) {
                    if (!empty($dg['key']))
                        $ue[PDO::MYSQL_ATTR_SSL_KEY] = $dg['key'];
                    if (!empty($dg['cert']))
                        $ue[PDO::MYSQL_ATTR_SSL_CERT] = $dg['cert'];
                    if (!empty($dg['ca']))
                        $ue[PDO::MYSQL_ATTR_SSL_CA] = $dg['ca'];
                }
                $this->dsn("mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $O)), $V, $G, $ue);
                return true;
            }
            function set_charset($La)
            {
                $this->query("SET NAMES $La");
            }
            function select_db($ub)
            {
                return $this->query("USE " . idf_escape($ub));
            }
            function query($I, $Yg = false)
            {
                $this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, !$Yg);
                return parent::query($I, $Yg);
            }
        }
    }
    class Min_Driver extends Min_SQL
    {
        function insert($Q, $P)
        {
            return ($P ? parent::insert($Q, $P) : queries("INSERT INTO " . table($Q) . " ()\nVALUES ()"));
        }
        function insertUpdate($Q, $M, $cf)
        {
            $d  = array_keys(reset($M));
            $af = "INSERT INTO " . table($Q) . " (" . implode(", ", $d) . ") VALUES\n";
            $oh = array();
            foreach ($d as $z)
                $oh[$z] = "$z = VALUES($z)";
            $mg = "\nON DUPLICATE KEY UPDATE " . implode(", ", $oh);
            $oh = array();
            $zd = 0;
            foreach ($M as $P) {
                $Y = "(" . implode(", ", $P) . ")";
                if ($oh && (strlen($af) + $zd + strlen($Y) + strlen($mg) > 1e6)) {
                    if (!queries($af . implode(",\n", $oh) . $mg))
                        return false;
                    $oh = array();
                    $zd = 0;
                }
                $oh[] = $Y;
                $zd += strlen($Y) + 2;
            }
            return queries($af . implode(",\n", $oh) . $mg);
        }
        function slowQuery($I, $Eg)
        {
            if (min_version('5.7.8', '10.1.2')) {
                if (preg_match('~MariaDB~', $this->_conn->server_info))
                    return "SET STATEMENT max_statement_time=$Eg FOR $I";
                elseif (preg_match('~^(SELECT\b)(.+)~is', $I, $C))
                    return "$C[1] /*+ MAX_EXECUTION_TIME(" . ($Eg * 1000) . ") */ $C[2]";
            }
        }
        function convertSearch($Wc, $X, $l)
        {
            return (preg_match('~char|text|enum|set~', $l["type"]) && !preg_match("~^utf8~", $l["collation"]) && preg_match('~[\x80-\xFF]~', $X['val']) ? "CONVERT($Wc USING " . charset($this->_conn) . ")" : $Wc);
        }
        function warnings()
        {
            $J = $this->_conn->query("SHOW WARNINGS");
            if ($J && $J->num_rows) {
                ob_start();
                select($J);
                return ob_get_clean();
            }
        }
        function tableHelp($E)
        {
            $Ed = preg_match('~MariaDB~', $this->_conn->server_info);
            if (information_schema(DB))
                return strtolower(($Ed ? "information-schema-$E-table/" : str_replace("_", "-", $E) . "-table.html"));
            if (DB == "mysql")
                return ($Ed ? "mysql$E-table/" : "system-database.html");
        }
    }
    function idf_escape($Wc)
    {
        return "`" . str_replace("`", "``", $Wc) . "`";
    }
    function table($Wc)
    {
        return idf_escape($Wc);
    }
    function connect()
    {
        global $b, $Xg, $jg;
        $e  = new Min_DB;
        $nb = $b->credentials();
        if ($e->connect($nb[0], $nb[1], $nb[2])) {
            $e->set_charset(charset($e));
            $e->query("SET sql_quote_show_create = 1, autocommit = 1");
            if (min_version('5.7.8', 10.2, $e)) {
                $jg['Strings'][] = "json";
                $Xg["json"]      = 4294967295;
            }
            return $e;
        }
        $K = $e->error;
        if (function_exists('iconv') && !is_utf8($K) && strlen($Ff = iconv("windows-1250", "utf-8", $K)) > strlen($K))
            $K = $Ff;
        return $K;
    }
    function get_databases($yc)
    {
        $K = get_session("dbs");
        if ($K === null) {
            $I = (min_version(5) ? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME" : "SHOW DATABASES");
            $K = ($yc ? slow_query($I) : get_vals($I));
            restart_session();
            set_session("dbs", $K);
            stop_session();
        }
        return $K;
    }
    function limit($I, $Z, $_, $he = 0, $Of = " ")
    {
        return " $I$Z" . ($_ !== null ? $Of . "LIMIT $_" . ($he ? " OFFSET $he" : "") : "");
    }
    function limit1($Q, $I, $Z, $Of = "\n")
    {
        return limit($I, $Z, 1, 0, $Of);
    }
    function db_collation($i, $Xa)
    {
        global $e;
        $K = null;
        $g = $e->result("SHOW CREATE DATABASE " . idf_escape($i), 1);
        if (preg_match('~ COLLATE ([^ ]+)~', $g, $C))
            $K = $C[1];
        elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $g, $C))
            $K = $Xa[$C[1]][-1];
        return $K;
    }
    function engines()
    {
        $K = array();
        foreach (get_rows("SHOW ENGINES") as $L) {
            if (preg_match("~YES|DEFAULT~", $L["Support"]))
                $K[] = $L["Engine"];
        }
        return $K;
    }
    function logged_user()
    {
        global $e;
        return $e->result("SELECT USER()");
    }
    function tables_list()
    {
        return get_key_vals(min_version(5) ? "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME" : "SHOW TABLES");
    }
    function count_tables($h)
    {
        $K = array();
        foreach ($h as $i)
            $K[$i] = count(get_vals("SHOW TABLES IN " . idf_escape($i)));
        return $K;
    }
    function table_status($E = "", $rc = false)
    {
        $K = array();
        foreach (get_rows($rc && min_version(5) ? "SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($E != "" ? "AND TABLE_NAME = " . q($E) : "ORDER BY Name") : "SHOW TABLE STATUS" . ($E != "" ? " LIKE " . q(addcslashes($E, "%_\\")) : "")) as $L) {
            if ($L["Engine"] == "InnoDB")
                $L["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $L["Comment"]);
            if (!isset($L["Engine"]))
                $L["Comment"] = "";
            if ($E != "")
                return $L;
            $K[$L["Name"]] = $L;
        }
        return $K;
    }
    function is_view($R)
    {
        return $R["Engine"] === null;
    }
    function fk_support($R)
    {
        return preg_match('~InnoDB|IBMDB2I~i', $R["Engine"]) || (preg_match('~NDB~i', $R["Engine"]) && min_version(5.6));
    }
    function fields($Q)
    {
        $K = array();
        foreach (get_rows("SHOW FULL COLUMNS FROM " . table($Q)) as $L) {
            preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $L["Type"], $C);
            $K[$L["Field"]] = array(
                "field" => $L["Field"],
                "full_type" => $L["Type"],
                "type" => $C[1],
                "length" => $C[2],
                "unsigned" => ltrim($C[3] . $C[4]),
                "default" => ($L["Default"] != "" || preg_match("~char|set~", $C[1]) ? (preg_match('~text~', $C[1]) ? stripslashes(preg_replace("~^'(.*)'\$~", '\1', $L["Default"])) : $L["Default"]) : null),
                "null" => ($L["Null"] == "YES"),
                "auto_increment" => ($L["Extra"] == "auto_increment"),
                "on_update" => (preg_match('~^on update (.+)~i', $L["Extra"], $C) ? $C[1] : ""),
                "collation" => $L["Collation"],
                "privileges" => array_flip(preg_split('~, *~', $L["Privileges"])),
                "comment" => $L["Comment"],
                "primary" => ($L["Key"] == "PRI"),
                "generated" => preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $L["Extra"])
            );
        }
        return $K;
    }
    function indexes($Q, $f = null)
    {
        $K = array();
        foreach (get_rows("SHOW INDEX FROM " . table($Q), $f) as $L) {
            $E                  = $L["Key_name"];
            $K[$E]["type"]      = ($E == "PRIMARY" ? "PRIMARY" : ($L["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($L["Non_unique"] ? ($L["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
            $K[$E]["columns"][] = $L["Column_name"];
            $K[$E]["lengths"][] = ($L["Index_type"] == "SPATIAL" ? null : $L["Sub_part"]);
            $K[$E]["descs"][]   = null;
        }
        return $K;
    }
    function foreign_keys($Q)
    {
        global $e, $oe;
        static $Re = '(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
        $K  = array();
        $lb = $e->result("SHOW CREATE TABLE " . table($Q), 1);
        if ($lb) {
            preg_match_all("~CONSTRAINT ($Re) FOREIGN KEY ?\\(((?:$Re,? ?)+)\\) REFERENCES ($Re)(?:\\.($Re))? \\(((?:$Re,? ?)+)\\)(?: ON DELETE ($oe))?(?: ON UPDATE ($oe))?~", $lb, $Gd, PREG_SET_ORDER);
            foreach ($Gd as $C) {
                preg_match_all("~$Re~", $C[2], $Yf);
                preg_match_all("~$Re~", $C[5], $yg);
                $K[idf_unescape($C[1])] = array(
                    "db" => idf_unescape($C[4] != "" ? $C[3] : $C[4]),
                    "table" => idf_unescape($C[4] != "" ? $C[4] : $C[3]),
                    "source" => array_map('idf_unescape', $Yf[0]),
                    "target" => array_map('idf_unescape', $yg[0]),
                    "on_delete" => ($C[6] ? $C[6] : "RESTRICT"),
                    "on_update" => ($C[7] ? $C[7] : "RESTRICT")
                );
            }
        }
        return $K;
    }
    function view($E)
    {
        global $e;
        return array(
            "select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $e->result("SHOW CREATE VIEW " . table($E), 1))
        );
    }
    function collations()
    {
        $K = array();
        foreach (get_rows("SHOW COLLATION") as $L) {
            if ($L["Default"])
                $K[$L["Charset"]][-1] = $L["Collation"];
            else
                $K[$L["Charset"]][] = $L["Collation"];
        }
        ksort($K);
        foreach ($K as $z => $X)
            asort($K[$z]);
        return $K;
    }
    function information_schema($i)
    {
        return (min_version(5) && $i == "information_schema") || (min_version(5.5) && $i == "performance_schema");
    }
    function error()
    {
        global $e;
        return h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $e->error));
    }
    function create_database($i, $Wa)
    {
        return queries("CREATE DATABASE " . idf_escape($i) . ($Wa ? " COLLATE " . q($Wa) : ""));
    }
    function drop_databases($h)
    {
        $K = apply_queries("DROP DATABASE", $h, 'idf_escape');
        restart_session();
        set_session("dbs", null);
        return $K;
    }
    function rename_database($E, $Wa)
    {
        $K = false;
        if (create_database($E, $Wa)) {
            $S  = array();
            $th = array();
            foreach (tables_list() as $Q => $U) {
                if ($U == 'VIEW')
                    $th[] = $Q;
                else
                    $S[] = $Q;
            }
            $K = (!$S && !$th) || move_tables($S, $th, $E);
            drop_databases($K ? array(
                DB
            ) : array());
        }
        return $K;
    }
    function auto_increment()
    {
        $za = " PRIMARY KEY";
        if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
            foreach (indexes($_GET["create"]) as $v) {
                if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $v["columns"], true)) {
                    $za = "";
                    break;
                }
                if ($v["type"] == "PRIMARY")
                    $za = " UNIQUE";
            }
        }
        return " AUTO_INCREMENT$za";
    }
    function alter_table($Q, $E, $m, $_c, $bb, $Zb, $Wa, $ya, $Ne)
    {
        $sa = array();
        foreach ($m as $l)
            $sa[] = ($l[1] ? ($Q != "" ? ($l[0] != "" ? "CHANGE " . idf_escape($l[0]) : "ADD") : " ") . " " . implode($l[1]) . ($Q != "" ? $l[2] : "") : "DROP " . idf_escape($l[0]));
        $sa = array_merge($sa, $_c);
        $fg = ($bb !== null ? " COMMENT=" . q($bb) : "") . ($Zb ? " ENGINE=" . q($Zb) : "") . ($Wa ? " COLLATE " . q($Wa) : "") . ($ya != "" ? " AUTO_INCREMENT=$ya" : "");
        if ($Q == "")
            return queries("CREATE TABLE " . table($E) . " (\n" . implode(",\n", $sa) . "\n)$fg$Ne");
        if ($Q != $E)
            $sa[] = "RENAME TO " . table($E);
        if ($fg)
            $sa[] = ltrim($fg);
        return ($sa || $Ne ? queries("ALTER TABLE " . table($Q) . "\n" . implode(",\n", $sa) . $Ne) : true);
    }
    function alter_indexes($Q, $sa)
    {
        foreach ($sa as $z => $X)
            $sa[$z] = ($X[2] == "DROP" ? "\nDROP INDEX " . idf_escape($X[1]) : "\nADD $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . ($X[1] != "" ? idf_escape($X[1]) . " " : "") . "(" . implode(", ", $X[2]) . ")");
        return queries("ALTER TABLE " . table($Q) . implode(",", $sa));
    }
    function truncate_tables($S)
    {
        return apply_queries("TRUNCATE TABLE", $S);
    }
    function drop_views($th)
    {
        return queries("DROP VIEW " . implode(", ", array_map('table', $th)));
    }
    function drop_tables($S)
    {
        return queries("DROP TABLE " . implode(", ", array_map('table', $S)));
    }
    function move_tables($S, $th, $yg)
    {
        global $e;
        $wf = array();
        foreach ($S as $Q)
            $wf[] = table($Q) . " TO " . idf_escape($yg) . "." . table($Q);
        if (!$wf || queries("RENAME TABLE " . implode(", ", $wf))) {
            $Bb = array();
            foreach ($th as $Q)
                $Bb[table($Q)] = view($Q);
            $e->select_db($yg);
            $i = idf_escape(DB);
            foreach ($Bb as $E => $sh) {
                if (!queries("CREATE VIEW $E AS " . str_replace(" $i.", " ", $sh["select"])) || !queries("DROP VIEW $i.$E"))
                    return false;
            }
            return true;
        }
        return false;
    }
    function copy_tables($S, $th, $yg)
    {
        queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
        foreach ($S as $Q) {
            $E = ($yg == DB ? table("copy_$Q") : idf_escape($yg) . "." . table($Q));
            if (($_POST["overwrite"] && !queries("\nDROP TABLE IF EXISTS $E")) || !queries("CREATE TABLE $E LIKE " . table($Q)) || !queries("INSERT INTO $E SELECT * FROM " . table($Q)))
                return false;
            foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $L) {
                $Sg = $L["Trigger"];
                if (!queries("CREATE TRIGGER " . ($yg == DB ? idf_escape("copy_$Sg") : idf_escape($yg) . "." . idf_escape($Sg)) . " $L[Timing] $L[Event] ON $E FOR EACH ROW\n$L[Statement];"))
                    return false;
            }
        }
        foreach ($th as $Q) {
            $E  = ($yg == DB ? table("copy_$Q") : idf_escape($yg) . "." . table($Q));
            $sh = view($Q);
            if (($_POST["overwrite"] && !queries("DROP VIEW IF EXISTS $E")) || !queries("CREATE VIEW $E AS $sh[select]"))
                return false;
        }
        return true;
    }
    function trigger($E)
    {
        if ($E == "")
            return array();
        $M = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($E));
        return reset($M);
    }
    function triggers($Q)
    {
        $K = array();
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $L)
            $K[$L["Trigger"]] = array(
                $L["Timing"],
                $L["Event"]
            );
        return $K;
    }
    function trigger_options()
    {
        return array(
            "Timing" => array(
                "BEFORE",
                "AFTER"
            ),
            "Event" => array(
                "INSERT",
                "UPDATE",
                "DELETE"
            ),
            "Type" => array(
                "FOR EACH ROW"
            )
        );
    }
    function routine($E, $U)
    {
        global $e, $bc, $cd, $Xg;
        $qa = array(
            "bool",
            "boolean",
            "integer",
            "double precision",
            "real",
            "dec",
            "numeric",
            "fixed",
            "national char",
            "national varchar"
        );
        $Zf = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $Wg = "((" . implode("|", array_merge(array_keys($Xg), $qa)) . ")\\b(?:\\s*\\(((?:[^'\")]|$bc)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
        $Re = "$Zf*(" . ($U == "FUNCTION" ? "" : $cd) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Wg";
        $g  = $e->result("SHOW CREATE $U " . idf_escape($E), 2);
        preg_match("~\\(((?:$Re\\s*,?)*)\\)\\s*" . ($U == "FUNCTION" ? "RETURNS\\s+$Wg\\s+" : "") . "(.*)~is", $g, $C);
        $m = array();
        preg_match_all("~$Re\\s*,?~is", $C[1], $Gd, PREG_SET_ORDER);
        foreach ($Gd as $Ie)
            $m[] = array(
                "field" => str_replace("``", "`", $Ie[2]) . $Ie[3],
                "type" => strtolower($Ie[5]),
                "length" => preg_replace_callback("~$bc~s", 'normalize_enum', $Ie[6]),
                "unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$Ie[8] $Ie[7]"))),
                "null" => 1,
                "full_type" => $Ie[4],
                "inout" => strtoupper($Ie[1]),
                "collation" => strtolower($Ie[9])
            );
        if ($U != "FUNCTION")
            return array(
                "fields" => $m,
                "definition" => $C[11]
            );
        return array(
            "fields" => $m,
            "returns" => array(
                "type" => $C[12],
                "length" => $C[13],
                "unsigned" => $C[15],
                "collation" => $C[16]
            ),
            "definition" => $C[17],
            "language" => "SQL"
        );
    }
    function routines()
    {
        return get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
    }
    function routine_languages()
    {
        return array();
    }
    function routine_id($E, $L)
    {
        return idf_escape($E);
    }
    function last_id()
    {
        global $e;
        return $e->result("SELECT LAST_INSERT_ID()");
    }
    function explain($e, $I)
    {
        return $e->query("EXPLAIN " . (min_version(5.1) && !min_version(5.7) ? "PARTITIONS " : "") . $I);
    }
    function found_rows($R, $Z)
    {
        return ($Z || $R["Engine"] != "InnoDB" ? null : $R["Rows"]);
    }
    function types()
    {
        return array();
    }
    function schemas()
    {
        return array();
    }
    function get_schema()
    {
        return "";
    }
    function set_schema($Hf, $f = null)
    {
        return true;
    }
    function create_sql($Q, $ya, $kg)
    {
        global $e;
        $K = $e->result("SHOW CREATE TABLE " . table($Q), 1);
        if (!$ya)
            $K = preg_replace('~ AUTO_INCREMENT=\d+~', '', $K);
        return $K;
    }
    function truncate_sql($Q)
    {
        return "TRUNCATE " . table($Q);
    }
    function use_sql($ub)
    {
        return "USE " . idf_escape($ub);
    }
    function trigger_sql($Q)
    {
        $K = "";
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\")), null, "-- ") as $L)
            $K .= "\nCREATE TRIGGER " . idf_escape($L["Trigger"]) . " $L[Timing] $L[Event] ON " . table($L["Table"]) . " FOR EACH ROW\n$L[Statement];;\n";
        return $K;
    }
    function show_variables()
    {
        return get_key_vals("SHOW VARIABLES");
    }
    function process_list()
    {
        return get_rows("SHOW FULL PROCESSLIST");
    }
    function show_status()
    {
        return get_key_vals("SHOW STATUS");
    }
    function convert_field($l)
    {
        if (preg_match("~binary~", $l["type"]))
            return "HEX(" . idf_escape($l["field"]) . ")";
        if ($l["type"] == "bit")
            return "BIN(" . idf_escape($l["field"]) . " + 0)";
        if (preg_match("~geometry|point|linestring|polygon~", $l["type"]))
            return (min_version(8) ? "ST_" : "") . "AsWKT(" . idf_escape($l["field"]) . ")";
    }
    function unconvert_field($l, $K)
    {
        if (preg_match("~binary~", $l["type"]))
            $K = "UNHEX($K)";
        if ($l["type"] == "bit")
            $K = "CONV($K, 2, 10) + 0";
        if (preg_match("~geometry|point|linestring|polygon~", $l["type"]))
            $K = (min_version(8) ? "ST_" : "") . "GeomFromText($K, SRID($l[field]))";
        return $K;
    }
    function support($sc)
    {
        return !preg_match("~scheme|sequence|type|view_trigger|materializedview" . (min_version(8) ? "" : "|descidx" . (min_version(5.1) ? "" : "|event|partitioning" . (min_version(5) ? "" : "|routine|trigger|view"))) . "~", $sc);
    }
    function kill_process($X)
    {
        return queries("KILL " . number($X));
    }
    function connection_id()
    {
        return "SELECT CONNECTION_ID()";
    }
    function max_connections()
    {
        global $e;
        return $e->result("SELECT @@max_connections");
    }
    function driver_config()
    {
        $Xg = array();
        $jg = array();
        foreach (array(
            'Numbers' => array(
                "tinyint" => 3,
                "smallint" => 5,
                "mediumint" => 8,
                "int" => 10,
                "bigint" => 20,
                "decimal" => 66,
                "float" => 12,
                "double" => 21
            ),
            'Date and time' => array(
                "date" => 10,
                "datetime" => 19,
                "timestamp" => 19,
                "time" => 10,
                "year" => 4
            ),
            'Strings' => array(
                "char" => 255,
                "varchar" => 65535,
                "tinytext" => 255,
                "text" => 65535,
                "mediumtext" => 16777215,
                "longtext" => 4294967295
            ),
            'Lists' => array(
                "enum" => 65535,
                "set" => 64
            ),
            'Binary' => array(
                "bit" => 20,
                "binary" => 255,
                "varbinary" => 65535,
                "tinyblob" => 255,
                "blob" => 65535,
                "mediumblob" => 16777215,
                "longblob" => 4294967295
            ),
            'Geometry' => array(
                "geometry" => 0,
                "point" => 0,
                "linestring" => 0,
                "polygon" => 0,
                "multipoint" => 0,
                "multilinestring" => 0,
                "multipolygon" => 0,
                "geometrycollection" => 0
            )
        ) as $z => $X) {
            $Xg += $X;
            $jg[$z] = array_keys($X);
        }
        return array(
            'possible_drivers' => array(
                "MySQLi",
                "MySQL",
                "PDO_MySQL"
            ),
            'jush' => "sql",
            'types' => $Xg,
            'structured_types' => $jg,
            'unsigned' => array(
                "unsigned",
                "zerofill",
                "unsigned zerofill"
            ),
            'operators' => array(
                "=",
                "<",
                ">",
                "<=",
                ">=",
                "!=",
                "LIKE",
                "LIKE %%",
                "REGEXP",
                "IN",
                "FIND_IN_SET",
                "IS NULL",
                "NOT LIKE",
                "NOT REGEXP",
                "NOT IN",
                "IS NOT NULL",
                "SQL"
            ),
            'functions' => array(
                "char_length",
                "date",
                "from_unixtime",
                "lower",
                "round",
                "floor",
                "ceil",
                "sec_to_time",
                "time_to_sec",
                "upper"
            ),
            'grouping' => array(
                "avg",
                "count",
                "count distinct",
                "group_concat",
                "max",
                "min",
                "sum"
            ),
            'edit_functions' => array(
                array(
                    "char" => "md5/sha1/password/encrypt/uuid",
                    "binary" => "md5/sha1",
                    "date|time" => "now"
                ),
                array(
                    number_type() => "+/-",
                    "date" => "+ interval/- interval",
                    "time" => "addtime/subtime",
                    "char|text" => "concat"
                )
            )
        );
    }
}
$eb = driver_config();
$Ze = $eb['possible_drivers'];
$y  = $eb['jush'];
$Xg = $eb['types'];
$jg = $eb['structured_types'];
$eh = $eb['unsigned'];
$se = $eb['operators'];
$Fc = $eb['functions'];
$Jc = $eb['grouping'];
$Rb = $eb['edit_functions'];
if ($b->operators === null)
    $b->operators = $se;
define("SERVER", $_GET[DRIVER]);
define("DB", $_GET["db"]);
define("ME", preg_replace('~\?.*~', '', relative_uri()) . '?' . (sid() ? SID . '&' : '') . (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '') . (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '') . (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : ''));
$ga = "4.8.1";
function page_header($Gg, $k = "", $Ha = array(), $Hg = "")
{
    global $ca, $ga, $b, $Kb, $y;
    page_headers();
    if (is_ajax() && $k) {
        page_messages($k);
        exit;
    }
    $Ig = $Gg . ($Hg != "" ? ": $Hg" : "");
    $Jg = strip_tags($Ig . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $b->name());
    echo '<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>', $Jg, '</title>
<link rel="stylesheet" type="text/css" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=default.css&version=4.8.1"), '">
', script_src(preg_replace("~\\?.*~", "", ME) . "?file=functions.js&version=4.8.1");
    if ($b->head()) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.1"), '">
<link rel="apple-touch-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.1"), '">
';
        foreach ($b->css() as $pb) {
            echo '<link rel="stylesheet" type="text/css" href="', h($pb), '">
';
        }
    }
    echo '
<body class="ltr nojs">
';
    $vc = get_temp_dir() . "/adminer.version";
    if (!$_COOKIE["adminer_version"] && function_exists('openssl_verify') && file_exists($vc) && filemtime($vc) + 86400 > time()) {
        $rh = unserialize(file_get_contents($vc));
        $jf = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
        if (openssl_verify($rh["version"], base64_decode($rh["signature"]), $jf) == 1)
            $_COOKIE["adminer_version"] = $rh["version"];
    }
    echo '<script', nonce(), '>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick', (isset($_COOKIE["adminer_version"]) ? "" : ", onload: partial(verifyVersion, '$ga', '" . js_escape(ME) . "', '" . get_token() . "')");
?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php
    echo js_escape('You are offline.'), '\';
var thousandsSeparator = \'', js_escape(','), '\';
</script>

<div id="help" class="jush-', $y, ' jsonly hidden"></div>
', script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"), '
<div id="content">
';
    if ($Ha !== null) {
        $A = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
        echo '<p id="breadcrumb"><a href="' . h($A ? $A : ".") . '">' . $Kb[DRIVER] . '</a> &raquo; ';
        $A = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
        $O = $b->serverName(SERVER);
        $O = ($O != "" ? $O : 'Server');
        if ($Ha === false)
            echo "$O\n";
        else {
            echo "<a href='" . h($A) . "' accesskey='1' title='Alt+Shift+1'>$O</a> &raquo; ";
            if ($_GET["ns"] != "" || (DB != "" && is_array($Ha)))
                echo '<a href="' . h($A . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> &raquo; ';
            if (is_array($Ha)) {
                if ($_GET["ns"] != "")
                    echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> &raquo; ';
                foreach ($Ha as $z => $X) {
                    $Db = (is_array($X) ? $X[1] : h($X));
                    if ($Db != "")
                        echo "<a href='" . h(ME . "$z=") . urlencode(is_array($X) ? $X[0] : $X) . "'>$Db</a> &raquo; ";
                }
            }
            echo "$Gg\n";
        }
    }
    echo "<h2>$Ig</h2>\n", "<div id='ajaxstatus' class='jsonly hidden'></div>\n";
    restart_session();
    page_messages($k);
    $h =& get_session("dbs");
    if (DB != "" && $h && !in_array(DB, $h, true))
        $h = null;
    stop_session();
    define("PAGE_HEADER", 1);
}
function page_headers()
{
    global $b;
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-cache");
    header("X-Frame-Options: deny");
    header("X-XSS-Protection: 0");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: origin-when-cross-origin");
    foreach ($b->csp() as $ob) {
        $Pc = array();
        foreach ($ob as $z => $X)
            $Pc[] = "$z $X";
        header("Content-Security-Policy: " . implode("; ", $Pc));
    }
    $b->headers();
}
function csp()
{
    return array(
        array(
            "script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'",
            "connect-src" => "'self'",
            "frame-src" => "https://www.adminer.org",
            "object-src" => "'none'",
            "base-uri" => "'none'",
            "form-action" => "'self'"
        )
    );
}
function get_nonce()
{
    static $ce;
    if (!$ce)
        $ce = base64_encode(rand_string());
    return $ce;
}
function page_messages($k)
{
    $gh = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
    $Rd = $_SESSION["messages"][$gh];
    if ($Rd) {
        echo "<div class='message'>" . implode("</div>\n<div class='message'>", $Rd) . "</div>" . script("messagesPrint();");
        unset($_SESSION["messages"][$gh]);
    }
    if ($k)
        echo "<div class='error'>$k</div>\n";
}
function page_footer($Td = "")
{
    global $b, $T;
    echo '</div>

';
    if ($Td != "auth") {
        echo '<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="', $T, '">
</p>
</form>
';
    }
    echo '<div id="menu">
';
    $b->navigation($Td);
    echo '</div>
', script("setupSubmitHighlight(document);");
}
function int32($Wd)
{
    while ($Wd >= 2147483648)
        $Wd -= 4294967296;
    while ($Wd <= -2147483649)
        $Wd += 4294967296;
    return (int) $Wd;
}
function long2str($W, $vh)
{
    $Ff = '';
    foreach ($W as $X)
        $Ff .= pack('V', $X);
    if ($vh)
        return substr($Ff, 0, end($W));
    return $Ff;
}
function str2long($Ff, $vh)
{
    $W = array_values(unpack('V*', str_pad($Ff, 4 * ceil(strlen($Ff) / 4), "\0")));
    if ($vh)
        $W[] = strlen($Ff);
    return $W;
}
function xxtea_mx($Bh, $Ah, $ng, $md)
{
    return int32((($Bh >> 5 & 0x7FFFFFF) ^ $Ah << 2) + (($Ah >> 3 & 0x1FFFFFFF) ^ $Bh << 4)) ^ int32(($ng ^ $Ah) + ($md ^ $Bh));
}
function encrypt_string($hg, $z)
{
    if ($hg == "")
        return "";
    $z  = array_values(unpack("V*", pack("H*", md5($z))));
    $W  = str2long($hg, true);
    $Wd = count($W) - 1;
    $Bh = $W[$Wd];
    $Ah = $W[0];
    $H  = floor(6 + 52 / ($Wd + 1));
    $ng = 0;
    while ($H-- > 0) {
        $ng = int32($ng + 0x9E3779B9);
        $Qb = $ng >> 2 & 3;
        for ($Ge = 0; $Ge < $Wd; $Ge++) {
            $Ah     = $W[$Ge + 1];
            $Vd     = xxtea_mx($Bh, $Ah, $ng, $z[$Ge & 3 ^ $Qb]);
            $Bh     = int32($W[$Ge] + $Vd);
            $W[$Ge] = $Bh;
        }
        $Ah     = $W[0];
        $Vd     = xxtea_mx($Bh, $Ah, $ng, $z[$Ge & 3 ^ $Qb]);
        $Bh     = int32($W[$Wd] + $Vd);
        $W[$Wd] = $Bh;
    }
    return long2str($W, false);
}
function decrypt_string($hg, $z)
{
    if ($hg == "")
        return "";
    if (!$z)
        return false;
    $z  = array_values(unpack("V*", pack("H*", md5($z))));
    $W  = str2long($hg, false);
    $Wd = count($W) - 1;
    $Bh = $W[$Wd];
    $Ah = $W[0];
    $H  = floor(6 + 52 / ($Wd + 1));
    $ng = int32($H * 0x9E3779B9);
    while ($ng) {
        $Qb = $ng >> 2 & 3;
        for ($Ge = $Wd; $Ge > 0; $Ge--) {
            $Bh     = $W[$Ge - 1];
            $Vd     = xxtea_mx($Bh, $Ah, $ng, $z[$Ge & 3 ^ $Qb]);
            $Ah     = int32($W[$Ge] - $Vd);
            $W[$Ge] = $Ah;
        }
        $Bh   = $W[$Wd];
        $Vd   = xxtea_mx($Bh, $Ah, $ng, $z[$Ge & 3 ^ $Qb]);
        $Ah   = int32($W[0] - $Vd);
        $W[0] = $Ah;
        $ng   = int32($ng - 0x9E3779B9);
    }
    return long2str($W, true);
}
$e  = '';
$Oc = $_SESSION["token"];
if (!$Oc)
    $_SESSION["token"] = rand(1, 1e6);
$T  = get_token();
$Te = array();
if ($_COOKIE["adminer_permanent"]) {
    foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $X) {
        list($z) = explode(":", $X);
        $Te[$z] = $X;
    }
}
function add_invalid_login()
{
    global $b;
    $p = file_open_lock(get_temp_dir() . "/adminer.invalid");
    if (!$p)
        return;
    $hd = unserialize(stream_get_contents($p));
    $Dg = time();
    if ($hd) {
        foreach ($hd as $id => $X) {
            if ($X[0] < $Dg)
                unset($hd[$id]);
        }
    }
    $gd =& $hd[$b->bruteForceKey()];
    if (!$gd)
        $gd = array(
            $Dg + 30 * 60,
            0
        );
    $gd[1]++;
    file_write_unlock($p, serialize($hd));
}
function check_invalid_login()
{
    global $b;
    $hd = unserialize(@file_get_contents(get_temp_dir() . "/adminer.invalid"));
    $gd = ($hd ? $hd[$b->bruteForceKey()] : array());
    $be = ($gd[1] > 29 ? $gd[0] - time() : 0);
    if ($be > 0)
        auth_error(lang(array(
            'Too many unsuccessful logins, try again in %d minute.',
            'Too many unsuccessful logins, try again in %d minutes.'
        ), ceil($be / 60)));
}
$xa = $_POST["auth"];
if ($xa) {
    session_regenerate_id();
    $qh = $xa["driver"];
    $O  = $xa["server"];
    $V  = $xa["username"];
    $G  = (string) $xa["password"];
    $i  = $xa["db"];
    set_password($qh, $O, $V, $G);
    $_SESSION["db"][$qh][$O][$V][$i] = true;
    if ($xa["permanent"]) {
        $z      = base64_encode($qh) . "-" . base64_encode($O) . "-" . base64_encode($V) . "-" . base64_encode($i);
        $ef     = $b->permanentLogin(true);
        $Te[$z] = "$z:" . base64_encode($ef ? encrypt_string($G, $ef) : "");
        cookie("adminer_permanent", implode(" ", $Te));
    }
    if (count($_POST) == 1 || DRIVER != $qh || SERVER != $O || $_GET["username"] !== $V || DB != $i)
        redirect(auth_url($qh, $O, $V, $i));
} elseif ($_POST["logout"] && (!$Oc || verify_token())) {
    foreach (array(
        "pwds",
        "db",
        "dbs",
        "queries"
    ) as $z)
        set_session($z, null);
    unset_permanent();
    redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), 'Logout successful.' . ' ' . 'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');
} elseif ($Te && !$_SESSION["pwds"]) {
    session_regenerate_id();
    $ef = $b->permanentLogin();
    foreach ($Te as $z => $X) {
        list(, $Qa) = explode(":", $X);
        list($qh, $O, $V, $i) = array_map('base64_decode', explode("-", $z));
        set_password($qh, $O, $V, decrypt_string(base64_decode($Qa), $ef));
        $_SESSION["db"][$qh][$O][$V][$i] = true;
    }
}
function unset_permanent()
{
    global $Te;
    foreach ($Te as $z => $X) {
        list($qh, $O, $V, $i) = array_map('base64_decode', explode("-", $z));
        if ($qh == DRIVER && $O == SERVER && $V == $_GET["username"] && $i == DB)
            unset($Te[$z]);
    }
    cookie("adminer_permanent", implode(" ", $Te));
}
function auth_error($k)
{
    global $b, $Oc;
    $Rf = session_name();
    if (isset($_GET["username"])) {
        header("HTTP/1.1 403 Forbidden");
        if (($_COOKIE[$Rf] || $_GET[$Rf]) && !$Oc)
            $k = 'Session expired, please login again.';
        else {
            restart_session();
            add_invalid_login();
            $G = get_password();
            if ($G !== null) {
                if ($G === false)
                    $k .= ($k ? '<br>' : '') . sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.', target_blank(), '<code>permanentLogin()</code>');
                set_password(DRIVER, SERVER, $_GET["username"], null);
            }
            unset_permanent();
        }
    }
    if (!$_COOKIE[$Rf] && $_GET[$Rf] && ini_bool("session.use_only_cookies"))
        $k = 'Session support must be enabled.';
    $Je = session_get_cookie_params();
    cookie("adminer_key", ($_COOKIE["adminer_key"] ? $_COOKIE["adminer_key"] : rand_string()), $Je["lifetime"]);
    page_header('Login', $k, null);
    echo "<form action='' method='post'>\n", "<div>";
    if (hidden_fields($_POST, array(
        "auth"
    )))
        echo "<p class='message'>" . 'The action will be performed after successful login with the same credentials.' . "\n";
    echo "</div>\n";
    $b->loginForm();
    echo "</form>\n";
    page_footer("auth");
    exit;
}
if (isset($_GET["username"]) && !class_exists("Min_DB")) {
    unset($_SESSION["pwds"][DRIVER]);
    unset_permanent();
    page_header('No extension', sprintf('None of the supported PHP extensions (%s) are available.', implode(", ", $Ze)), false);
    page_footer("auth");
    exit;
}
stop_session(true);
if (isset($_GET["username"]) && is_string(get_password())) {
    list($Tc, $Ve) = explode(":", SERVER, 2);
    if (preg_match('~^\s*([-+]?\d+)~', $Ve, $C) && ($C[1] < 1024 || $C[1] > 65535))
        auth_error('Connecting to privileged ports is not allowed.');
    check_invalid_login();
    $e = connect();
    $j = new Min_Driver($e);
}
$Cd = null;
if (!is_object($e) || ($Cd = $b->login($_GET["username"], get_password())) !== true) {
    $k = (is_string($e) ? h($e) : (is_string($Cd) ? $Cd : 'Invalid credentials.'));
    auth_error($k . (preg_match('~^ | $~', get_password()) ? '<br>' . 'There is a space in the input password which might be the cause.' : ''));
}
if ($_POST["logout"] && $Oc && !verify_token()) {
    page_header('Logout', 'Invalid CSRF token. Send the form again.');
    page_footer("db");
    exit;
}
if ($xa && $_POST["token"])
    $_POST["token"] = $T;
$k = '';
if ($_POST) {
    if (!verify_token()) {
        $bd = "max_input_vars";
        $Md = ini_get($bd);
        if (extension_loaded("suhosin")) {
            foreach (array(
                "suhosin.request.max_vars",
                "suhosin.post.max_vars"
            ) as $z) {
                $X = ini_get($z);
                if ($X && (!$Md || $X < $Md)) {
                    $bd = $z;
                    $Md = $X;
                }
            }
        }
        $k = (!$_POST["token"] && $Md ? sprintf('Maximum number of allowed fields exceeded. Please increase %s.', "'$bd'") : 'Invalid CSRF token. Send the form again.' . ' ' . 'If you did not send this request from Adminer then close this page.');
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $k = sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.', "'post_max_size'");
    if (isset($_GET["sql"]))
        $k .= ' ' . 'You can upload a big SQL file via FTP and import it from server.';
}
function select($J, $f = null, $ze = array(), $_ = 0)
{
    global $y;
    $Bd = array();
    $w  = array();
    $d  = array();
    $Fa = array();
    $Xg = array();
    $K  = array();
    odd('');
    for ($t = 0; (!$_ || $t < $_) && ($L = $J->fetch_row()); $t++) {
        if (!$t) {
            echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr>";
            for ($x = 0; $x < count($L); $x++) {
                $l            = $J->fetch_field();
                $E            = $l->name;
                $ye           = $l->orgtable;
                $xe           = $l->orgname;
                $K[$l->table] = $ye;
                if ($ze && $y == "sql")
                    $Bd[$x] = ($E == "table" ? "table=" : ($E == "possible_keys" ? "indexes=" : null));
                elseif ($ye != "") {
                    if (!isset($w[$ye])) {
                        $w[$ye] = array();
                        foreach (indexes($ye, $f) as $v) {
                            if ($v["type"] == "PRIMARY") {
                                $w[$ye] = array_flip($v["columns"]);
                                break;
                            }
                        }
                        $d[$ye] = $w[$ye];
                    }
                    if (isset($d[$ye][$xe])) {
                        unset($d[$ye][$xe]);
                        $w[$ye][$xe] = $x;
                        $Bd[$x]      = $ye;
                    }
                }
                if ($l->charsetnr == 63)
                    $Fa[$x] = true;
                $Xg[$x] = $l->type;
                echo "<th" . ($ye != "" || $l->name != $xe ? " title='" . h(($ye != "" ? "$ye." : "") . $xe) . "'" : "") . ">" . h($E) . ($ze ? doc_link(array(
                    'sql' => "explain-output.html#explain_" . strtolower($E),
                    'mariadb' => "explain/#the-columns-in-explain-select"
                )) : "");
            }
            echo "</thead>\n";
        }
        echo "<tr" . odd() . ">";
        foreach ($L as $z => $X) {
            $A = "";
            if (isset($Bd[$z]) && !$d[$Bd[$z]]) {
                if ($ze && $y == "sql") {
                    $Q = $L[array_search("table=", $Bd)];
                    $A = ME . $Bd[$z] . urlencode($ze[$Q] != "" ? $ze[$Q] : $Q);
                } else {
                    $A = ME . "edit=" . urlencode($Bd[$z]);
                    foreach ($w[$Bd[$z]] as $Ua => $x)
                        $A .= "&where" . urlencode("[" . bracket_escape($Ua) . "]") . "=" . urlencode($L[$x]);
                }
            } elseif (is_url($X))
                $A = $X;
            if ($X === null)
                $X = "<i>NULL</i>";
            elseif ($Fa[$z] && !is_utf8($X))
                $X = "<i>" . lang(array(
                    '%d byte',
                    '%d bytes'
                ), strlen($X)) . "</i>";
            else {
                $X = h($X);
                if ($Xg[$z] == 254)
                    $X = "<code>$X</code>";
            }
            if ($A)
                $X = "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : '') . ">$X</a>";
            echo "<td>$X";
        }
    }
    echo ($t ? "</table>\n</div>" : "<p class='message'>" . 'No rows.') . "\n";
    return $K;
}
function referencable_primary($Mf)
{
    $K = array();
    foreach (table_status('', true) as $rg => $Q) {
        if ($rg != $Mf && fk_support($Q)) {
            foreach (fields($rg) as $l) {
                if ($l["primary"]) {
                    if ($K[$rg]) {
                        unset($K[$rg]);
                        break;
                    }
                    $K[$rg] = $l;
                }
            }
        }
    }
    return $K;
}
function adminer_settings()
{
    parse_str($_COOKIE["adminer_settings"], $Tf);
    return $Tf;
}
function adminer_setting($z)
{
    $Tf = adminer_settings();
    return $Tf[$z];
}
function set_adminer_settings($Tf)
{
    return cookie("adminer_settings", http_build_query($Tf + adminer_settings()));
}
function textarea($E, $Y, $M = 10, $Ya = 80)
{
    global $y;
    echo "<textarea name='$E' rows='$M' cols='$Ya' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";
    if (is_array($Y)) {
        foreach ($Y as $X)
            echo h($X[0]) . "\n\n\n";
    } else
        echo h($Y);
    echo "</textarea>";
}
function edit_type($z, $l, $Xa, $o = array(), $pc = array())
{
    global $jg, $Xg, $eh, $oe;
    $U = $l["type"];
    echo '<td><select name="', h($z), '[type]" class="type" aria-labelledby="label-type">';
    if ($U && !isset($Xg[$U]) && !isset($o[$U]) && !in_array($U, $pc))
        $pc[] = $U;
    if ($o)
        $jg['Foreign keys'] = $o;
    echo optionlist(array_merge($pc, $jg), $U), '</select><td><input name="', h($z), '[length]" value="', h($l["length"]), '" size="3"', (!$l["length"] && preg_match('~var(char|binary)$~', $U) ? " class='required'" : "");
    echo ' aria-labelledby="label-length"><td class="options">', "<select name='" . h($z) . "[collation]'" . (preg_match('~(char|text|enum|set)$~', $U) ? "" : " class='hidden'") . '><option value="">(' . 'collation' . ')' . optionlist($Xa, $l["collation"]) . '</select>', ($eh ? "<select name='" . h($z) . "[unsigned]'" . (!$U || preg_match(number_type(), $U) ? "" : " class='hidden'") . '><option>' . optionlist($eh, $l["unsigned"]) . '</select>' : ''), (isset($l['on_update']) ? "<select name='" . h($z) . "[on_update]'" . (preg_match('~timestamp|datetime~', $U) ? "" : " class='hidden'") . '>' . optionlist(array(
        "" => "(" . 'ON UPDATE' . ")",
        "CURRENT_TIMESTAMP"
    ), (preg_match('~^CURRENT_TIMESTAMP~i', $l["on_update"]) ? "CURRENT_TIMESTAMP" : $l["on_update"])) . '</select>' : ''), ($o ? "<select name='" . h($z) . "[on_delete]'" . (preg_match("~`~", $U) ? "" : " class='hidden'") . "><option value=''>(" . 'ON DELETE' . ")" . optionlist(explode("|", $oe), $l["on_delete"]) . "</select> " : " ");
}
function process_length($zd)
{
    global $bc;
    return (preg_match("~^\\s*\\(?\\s*$bc(?:\\s*,\\s*$bc)*+\\s*\\)?\\s*\$~", $zd) && preg_match_all("~$bc~", $zd, $Gd) ? "(" . implode(",", $Gd[0]) . ")" : preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $zd)));
}
function process_type($l, $Va = "COLLATE")
{
    global $eh;
    return " $l[type]" . process_length($l["length"]) . (preg_match(number_type(), $l["type"]) && in_array($l["unsigned"], $eh) ? " $l[unsigned]" : "") . (preg_match('~char|text|enum|set~', $l["type"]) && $l["collation"] ? " $Va " . q($l["collation"]) : "");
}
function process_field($l, $Vg)
{
    return array(
        idf_escape(trim($l["field"])),
        process_type($Vg),
        ($l["null"] ? " NULL" : " NOT NULL"),
        default_value($l),
        (preg_match('~timestamp|datetime~', $l["type"]) && $l["on_update"] ? " ON UPDATE $l[on_update]" : ""),
        (support("comment") && $l["comment"] != "" ? " COMMENT " . q($l["comment"]) : ""),
        ($l["auto_increment"] ? auto_increment() : null)
    );
}
function default_value($l)
{
    $zb = $l["default"];
    return ($zb === null ? "" : " DEFAULT " . (preg_match('~char|binary|text|enum|set~', $l["type"]) || preg_match('~^(?![a-z])~i', $zb) ? q($zb) : $zb));
}
function type_class($U)
{
    foreach (array(
        'char' => 'text',
        'date' => 'time|year',
        'binary' => 'blob',
        'enum' => 'set'
    ) as $z => $X) {
        if (preg_match("~$z|$X~", $U))
            return " class='$z'";
    }
}
function edit_fields($m, $Xa, $U = "TABLE", $o = array())
{
    global $cd;
    $m  = array_values($m);
    $_b = (($_POST ? $_POST["defaults"] : adminer_setting("defaults")) ? "" : " class='hidden'");
    $cb = (($_POST ? $_POST["comments"] : adminer_setting("comments")) ? "" : " class='hidden'");
    echo '<thead><tr>
';
    if ($U == "PROCEDURE") {
        echo '<td>';
    }
    echo '<th id="label-name">', ($U == "TABLE" ? 'Column name' : 'Parameter name'), '<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>', script("qs('#enum-edit').onblur = editingLengthBlur;"), '<td id="label-length">Length
<td>', 'Options';
    if ($U == "TABLE") {
        echo '<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="Auto Increment">AI</acronym>', doc_link(array(
            'sql' => "example-auto-increment.html",
            'mariadb' => "auto_increment/"
        )), '<td id="label-default"', $_b, '>Default value
', (support("comment") ? "<td id='label-comment'$cb>" . 'Comment' : "");
    }
    echo '<td>', "<input type='submit' class='icon' name='add[" . (support("move_col") ? 0 : count($m)) . "]' value='+' title='" . 'Add next' . "'>" . script("row_count = " . count($m) . ";"), '</thead>
<tbody>
', script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");
    foreach ($m as $t => $l) {
        $t++;
        $_e = $l[($_POST ? "orig" : "field")];
        $Hb = (isset($_POST["add"][$t - 1]) || (isset($l["field"]) && !$_POST["drop_col"][$t])) && (support("drop_col") || $_e == "");
        echo '<tr', ($Hb ? "" : " style='display: none;'"), '>
', ($U == "PROCEDURE" ? "<td>" . html_select("fields[$t][inout]", explode("|", $cd), $l["inout"]) : ""), '<th>';
        if ($Hb) {
            echo '<input name="fields[', $t, '][field]" value="', h($l["field"]), '" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';
        }
        echo '<input type="hidden" name="fields[', $t, '][orig]" value="', h($_e), '">';
        edit_type("fields[$t]", $l, $Xa, $o);
        if ($U == "TABLE") {
            echo '<td>', checkbox("fields[$t][null]", 1, $l["null"], "", "", "block", "label-null"), '<td><label class="block"><input type="radio" name="auto_increment_col" value="', $t, '"';
            if ($l["auto_increment"]) {
                echo ' checked';
            }
            echo ' aria-labelledby="label-ai"></label><td', $_b, '>', checkbox("fields[$t][has_default]", 1, $l["has_default"], "", "", "", "label-default"), '<input name="fields[', $t, '][default]" value="', h($l["default"]), '" aria-labelledby="label-default">', (support("comment") ? "<td$cb><input name='fields[$t][comment]' value='" . h($l["comment"]) . "' data-maxlength='" . (min_version(5.5) ? 1024 : 255) . "' aria-labelledby='label-comment'>" : "");
        }
        echo "<td>", (support("move_col") ? "<input type='submit' class='icon' name='add[$t]' value='+' title='" . 'Add next' . "'> " . "<input type='submit' class='icon' name='up[$t]' value='UP' title='" . 'Move up' . "'> " . "<input type='submit' class='icon' name='down[$t]' value='DW' title='" . 'Move down' . "'> " : ""), ($_e == "" || support("drop_col") ? "<input type='submit' class='icon' name='drop_col[$t]' value='X' title='" . 'Remove' . "'>" : "");
    }
}
function process_fields(&$m)
{
    $he = 0;
    if ($_POST["up"]) {
        $td = 0;
        foreach ($m as $z => $l) {
            if (key($_POST["up"]) == $z) {
                unset($m[$z]);
                array_splice($m, $td, 0, array(
                    $l
                ));
                break;
            }
            if (isset($l["field"]))
                $td = $he;
            $he++;
        }
    } elseif ($_POST["down"]) {
        $Cc = false;
        foreach ($m as $z => $l) {
            if (isset($l["field"]) && $Cc) {
                unset($m[key($_POST["down"])]);
                array_splice($m, $he, 0, array(
                    $Cc
                ));
                break;
            }
            if (key($_POST["down"]) == $z)
                $Cc = $l;
            $he++;
        }
    } elseif ($_POST["add"]) {
        $m = array_values($m);
        array_splice($m, key($_POST["add"]), 0, array(
            array()
        ));
    } elseif (!$_POST["drop_col"])
        return false;
    return true;
}
function normalize_enum($C)
{
    return "'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($C[0][0] . $C[0][0], $C[0][0], substr($C[0], 1, -1))), '\\')) . "'";
}
function grant($r, $gf, $d, $ne)
{
    if (!$gf)
        return true;
    if ($gf == array(
        "ALL PRIVILEGES",
        "GRANT OPTION"
    ))
        return ($r == "GRANT" ? queries("$r ALL PRIVILEGES$ne WITH GRANT OPTION") : queries("$r ALL PRIVILEGES$ne") && queries("$r GRANT OPTION$ne"));
    return queries("$r " . preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$d, ", $gf) . $d) . $ne);
}
function drop_create($Lb, $g, $Mb, $Ag, $Nb, $B, $Qd, $Od, $Pd, $ke, $Zd)
{
    if ($_POST["drop"])
        query_redirect($Lb, $B, $Qd);
    elseif ($ke == "")
        query_redirect($g, $B, $Pd);
    elseif ($ke != $Zd) {
        $mb = queries($g);
        queries_redirect($B, $Od, $mb && queries($Lb));
        if ($mb)
            queries($Mb);
    } else
        queries_redirect($B, $Od, queries($Ag) && queries($Nb) && queries($Lb) && queries($g));
}
function create_trigger($ne, $L)
{
    global $y;
    $Fg = " $L[Timing] $L[Event]" . (preg_match('~ OF~', $L["Event"]) ? " $L[Of]" : "");
    return "CREATE TRIGGER " . idf_escape($L["Trigger"]) . ($y == "mssql" ? $ne . $Fg : $Fg . $ne) . rtrim(" $L[Type]\n$L[Statement]", ";") . ";";
}
function create_routine($Cf, $L)
{
    global $cd, $y;
    $P = array();
    $m = (array) $L["fields"];
    ksort($m);
    foreach ($m as $l) {
        if ($l["field"] != "")
            $P[] = (preg_match("~^($cd)\$~", $l["inout"]) ? "$l[inout] " : "") . idf_escape($l["field"]) . process_type($l, "CHARACTER SET");
    }
    $Ab = rtrim("\n$L[definition]", ";");
    return "CREATE $Cf " . idf_escape(trim($L["name"])) . " (" . implode(", ", $P) . ")" . (isset($_GET["function"]) ? " RETURNS" . process_type($L["returns"], "CHARACTER SET") : "") . ($L["language"] ? " LANGUAGE $L[language]" : "") . ($y == "pgsql" ? " AS " . q($Ab) : "$Ab;");
}
function remove_definer($I)
{
    return preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()) . '`~', '\1', $I);
}
function format_foreign_key($n)
{
    global $oe;
    $i  = $n["db"];
    $de = $n["ns"];
    return " FOREIGN KEY (" . implode(", ", array_map('idf_escape', $n["source"])) . ") REFERENCES " . ($i != "" && $i != $_GET["db"] ? idf_escape($i) . "." : "") . ($de != "" && $de != $_GET["ns"] ? idf_escape($de) . "." : "") . table($n["table"]) . " (" . implode(", ", array_map('idf_escape', $n["target"])) . ")" . (preg_match("~^($oe)\$~", $n["on_delete"]) ? " ON DELETE $n[on_delete]" : "") . (preg_match("~^($oe)\$~", $n["on_update"]) ? " ON UPDATE $n[on_update]" : "");
}
function tar_file($vc, $Kg)
{
    $K  = pack("a100a8a8a8a12a12", $vc, 644, 0, 0, decoct($Kg->size), decoct(time()));
    $Pa = 8 * 32;
    for ($t = 0; $t < strlen($K); $t++)
        $Pa += ord($K[$t]);
    $K .= sprintf("%06o", $Pa) . "\0 ";
    echo $K, str_repeat("\0", 512 - strlen($K));
    $Kg->send();
    echo str_repeat("\0", 511 - ($Kg->size + 511) % 512);
}
function ini_bytes($bd)
{
    $X = ini_get($bd);
    switch (strtolower(substr($X, -1))) {
        case 'g':
            $X *= 1024;
        case 'm':
            $X *= 1024;
        case 'k':
            $X *= 1024;
    }
    return $X;
}
function doc_link($Qe, $Bg = "<sup>?</sup>")
{
    global $y, $e;
    $Pf = $e->server_info;
    $rh = preg_replace('~^(\d\.?\d).*~s', '\1', $Pf);
    $ih = array(
        'sql' => "https://dev.mysql.com/doc/refman/$rh/en/",
        'sqlite' => "https://www.sqlite.org/",
        'pgsql' => "https://www.postgresql.org/docs/$rh/",
        'mssql' => "https://msdn.microsoft.com/library/",
        'oracle' => "https://www.oracle.com/pls/topic/lookup?ctx=db" . preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s', '\1\2', $Pf) . "&id="
    );
    if (preg_match('~MariaDB~', $Pf)) {
        $ih['sql'] = "https://mariadb.com/kb/en/library/";
        $Qe['sql'] = (isset($Qe['mariadb']) ? $Qe['mariadb'] : str_replace(".html", "/", $Qe['sql']));
    }
    return ($Qe[$y] ? "<a href='" . h($ih[$y] . $Qe[$y]) . "'" . target_blank() . ">$Bg</a>" : "");
}
function ob_gzencode($ig)
{
    return gzencode($ig);
}
function db_size($i)
{
    global $e;
    if (!$e->select_db($i))
        return "?";
    $K = 0;
    foreach (table_status() as $R)
        $K += $R["Data_length"] + $R["Index_length"];
    return format_number($K);
}
function set_utf8mb4($g)
{
    global $e;
    static $P = false;
    if (!$P && preg_match('~\butf8mb4~i', $g)) {
        $P = true;
        echo "SET NAMES " . charset($e) . ";\n\n";
    }
}
function connect_error()
{
    global $b, $e, $T, $k, $Kb;
    if (DB != "") {
        header("HTTP/1.1 404 Not Found");
        page_header('Database' . ": " . h(DB), 'Invalid database.', true);
    } else {
        if ($_POST["db"] && !$k)
            queries_redirect(substr(ME, 0, -1), 'Databases have been dropped.', drop_databases($_POST["db"]));
        page_header('Select database', $k, false);
        echo "<p class='links'>\n";
        foreach (array(
            'database' => 'Create database',
            'privileges' => 'Privileges',
            'processlist' => 'Process list',
            'variables' => 'Variables',
            'status' => 'Status'
        ) as $z => $X) {
            if (support($z))
                echo "<a href='" . h(ME) . "$z='>$X</a>\n";
        }
        echo "<p>" . sprintf('%s version: %s through PHP extension %s', $Kb[DRIVER], "<b>" . h($e->server_info) . "</b>", "<b>$e->extension</b>") . "\n", "<p>" . sprintf('Logged as: %s', "<b>" . h(logged_user()) . "</b>") . "\n";
        $h = $b->databases();
        if ($h) {
            $If = support("scheme");
            $Xa = collations();
            echo "<form action='' method='post'>\n", "<table cellspacing='0' class='checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), "<thead><tr>" . (support("database") ? "<td>" : "") . "<th>" . 'Database' . " - <a href='" . h(ME) . "refresh=1'>" . 'Refresh' . "</a>" . "<td>" . 'Collation' . "<td>" . 'Tables' . "<td>" . 'Size' . " - <a href='" . h(ME) . "dbsize=1'>" . 'Compute' . "</a>" . script("qsl('a').onclick = partial(ajaxSetHtml, '" . js_escape(ME) . "script=connect');", "") . "</thead>\n";
            $h = ($_GET["dbsize"] ? count_tables($h) : array_flip($h));
            foreach ($h as $i => $S) {
                $Bf = h(ME) . "db=" . urlencode($i);
                $u  = h("Db-" . $i);
                echo "<tr" . odd() . ">" . (support("database") ? "<td>" . checkbox("db[]", $i, in_array($i, (array) $_POST["db"]), "", "", "", $u) : ""), "<th><a href='$Bf' id='$u'>" . h($i) . "</a>";
                $Wa = h(db_collation($i, $Xa));
                echo "<td>" . (support("database") ? "<a href='$Bf" . ($If ? "&amp;ns=" : "") . "&amp;database=' title='" . 'Alter database' . "'>$Wa</a>" : $Wa), "<td align='right'><a href='$Bf&amp;schema=' id='tables-" . h($i) . "' title='" . 'Database schema' . "'>" . ($_GET["dbsize"] ? $S : "?") . "</a>", "<td align='right' id='size-" . h($i) . "'>" . ($_GET["dbsize"] ? db_size($i) : "?"), "\n";
            }
            echo "</table>\n", (support("database") ? "<div class='footer'><div>\n" . "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>\n" . "<input type='hidden' name='all' value=''>" . script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };") . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm() . "\n" . "</div></fieldset>\n" . "</div></div>\n" : ""), "<input type='hidden' name='token' value='$T'>\n", "</form>\n", script("tableCheck();");
        }
    }
    page_footer("db");
}
if (isset($_GET["status"]))
    $_GET["variables"] = $_GET["status"];
if (isset($_GET["import"]))
    $_GET["sql"] = $_GET["import"];
if (!(DB != "" ? $e->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
    if (DB != "" || $_GET["refresh"]) {
        restart_session();
        set_session("dbs", null);
    }
    connect_error();
    exit;
}
$oe = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";
class TmpFile
{
    var $handler;
    var $size;
    function __construct()
    {
        $this->handler = tmpfile();
    }
    function write($hb)
    {
        $this->size += strlen($hb);
        fwrite($this->handler, $hb);
    }
    function send()
    {
        fseek($this->handler, 0);
        fpassthru($this->handler);
        fclose($this->handler);
    }
}
$bc = "'(?:''|[^'\\\\]|\\\\.)*'";
$cd = "IN|OUT|INOUT";
if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"])
    $_GET["edit"] = $_GET["select"];
if (isset($_GET["callf"]))
    $_GET["call"] = $_GET["callf"];
if (isset($_GET["function"]))
    $_GET["procedure"] = $_GET["function"];
if (isset($_GET["download"])) {
    $a = $_GET["download"];
    $m = fields($a);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . friendly_url("$a-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
    $N = array(
        idf_escape($_GET["field"])
    );
    $J = $j->select($a, $N, array(
        where($_GET, $m)
    ), $N);
    $L = ($J ? $J->fetch_row() : array());
    echo $j->value($L[0], $m[$_GET["field"]]);
    exit;
} elseif (isset($_GET["table"])) {
    $a = $_GET["table"];
    $m = fields($a);
    if (!$m)
        $k = error();
    $R = table_status1($a, true);
    $E = $b->tableName($R);
    page_header(($m && is_view($R) ? $R['Engine'] == 'materialized view' ? 'Materialized view' : 'View' : 'Table') . ": " . ($E != "" ? $E : h($a)), $k);
    $b->selectLinks($R);
    $bb = $R["Comment"];
    if ($bb != "")
        echo "<p class='nowrap'>" . 'Comment' . ": " . h($bb) . "\n";
    if ($m)
        $b->tableStructurePrint($m);
    if (!is_view($R)) {
        if (support("indexes")) {
            echo "<h3 id='indexes'>" . 'Indexes' . "</h3>\n";
            $w = indexes($a);
            if ($w)
                $b->tableIndexesPrint($w);
            echo '<p class="links"><a href="' . h(ME) . 'indexes=' . urlencode($a) . '">' . 'Alter indexes' . "</a>\n";
        }
        if (fk_support($R)) {
            echo "<h3 id='foreign-keys'>" . 'Foreign keys' . "</h3>\n";
            $o = foreign_keys($a);
            if ($o) {
                echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Source' . "<td>" . 'Target' . "<td>" . 'ON DELETE' . "<td>" . 'ON UPDATE' . "<td></thead>\n";
                foreach ($o as $E => $n) {
                    echo "<tr title='" . h($E) . "'>", "<th><i>" . implode("</i>, <i>", array_map('h', $n["source"])) . "</i>", "<td><a href='" . h($n["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($n["db"]), ME) : ($n["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($n["ns"]), ME) : ME)) . "table=" . urlencode($n["table"]) . "'>" . ($n["db"] != "" ? "<b>" . h($n["db"]) . "</b>." : "") . ($n["ns"] != "" ? "<b>" . h($n["ns"]) . "</b>." : "") . h($n["table"]) . "</a>", "(<i>" . implode("</i>, <i>", array_map('h', $n["target"])) . "</i>)", "<td>" . h($n["on_delete"]) . "\n", "<td>" . h($n["on_update"]) . "\n", '<td><a href="' . h(ME . 'foreign=' . urlencode($a) . '&name=' . urlencode($E)) . '">' . 'Alter' . '</a>';
                }
                echo "</table>\n";
            }
            echo '<p class="links"><a href="' . h(ME) . 'foreign=' . urlencode($a) . '">' . 'Add foreign key' . "</a>\n";
        }
    }
    if (support(is_view($R) ? "view_trigger" : "trigger")) {
        echo "<h3 id='triggers'>" . 'Triggers' . "</h3>\n";
        $Ug = triggers($a);
        if ($Ug) {
            echo "<table cellspacing='0'>\n";
            foreach ($Ug as $z => $X)
                echo "<tr valign='top'><td>" . h($X[0]) . "<td>" . h($X[1]) . "<th>" . h($z) . "<td><a href='" . h(ME . 'trigger=' . urlencode($a) . '&name=' . urlencode($z)) . "'>" . 'Alter' . "</a>\n";
            echo "</table>\n";
        }
        echo '<p class="links"><a href="' . h(ME) . 'trigger=' . urlencode($a) . '">' . 'Add trigger' . "</a>\n";
    }
} elseif (isset($_GET["schema"])) {
    page_header('Database schema', "", array(), h(DB . ($_GET["ns"] ? ".$_GET[ns]" : "")));
    $sg = array();
    $tg = array();
    $ea = ($_GET["schema"] ? $_GET["schema"] : $_COOKIE["adminer_schema-" . str_replace(".", "_", DB)]);
    preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $ea, $Gd, PREG_SET_ORDER);
    foreach ($Gd as $t => $C) {
        $sg[$C[1]] = array(
            $C[2],
            $C[3]
        );
        $tg[]      = "\n\t'" . js_escape($C[1]) . "': [ $C[2], $C[3] ]";
    }
    $Mg = 0;
    $Ca = -1;
    $Hf = array();
    $tf = array();
    $xd = array();
    foreach (table_status('', true) as $Q => $R) {
        if (is_view($R))
            continue;
        $We               = 0;
        $Hf[$Q]["fields"] = array();
        foreach (fields($Q) as $E => $l) {
            $We += 1.25;
            $l["pos"]             = $We;
            $Hf[$Q]["fields"][$E] = $l;
        }
        $Hf[$Q]["pos"] = ($sg[$Q] ? $sg[$Q] : array(
            $Mg,
            0
        ));
        foreach ($b->foreignKeys($Q) as $X) {
            if (!$X["db"]) {
                $vd = $Ca;
                if ($sg[$Q][1] || $sg[$X["table"]][1])
                    $vd = min(floatval($sg[$Q][1]), floatval($sg[$X["table"]][1])) - 1;
                else
                    $Ca -= .1;
                while ($xd[(string) $vd])
                    $vd -= .0001;
                $Hf[$Q]["references"][$X["table"]][(string) $vd] = array(
                    $X["source"],
                    $X["target"]
                );
                $tf[$X["table"]][$Q][(string) $vd]               = $X["target"];
                $xd[(string) $vd]                                = true;
            }
        }
        $Mg = max($Mg, $Hf[$Q]["pos"][0] + 2.5 + $We);
    }
    echo '<div id="schema" style="height: ', $Mg, 'em;">
<script', nonce(), '>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {', implode(",", $tg) . "\n", '};
var em = qs(\'#schema\').offsetHeight / ', $Mg, ';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'', js_escape(DB), '\');
</script>
';
    foreach ($Hf as $E => $Q) {
        echo "<div class='table' style='top: " . $Q["pos"][0] . "em; left: " . $Q["pos"][1] . "em;'>", '<a href="' . h(ME) . 'table=' . urlencode($E) . '"><b>' . h($E) . "</b></a>", script("qsl('div').onmousedown = schemaMousedown;");
        foreach ($Q["fields"] as $l) {
            $X = '<span' . type_class($l["type"]) . ' title="' . h($l["full_type"] . ($l["null"] ? " NULL" : '')) . '">' . h($l["field"]) . '</span>';
            echo "<br>" . ($l["primary"] ? "<i>$X</i>" : $X);
        }
        foreach ((array) $Q["references"] as $zg => $uf) {
            foreach ($uf as $vd => $qf) {
                $wd = $vd - $sg[$E][1];
                $t  = 0;
                foreach ($qf[0] as $Yf)
                    echo "\n<div class='references' title='" . h($zg) . "' id='refs$vd-" . ($t++) . "' style='left: $wd" . "em; top: " . $Q["fields"][$Yf]["pos"] . "em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: " . (-$wd) . "em;'></div></div>";
            }
        }
        foreach ((array) $tf[$E] as $zg => $uf) {
            foreach ($uf as $vd => $d) {
                $wd = $vd - $sg[$E][1];
                $t  = 0;
                foreach ($d as $yg)
                    echo "\n<div class='references' title='" . h($zg) . "' id='refd$vd-" . ($t++) . "' style='left: $wd" . "em; top: " . $Q["fields"][$yg]["pos"] . "em; height: 1.25em; background: url(" . h(preg_replace("~\\?.*~", "", ME) . "?file=arrow.gif) no-repeat right center;&version=4.8.1") . "'><div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$wd) . "em;'></div></div>";
            }
        }
        echo "\n</div>\n";
    }
    foreach ($Hf as $E => $Q) {
        foreach ((array) $Q["references"] as $zg => $uf) {
            foreach ($uf as $vd => $qf) {
                $Sd = $Mg;
                $Kd = -10;
                foreach ($qf[0] as $z => $Yf) {
                    $Xe = $Q["pos"][0] + $Q["fields"][$Yf]["pos"];
                    $Ye = $Hf[$zg]["pos"][0] + $Hf[$zg]["fields"][$qf[1][$z]]["pos"];
                    $Sd = min($Sd, $Xe, $Ye);
                    $Kd = max($Kd, $Xe, $Ye);
                }
                echo "<div class='references' id='refl$vd' style='left: $vd" . "em; top: $Sd" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($Kd - $Sd) . "em;'></div></div>\n";
            }
        }
    }
    echo '</div>
<p class="links"><a href="', h(ME . "schema=" . urlencode($ea)), '" id="schema-link">Permanent link</a>
';
} elseif (isset($_GET["dump"])) {
    $a = $_GET["dump"];
    if ($_POST && !$k) {
        $kb = "";
        foreach (array(
            "output",
            "format",
            "db_style",
            "routines",
            "events",
            "table_style",
            "auto_increment",
            "triggers",
            "data_style"
        ) as $z)
            $kb .= "&$z=" . urlencode($_POST[$z]);
        cookie("adminer_export", substr($kb, 1));
        $S  = array_flip((array) $_POST["tables"]) + array_flip((array) $_POST["data"]);
        $nc = dump_headers((count($S) == 1 ? key($S) : DB), (DB == "" || count($S) > 1));
        $kd = preg_match('~sql~', $_POST["format"]);
        if ($kd) {
            echo "-- Adminer $ga " . $Kb[DRIVER] . " " . str_replace("\n", " ", $e->server_info) . " dump\n\n";
            if ($y == "sql") {
                echo "SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
" . ($_POST["data_style"] ? "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
";
                $e->query("SET time_zone = '+00:00'");
                $e->query("SET sql_mode = ''");
            }
        }
        $kg = $_POST["db_style"];
        $h  = array(
            DB
        );
        if (DB == "") {
            $h = $_POST["databases"];
            if (is_string($h))
                $h = explode("\n", rtrim(str_replace("\r", "", $h), "\n"));
        }
        foreach ((array) $h as $i) {
            $b->dumpDatabase($i);
            if ($e->select_db($i)) {
                if ($kd && preg_match('~CREATE~', $kg) && ($g = $e->result("SHOW CREATE DATABASE " . idf_escape($i), 1))) {
                    set_utf8mb4($g);
                    if ($kg == "DROP+CREATE")
                        echo "DROP DATABASE IF EXISTS " . idf_escape($i) . ";\n";
                    echo "$g;\n";
                }
                if ($kd) {
                    if ($kg)
                        echo use_sql($i) . ";\n\n";
                    $Ee = "";
                    if ($_POST["routines"]) {
                        foreach (array(
                            "FUNCTION",
                            "PROCEDURE"
                        ) as $Cf) {
                            foreach (get_rows("SHOW $Cf STATUS WHERE Db = " . q($i), null, "-- ") as $L) {
                                $g = remove_definer($e->result("SHOW CREATE $Cf " . idf_escape($L["Name"]), 2));
                                set_utf8mb4($g);
                                $Ee .= ($kg != 'DROP+CREATE' ? "DROP $Cf IF EXISTS " . idf_escape($L["Name"]) . ";;\n" : "") . "$g;;\n\n";
                            }
                        }
                    }
                    if ($_POST["events"]) {
                        foreach (get_rows("SHOW EVENTS", null, "-- ") as $L) {
                            $g = remove_definer($e->result("SHOW CREATE EVENT " . idf_escape($L["Name"]), 3));
                            set_utf8mb4($g);
                            $Ee .= ($kg != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($L["Name"]) . ";;\n" : "") . "$g;;\n\n";
                        }
                    }
                    if ($Ee)
                        echo "DELIMITER ;;\n\n$Ee" . "DELIMITER ;\n\n";
                }
                if ($_POST["table_style"] || $_POST["data_style"]) {
                    $th = array();
                    foreach (table_status('', true) as $E => $R) {
                        $Q  = (DB == "" || in_array($E, (array) $_POST["tables"]));
                        $sb = (DB == "" || in_array($E, (array) $_POST["data"]));
                        if ($Q || $sb) {
                            if ($nc == "tar") {
                                $Kg = new TmpFile;
                                ob_start(array(
                                    $Kg,
                                    'write'
                                ), 1e5);
                            }
                            $b->dumpTable($E, ($Q ? $_POST["table_style"] : ""), (is_view($R) ? 2 : 0));
                            if (is_view($R))
                                $th[] = $E;
                            elseif ($sb) {
                                $m = fields($E);
                                $b->dumpData($E, $_POST["data_style"], "SELECT *" . convert_fields($m, $m) . " FROM " . table($E));
                            }
                            if ($kd && $_POST["triggers"] && $Q && ($Ug = trigger_sql($E)))
                                echo "\nDELIMITER ;;\n$Ug\nDELIMITER ;\n";
                            if ($nc == "tar") {
                                ob_end_flush();
                                tar_file((DB != "" ? "" : "$i/") . "$E.csv", $Kg);
                            } elseif ($kd)
                                echo "\n";
                        }
                    }
                    if (function_exists('foreign_keys_sql')) {
                        foreach (table_status('', true) as $E => $R) {
                            $Q = (DB == "" || in_array($E, (array) $_POST["tables"]));
                            if ($Q && !is_view($R))
                                echo foreign_keys_sql($E);
                        }
                    }
                    foreach ($th as $sh)
                        $b->dumpTable($sh, $_POST["table_style"], 1);
                    if ($nc == "tar")
                        echo pack("x512");
                }
            }
        }
        if ($kd)
            echo "-- " . $e->result("SELECT NOW()") . "\n";
        exit;
    }
    page_header('Export', $k, ($_GET["export"] != "" ? array(
        "table" => $_GET["export"]
    ) : array()), h(DB));
    echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
';
    $wb = array(
        '',
        'USE',
        'DROP+CREATE',
        'CREATE'
    );
    $ug = array(
        '',
        'DROP+CREATE',
        'CREATE'
    );
    $tb = array(
        '',
        'TRUNCATE+INSERT',
        'INSERT'
    );
    if ($y == "sql")
        $tb[] = 'INSERT+UPDATE';
    parse_str($_COOKIE["adminer_export"], $L);
    if (!$L)
        $L = array(
            "output" => "text",
            "format" => "sql",
            "db_style" => (DB != "" ? "" : "CREATE"),
            "table_style" => "DROP+CREATE",
            "data_style" => "INSERT"
        );
    if (!isset($L["events"])) {
        $L["routines"] = $L["events"] = ($_GET["dump"] == "");
        $L["triggers"] = $L["table_style"];
    }
    echo "<tr><th>" . 'Output' . "<td>" . html_select("output", $b->dumpOutput(), $L["output"], 0) . "\n";
    echo "<tr><th>" . 'Format' . "<td>" . html_select("format", $b->dumpFormat(), $L["format"], 0) . "\n";
    echo ($y == "sqlite" ? "" : "<tr><th>" . 'Database' . "<td>" . html_select('db_style', $wb, $L["db_style"]) . (support("routine") ? checkbox("routines", 1, $L["routines"], 'Routines') : "") . (support("event") ? checkbox("events", 1, $L["events"], 'Events') : "")), "<tr><th>" . 'Tables' . "<td>" . html_select('table_style', $ug, $L["table_style"]) . checkbox("auto_increment", 1, $L["auto_increment"], 'Auto Increment') . (support("trigger") ? checkbox("triggers", 1, $L["triggers"], 'Triggers') : ""), "<tr><th>" . 'Data' . "<td>" . html_select('data_style', $tb, $L["data_style"]), '</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="', $T, '">

<table cellspacing="0">
', script("qsl('table').onclick = dumpClick;");
    $bf = array();
    if (DB != "") {
        $Na = ($a != "" ? "" : " checked");
        echo "<thead><tr>", "<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Na>" . 'Tables' . "</label>" . script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", ""), "<th style='text-align: right;'><label class='block'>" . 'Data' . "<input type='checkbox' id='check-data'$Na></label>" . script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", ""), "</thead>\n";
        $th = "";
        $vg = tables_list();
        foreach ($vg as $E => $U) {
            $af = preg_replace('~_.*~', '', $E);
            $Na = ($a == "" || $a == (substr($a, -1) == "%" ? "$af%" : $E));
            $df = "<tr><td>" . checkbox("tables[]", $E, $Na, $E, "", "block");
            if ($U !== null && !preg_match('~table~i', $U))
                $th .= "$df\n";
            else
                echo "$df<td align='right'><label class='block'><span id='Rows-" . h($E) . "'></span>" . checkbox("data[]", $E, $Na) . "</label>\n";
            $bf[$af]++;
        }
        echo $th;
        if ($vg)
            echo script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
    } else {
        echo "<thead><tr><th style='text-align: left;'>", "<label class='block'><input type='checkbox' id='check-databases'" . ($a == "" ? " checked" : "") . ">" . 'Database' . "</label>", script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", ""), "</thead>\n";
        $h = $b->databases();
        if ($h) {
            foreach ($h as $i) {
                if (!information_schema($i)) {
                    $af = preg_replace('~_.*~', '', $i);
                    echo "<tr><td>" . checkbox("databases[]", $i, $a == "" || $a == "$af%", $i, "", "block") . "\n";
                    $bf[$af]++;
                }
            }
        } else
            echo "<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
    }
    echo '</table>
</form>
';
    $xc = true;
    foreach ($bf as $z => $X) {
        if ($z != "" && $X > 1) {
            echo ($xc ? "<p>" : " ") . "<a href='" . h(ME) . "dump=" . urlencode("$z%") . "'>" . h($z) . "</a>";
            $xc = false;
        }
    }
} elseif (isset($_GET["privileges"])) {
    page_header('Privileges');
    echo '<p class="links"><a href="' . h(ME) . 'user=">' . 'Create user' . "</a>";
    $J = $e->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
    $r = $J;
    if (!$J)
        $J = $e->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
    echo "<form action=''><p>\n";
    hidden_fields_get();
    echo "<input type='hidden' name='db' value='" . h(DB) . "'>\n", ($r ? "" : "<input type='hidden' name='grant' value=''>\n"), "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Username' . "<th>" . 'Server' . "<th></thead>\n";
    while ($L = $J->fetch_assoc())
        echo '<tr' . odd() . '><td>' . h($L["User"]) . "<td>" . h($L["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($L["User"]) . '&host=' . urlencode($L["Host"])) . '">' . 'Edit' . "</a>\n";
    if (!$r || DB != "")
        echo "<tr" . odd() . "><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='" . 'Edit' . "'>\n";
    echo "</table>\n", "</form>\n";
} elseif (isset($_GET["sql"])) {
    if (!$k && $_POST["export"]) {
        dump_headers("sql");
        $b->dumpTable("", "");
        $b->dumpData("", "table", $_POST["query"]);
        exit;
    }
    restart_session();
    $Sc =& get_session("queries");
    $Rc =& $Sc[DB];
    if (!$k && $_POST["clear"]) {
        $Rc = array();
        redirect(remove_from_uri("history"));
    }
    page_header((isset($_GET["import"]) ? 'Import' : 'SQL command'), $k);
    if (!$k && $_POST) {
        $p = false;
        if (!isset($_GET["import"]))
            $I = $_POST["query"];
        elseif ($_POST["webfile"]) {
            $bg = $b->importServerPath();
            $p  = @fopen((file_exists($bg) ? $bg : "compress.zlib://$bg.gz"), "rb");
            $I  = ($p ? fread($p, 1e6) : false);
        } else
            $I = get_file("sql_file", true);
        if (is_string($I)) {
            if (function_exists('memory_get_usage'))
                @ini_set("memory_limit", max(ini_bytes("memory_limit"), 2 * strlen($I) + memory_get_usage() + 8e6));
            if ($I != "" && strlen($I) < 1e6) {
                $H = $I . (preg_match("~;[ \t\r\n]*\$~", $I) ? "" : ";");
                if (!$Rc || reset(end($Rc)) != $H) {
                    restart_session();
                    $Rc[] = array(
                        $H,
                        time()
                    );
                    set_session("queries", $Sc);
                    stop_session();
                }
            }
            $Zf = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
            $Cb = ";";
            $he = 0;
            $Yb = true;
            $f  = connect();
            if (is_object($f) && DB != "") {
                $f->select_db(DB);
                if ($_GET["ns"] != "")
                    set_schema($_GET["ns"], $f);
            }
            $ab = 0;
            $dc = array();
            $Ke = '[\'"' . ($y == "sql" ? '`#' : ($y == "sqlite" ? '`[' : ($y == "mssql" ? '[' : ''))) . ']|/\*|-- |$' . ($y == "pgsql" ? '|\$[^$]*\$' : '');
            $Ng = microtime(true);
            parse_str($_COOKIE["adminer_export"], $la);
            $Pb = $b->dumpFormat();
            unset($Pb["sql"]);
            while ($I != "") {
                if (!$he && preg_match("~^$Zf*+DELIMITER\\s+(\\S+)~i", $I, $C)) {
                    $Cb = $C[1];
                    $I  = substr($I, strlen($C[0]));
                } else {
                    preg_match('(' . preg_quote($Cb) . "\\s*|$Ke)", $I, $C, PREG_OFFSET_CAPTURE, $he);
                    list($Cc, $We) = $C[0];
                    if (!$Cc && $p && !feof($p))
                        $I .= fread($p, 1e5);
                    else {
                        if (!$Cc && rtrim($I) == "")
                            break;
                        $he = $We + strlen($Cc);
                        if ($Cc && rtrim($Cc) != $Cb) {
                            while (preg_match('(' . ($Cc == '/*' ? '\*/' : ($Cc == '[' ? ']' : (preg_match('~^-- |^#~', $Cc) ? "\n" : preg_quote($Cc) . "|\\\\."))) . '|$)s', $I, $C, PREG_OFFSET_CAPTURE, $he)) {
                                $Ff = $C[0][0];
                                if (!$Ff && $p && !feof($p))
                                    $I .= fread($p, 1e5);
                                else {
                                    $he = $C[0][1] + strlen($Ff);
                                    if ($Ff[0] != "\\")
                                        break;
                                }
                            }
                        } else {
                            $Yb = false;
                            $H  = substr($I, 0, $We);
                            $ab++;
                            $df = "<pre id='sql-$ab'><code class='jush-$y'>" . $b->sqlCommandQuery($H) . "</code></pre>\n";
                            if ($y == "sqlite" && preg_match("~^$Zf*+ATTACH\\b~i", $H, $C)) {
                                echo $df, "<p class='error'>" . 'ATTACH queries are not supported.' . "\n";
                                $dc[] = " <a href='#sql-$ab'>$ab</a>";
                                if ($_POST["error_stops"])
                                    break;
                            } else {
                                if (!$_POST["only_errors"]) {
                                    echo $df;
                                    ob_flush();
                                    flush();
                                }
                                $eg = microtime(true);
                                if ($e->multi_query($H) && is_object($f) && preg_match("~^$Zf*+USE\\b~i", $H))
                                    $f->query($H);
                                do {
                                    $J = $e->store_result();
                                    if ($e->error) {
                                        echo ($_POST["only_errors"] ? $df : ""), "<p class='error'>" . 'Error in query' . ($e->errno ? " ($e->errno)" : "") . ": " . error() . "\n";
                                        $dc[] = " <a href='#sql-$ab'>$ab</a>";
                                        if ($_POST["error_stops"])
                                            break 2;
                                    } else {
                                        $Dg = " <span class='time'>(" . format_time($eg) . ")</span>" . (strlen($H) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($H)) . "'>" . 'Edit' . "</a>" : "");
                                        $na = $e->affected_rows;
                                        $wh = ($_POST["only_errors"] ? "" : $j->warnings());
                                        $xh = "warnings-$ab";
                                        if ($wh)
                                            $Dg .= ", <a href='#$xh'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$xh');", "");
                                        $lc = null;
                                        $mc = "explain-$ab";
                                        if (is_object($J)) {
                                            $_  = $_POST["limit"];
                                            $ze = select($J, $f, array(), $_);
                                            if (!$_POST["only_errors"]) {
                                                echo "<form action='' method='post'>\n";
                                                $ee = $J->num_rows;
                                                echo "<p>" . ($ee ? ($_ && $ee > $_ ? sprintf('%d / ', $_) : "") . lang(array(
                                                    '%d row',
                                                    '%d rows'
                                                ), $ee) : ""), $Dg;
                                                if ($f && preg_match("~^($Zf|\\()*+SELECT\\b~i", $H) && ($lc = explain($f, $H)))
                                                    echo ", <a href='#$mc'>Explain</a>" . script("qsl('a').onclick = partial(toggle, '$mc');", "");
                                                $u = "export-$ab";
                                                echo ", <a href='#$u'>" . 'Export' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "<span id='$u' class='hidden'>: " . html_select("output", $b->dumpOutput(), $la["output"]) . " " . html_select("format", $Pb, $la["format"]) . "<input type='hidden' name='query' value='" . h($H) . "'>" . " <input type='submit' name='export' value='" . 'Export' . "'><input type='hidden' name='token' value='$T'></span>\n" . "</form>\n";
                                            }
                                        } else {
                                            if (preg_match("~^$Zf*+(CREATE|DROP|ALTER)$Zf++(DATABASE|SCHEMA)\\b~i", $H)) {
                                                restart_session();
                                                set_session("dbs", null);
                                                stop_session();
                                            }
                                            if (!$_POST["only_errors"])
                                                echo "<p class='message' title='" . h($e->info) . "'>" . lang(array(
                                                    'Query executed OK, %d row affected.',
                                                    'Query executed OK, %d rows affected.'
                                                ), $na) . "$Dg\n";
                                        }
                                        echo ($wh ? "<div id='$xh' class='hidden'>\n$wh</div>\n" : "");
                                        if ($lc) {
                                            echo "<div id='$mc' class='hidden'>\n";
                                            select($lc, $f, $ze);
                                            echo "</div>\n";
                                        }
                                    }
                                    $eg = microtime(true);
                                } while ($e->next_result());
                            }
                            $I  = substr($I, $he);
                            $he = 0;
                        }
                    }
                }
            }
            if ($Yb)
                echo "<p class='message'>" . 'No commands to execute.' . "\n";
            elseif ($_POST["only_errors"]) {
                echo "<p class='message'>" . lang(array(
                    '%d query executed OK.',
                    '%d queries executed OK.'
                ), $ab - count($dc)), " <span class='time'>(" . format_time($Ng) . ")</span>\n";
            } elseif ($dc && $ab > 1)
                echo "<p class='error'>" . 'Error in query' . ": " . implode("", $dc) . "\n";
        } else
            echo "<p class='error'>" . upload_error($I) . "\n";
    }
    echo '
<form action="" method="post" enctype="multipart/form-data" id="form">
';
    $jc = "<input type='submit' value='" . 'Execute' . "' title='Ctrl+Enter'>";
    if (!isset($_GET["import"])) {
        $H = $_GET["sql"];
        if ($_POST)
            $H = $_POST["query"];
        elseif ($_GET["history"] == "all")
            $H = $Rc;
        elseif ($_GET["history"] != "")
            $H = $Rc[$_GET["history"]][0];
        echo "<p>";
        textarea("query", $H, 20);
        echo script(($_POST ? "" : "qs('textarea').focus();\n") . "qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '" . js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history")) . "');"), "<p>$jc\n", 'Limit rows' . ": <input type='number' name='limit' class='size' value='" . h($_POST ? $_POST["limit"] : $_GET["limit"]) . "'>\n";
    } else {
        echo "<fieldset><legend>" . 'File upload' . "</legend><div>";
        $Kc = (extension_loaded("zlib") ? "[.gz]" : "");
        echo (ini_bool("file_uploads") ? "SQL$Kc (&lt; " . ini_get("upload_max_filesize") . "B): <input type='file' name='sql_file[]' multiple>\n$jc" : 'File uploads are disabled.'), "</div></fieldset>\n";
        $Yc = $b->importServerPath();
        if ($Yc) {
            echo "<fieldset><legend>" . 'From server' . "</legend><div>", sprintf('Webserver file %s', "<code>" . h($Yc) . "$Kc</code>"), ' <input type="submit" name="webfile" value="' . 'Run file' . '">', "</div></fieldset>\n";
        }
        echo "<p>";
    }
    echo checkbox("error_stops", 1, ($_POST ? $_POST["error_stops"] : isset($_GET["import"]) || $_GET["error_stops"]), 'Stop on error') . "\n", checkbox("only_errors", 1, ($_POST ? $_POST["only_errors"] : isset($_GET["import"]) || $_GET["only_errors"]), 'Show only errors') . "\n", "<input type='hidden' name='token' value='$T'>\n";
    if (!isset($_GET["import"]) && $Rc) {
        print_fieldset("history", 'History', $_GET["history"] != "");
        for ($X = end($Rc); $X; $X = prev($Rc)) {
            $z = key($Rc);
            list($H, $Dg, $Tb) = $X;
            echo '<a href="' . h(ME . "sql=&history=$z") . '">' . 'Edit' . "</a>" . " <span class='time' title='" . @date('Y-m-d', $Dg) . "'>" . @date("H:i:s", $Dg) . "</span>" . " <code class='jush-$y'>" . shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $H)))), 80, "</code>") . ($Tb ? " <span class='time'>($Tb)</span>" : "") . "<br>\n";
        }
        echo "<input type='submit' name='clear' value='" . 'Clear' . "'>\n", "<a href='" . h(ME . "sql=&history=all") . "'>" . 'Edit all' . "</a>\n", "</div></fieldset>\n";
    }
    echo '</form>
';
} elseif (isset($_GET["edit"])) {
    $a  = $_GET["edit"];
    $m  = fields($a);
    $Z  = (isset($_GET["select"]) ? ($_POST["check"] && count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $m) : "") : where($_GET, $m));
    $fh = (isset($_GET["select"]) ? $_POST["edit"] : $Z);
    foreach ($m as $E => $l) {
        if (!isset($l["privileges"][$fh ? "update" : "insert"]) || $b->fieldName($l) == "" || $l["generated"])
            unset($m[$E]);
    }
    if ($_POST && !$k && !isset($_GET["select"])) {
        $B = $_POST["referer"];
        if ($_POST["insert"])
            $B = ($fh ? null : $_SERVER["REQUEST_URI"]);
        elseif (!preg_match('~^.+&select=.+$~', $B))
            $B = ME . "select=" . urlencode($a);
        $w  = indexes($a);
        $ah = unique_array($_GET["where"], $w);
        $mf = "\nWHERE $Z";
        if (isset($_POST["delete"]))
            queries_redirect($B, 'Item has been deleted.', $j->delete($a, $mf, !$ah));
        else {
            $P = array();
            foreach ($m as $E => $l) {
                $X = process_input($l);
                if ($X !== false && $X !== null)
                    $P[idf_escape($E)] = $X;
            }
            if ($fh) {
                if (!$P)
                    redirect($B);
                queries_redirect($B, 'Item has been updated.', $j->update($a, $P, $mf, !$ah));
                if (is_ajax()) {
                    page_headers();
                    page_messages($k);
                    exit;
                }
            } else {
                $J  = $j->insert($a, $P);
                $ud = ($J ? last_id() : 0);
                queries_redirect($B, sprintf('Item%s has been inserted.', ($ud ? " $ud" : "")), $J);
            }
        }
    }
    $L = null;
    if ($_POST["save"])
        $L = (array) $_POST["fields"];
    elseif ($Z) {
        $N = array();
        foreach ($m as $E => $l) {
            if (isset($l["privileges"]["select"])) {
                $ua = convert_field($l);
                if ($_POST["clone"] && $l["auto_increment"])
                    $ua = "''";
                if ($y == "sql" && preg_match("~enum|set~", $l["type"]))
                    $ua = "1*" . idf_escape($E);
                $N[] = ($ua ? "$ua AS " : "") . idf_escape($E);
            }
        }
        $L = array();
        if (!support("table"))
            $N = array(
                "*"
            );
        if ($N) {
            $J = $j->select($a, $N, array(
                $Z
            ), $N, array(), (isset($_GET["select"]) ? 2 : 1));
            if (!$J)
                $k = error();
            else {
                $L = $J->fetch_assoc();
                if (!$L)
                    $L = false;
            }
            if (isset($_GET["select"]) && (!$L || $J->fetch_assoc()))
                $L = null;
        }
    }
    if (!support("table") && !$m) {
        if (!$Z) {
            $J = $j->select($a, array(
                "*"
            ), $Z, array(
                "*"
            ));
            $L = ($J ? $J->fetch_assoc() : false);
            if (!$L)
                $L = array(
                    $j->primary => ""
                );
        }
        if ($L) {
            foreach ($L as $z => $X) {
                if (!$Z)
                    $L[$z] = null;
                $m[$z] = array(
                    "field" => $z,
                    "null" => ($z != $j->primary),
                    "auto_increment" => ($z == $j->primary)
                );
            }
        }
    }
    edit_form($a, $m, $L, $fh);
} elseif (isset($_GET["create"])) {
    $a  = $_GET["create"];
    $Le = array();
    foreach (array(
        'HASH',
        'LINEAR HASH',
        'KEY',
        'LINEAR KEY',
        'RANGE',
        'LIST'
    ) as $z)
        $Le[$z] = $z;
    $sf = referencable_primary($a);
    $o  = array();
    foreach ($sf as $rg => $l)
        $o[str_replace("`", "``", $rg) . "`" . str_replace("`", "``", $l["field"])] = $rg;
    $Be = array();
    $R  = array();
    if ($a != "") {
        $Be = fields($a);
        $R  = table_status($a);
        if (!$R)
            $k = 'No tables.';
    }
    $L           = $_POST;
    $L["fields"] = (array) $L["fields"];
    if ($L["auto_increment_col"])
        $L["fields"][$L["auto_increment_col"]]["auto_increment"] = true;
    if ($_POST)
        set_adminer_settings(array(
            "comments" => $_POST["comments"],
            "defaults" => $_POST["defaults"]
        ));
    if ($_POST && !process_fields($L["fields"]) && !$k) {
        if ($_POST["drop"])
            queries_redirect(substr(ME, 0, -1), 'Table has been dropped.', drop_tables(array(
                $a
            )));
        else {
            $m  = array();
            $ra = array();
            $jh = false;
            $_c = array();
            $Ae = reset($Be);
            $pa = " FIRST";
            foreach ($L["fields"] as $z => $l) {
                $n  = $o[$l["type"]];
                $Vg = ($n !== null ? $sf[$n] : $l);
                if ($l["field"] != "") {
                    if (!$l["has_default"])
                        $l["default"] = null;
                    if ($z == $L["auto_increment_col"])
                        $l["auto_increment"] = true;
                    $if   = process_field($l, $Vg);
                    $ra[] = array(
                        $l["orig"],
                        $if,
                        $pa
                    );
                    if (!$Ae || $if != process_field($Ae, $Ae)) {
                        $m[] = array(
                            $l["orig"],
                            $if,
                            $pa
                        );
                        if ($l["orig"] != "" || $pa)
                            $jh = true;
                    }
                    if ($n !== null)
                        $_c[idf_escape($l["field"])] = ($a != "" && $y != "sqlite" ? "ADD" : " ") . format_foreign_key(array(
                            'table' => $o[$l["type"]],
                            'source' => array(
                                $l["field"]
                            ),
                            'target' => array(
                                $Vg["field"]
                            ),
                            'on_delete' => $l["on_delete"]
                        ));
                    $pa = " AFTER " . idf_escape($l["field"]);
                } elseif ($l["orig"] != "") {
                    $jh  = true;
                    $m[] = array(
                        $l["orig"]
                    );
                }
                if ($l["orig"] != "") {
                    $Ae = next($Be);
                    if (!$Ae)
                        $pa = "";
                }
            }
            $Ne = "";
            if ($Le[$L["partition_by"]]) {
                $Oe = array();
                if ($L["partition_by"] == 'RANGE' || $L["partition_by"] == 'LIST') {
                    foreach (array_filter($L["partition_names"]) as $z => $X) {
                        $Y    = $L["partition_values"][$z];
                        $Oe[] = "\n  PARTITION " . idf_escape($X) . " VALUES " . ($L["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($Y != "" ? " ($Y)" : " MAXVALUE");
                    }
                }
                $Ne .= "\nPARTITION BY $L[partition_by]($L[partition])" . ($Oe ? " (" . implode(",", $Oe) . "\n)" : ($L["partitions"] ? " PARTITIONS " . (+$L["partitions"]) : ""));
            } elseif (support("partitioning") && preg_match("~partitioned~", $R["Create_options"]))
                $Ne .= "\nREMOVE PARTITIONING";
            $D = 'Table has been altered.';
            if ($a == "") {
                cookie("adminer_engine", $L["Engine"]);
                $D = 'Table has been created.';
            }
            $E = trim($L["name"]);
            queries_redirect(ME . (support("table") ? "table=" : "select=") . urlencode($E), $D, alter_table($a, $E, ($y == "sqlite" && ($jh || $_c) ? $ra : $m), $_c, ($L["Comment"] != $R["Comment"] ? $L["Comment"] : null), ($L["Engine"] && $L["Engine"] != $R["Engine"] ? $L["Engine"] : ""), ($L["Collation"] && $L["Collation"] != $R["Collation"] ? $L["Collation"] : ""), ($L["Auto_increment"] != "" ? number($L["Auto_increment"]) : ""), $Ne));
        }
    }
    page_header(($a != "" ? 'Alter table' : 'Create table'), $k, array(
        "table" => $a
    ), h($a));
    if (!$_POST) {
        $L = array(
            "Engine" => $_COOKIE["adminer_engine"],
            "fields" => array(
                array(
                    "field" => "",
                    "type" => (isset($Xg["int"]) ? "int" : (isset($Xg["integer"]) ? "integer" : "")),
                    "on_update" => ""
                )
            ),
            "partition_names" => array(
                ""
            )
        );
        if ($a != "") {
            $L           = $R;
            $L["name"]   = $a;
            $L["fields"] = array();
            if (!$_GET["auto_increment"])
                $L["Auto_increment"] = "";
            foreach ($Be as $l) {
                $l["has_default"] = isset($l["default"]);
                $L["fields"][]    = $l;
            }
            if (support("partitioning")) {
                $Ec = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($a);
                $J  = $e->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $Ec ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
                list($L["partition_by"], $L["partitions"], $L["partition"]) = $J->fetch_row();
                $Oe                    = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $Ec AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
                $Oe[""]                = "";
                $L["partition_names"]  = array_keys($Oe);
                $L["partition_values"] = array_values($Oe);
            }
        }
    }
    $Xa = collations();
    $ac = engines();
    foreach ($ac as $Zb) {
        if (!strcasecmp($Zb, $L["Engine"])) {
            $L["Engine"] = $Zb;
            break;
        }
    }
    echo '
<form action="" method="post" id="form">
<p>
';
    if (support("columns") || $a == "") {
        echo 'Table name: <input name="name" data-maxlength="64" value="', h($L["name"]), '" autocapitalize="off">
';
        if ($a == "" && !$_POST)
            echo script("focus(qs('#form')['name']);");
        echo ($ac ? "<select name='Engine'>" . optionlist(array(
            "" => "(" . 'engine' . ")"
        ) + $ac, $L["Engine"]) . "</select>" . on_help("getTarget(event).value", 1) . script("qsl('select').onchange = helpClose;") : ""), ' ', ($Xa && !preg_match("~sqlite|mssql~", $y) ? html_select("Collation", array(
            "" => "(" . 'collation' . ")"
        ) + $Xa, $L["Collation"]) : ""), ' <input type="submit" value="Save">
';
    }
    echo '
';
    if (support("columns")) {
        echo '<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';
        edit_fields($L["fields"], $Xa, "TABLE", $o);
        echo '</table>
', script("editFields();"), '</div>
<p>
Auto Increment: <input type="number" name="Auto_increment" size="6" value="', h($L["Auto_increment"]), '">
', checkbox("defaults", 1, ($_POST ? $_POST["defaults"] : adminer_setting("defaults")), 'Default values', "columnShow(this.checked, 5)", "jsonly"), (support("comment") ? checkbox("comments", 1, ($_POST ? $_POST["comments"] : adminer_setting("comments")), 'Comment', "editingCommentsClick(this, true);", "jsonly") . ' <input name="Comment" value="' . h($L["Comment"]) . '" data-maxlength="' . (min_version(5.5) ? 2048 : 60) . '">' : ''), '<p>
<input type="submit" value="Save">
';
    }
    echo '
';
    if ($a != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
    }
    if (support("partitioning")) {
        $Me = preg_match('~RANGE|LIST~', $L["partition_by"]);
        print_fieldset("partition", 'Partition by', $L["partition_by"]);
        echo '<p>
', "<select name='partition_by'>" . optionlist(array(
            "" => ""
        ) + $Le, $L["partition_by"]) . "</select>" . on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1) . script("qsl('select').onchange = partitionByChange;"), '(<input name="partition" value="', h($L["partition"]), '">)
Partitions: <input type="number" name="partitions" class="size', ($Me || !$L["partition_by"] ? " hidden" : ""), '" value="', h($L["partitions"]), '">
<table cellspacing="0" id="partition-table"', ($Me ? "" : " class='hidden'"), '>
<thead><tr><th>Partition name<th>Values</thead>
';
        foreach ($L["partition_names"] as $z => $X) {
            echo '<tr>', '<td><input name="partition_names[]" value="' . h($X) . '" autocapitalize="off">', ($z == count($L["partition_names"]) - 1 ? script("qsl('input').oninput = partitionNameChange;") : ''), '<td><input name="partition_values[]" value="' . h($L["partition_values"][$z]) . '">';
        }
        echo '</table>
</div></fieldset>
';
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["indexes"])) {
    $a  = $_GET["indexes"];
    $ad = array(
        "PRIMARY",
        "UNIQUE",
        "INDEX"
    );
    $R  = table_status($a, true);
    if (preg_match('~MyISAM|M?aria' . (min_version(5.6, '10.0.5') ? '|InnoDB' : '') . '~i', $R["Engine"]))
        $ad[] = "FULLTEXT";
    if (preg_match('~MyISAM|M?aria' . (min_version(5.7, '10.2.2') ? '|InnoDB' : '') . '~i', $R["Engine"]))
        $ad[] = "SPATIAL";
    $w  = indexes($a);
    $cf = array();
    if ($y == "mongo") {
        $cf = $w["_id_"];
        unset($ad[0]);
        unset($w["_id_"]);
    }
    $L = $_POST;
    if ($_POST && !$k && !$_POST["add"] && !$_POST["drop_col"]) {
        $sa = array();
        foreach ($L["indexes"] as $v) {
            $E = $v["name"];
            if (in_array($v["type"], $ad)) {
                $d  = array();
                $_d = array();
                $Eb = array();
                $P  = array();
                ksort($v["columns"]);
                foreach ($v["columns"] as $z => $c) {
                    if ($c != "") {
                        $zd   = $v["lengths"][$z];
                        $Db   = $v["descs"][$z];
                        $P[]  = idf_escape($c) . ($zd ? "(" . (+$zd) . ")" : "") . ($Db ? " DESC" : "");
                        $d[]  = $c;
                        $_d[] = ($zd ? $zd : null);
                        $Eb[] = $Db;
                    }
                }
                if ($d) {
                    $kc = $w[$E];
                    if ($kc) {
                        ksort($kc["columns"]);
                        ksort($kc["lengths"]);
                        ksort($kc["descs"]);
                        if ($v["type"] == $kc["type"] && array_values($kc["columns"]) === $d && (!$kc["lengths"] || array_values($kc["lengths"]) === $_d) && array_values($kc["descs"]) === $Eb) {
                            unset($w[$E]);
                            continue;
                        }
                    }
                    $sa[] = array(
                        $v["type"],
                        $E,
                        $P
                    );
                }
            }
        }
        foreach ($w as $E => $kc)
            $sa[] = array(
                $kc["type"],
                $E,
                "DROP"
            );
        if (!$sa)
            redirect(ME . "table=" . urlencode($a));
        queries_redirect(ME . "table=" . urlencode($a), 'Indexes have been altered.', alter_indexes($a, $sa));
    }
    page_header('Indexes', $k, array(
        "table" => $a
    ), h($a));
    $m = array_keys(fields($a));
    if ($_POST["add"]) {
        foreach ($L["indexes"] as $z => $v) {
            if ($v["columns"][count($v["columns"])] != "")
                $L["indexes"][$z]["columns"][] = "";
        }
        $v = end($L["indexes"]);
        if ($v["type"] || array_filter($v["columns"], 'strlen'))
            $L["indexes"][] = array(
                "columns" => array(
                    1 => ""
                )
            );
    }
    if (!$L) {
        foreach ($w as $z => $v) {
            $w[$z]["name"]      = $z;
            $w[$z]["columns"][] = "";
        }
        $w[]          = array(
            "columns" => array(
                1 => ""
            )
        );
        $L["indexes"] = $w;
    }
    echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">Column (length)
<th id="label-name">Name
<th><noscript>', "<input type='submit' class='icon' name='add[0]' value='+' title='" . 'Add next' . "'>", '</noscript>
</thead>
';
    if ($cf) {
        echo "<tr><td>PRIMARY<td>";
        foreach ($cf["columns"] as $z => $c) {
            echo select_input(" disabled", $m, $c), "<label><input disabled type='checkbox'>" . 'descending' . "</label> ";
        }
        echo "<td><td>\n";
    }
    $x = 1;
    foreach ($L["indexes"] as $v) {
        if (!$_POST["drop_col"] || $x != key($_POST["drop_col"])) {
            echo "<tr><td>" . html_select("indexes[$x][type]", array(
                -1 => ""
            ) + $ad, $v["type"], ($x == count($L["indexes"]) ? "indexesAddRow.call(this);" : 1), "label-type"), "<td>";
            ksort($v["columns"]);
            $t = 1;
            foreach ($v["columns"] as $z => $c) {
                echo "<span>" . select_input(" name='indexes[$x][columns][$t]' title='" . 'Column' . "'", ($m ? array_combine($m, $m) : $m), $c, "partial(" . ($t == count($v["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . ", '" . js_escape($y == "sql" ? "" : $_GET["indexes"] . "_") . "')"), ($y == "sql" || $y == "mssql" ? "<input type='number' name='indexes[$x][lengths][$t]' class='size' value='" . h($v["lengths"][$z]) . "' title='" . 'Length' . "'>" : ""), (support("descidx") ? checkbox("indexes[$x][descs][$t]", 1, $v["descs"][$z], 'descending') : ""), " </span>";
                $t++;
            }
            echo "<td><input name='indexes[$x][name]' value='" . h($v["name"]) . "' autocapitalize='off' aria-labelledby='label-name'>\n", "<td><input type='submit' class='icon' name='drop_col[$x]' value='x' title='" . 'Remove' . "'>" . script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
        }
        $x++;
    }
    echo '</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["database"])) {
    $L = $_POST;
    if ($_POST && !$k && !isset($_POST["add_x"])) {
        $E = trim($L["name"]);
        if ($_POST["drop"]) {
            $_GET["db"] = "";
            queries_redirect(remove_from_uri("db|database"), 'Database has been dropped.', drop_databases(array(
                DB
            )));
        } elseif (DB !== $E) {
            if (DB != "") {
                $_GET["db"] = $E;
                queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME) . "db=" . urlencode($E), 'Database has been renamed.', rename_database($E, $L["collation"]));
            } else {
                $h  = explode("\n", str_replace("\r", "", $E));
                $lg = true;
                $td = "";
                foreach ($h as $i) {
                    if (count($h) == 1 || $i != "") {
                        if (!create_database($i, $L["collation"]))
                            $lg = false;
                        $td = $i;
                    }
                }
                restart_session();
                set_session("dbs", null);
                queries_redirect(ME . "db=" . urlencode($td), 'Database has been created.', $lg);
            }
        } else {
            if (!$L["collation"])
                redirect(substr(ME, 0, -1));
            query_redirect("ALTER DATABASE " . idf_escape($E) . (preg_match('~^[a-z0-9_]+$~i', $L["collation"]) ? " COLLATE $L[collation]" : ""), substr(ME, 0, -1), 'Database has been altered.');
        }
    }
    page_header(DB != "" ? 'Alter database' : 'Create database', $k, array(), h(DB));
    $Xa = collations();
    $E  = DB;
    if ($_POST)
        $E = $L["name"];
    elseif (DB != "")
        $L["collation"] = db_collation(DB, $Xa);
    elseif ($y == "sql") {
        foreach (get_vals("SHOW GRANTS") as $r) {
            if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $r, $C) && $C[1]) {
                $E = stripcslashes(idf_unescape("`$C[2]`"));
                break;
            }
        }
    }
    echo '
<form action="" method="post">
<p>
', ($_POST["add_x"] || strpos($E, "\n") ? '<textarea id="name" name="name" rows="10" cols="40">' . h($E) . '</textarea><br>' : '<input name="name" id="name" value="' . h($E) . '" data-maxlength="64" autocapitalize="off">') . "\n" . ($Xa ? html_select("collation", array(
        "" => "(" . 'collation' . ")"
    ) + $Xa, $L["collation"]) . doc_link(array(
        'sql' => "charset-charsets.html",
        'mariadb' => "supported-character-sets-and-collations/"
    )) : ""), script("focus(qs('#name'));"), '<input type="submit" value="Save">
';
    if (DB != "")
        echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', DB)) . "\n";
    elseif (!$_POST["add_x"] && $_GET["db"] == "")
        echo "<input type='submit' class='icon' name='add' value='+' title='" . 'Add next' . "'>\n";
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["call"])) {
    $da = ($_GET["name"] ? $_GET["name"] : $_GET["call"]);
    page_header('Call' . ": " . h($da), $k);
    $Cf = routine($_GET["call"], (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
    $Zc = array();
    $Ee = array();
    foreach ($Cf["fields"] as $t => $l) {
        if (substr($l["inout"], -3) == "OUT")
            $Ee[$t] = "@" . idf_escape($l["field"]) . " AS " . idf_escape($l["field"]);
        if (!$l["inout"] || substr($l["inout"], 0, 2) == "IN")
            $Zc[] = $t;
    }
    if (!$k && $_POST) {
        $Ja = array();
        foreach ($Cf["fields"] as $z => $l) {
            if (in_array($z, $Zc)) {
                $X = process_input($l);
                if ($X === false)
                    $X = "''";
                if (isset($Ee[$z]))
                    $e->query("SET @" . idf_escape($l["field"]) . " = $X");
            }
            $Ja[] = (isset($Ee[$z]) ? "@" . idf_escape($l["field"]) : $X);
        }
        $I  = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . table($da) . "(" . implode(", ", $Ja) . ")";
        $eg = microtime(true);
        $J  = $e->multi_query($I);
        $na = $e->affected_rows;
        echo $b->selectQuery($I, $eg, !$J);
        if (!$J)
            echo "<p class='error'>" . error() . "\n";
        else {
            $f = connect();
            if (is_object($f))
                $f->select_db(DB);
            do {
                $J = $e->store_result();
                if (is_object($J))
                    select($J, $f);
                else
                    echo "<p class='message'>" . lang(array(
                        'Routine has been called, %d row affected.',
                        'Routine has been called, %d rows affected.'
                    ), $na) . " <span class='time'>" . @date("H:i:s") . "</span>\n";
            } while ($e->next_result());
            if ($Ee)
                select($e->query("SELECT " . implode(", ", $Ee)));
        }
    }
    echo '
<form action="" method="post">
';
    if ($Zc) {
        echo "<table cellspacing='0' class='layout'>\n";
        foreach ($Zc as $z) {
            $l = $Cf["fields"][$z];
            $E = $l["field"];
            echo "<tr><th>" . $b->fieldName($l);
            $Y = $_POST["fields"][$E];
            if ($Y != "") {
                if ($l["type"] == "enum")
                    $Y = +$Y;
                if ($l["type"] == "set")
                    $Y = array_sum($Y);
            }
            input($l, $Y, (string) $_POST["function"][$E]);
            echo "\n";
        }
        echo "</table>\n";
    }
    echo '<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["foreign"])) {
    $a = $_GET["foreign"];
    $E = $_GET["name"];
    $L = $_POST;
    if ($_POST && !$k && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
        $D = ($_POST["drop"] ? 'Foreign key has been dropped.' : ($E != "" ? 'Foreign key has been altered.' : 'Foreign key has been created.'));
        $B = ME . "table=" . urlencode($a);
        if (!$_POST["drop"]) {
            $L["source"] = array_filter($L["source"], 'strlen');
            ksort($L["source"]);
            $yg = array();
            foreach ($L["source"] as $z => $X)
                $yg[$z] = $L["target"][$z];
            $L["target"] = $yg;
        }
        if ($y == "sqlite")
            queries_redirect($B, $D, recreate_table($a, $a, array(), array(), array(
                " $E" => ($_POST["drop"] ? "" : " " . format_foreign_key($L))
            )));
        else {
            $sa = "ALTER TABLE " . table($a);
            $Lb = "\nDROP " . ($y == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($E);
            if ($_POST["drop"])
                query_redirect($sa . $Lb, $B, $D);
            else {
                query_redirect($sa . ($E != "" ? "$Lb," : "") . "\nADD" . format_foreign_key($L), $B, $D);
                $k = 'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' . "<br>$k";
            }
        }
    }
    page_header('Foreign key', $k, array(
        "table" => $a
    ), h($a));
    if ($_POST) {
        ksort($L["source"]);
        if ($_POST["add"])
            $L["source"][] = "";
        elseif ($_POST["change"] || $_POST["change-js"])
            $L["target"] = array();
    } elseif ($E != "") {
        $o             = foreign_keys($a);
        $L             = $o[$E];
        $L["source"][] = "";
    } else {
        $L["table"]  = $a;
        $L["source"] = array(
            ""
        );
    }
    echo '
<form action="" method="post">
';
    $Yf = array_keys(fields($a));
    if ($L["db"] != "")
        $e->select_db($L["db"]);
    if ($L["ns"] != "")
        set_schema($L["ns"]);
    $rf = array_keys(array_filter(table_status('', true), 'fk_support'));
    $yg = array_keys(fields(in_array($L["table"], $rf) ? $L["table"] : reset($rf)));
    $pe = "this.form['change-js'].value = '1'; this.form.submit();";
    echo "<p>" . 'Target table' . ": " . html_select("table", $rf, $L["table"], $pe) . "\n";
    if ($y == "pgsql")
        echo 'Schema' . ": " . html_select("ns", $b->schemas(), $L["ns"] != "" ? $L["ns"] : $_GET["ns"], $pe);
    elseif ($y != "sqlite") {
        $xb = array();
        foreach ($b->databases() as $i) {
            if (!information_schema($i))
                $xb[] = $i;
        }
        echo 'DB' . ": " . html_select("db", $xb, $L["db"] != "" ? $L["db"] : $_GET["db"], $pe);
    }
    echo '<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';
    $x = 0;
    foreach ($L["source"] as $z => $X) {
        echo "<tr>", "<td>" . html_select("source[" . (+$z) . "]", array(
            -1 => ""
        ) + $Yf, $X, ($x == count($L["source"]) - 1 ? "foreignAddRow.call(this);" : 1), "label-source"), "<td>" . html_select("target[" . (+$z) . "]", $yg, $L["target"][$z], 1, "label-target");
        $x++;
    }
    echo '</table>
<p>
ON DELETE: ', html_select("on_delete", array(
        -1 => ""
    ) + explode("|", $oe), $L["on_delete"]), ' ON UPDATE: ', html_select("on_update", array(
        -1 => ""
    ) + explode("|", $oe), $L["on_update"]), doc_link(array(
        'sql' => "innodb-foreign-key-constraints.html",
        'mariadb' => "foreign-keys/"
    )), '<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';
    if ($E != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $E));
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["view"])) {
    $a  = $_GET["view"];
    $L  = $_POST;
    $Ce = "VIEW";
    if ($y == "pgsql" && $a != "") {
        $fg = table_status($a);
        $Ce = strtoupper($fg["Engine"]);
    }
    if ($_POST && !$k) {
        $E  = trim($L["name"]);
        $ua = " AS\n$L[select]";
        $B  = ME . "table=" . urlencode($E);
        $D  = 'View has been altered.';
        $U  = ($_POST["materialized"] ? "MATERIALIZED VIEW" : "VIEW");
        if (!$_POST["drop"] && $a == $E && $y != "sqlite" && $U == "VIEW" && $Ce == "VIEW")
            query_redirect(($y == "mssql" ? "ALTER" : "CREATE OR REPLACE") . " VIEW " . table($E) . $ua, $B, $D);
        else {
            $_g = $E . "_adminer_" . uniqid();
            drop_create("DROP $Ce " . table($a), "CREATE $U " . table($E) . $ua, "DROP $U " . table($E), "CREATE $U " . table($_g) . $ua, "DROP $U " . table($_g), ($_POST["drop"] ? substr(ME, 0, -1) : $B), 'View has been dropped.', $D, 'View has been created.', $a, $E);
        }
    }
    if (!$_POST && $a != "") {
        $L                 = view($a);
        $L["name"]         = $a;
        $L["materialized"] = ($Ce != "VIEW");
        if (!$k)
            $k = error();
    }
    page_header(($a != "" ? 'Alter view' : 'Create view'), $k, array(
        "table" => $a
    ), h($a));
    echo '
<form action="" method="post">
<p>Name: <input name="name" value="', h($L["name"]), '" data-maxlength="64" autocapitalize="off">
', (support("materializedview") ? " " . checkbox("materialized", 1, $L["materialized"], 'Materialized view') : ""), '<p>';
    textarea("select", $L["select"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($a != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["event"])) {
    $aa = $_GET["event"];
    $fd = array(
        "YEAR",
        "QUARTER",
        "MONTH",
        "DAY",
        "HOUR",
        "MINUTE",
        "WEEK",
        "SECOND",
        "YEAR_MONTH",
        "DAY_HOUR",
        "DAY_MINUTE",
        "DAY_SECOND",
        "HOUR_MINUTE",
        "HOUR_SECOND",
        "MINUTE_SECOND"
    );
    $gg = array(
        "ENABLED" => "ENABLE",
        "DISABLED" => "DISABLE",
        "SLAVESIDE_DISABLED" => "DISABLE ON SLAVE"
    );
    $L  = $_POST;
    if ($_POST && !$k) {
        if ($_POST["drop"])
            query_redirect("DROP EVENT " . idf_escape($aa), substr(ME, 0, -1), 'Event has been dropped.');
        elseif (in_array($L["INTERVAL_FIELD"], $fd) && isset($gg[$L["STATUS"]])) {
            $Gf = "\nON SCHEDULE " . ($L["INTERVAL_VALUE"] ? "EVERY " . q($L["INTERVAL_VALUE"]) . " $L[INTERVAL_FIELD]" . ($L["STARTS"] ? " STARTS " . q($L["STARTS"]) : "") . ($L["ENDS"] ? " ENDS " . q($L["ENDS"]) : "") : "AT " . q($L["STARTS"])) . " ON COMPLETION" . ($L["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE";
            queries_redirect(substr(ME, 0, -1), ($aa != "" ? 'Event has been altered.' : 'Event has been created.'), queries(($aa != "" ? "ALTER EVENT " . idf_escape($aa) . $Gf . ($aa != $L["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($L["EVENT_NAME"]) : "") : "CREATE EVENT " . idf_escape($L["EVENT_NAME"]) . $Gf) . "\n" . $gg[$L["STATUS"]] . " COMMENT " . q($L["EVENT_COMMENT"]) . rtrim(" DO\n$L[EVENT_DEFINITION]", ";") . ";"));
        }
    }
    page_header(($aa != "" ? 'Alter event' . ": " . h($aa) : 'Create event'), $k);
    if (!$L && $aa != "") {
        $M = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($aa));
        $L = reset($M);
    }
    echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="', h($L["EVENT_NAME"]), '" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="', h("$L[EXECUTE_AT]$L[STARTS]"), '">
<tr><th title="datetime">End<td><input name="ENDS" value="', h($L["ENDS"]), '">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="', h($L["INTERVAL_VALUE"]), '" class="size"> ', html_select("INTERVAL_FIELD", $fd, $L["INTERVAL_FIELD"]), '<tr><th>Status<td>', html_select("STATUS", $gg, $L["STATUS"]), '<tr><th>Comment<td><input name="EVENT_COMMENT" value="', h($L["EVENT_COMMENT"]), '" data-maxlength="64">
<tr><th><td>', checkbox("ON_COMPLETION", "PRESERVE", $L["ON_COMPLETION"] == "PRESERVE", 'On completion preserve'), '</table>
<p>';
    textarea("EVENT_DEFINITION", $L["EVENT_DEFINITION"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($aa != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $aa));
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["procedure"])) {
    $da          = ($_GET["name"] ? $_GET["name"] : $_GET["procedure"]);
    $Cf          = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
    $L           = $_POST;
    $L["fields"] = (array) $L["fields"];
    if ($_POST && !process_fields($L["fields"]) && !$k) {
        $_e = routine($_GET["procedure"], $Cf);
        $_g = "$L[name]_adminer_" . uniqid();
        drop_create("DROP $Cf " . routine_id($da, $_e), create_routine($Cf, $L), "DROP $Cf " . routine_id($L["name"], $L), create_routine($Cf, array(
            "name" => $_g
        ) + $L), "DROP $Cf " . routine_id($_g, $L), substr(ME, 0, -1), 'Routine has been dropped.', 'Routine has been altered.', 'Routine has been created.', $da, $L["name"]);
    }
    page_header(($da != "" ? (isset($_GET["function"]) ? 'Alter function' : 'Alter procedure') . ": " . h($da) : (isset($_GET["function"]) ? 'Create function' : 'Create procedure')), $k);
    if (!$_POST && $da != "") {
        $L         = routine($_GET["procedure"], $Cf);
        $L["name"] = $da;
    }
    $Xa = get_vals("SHOW CHARACTER SET");
    sort($Xa);
    $Df = routine_languages();
    echo '
<form action="" method="post" id="form">
<p>Name: <input name="name" value="', h($L["name"]), '" data-maxlength="64" autocapitalize="off">
', ($Df ? 'Language' . ": " . html_select("language", $Df, $L["language"]) . "\n" : ""), '<input type="submit" value="Save">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
    edit_fields($L["fields"], $Xa, $Cf);
    if (isset($_GET["function"])) {
        echo "<tr><td>" . 'Return type';
        edit_type("returns", $L["returns"], $Xa, array(), ($y == "pgsql" ? array(
            "void",
            "trigger"
        ) : array()));
    }
    echo '</table>
', script("editFields();"), '</div>
<p>';
    textarea("definition", $L["definition"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($da != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $da));
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["trigger"])) {
    $a  = $_GET["trigger"];
    $E  = $_GET["name"];
    $Tg = trigger_options();
    $L  = (array) trigger($E, $a) + array(
        "Trigger" => $a . "_bi"
    );
    if ($_POST) {
        if (!$k && in_array($_POST["Timing"], $Tg["Timing"]) && in_array($_POST["Event"], $Tg["Event"]) && in_array($_POST["Type"], $Tg["Type"])) {
            $ne = " ON " . table($a);
            $Lb = "DROP TRIGGER " . idf_escape($E) . ($y == "pgsql" ? $ne : "");
            $B  = ME . "table=" . urlencode($a);
            if ($_POST["drop"])
                query_redirect($Lb, $B, 'Trigger has been dropped.');
            else {
                if ($E != "")
                    queries($Lb);
                queries_redirect($B, ($E != "" ? 'Trigger has been altered.' : 'Trigger has been created.'), queries(create_trigger($ne, $_POST)));
                if ($E != "")
                    queries(create_trigger($ne, $L + array(
                        "Type" => reset($Tg["Type"])
                    )));
            }
        }
        $L = $_POST;
    }
    page_header(($E != "" ? 'Alter trigger' . ": " . h($E) : 'Create trigger'), $k, array(
        "table" => $a
    ));
    echo '
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>Time<td>', html_select("Timing", $Tg["Timing"], $L["Timing"], "triggerChange(/^" . preg_quote($a, "/") . "_[ba][iud]$/, '" . js_escape($a) . "', this.form);"), '<tr><th>Event<td>', html_select("Event", $Tg["Event"], $L["Event"], "this.form['Timing'].onchange();"), (in_array("UPDATE OF", $Tg["Event"]) ? " <input name='Of' value='" . h($L["Of"]) . "' class='hidden'>" : ""), '<tr><th>Type<td>', html_select("Type", $Tg["Type"], $L["Type"]), '</table>
<p>Name: <input name="Trigger" value="', h($L["Trigger"]), '" data-maxlength="64" autocapitalize="off">
', script("qs('#form')['Timing'].onchange();"), '<p>';
    textarea("Statement", $L["Statement"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($E != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $E));
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["user"])) {
    $fa = $_GET["user"];
    $gf = array(
        "" => array(
            "All privileges" => ""
        )
    );
    foreach (get_rows("SHOW PRIVILEGES") as $L) {
        foreach (explode(",", ($L["Privilege"] == "Grant option" ? "" : $L["Context"])) as $ib)
            $gf[$ib][$L["Privilege"]] = $L["Comment"];
    }
    $gf["Server Admin"] += $gf["File access on server"];
    $gf["Databases"]["Create routine"] = $gf["Procedures"]["Create routine"];
    unset($gf["Procedures"]["Create routine"]);
    $gf["Columns"] = array();
    foreach (array(
        "Select",
        "Insert",
        "Update",
        "References"
    ) as $X)
        $gf["Columns"][$X] = $gf["Tables"][$X];
    unset($gf["Server Admin"]["Usage"]);
    foreach ($gf["Tables"] as $z => $X)
        unset($gf["Databases"][$z]);
    $Yd = array();
    if ($_POST) {
        foreach ($_POST["objects"] as $z => $X)
            $Yd[$X] = (array) $Yd[$X] + (array) $_POST["grants"][$z];
    }
    $Gc = array();
    $le = "";
    if (isset($_GET["host"]) && ($J = $e->query("SHOW GRANTS FOR " . q($fa) . "@" . q($_GET["host"])))) {
        while ($L = $J->fetch_row()) {
            if (preg_match('~GRANT (.*) ON (.*) TO ~', $L[0], $C) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $C[1], $Gd, PREG_SET_ORDER)) {
                foreach ($Gd as $X) {
                    if ($X[1] != "USAGE")
                        $Gc["$C[2]$X[2]"][$X[1]] = true;
                    if (preg_match('~ WITH GRANT OPTION~', $L[0]))
                        $Gc["$C[2]$X[2]"]["GRANT OPTION"] = true;
                }
            }
            if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $L[0], $C))
                $le = $C[1];
        }
    }
    if ($_POST && !$k) {
        $me = (isset($_GET["host"]) ? q($fa) . "@" . q($_GET["host"]) : "''");
        if ($_POST["drop"])
            query_redirect("DROP USER $me", ME . "privileges=", 'User has been dropped.');
        else {
            $ae = q($_POST["user"]) . "@" . q($_POST["host"]);
            $Pe = $_POST["pass"];
            if ($Pe != '' && !$_POST["hashed"] && !min_version(8)) {
                $Pe = $e->result("SELECT PASSWORD(" . q($Pe) . ")");
                $k  = !$Pe;
            }
            $mb = false;
            if (!$k) {
                if ($me != $ae) {
                    $mb = queries((min_version(5) ? "CREATE USER" : "GRANT USAGE ON *.* TO") . " $ae IDENTIFIED BY " . (min_version(8) ? "" : "PASSWORD ") . q($Pe));
                    $k  = !$mb;
                } elseif ($Pe != $le)
                    queries("SET PASSWORD FOR $ae = " . q($Pe));
            }
            if (!$k) {
                $_f = array();
                foreach ($Yd as $ge => $r) {
                    if (isset($_GET["grant"]))
                        $r = array_filter($r);
                    $r = array_keys($r);
                    if (isset($_GET["grant"]))
                        $_f = array_diff(array_keys(array_filter($Yd[$ge], 'strlen')), $r);
                    elseif ($me == $ae) {
                        $je = array_keys((array) $Gc[$ge]);
                        $_f = array_diff($je, $r);
                        $r  = array_diff($r, $je);
                        unset($Gc[$ge]);
                    }
                    if (preg_match('~^(.+)\s*(\(.*\))?$~U', $ge, $C) && (!grant("REVOKE", $_f, $C[2], " ON $C[1] FROM $ae") || !grant("GRANT", $r, $C[2], " ON $C[1] TO $ae"))) {
                        $k = true;
                        break;
                    }
                }
            }
            if (!$k && isset($_GET["host"])) {
                if ($me != $ae)
                    queries("DROP USER $me");
                elseif (!isset($_GET["grant"])) {
                    foreach ($Gc as $ge => $_f) {
                        if (preg_match('~^(.+)(\(.*\))?$~U', $ge, $C))
                            grant("REVOKE", array_keys($_f), $C[2], " ON $C[1] FROM $ae");
                    }
                }
            }
            queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? 'User has been altered.' : 'User has been created.'), !$k);
            if ($mb)
                $e->query("DROP USER $ae");
        }
    }
    page_header((isset($_GET["host"]) ? 'Username' . ": " . h("$fa@$_GET[host]") : 'Create user'), $k, array(
        "privileges" => array(
            '',
            'Privileges'
        )
    ));
    if ($_POST) {
        $L  = $_POST;
        $Gc = $Yd;
    } else {
        $L         = $_GET + array(
            "host" => $e->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)")
        );
        $L["pass"] = $le;
        if ($le != "")
            $L["hashed"] = true;
        $Gc[(DB == "" || $Gc ? "" : idf_escape(addcslashes(DB, "%_\\"))) . ".*"] = array();
    }
    echo '<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="', h($L["host"]), '" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="', h($L["user"]), '" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="', h($L["pass"]), '" autocomplete="new-password">
';
    if (!$L["hashed"])
        echo script("typePassword(qs('#pass'));");
    echo (min_version(8) ? "" : checkbox("hashed", 1, $L["hashed"], 'Hashed', "typePassword(this.form['pass'], this.checked);")), '</table>

';
    echo "<table cellspacing='0'>\n", "<thead><tr><th colspan='2'>" . 'Privileges' . doc_link(array(
        'sql' => "grant.html#priv_level"
    ));
    $t = 0;
    foreach ($Gc as $ge => $r) {
        echo '<th>' . ($ge != "*.*" ? "<input name='objects[$t]' value='" . h($ge) . "' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");
        $t++;
    }
    echo "</thead>\n";
    foreach (array(
        "" => "",
        "Server Admin" => 'Server',
        "Databases" => 'Database',
        "Tables" => 'Table',
        "Columns" => 'Column',
        "Procedures" => 'Routine'
    ) as $ib => $Db) {
        foreach ((array) $gf[$ib] as $ff => $bb) {
            echo "<tr" . odd() . "><td" . ($Db ? ">$Db<td" : " colspan='2'") . ' lang="en" title="' . h($bb) . '">' . h($ff);
            $t = 0;
            foreach ($Gc as $ge => $r) {
                $E = "'grants[$t][" . h(strtoupper($ff)) . "]'";
                $Y = $r[strtoupper($ff)];
                if ($ib == "Server Admin" && $ge != (isset($Gc["*.*"]) ? "*.*" : ".*"))
                    echo "<td>";
                elseif (isset($_GET["grant"]))
                    echo "<td><select name=$E><option><option value='1'" . ($Y ? " selected" : "") . ">" . 'Grant' . "<option value='0'" . ($Y == "0" ? " selected" : "") . ">" . 'Revoke' . "</select>";
                else {
                    echo "<td align='center'><label class='block'>", "<input type='checkbox' name=$E value='1'" . ($Y ? " checked" : "") . ($ff == "All privileges" ? " id='grants-$t-all'>" : ">" . ($ff == "Grant option" ? "" : script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))), "</label>";
                }
                $t++;
            }
        }
    }
    echo "</table>\n", '<p>
<input type="submit" value="Save">
';
    if (isset($_GET["host"])) {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', "$fa@$_GET[host]"));
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
} elseif (isset($_GET["processlist"])) {
    if (support("kill")) {
        if ($_POST && !$k) {
            $pd = 0;
            foreach ((array) $_POST["kill"] as $X) {
                if (kill_process($X))
                    $pd++;
            }
            queries_redirect(ME . "processlist=", lang(array(
                '%d process has been killed.',
                '%d processes have been killed.'
            ), $pd), $pd || !$_POST["kill"]);
        }
    }
    page_header('Process list', $k);
    echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
', script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
    $t = -1;
    foreach (process_list() as $t => $L) {
        if (!$t) {
            echo "<thead><tr lang='en'>" . (support("kill") ? "<th>" : "");
            foreach ($L as $z => $X)
                echo "<th>$z" . doc_link(array(
                    'sql' => "show-processlist.html#processlist_" . strtolower($z)
                ));
            echo "</thead>\n";
        }
        echo "<tr" . odd() . ">" . (support("kill") ? "<td>" . checkbox("kill[]", $L[$y == "sql" ? "Id" : "pid"], 0) : "");
        foreach ($L as $z => $X)
            echo "<td>" . (($y == "sql" && $z == "Info" && preg_match("~Query|Killed~", $L["Command"]) && $X != "") || ($y == "pgsql" && $z == "current_query" && $X != "<IDLE>") || ($y == "oracle" && $z == "sql_text" && $X != "") ? "<code class='jush-$y'>" . shorten_utf8($X, 100, "</code>") . ' <a href="' . h(ME . ($L["db"] != "" ? "db=" . urlencode($L["db"]) . "&" : "") . "sql=" . urlencode($X)) . '">' . 'Clone' . '</a>' : h($X));
        echo "\n";
    }
    echo '</table>
</div>
<p>
';
    if (support("kill")) {
        echo ($t + 1) . "/" . sprintf('%d in total', max_connections()), "<p><input type='submit' value='" . 'Kill' . "'>\n";
    }
    echo '<input type="hidden" name="token" value="', $T, '">
</form>
', script("tableCheck();");
} elseif (isset($_GET["select"])) {
    $a  = $_GET["select"];
    $R  = table_status1($a);
    $w  = indexes($a);
    $m  = fields($a);
    $o  = column_foreign_keys($a);
    $ie = $R["Oid"];
    parse_str($_COOKIE["adminer_import"], $ma);
    $Af = array();
    $d  = array();
    $Cg = null;
    foreach ($m as $z => $l) {
        $E = $b->fieldName($l);
        if (isset($l["privileges"]["select"]) && $E != "") {
            $d[$z] = html_entity_decode(strip_tags($E), ENT_QUOTES);
            if (is_shortable($l))
                $Cg = $b->selectLengthProcess();
        }
        $Af += $l["privileges"];
    }
    list($N, $s) = $b->selectColumnsProcess($d, $w);
    $jd = count($s) < count($N);
    $Z  = $b->selectSearchProcess($m, $w);
    $we = $b->selectOrderProcess($m, $w);
    $_  = $b->selectLimitProcess();
    if ($_GET["val"] && is_ajax()) {
        header("Content-Type: text/plain; charset=utf-8");
        foreach ($_GET["val"] as $bh => $L) {
            $ua  = convert_field($m[key($L)]);
            $N   = array(
                $ua ? $ua : idf_escape(key($L))
            );
            $Z[] = where_check($bh, $m);
            $K   = $j->select($a, $N, $Z, $N);
            if ($K)
                echo reset($K->fetch_row());
        }
        exit;
    }
    $cf = $dh = null;
    foreach ($w as $v) {
        if ($v["type"] == "PRIMARY") {
            $cf = array_flip($v["columns"]);
            $dh = ($N ? $cf : array());
            foreach ($dh as $z => $X) {
                if (in_array(idf_escape($z), $N))
                    unset($dh[$z]);
            }
            break;
        }
    }
    if ($ie && !$cf) {
        $cf  = $dh = array(
            $ie => 0
        );
        $w[] = array(
            "type" => "PRIMARY",
            "columns" => array(
                $ie
            )
        );
    }
    if ($_POST && !$k) {
        $zh = $Z;
        if (!$_POST["all"] && is_array($_POST["check"])) {
            $Oa = array();
            foreach ($_POST["check"] as $Ma)
                $Oa[] = where_check($Ma, $m);
            $zh[] = "((" . implode(") OR (", $Oa) . "))";
        }
        $zh = ($zh ? "\nWHERE " . implode(" AND ", $zh) : "");
        if ($_POST["export"]) {
            cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
            dump_headers($a);
            $b->dumpTable($a, "");
            $Ec = ($N ? implode(", ", $N) : "*") . convert_fields($d, $m, $N) . "\nFROM " . table($a);
            $Ic = ($s && $jd ? "\nGROUP BY " . implode(", ", $s) : "") . ($we ? "\nORDER BY " . implode(", ", $we) : "");
            if (!is_array($_POST["check"]) || $cf)
                $I = "SELECT $Ec$zh$Ic";
            else {
                $Zg = array();
                foreach ($_POST["check"] as $X)
                    $Zg[] = "(SELECT" . limit($Ec, "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $m) . $Ic, 1) . ")";
                $I = implode(" UNION ALL ", $Zg);
            }
            $b->dumpData($a, "table", $I);
            exit;
        }
        if (!$b->selectEmailProcess($Z, $o)) {
            if ($_POST["save"] || $_POST["delete"]) {
                $J  = true;
                $na = 0;
                $P  = array();
                if (!$_POST["delete"]) {
                    foreach ($d as $E => $X) {
                        $X = process_input($m[$E]);
                        if ($X !== null && ($_POST["clone"] || $X !== false))
                            $P[idf_escape($E)] = ($X !== false ? $X : idf_escape($E));
                    }
                }
                if ($_POST["delete"] || $P) {
                    if ($_POST["clone"])
                        $I = "INTO " . table($a) . " (" . implode(", ", array_keys($P)) . ")\nSELECT " . implode(", ", $P) . "\nFROM " . table($a);
                    if ($_POST["all"] || ($cf && is_array($_POST["check"])) || $jd) {
                        $J  = ($_POST["delete"] ? $j->delete($a, $zh) : ($_POST["clone"] ? queries("INSERT $I$zh") : $j->update($a, $P, $zh)));
                        $na = $e->affected_rows;
                    } else {
                        foreach ((array) $_POST["check"] as $X) {
                            $yh = "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $m);
                            $J  = ($_POST["delete"] ? $j->delete($a, $yh, 1) : ($_POST["clone"] ? queries("INSERT" . limit1($a, $I, $yh)) : $j->update($a, $P, $yh, 1)));
                            if (!$J)
                                break;
                            $na += $e->affected_rows;
                        }
                    }
                }
                $D = lang(array(
                    '%d item has been affected.',
                    '%d items have been affected.'
                ), $na);
                if ($_POST["clone"] && $J && $na == 1) {
                    $ud = last_id();
                    if ($ud)
                        $D = sprintf('Item%s has been inserted.', " $ud");
                }
                queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $D, $J);
                if (!$_POST["delete"]) {
                    edit_form($a, $m, (array) $_POST["fields"], !$_POST["clone"]);
                    page_footer();
                    exit;
                }
            } elseif (!$_POST["import"]) {
                if (!$_POST["val"])
                    $k = 'Ctrl+click on a value to modify it.';
                else {
                    $J  = true;
                    $na = 0;
                    foreach ($_POST["val"] as $bh => $L) {
                        $P = array();
                        foreach ($L as $z => $X) {
                            $z                 = bracket_escape($z, 1);
                            $P[idf_escape($z)] = (preg_match('~char|text~', $m[$z]["type"]) || $X != "" ? $b->processInput($m[$z], $X) : "NULL");
                        }
                        $J = $j->update($a, $P, " WHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($bh, $m), !$jd && !$cf, " ");
                        if (!$J)
                            break;
                        $na += $e->affected_rows;
                    }
                    queries_redirect(remove_from_uri(), lang(array(
                        '%d item has been affected.',
                        '%d items have been affected.'
                    ), $na), $J);
                }
            } elseif (!is_string($uc = get_file("csv_file", true)))
                $k = upload_error($uc);
            elseif (!preg_match('~~u', $uc))
                $k = 'File must be in UTF-8 encoding.';
            else {
                cookie("adminer_import", "output=" . urlencode($ma["output"]) . "&format=" . urlencode($_POST["separator"]));
                $J  = true;
                $Ya = array_keys($m);
                preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $uc, $Gd);
                $na = count($Gd[0]);
                $j->begin();
                $Of = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
                $M  = array();
                foreach ($Gd[0] as $z => $X) {
                    preg_match_all("~((?>\"[^\"]*\")+|[^$Of]*)$Of~", $X . $Of, $Hd);
                    if (!$z && !array_diff($Hd[1], $Ya)) {
                        $Ya = $Hd[1];
                        $na--;
                    } else {
                        $P = array();
                        foreach ($Hd[1] as $t => $Ua)
                            $P[idf_escape($Ya[$t])] = ($Ua == "" && $m[$Ya[$t]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $Ua))));
                        $M[] = $P;
                    }
                }
                $J = (!$M || $j->insertUpdate($a, $M, $cf));
                if ($J)
                    $J = $j->commit();
                queries_redirect(remove_from_uri("page"), lang(array(
                    '%d row has been imported.',
                    '%d rows have been imported.'
                ), $na), $J);
                $j->rollback();
            }
        }
    }
    $rg = $b->tableName($R);
    if (is_ajax()) {
        page_headers();
        ob_start();
    } else
        page_header('Select' . ": $rg", $k);
    $P = null;
    if (isset($Af["insert"]) || !support("table")) {
        $P = "";
        foreach ((array) $_GET["where"] as $X) {
            if ($o[$X["col"]] && count($o[$X["col"]]) == 1 && ($X["op"] == "=" || (!$X["op"] && !preg_match('~[_%]~', $X["val"]))))
                $P .= "&set" . urlencode("[" . bracket_escape($X["col"]) . "]") . "=" . urlencode($X["val"]);
        }
    }
    $b->selectLinks($R, $P);
    if (!$d && support("table"))
        echo "<p class='error'>" . 'Unable to select the table' . ($m ? "." : ": " . error()) . "\n";
    else {
        echo "<form action='' id='form'>\n", "<div style='display: none;'>";
        hidden_fields_get();
        echo (DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : "");
        echo '<input type="hidden" name="select" value="' . h($a) . '">', "</div>\n";
        $b->selectColumnsPrint($N, $d);
        $b->selectSearchPrint($Z, $d, $w);
        $b->selectOrderPrint($we, $d, $w);
        $b->selectLimitPrint($_);
        $b->selectLengthPrint($Cg);
        $b->selectActionPrint($w);
        echo "</form>\n";
        $F = $_GET["page"];
        if ($F == "last") {
            $Dc = $e->result(count_rows($a, $Z, $jd, $s));
            $F  = floor(max(0, $Dc - 1) / $_);
        }
        $Jf = $N;
        $Hc = $s;
        if (!$Jf) {
            $Jf[] = "*";
            $jb   = convert_fields($d, $m, $N);
            if ($jb)
                $Jf[] = substr($jb, 2);
        }
        foreach ($N as $z => $X) {
            $l = $m[idf_unescape($X)];
            if ($l && ($ua = convert_field($l)))
                $Jf[$z] = "$ua AS $X";
        }
        if (!$jd && $dh) {
            foreach ($dh as $z => $X) {
                $Jf[] = idf_escape($z);
                if ($Hc)
                    $Hc[] = idf_escape($z);
            }
        }
        $J = $j->select($a, $Jf, $Z, $Hc, $we, $_, $F, true);
        if (!$J)
            echo "<p class='error'>" . error() . "\n";
        else {
            if ($y == "mssql" && $F)
                $J->seek($_ * $F);
            $Xb = array();
            echo "<form action='' method='post' enctype='multipart/form-data'>\n";
            $M = array();
            while ($L = $J->fetch_assoc()) {
                if ($F && $y == "oracle")
                    unset($L["RNUM"]);
                $M[] = $L;
            }
            if ($_GET["page"] != "last" && $_ != "" && $s && $jd && $y == "sql")
                $Dc = $e->result(" SELECT FOUND_ROWS()");
            if (!$M)
                echo "<p class='message'>" . 'No rows.' . "\n";
            else {
                $Ba = $b->backwardKeys($a, $rg);
                echo "<div class='scrollable'>", "<table id='table' cellspacing='0' class='nowrap checkable'>", script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"), "<thead><tr>" . (!$s && $N ? "" : "<td><input type='checkbox' id='all-page' class='jsonly'>" . script("qs('#all-page').onclick = partial(formCheck, /check/);", "") . " <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . 'Modify' . "</a>");
                $Xd = array();
                $Fc = array();
                reset($N);
                $of = 1;
                foreach ($M[0] as $z => $X) {
                    if (!isset($dh[$z])) {
                        $X = $_GET["columns"][key($N)];
                        $l = $m[$N ? ($X ? $X["col"] : current($N)) : $z];
                        $E = ($l ? $b->fieldName($l, $of) : ($X["fun"] ? "*" : $z));
                        if ($E != "") {
                            $of++;
                            $Xd[$z] = $E;
                            $c      = idf_escape($z);
                            $Uc     = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($z);
                            $Db     = "&desc%5B0%5D=1";
                            echo "<th id='th[" . h(bracket_escape($z)) . "]'>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ""), '<a href="' . h($Uc . ($we[0] == $c || $we[0] == $z || (!$we && $jd && $s[0] == $c) ? $Db : '')) . '">';
                            echo apply_sql_function($X["fun"], $E) . "</a>";
                            echo "<span class='column hidden'>", "<a href='" . h($Uc . $Db) . "' title='" . 'descending' . "' class='text'> â†“</a>";
                            if (!$X["fun"]) {
                                echo '<a href="#fieldset-search" title="' . 'Search' . '" class="text jsonly"> =</a>', script("qsl('a').onclick = partial(selectSearch, '" . js_escape($z) . "');");
                            }
                            echo "</span>";
                        }
                        $Fc[$z] = $X["fun"];
                        next($N);
                    }
                }
                $_d = array();
                if ($_GET["modify"]) {
                    foreach ($M as $L) {
                        foreach ($L as $z => $X)
                            $_d[$z] = max($_d[$z], min(40, strlen(utf8_decode($X))));
                    }
                }
                echo ($Ba ? "<th>" . 'Relations' : "") . "</thead>\n";
                if (is_ajax()) {
                    if ($_ % 2 == 1 && $F % 2 == 1)
                        odd();
                    ob_end_clean();
                }
                foreach ($b->rowDescriptions($M, $o) as $Wd => $L) {
                    $ah = unique_array($M[$Wd], $w);
                    if (!$ah) {
                        $ah = array();
                        foreach ($M[$Wd] as $z => $X) {
                            if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $z))
                                $ah[$z] = $X;
                        }
                    }
                    $bh = "";
                    foreach ($ah as $z => $X) {
                        if (($y == "sql" || $y == "pgsql") && preg_match('~char|text|enum|set~', $m[$z]["type"]) && strlen($X) > 64) {
                            $z = (strpos($z, '(') ? $z : idf_escape($z));
                            $z = "MD5(" . ($y != 'sql' || preg_match("~^utf8~", $m[$z]["collation"]) ? $z : "CONVERT($z USING " . charset($e) . ")") . ")";
                            $X = md5($X);
                        }
                        $bh .= "&" . ($X !== null ? urlencode("where[" . bracket_escape($z) . "]") . "=" . urlencode($X) : "null%5B%5D=" . urlencode($z));
                    }
                    echo "<tr" . odd() . ">" . (!$s && $N ? "" : "<td>" . checkbox("check[]", substr($bh, 1), in_array(substr($bh, 1), (array) $_POST["check"])) . ($jd || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($a) . $bh) . "' class='edit'>" . 'edit' . "</a>"));
                    foreach ($L as $z => $X) {
                        if (isset($Xd[$z])) {
                            $l = $m[$z];
                            $X = $j->value($X, $l);
                            if ($X != "" && (!isset($Xb[$z]) || $Xb[$z] != ""))
                                $Xb[$z] = (is_mail($X) ? $Xd[$z] : "");
                            $A = "";
                            if (preg_match('~blob|bytea|raw|file~', $l["type"]) && $X != "")
                                $A = ME . 'download=' . urlencode($a) . '&field=' . urlencode($z) . $bh;
                            if (!$A && $X !== null) {
                                foreach ((array) $o[$z] as $n) {
                                    if (count($o[$z]) == 1 || end($n["source"]) == $z) {
                                        $A = "";
                                        foreach ($n["source"] as $t => $Yf)
                                            $A .= where_link($t, $n["target"][$t], $M[$Wd][$Yf]);
                                        $A = ($n["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($n["db"]), ME) : ME) . 'select=' . urlencode($n["table"]) . $A;
                                        if ($n["ns"])
                                            $A = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($n["ns"]), $A);
                                        if (count($n["source"]) == 1)
                                            break;
                                    }
                                }
                            }
                            if ($z == "COUNT(*)") {
                                $A = ME . "select=" . urlencode($a);
                                $t = 0;
                                foreach ((array) $_GET["where"] as $W) {
                                    if (!array_key_exists($W["col"], $ah))
                                        $A .= where_link($t++, $W["col"], $W["val"], $W["op"]);
                                }
                                foreach ($ah as $md => $W)
                                    $A .= where_link($t++, $md, $W);
                            }
                            $X  = select_value($X, $A, $l, $Cg);
                            $u  = h("val[$bh][" . bracket_escape($z) . "]");
                            $Y  = $_POST["val"][$bh][bracket_escape($z)];
                            $Sb = !is_array($L[$z]) && is_utf8($X) && $M[$Wd][$z] == $L[$z] && !$Fc[$z];
                            $Bg = preg_match('~text|lob~', $l["type"]);
                            echo "<td id='$u'";
                            if (($_GET["modify"] && $Sb) || $Y !== null) {
                                $Lc = h($Y !== null ? $Y : $L[$z]);
                                echo ">" . ($Bg ? "<textarea name='$u' cols='30' rows='" . (substr_count($L[$z], "\n") + 1) . "'>$Lc</textarea>" : "<input name='$u' value='$Lc' size='$_d[$z]'>");
                            } else {
                                $Dd = strpos($X, "<i>â€¦</i>");
                                echo " data-text='" . ($Dd ? 2 : ($Bg ? 1 : 0)) . "'" . ($Sb ? "" : " data-warning='" . h('Use edit link to modify this value.') . "'") . ">$X</td>";
                            }
                        }
                    }
                    if ($Ba)
                        echo "<td>";
                    $b->backwardKeysPrint($Ba, $M[$Wd]);
                    echo "</tr>\n";
                }
                if (is_ajax())
                    exit;
                echo "</table>\n", "</div>\n";
            }
            if (!is_ajax()) {
                if ($M || $F) {
                    $ic = true;
                    if ($_GET["page"] != "last") {
                        if ($_ == "" || (count($M) < $_ && ($M || !$F)))
                            $Dc = ($F ? $F * $_ : 0) + count($M);
                        elseif ($y != "sql" || !$jd) {
                            $Dc = ($jd ? false : found_rows($R, $Z));
                            if ($Dc < max(1e4, 2 * ($F + 1) * $_))
                                $Dc = reset(slow_query(count_rows($a, $Z, $jd, $s)));
                            else
                                $ic = false;
                        }
                    }
                    $He = ($_ != "" && ($Dc === false || $Dc > $_ || $F));
                    if ($He) {
                        echo (($Dc === false ? count($M) + 1 : $Dc - $F * $_) > $_ ? '<p><a href="' . h(remove_from_uri("page") . "&page=" . ($F + 1)) . '" class="loadmore">' . 'Load more data' . '</a>' . script("qsl('a').onclick = partial(selectLoadMore, " . (+$_) . ", '" . 'Loading' . "â€¦');", "") : ''), "\n";
                    }
                }
                echo "<div class='footer'><div>\n";
                if ($M || $F) {
                    if ($He) {
                        $Jd = ($Dc === false ? $F + (count($M) >= $_ ? 2 : 1) : floor(($Dc - 1) / $_));
                        echo "<fieldset>";
                        if ($y != "simpledb") {
                            echo "<legend><a href='" . h(remove_from_uri("page")) . "'>" . 'Page' . "</a></legend>", script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . 'Page' . "', '" . ($F + 1) . "')); return false; };"), pagination(0, $F) . ($F > 5 ? " â€¦" : "");
                            for ($t = max(1, $F - 4); $t < min($Jd, $F + 5); $t++)
                                echo pagination($t, $F);
                            if ($Jd > 0) {
                                echo ($F + 5 < $Jd ? " â€¦" : ""), ($ic && $Dc !== false ? pagination($Jd, $F) : " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$Jd'>" . 'last' . "</a>");
                            }
                        } else {
                            echo "<legend>" . 'Page' . "</legend>", pagination(0, $F) . ($F > 1 ? " â€¦" : ""), ($F ? pagination($F, $F) : ""), ($Jd > $F ? pagination($F + 1, $F) . ($Jd > $F + 1 ? " â€¦" : "") : "");
                        }
                        echo "</fieldset>\n";
                    }
                    echo "<fieldset>", "<legend>" . 'Whole result' . "</legend>";
                    $Ib = ($ic ? "" : "~ ") . $Dc;
                    echo checkbox("all", 1, 0, ($Dc !== false ? ($ic ? "" : "~ ") . lang(array(
                        '%d row',
                        '%d rows'
                    ), $Dc) : ""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Ib' : checked); selectCount('selected2', this.checked || !checked ? '$Ib' : checked);") . "\n", "</fieldset>\n";
                    if ($b->selectCommandPrint()) {
                        echo '<fieldset', ($_GET["modify"] ? '' : ' class="jsonly"'), '><legend>Modify</legend><div>
<input type="submit" value="Save"', ($_GET["modify"] ? '' : ' title="' . 'Ctrl+click on a value to modify it.' . '"'), '>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">', confirm(), '</div></fieldset>
';
                    }
                    $Bc = $b->dumpFormat();
                    foreach ((array) $_GET["columns"] as $c) {
                        if ($c["fun"]) {
                            unset($Bc['sql']);
                            break;
                        }
                    }
                    if ($Bc) {
                        print_fieldset("export", 'Export' . " <span id='selected2'></span>");
                        $Fe = $b->dumpOutput();
                        echo ($Fe ? html_select("output", $Fe, $ma["output"]) . " " : ""), html_select("format", $Bc, $ma["format"]), " <input type='submit' name='export' value='" . 'Export' . "'>\n", "</div></fieldset>\n";
                    }
                    $b->selectEmailPrint(array_filter($Xb, 'strlen'), $d);
                }
                echo "</div></div>\n";
                if ($b->selectImportPrint()) {
                    echo "<div>", "<a href='#import'>" . 'Import' . "</a>", script("qsl('a').onclick = partial(toggle, 'import');", ""), "<span id='import' class='hidden'>: ", "<input type='file' name='csv_file'> ", html_select("separator", array(
                        "csv" => "CSV,",
                        "csv;" => "CSV;",
                        "tsv" => "TSV"
                    ), $ma["format"], 1);
                    echo " <input type='submit' name='import' value='" . 'Import' . "'>", "</span>", "</div>";
                }
                echo "<input type='hidden' name='token' value='$T'>\n", "</form>\n", (!$s && $N ? "" : script("tableCheck();"));
            }
        }
    }
    if (is_ajax()) {
        ob_end_clean();
        exit;
    }
} elseif (isset($_GET["variables"])) {
    $fg = isset($_GET["status"]);
    page_header($fg ? 'Status' : 'Variables');
    $ph = ($fg ? show_status() : show_variables());
    if (!$ph)
        echo "<p class='message'>" . 'No rows.' . "\n";
    else {
        echo "<table cellspacing='0'>\n";
        foreach ($ph as $z => $X) {
            echo "<tr>", "<th><code class='jush-" . $y . ($fg ? "status" : "set") . "'>" . h($z) . "</code>", "<td>" . h($X);
        }
        echo "</table>\n";
    }
} elseif (isset($_GET["script"])) {
    header("Content-Type: text/javascript; charset=utf-8");
    if ($_GET["script"] == "db") {
        $og = array(
            "Data_length" => 0,
            "Index_length" => 0,
            "Data_free" => 0
        );
        foreach (table_status() as $E => $R) {
            json_row("Comment-$E", h($R["Comment"]));
            if (!is_view($R)) {
                foreach (array(
                    "Engine",
                    "Collation"
                ) as $z)
                    json_row("$z-$E", h($R[$z]));
                foreach ($og + array(
                    "Auto_increment" => 0,
                    "Rows" => 0
                ) as $z => $X) {
                    if ($R[$z] != "") {
                        $X = format_number($R[$z]);
                        json_row("$z-$E", ($z == "Rows" && $X && $R["Engine"] == ($ag == "pgsql" ? "table" : "InnoDB") ? "~ $X" : $X));
                        if (isset($og[$z]))
                            $og[$z] += ($R["Engine"] != "InnoDB" || $z != "Data_free" ? $R[$z] : 0);
                    } elseif (array_key_exists($z, $R))
                        json_row("$z-$E");
                }
            }
        }
        foreach ($og as $z => $X)
            json_row("sum-$z", format_number($X));
        json_row("");
    } elseif ($_GET["script"] == "kill")
        $e->query("KILL " . number($_POST["kill"]));
    else {
        foreach (count_tables($b->databases()) as $i => $X) {
            json_row("tables-$i", $X);
            json_row("size-$i", db_size($i));
        }
        json_row("");
    }
    exit;
} else {
    $wg = array_merge((array) $_POST["tables"], (array) $_POST["views"]);
    if ($wg && !$k && !$_POST["search"]) {
        $J = true;
        $D = "";
        if ($y == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"]))
            queries("SET foreign_key_checks = 0");
        if ($_POST["truncate"]) {
            if ($_POST["tables"])
                $J = truncate_tables($_POST["tables"]);
            $D = 'Tables have been truncated.';
        } elseif ($_POST["move"]) {
            $J = move_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
            $D = 'Tables have been moved.';
        } elseif ($_POST["copy"]) {
            $J = copy_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
            $D = 'Tables have been copied.';
        } elseif ($_POST["drop"]) {
            if ($_POST["views"])
                $J = drop_views($_POST["views"]);
            if ($J && $_POST["tables"])
                $J = drop_tables($_POST["tables"]);
            $D = 'Tables have been dropped.';
        } elseif ($y != "sql") {
            $J = ($y == "sqlite" ? queries("VACUUM") : apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE"), $_POST["tables"]));
            $D = 'Tables have been optimized.';
        } elseif (!$_POST["tables"])
            $D = 'No tables.';
        elseif ($J = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('idf_escape', $_POST["tables"])))) {
            while ($L = $J->fetch_assoc())
                $D .= "<b>" . h($L["Table"]) . "</b>: " . h($L["Msg_text"]) . "<br>";
        }
        queries_redirect(substr(ME, 0, -1), $D, $J);
    }
    page_header(($_GET["ns"] == "" ? 'Database' . ": " . h(DB) : 'Schema' . ": " . h($_GET["ns"])), $k, true);
    if ($b->homepage()) {
        if ($_GET["ns"] !== "") {
            echo "<h3 id='tables-views'>" . 'Tables and views' . "</h3>\n";
            $vg = tables_list();
            if (!$vg)
                echo "<p class='message'>" . 'No tables.' . "\n";
            else {
                echo "<form action='' method='post'>\n";
                if (support("table")) {
                    echo "<fieldset><legend>" . 'Search data in tables' . " <span id='selected2'></span></legend><div>", "<input type='search' name='query' value='" . h($_POST["query"]) . "'>", script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", ""), " <input type='submit' name='search' value='" . 'Search' . "'>\n", "</div></fieldset>\n";
                    if ($_POST["search"] && $_POST["query"] != "") {
                        $_GET["where"][0]["op"] = "LIKE %%";
                        search_tables();
                    }
                }
                echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), '<thead><tr class="wrap">', '<td><input id="check-all" type="checkbox" class="jsonly">' . script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", ""), '<th>' . 'Table', '<td>' . 'Engine' . doc_link(array(
                    'sql' => 'storage-engines.html'
                )), '<td>' . 'Collation' . doc_link(array(
                    'sql' => 'charset-charsets.html',
                    'mariadb' => 'supported-character-sets-and-collations/'
                )), '<td>' . 'Data Length' . doc_link(array(
                    'sql' => 'show-table-status.html'
                )), '<td>' . 'Index Length' . doc_link(array(
                    'sql' => 'show-table-status.html'
                )), '<td>' . 'Data Free' . doc_link(array(
                    'sql' => 'show-table-status.html'
                )), '<td>' . 'Auto Increment' . doc_link(array(
                    'sql' => 'example-auto-increment.html',
                    'mariadb' => 'auto_increment/'
                )), '<td>' . 'Rows' . doc_link(array(
                    'sql' => 'show-table-status.html'
                )), (support("comment") ? '<td>' . 'Comment' . doc_link(array(
                    'sql' => 'show-table-status.html'
                )) : ''), "</thead>\n";
                $S = 0;
                foreach ($vg as $E => $U) {
                    $sh = ($U !== null && !preg_match('~table|sequence~i', $U));
                    $u  = h("Table-" . $E);
                    echo '<tr' . odd() . '><td>' . checkbox(($sh ? "views[]" : "tables[]"), $E, in_array($E, $wg, true), "", "", "", $u), '<th>' . (support("table") || support("indexes") ? "<a href='" . h(ME) . "table=" . urlencode($E) . "' title='" . 'Show structure' . "' id='$u'>" . h($E) . '</a>' : h($E));
                    if ($sh) {
                        echo '<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($E) . '" title="' . 'Alter view' . '">' . (preg_match('~materialized~i', $U) ? 'Materialized view' : 'View') . '</a>', '<td align="right"><a href="' . h(ME) . "select=" . urlencode($E) . '" title="' . 'Select data' . '">?</a>';
                    } else {
                        foreach (array(
                            "Engine" => array(),
                            "Collation" => array(),
                            "Data_length" => array(
                                "create",
                                'Alter table'
                            ),
                            "Index_length" => array(
                                "indexes",
                                'Alter indexes'
                            ),
                            "Data_free" => array(
                                "edit",
                                'New item'
                            ),
                            "Auto_increment" => array(
                                "auto_increment=1&create",
                                'Alter table'
                            ),
                            "Rows" => array(
                                "select",
                                'Select data'
                            )
                        ) as $z => $A) {
                            $u = " id='$z-" . h($E) . "'";
                            echo ($A ? "<td align='right'>" . (support("table") || $z == "Rows" || (support("indexes") && $z != "Data_length") ? "<a href='" . h(ME . "$A[0]=") . urlencode($E) . "'$u title='$A[1]'>?</a>" : "<span$u>?</span>") : "<td id='$z-" . h($E) . "'>");
                        }
                        $S++;
                    }
                    echo (support("comment") ? "<td id='Comment-" . h($E) . "'>" : "");
                }
                echo "<tr><td><th>" . sprintf('%d in total', count($vg)), "<td>" . h($y == "sql" ? $e->result("SELECT @@default_storage_engine") : ""), "<td>" . h(db_collation(DB, collations()));
                foreach (array(
                    "Data_length",
                    "Index_length",
                    "Data_free"
                ) as $z)
                    echo "<td align='right' id='sum-$z'>";
                echo "</table>\n", "</div>\n";
                if (!information_schema(DB)) {
                    echo "<div class='footer'><div>\n";
                    $nh = "<input type='submit' value='" . 'Vacuum' . "'> " . on_help("'VACUUM'");
                    $te = "<input type='submit' name='optimize' value='" . 'Optimize' . "'> " . on_help($y == "sql" ? "'OPTIMIZE TABLE'" : "'VACUUM OPTIMIZE'");
                    echo "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>" . ($y == "sqlite" ? $nh : ($y == "pgsql" ? $nh . $te : ($y == "sql" ? "<input type='submit' value='" . 'Analyze' . "'> " . on_help("'ANALYZE TABLE'") . $te . "<input type='submit' name='check' value='" . 'Check' . "'> " . on_help("'CHECK TABLE'") . "<input type='submit' name='repair' value='" . 'Repair' . "'> " . on_help("'REPAIR TABLE'") : ""))) . "<input type='submit' name='truncate' value='" . 'Truncate' . "'> " . on_help($y == "sqlite" ? "'DELETE'" : "'TRUNCATE" . ($y == "pgsql" ? "'" : " TABLE'")) . confirm() . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . on_help("'DROP TABLE'") . confirm() . "\n";
                    $h = (support("scheme") ? $b->schemas() : $b->databases());
                    if (count($h) != 1 && $y != "sqlite") {
                        $i = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
                        echo "<p>" . 'Move to other database' . ": ", ($h ? html_select("target", $h, $i) : '<input name="target" value="' . h($i) . '" autocapitalize="off">'), " <input type='submit' name='move' value='" . 'Move' . "'>", (support("copy") ? " <input type='submit' name='copy' value='" . 'Copy' . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], 'overwrite') : ""), "\n";
                    }
                    echo "<input type='hidden' name='all' value=''>";
                    echo script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));" . (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $S);" : "") . " }"), "<input type='hidden' name='token' value='$T'>\n", "</div></fieldset>\n", "</div></div>\n";
                }
                echo "</form>\n", script("tableCheck();");
            }
            echo '<p class="links"><a href="' . h(ME) . 'create=">' . 'Create table' . "</a>\n", (support("view") ? '<a href="' . h(ME) . 'view=">' . 'Create view' . "</a>\n" : "");
            if (support("routine")) {
                echo "<h3 id='routines'>" . 'Routines' . "</h3>\n";
                $Ef = routines();
                if ($Ef) {
                    echo "<table cellspacing='0'>\n", '<thead><tr><th>' . 'Name' . '<td>' . 'Type' . '<td>' . 'Return type' . "<td></thead>\n";
                    odd('');
                    foreach ($Ef as $L) {
                        $E = ($L["SPECIFIC_NAME"] == $L["ROUTINE_NAME"] ? "" : "&name=" . urlencode($L["ROUTINE_NAME"]));
                        echo '<tr' . odd() . '>', '<th><a href="' . h(ME . ($L["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($L["SPECIFIC_NAME"]) . $E) . '">' . h($L["ROUTINE_NAME"]) . '</a>', '<td>' . h($L["ROUTINE_TYPE"]), '<td>' . h($L["DTD_IDENTIFIER"]), '<td><a href="' . h(ME . ($L["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($L["SPECIFIC_NAME"]) . $E) . '">' . 'Alter' . "</a>";
                    }
                    echo "</table>\n";
                }
                echo '<p class="links">' . (support("procedure") ? '<a href="' . h(ME) . 'procedure=">' . 'Create procedure' . '</a>' : '') . '<a href="' . h(ME) . 'function=">' . 'Create function' . "</a>\n";
            }
            if (support("event")) {
                echo "<h3 id='events'>" . 'Events' . "</h3>\n";
                $M = get_rows("SHOW EVENTS");
                if ($M) {
                    echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "<td>" . 'Schedule' . "<td>" . 'Start' . "<td>" . 'End' . "<td></thead>\n";
                    foreach ($M as $L) {
                        echo "<tr>", "<th>" . h($L["Name"]), "<td>" . ($L["Execute at"] ? 'At given time' . "<td>" . $L["Execute at"] : 'Every' . " " . $L["Interval value"] . " " . $L["Interval field"] . "<td>$L[Starts]"), "<td>$L[Ends]", '<td><a href="' . h(ME) . 'event=' . urlencode($L["Name"]) . '">' . 'Alter' . '</a>';
                    }
                    echo "</table>\n";
                    $gc = $e->result("SELECT @@event_scheduler");
                    if ($gc && $gc != "ON")
                        echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($gc) . "\n";
                }
                echo '<p class="links"><a href="' . h(ME) . 'event=">' . 'Create event' . "</a>\n";
            }
            if ($vg)
                echo script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
        }
    }
}
page_footer();