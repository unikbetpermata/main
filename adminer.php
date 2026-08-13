<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.8.1
*/function
adminer_errors($Cc,$Ec){return!!preg_match('~^(Trying to access array offset on value of type null|Undefined array key)~',$Ec);}error_reporting(6135);set_error_handler('adminer_errors',E_WARNING);$ad=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($ad||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Ii=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Ii)$$X=$Ii;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$g;return$g;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($v){if(!preg_match('~^[`\'"]~',$v))return$v;$qe=substr($v,-1);return
str_replace($qe.$qe,$qe,substr($v,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($tg,$ad=false){if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){while(list($z,$X)=each($tg)){foreach($X
as$he=>$W){unset($tg[$z][$he]);if(is_array($W)){$tg[$z][stripslashes($he)]=$W;$tg[]=&$tg[$z][stripslashes($he)];}else$tg[$z][stripslashes($he)]=($ad?$W:stripslashes($W));}}}}function
bracket_escape($v,$Na=false){static$ui=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($v,($Na?array_flip($ui):$ui));}function
min_version($Zi,$De="",$h=null){global$g;if(!$h)$h=$g;$nh=$h->server_info;if($De&&preg_match('~([\d.]+)-MariaDB~',$nh,$C)){$nh=$C[1];$Zi=$De;}return(version_compare($nh,$Zi)>=0);}function
charset($g){return(min_version("5.5.3",0,$g)?"utf8mb4":"utf8");}function
script($yh,$ti="\n"){return"<script".nonce().">$yh</script>$ti";}function
script_src($Ni){return"<script src='".h($Ni)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($P){return
str_replace("\0","&#0;",htmlspecialchars($P,ENT_QUOTES,'utf-8'));}function
nl_br($P){return
str_replace("\n","<br>",$P);}function
checkbox($D,$Y,$db,$me="",$uf="",$hb="",$ne=""){$I="<input type='checkbox' name='$D' value='".h($Y)."'".($db?" checked":"").($ne?" aria-labelledby='$ne'":"").">".($uf?script("qsl('input').onclick = function () { $uf };",""):"");return($me!=""||$hb?"<label".($hb?" class='$hb'":"").">$I".h($me)."</label>":$I);}function
optionlist($_f,$gh=null,$Ri=false){$I="";foreach($_f
as$he=>$W){$Af=array($he=>$W);if(is_array($W)){$I.='<optgroup label="'.h($he).'">';$Af=$W;}foreach($Af
as$z=>$X)$I.='<option'.($Ri||is_string($z)?' value="'.h($z).'"':'').(($Ri||is_string($z)?(string)$z:$X)===$gh?' selected':'').'>'.h($X);if(is_array($W))$I.='</optgroup>';}return$I;}function
html_select($D,$_f,$Y="",$tf=true,$ne=""){if($tf)return"<select name='".h($D)."'".($ne?" aria-labelledby='$ne'":"").">".optionlist($_f,$Y)."</select>".(is_string($tf)?script("qsl('select').onchange = function () { $tf };",""):"");$I="";foreach($_f
as$z=>$X)$I.="<label><input type='radio' name='".h($D)."' value='".h($z)."'".($z==$Y?" checked":"").">".h($X)."</label>";return$I;}function
select_input($Ia,$_f,$Y="",$tf="",$fg=""){$Yh=($_f?"select":"input");return"<$Yh$Ia".($_f?"><option value=''>$fg".optionlist($_f,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$fg'>").($tf?script("qsl('$Yh').onchange = $tf;",""):"");}function
confirm($Ne="",$hh="qsl('input')"){return
script("$hh.onclick = function () { return confirm('".($Ne?js_escape($Ne):lang(0))."'); };","");}function
print_fieldset($u,$ve,$cj=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$ve</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($cj?"":" class='hidden'").">\n";}function
bold($Ua,$hb=""){return($Ua?" class='active $hb'":($hb?" class='$hb'":""));}function
odd($I=' class="odd"'){static$t=0;if(!$I)$t=-1;return($t++%2?$I:'');}function
js_escape($P){return
addcslashes($P,"\r\n'\\/");}function
json_row($z,$X=null){static$bd=true;if($bd)echo"{";if($z!=""){echo($bd?"":",")."\n\t\"".addcslashes($z,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$bd=false;}else{echo"\n}\n";$bd=true;}}function
ini_bool($Ud){$X=ini_get($Ud);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$I;if($I===null)$I=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$I;}function
set_password($Yi,$M,$V,$F){$_SESSION["pwds"][$Yi][$M][$V]=($_COOKIE["adminer_key"]&&is_string($F)?array(encrypt_string($F,$_COOKIE["adminer_key"])):$F);}function
get_password(){$I=get_session("pwds");if(is_array($I))$I=($_COOKIE["adminer_key"]?decrypt_string($I[0],$_COOKIE["adminer_key"]):false);return$I;}function
q($P){global$g;return$g->quote($P);}function
get_vals($G,$d=0){global$g;$I=array();$H=$g->query($G);if(is_object($H)){while($J=$H->fetch_row())$I[]=$J[$d];}return$I;}function
get_key_vals($G,$h=null,$qh=true){global$g;if(!is_object($h))$h=$g;$I=array();$H=$h->query($G);if(is_object($H)){while($J=$H->fetch_row()){if($qh)$I[$J[0]]=$J[1];else$I[]=$J[0];}}return$I;}function
get_rows($G,$h=null,$n="<p class='error'>"){global$g;$yb=(is_object($h)?$h:$g);$I=array();$H=$yb->query($G);if(is_object($H)){while($J=$H->fetch_assoc())$I[]=$J;}elseif(!$H&&!is_object($h)&&$n&&defined("PAGE_HEADER"))echo$n.error()."\n";return$I;}function
unique_array($J,$x){foreach($x
as$w){if(preg_match("~PRIMARY|UNIQUE~",$w["type"])){$I=array();foreach($w["columns"]as$z){if(!isset($J[$z]))continue
2;$I[$z]=$J[$z];}return$I;}}}function
escape_key($z){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$z,$C))return$C[1].idf_escape(idf_unescape($C[2])).$C[3];return
idf_escape($z);}function
where($Z,$p=array()){global$g,$y;$I=array();foreach((array)$Z["where"]as$z=>$X){$z=bracket_escape($z,1);$d=escape_key($z);$I[]=$d.($y=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):($y=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($p[$z],q($X))));if($y=="sql"&&preg_match('~char|text~',$p[$z]["type"])&&preg_match("~[^ -@]~",$X))$I[]="$d = ".q($X)." COLLATE ".charset($g)."_bin";}foreach((array)$Z["null"]as$z)$I[]=escape_key($z)." IS NULL";return
implode(" AND ",$I);}function
where_check($X,$p=array()){parse_str($X,$bb);remove_slashes(array(&$bb));return
where($bb,$p);}function
where_link($t,$d,$Y,$wf="="){return"&where%5B$t%5D%5Bcol%5D=".urlencode($d)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$wf:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($e,$p,$L=array()){$I="";foreach($e
as$z=>$X){if($L&&!in_array(idf_escape($z),$L))continue;$Ga=convert_field($p[$z]);if($Ga)$I.=", $Ga AS ".idf_escape($z);}return$I;}function
cookie($D,$Y,$ye=2592000){global$ba;return
header("Set-Cookie: $D=".urlencode($Y).($ye?"; expires=".gmdate("D, d M Y H:i:s",time()+$ye)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($gd=false){$Qi=ini_bool("session.use_cookies");if(!$Qi||$gd){session_write_close();if($Qi&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($z){return$_SESSION[$z][DRIVER][SERVER][$_GET["username"]];}function
set_session($z,$X){$_SESSION[$z][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($Yi,$M,$V,$l=null){global$kc;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($kc))."|username|".($l!==null?"db|":"").session_name()),$C);return"$C[1]?".(sid()?SID."&":"").($Yi!="server"||$M!=""?urlencode($Yi)."=".urlencode($M)."&":"")."username=".urlencode($V).($l!=""?"&db=".urlencode($l):"").($C[2]?"&$C[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($B,$Ne=null){if($Ne!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($B!==null?$B:$_SERVER["REQUEST_URI"]))][]=$Ne;}if($B!==null){if($B=="")$B=".";header("Location: $B");exit;}}function
query_redirect($G,$B,$Ne,$Dg=true,$Jc=true,$Tc=false,$gi=""){global$g,$n,$b;if($Jc){$Fh=microtime(true);$Tc=!$g->query($G);$gi=format_time($Fh);}$Ah="";if($G)$Ah=$b->messageQuery($G,$gi,$Tc);if($Tc){$n=error().$Ah.script("messagesPrint();");return
false;}if($Dg)redirect($B,$Ne.$Ah);return
true;}function
queries($G){global$g;static$yg=array();static$Fh;if(!$Fh)$Fh=microtime(true);if($G===null)return
array(implode("\n",$yg),format_time($Fh));$yg[]=(preg_match('~;$~',$G)?"DELIMITER ;;\n$G;\nDELIMITER ":$G).";";return$g->query($G);}function
apply_queries($G,$S,$Fc='table'){foreach($S
as$Q){if(!queries("$G ".$Fc($Q)))return
false;}return
true;}function
queries_redirect($B,$Ne,$Dg){list($yg,$gi)=queries(null);return
query_redirect($yg,$B,$Ne,$Dg,false,!$Dg,$gi);}function
format_time($Fh){return
lang(1,max(0,microtime(true)-$Fh));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Qf=""){return
substr(preg_replace("~(?<=[?&])($Qf".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
pagination($E,$Pb){return" ".($E==$Pb?$E+1:'<a href="'.h(remove_from_uri("page").($E?"&page=$E".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($E+1)."</a>");}function
get_file($z,$Xb=false){$Zc=$_FILES[$z];if(!$Zc)return
null;foreach($Zc
as$z=>$X)$Zc[$z]=(array)$X;$I='';foreach($Zc["error"]as$z=>$n){if($n)return$n;$D=$Zc["name"][$z];$oi=$Zc["tmp_name"][$z];$Db=file_get_contents($Xb&&preg_match('~\.gz$~',$D)?"compress.zlib://$oi":$oi);if($Xb){$Fh=substr($Db,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$Fh,$Jg))$Db=iconv("utf-16","utf-8",$Db);elseif($Fh=="\xEF\xBB\xBF")$Db=substr($Db,3);$I.=$Db."\n\n";}else$I.=$Db;}return$I;}function
upload_error($n){$Ke=($n==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($n?lang(2).($Ke?" ".lang(3,$Ke):""):lang(4));}function
repeat_pattern($cg,$we){return
str_repeat("$cg{0,65535}",$we/65535)."$cg{0,".($we%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($P,$we=80,$Mh=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$we).")($)?)u",$P,$C))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$we).")($)?)",$P,$C);return
h($C[1]).$Mh.(isset($C[2])?"":"<i>…</i>");}function
format_number($X){return
strtr(number_format($X,0,".",lang(5)),preg_split('~~u',lang(6),-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~[^a-z0-9_]~i','-',$X);}function
hidden_fields($tg,$Jd=array(),$lg=''){$I=false;foreach($tg
as$z=>$X){if(!in_array($z,$Jd)){if(is_array($X))hidden_fields($X,array(),$z);else{$I=true;echo'<input type="hidden" name="'.h($lg?$lg."[$z]":$z).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($Q,$Uc=false){$I=table_status($Q,$Uc);return($I?$I:array("Name"=>$Q));}function
column_foreign_keys($Q){global$b;$I=array();foreach($b->foreignKeys($Q)as$r){foreach($r["source"]as$X)$I[$X][]=$r;}return$I;}function
enum_input($T,$Ia,$o,$Y,$zc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$Fe);$I=($zc!==null?"<label><input type='$T'$Ia value='$zc'".((is_array($Y)?in_array($zc,$Y):$Y===0)?" checked":"")."><i>".lang(7)."</i></label>":"");foreach($Fe[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$db=(is_int($Y)?$Y==$t+1:(is_array($Y)?in_array($t+1,$Y):$Y===$X));$I.=" <label><input type='$T'$Ia value='".($t+1)."'".($db?' checked':'').'>'.h($b->editVal($X,$o)).'</label>';}return$I;}function
input($o,$Y,$s){global$U,$b,$y;$D=h(bracket_escape($o["field"]));echo"<td class='function'>";if(is_array($Y)&&!$s){$Ea=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$Ea[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$Ea);$s="json";}$Ng=($y=="mssql"&&$o["auto_increment"]);if($Ng&&!$_POST["save"])$s=null;$pd=(isset($_GET["select"])||$Ng?array("orig"=>lang(8)):array())+$b->editFunctions($o);$Ia=" name='fields[$D]'";if($o["type"]=="enum")echo
h($pd[""])."<td>".$b->editInput($_GET["edit"],$o,$Ia,$Y);else{$zd=(in_array($s,$pd)||isset($pd[$s]));echo(count($pd)>1?"<select name='function[$D]'>".optionlist($pd,$s===null||$zd?$s:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($pd))).'<td>';$Wd=$b->editInput($_GET["edit"],$o,$Ia,$Y);if($Wd!="")echo$Wd;elseif(preg_match('~bool~',$o["type"]))echo"<input type='hidden'$Ia value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Ia value='1'>";elseif($o["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$Fe);foreach($Fe[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$db=(is_int($Y)?($Y>>$t)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$D][$t]' value='".(1<<$t)."'".($db?' checked':'').">".h($b->editVal($X,$o)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$D'>";elseif(($ei=preg_match('~text|lob|memo~i',$o["type"]))||preg_match("~\n~",$Y)){if($ei&&$y!="sqlite")$Ia.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$Ia.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$Ia>".h($Y).'</textarea>';}elseif($s=="json"||preg_match('~^jsonb?$~',$o["type"]))echo"<textarea$Ia cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Me=(!preg_match('~int~',$o["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$o["length"],$C)?((preg_match("~binary~",$o["type"])?2:1)*$C[1]+($C[3]?1:0)+($C[2]&&!$o["unsigned"]?1:0)):($U[$o["type"]]?$U[$o["type"]]+($o["unsigned"]?0:1):0));if($y=='sql'&&min_version(5.6)&&preg_match('~time~',$o["type"]))$Me+=7;echo"<input".((!$zd||$s==="")&&preg_match('~(?<!o)int(?!er)~',$o["type"])&&!preg_match('~\[\]~',$o["full_type"])?" type='number'":"")." value='".h($Y)."'".($Me?" data-maxlength='$Me'":"").(preg_match('~char|binary~',$o["type"])&&$Me>20?" size='40'":"")."$Ia>";}echo$b->editHint($_GET["edit"],$o,$Y);$bd=0;foreach($pd
as$z=>$X){if($z===""||!$X)break;$bd++;}if($bd)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $bd), oninput: function () { this.onchange(); }});");}}function
process_input($o){global$b,$m;$v=bracket_escape($o["field"]);$s=$_POST["function"][$v];$Y=$_POST["fields"][$v];if($o["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($o["auto_increment"]&&$Y=="")return
null;if($s=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?idf_escape($o["field"]):false);if($s=="NULL")return"NULL";if($o["type"]=="set")return
array_sum((array)$Y);if($s=="json"){$s="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads")){$Zc=get_file("fields-$v");if(!is_string($Zc))return
false;return$m->quoteBinary($Zc);}return$b->processInput($o,$Y,$s);}function
fields_from_edit(){global$m;$I=array();foreach((array)$_POST["field_keys"]as$z=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$z];$_POST["fields"][$X]=$_POST["field_vals"][$z];}}foreach((array)$_POST["fields"]as$z=>$X){$D=bracket_escape($z,1);$I[$D]=array("field"=>$D,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($z==$m->primary),);}return$I;}function
search_tables(){global$b,$g;$_GET["where"][0]["val"]=$_POST["query"];$jh="<ul>\n";foreach(table_status('',true)as$Q=>$R){$D=$b->tableName($R);if(isset($R["Engine"])&&$D!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$H=$g->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$H||$H->fetch_row()){$pg="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$D</a>";echo"$jh<li>".($H?$pg:"<p class='error'>$pg: ".error())."\n";$jh="";}}}echo($jh?"<p class='message'>".lang(9):"</ul>")."\n";}function
dump_headers($Hd,$Ve=false){global$b;$I=$b->dumpHeaders($Hd,$Ve);$Mf=$_POST["output"];if($Mf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Hd).".$I".($Mf!="file"&&preg_match('~^[0-9a-z]+$~',$Mf)?".$Mf":""));session_write_close();ob_flush();flush();return$I;}function
dump_csv($J){foreach($J
as$z=>$X){if(preg_match('~["\n,;\t]|^0|\.\d*0$~',$X)||$X==="")$J[$z]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$J)."\r\n";}function
apply_sql_function($s,$d){return($s?($s=="unixepoch"?"DATETIME($d, '$s')":($s=="count distinct"?"COUNT(DISTINCT ":strtoupper("$s("))."$d)"):$d);}function
get_temp_dir(){$I=ini_get("upload_tmp_dir");if(!$I){if(function_exists('sys_get_temp_dir'))$I=sys_get_temp_dir();else{$q=@tempnam("","");if(!$q)return
false;$I=dirname($q);unlink($q);}}return$I;}function
file_open_lock($q){$nd=@fopen($q,"r+");if(!$nd){$nd=@fopen($q,"w");if(!$nd)return;chmod($q,0660);}flock($nd,LOCK_EX);return$nd;}function
file_write_unlock($nd,$Rb){rewind($nd);fwrite($nd,$Rb);ftruncate($nd,strlen($Rb));flock($nd,LOCK_UN);fclose($nd);}function
password_file($i){$q=get_temp_dir()."/adminer.key";$I=@file_get_contents($q);if($I||!$i)return$I;$nd=@fopen($q,"w");if($nd){chmod($q,0660);$I=rand_string();fwrite($nd,$I);fclose($nd);}return$I;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$A,$o,$fi){global$b;if(is_array($X)){$I="";foreach($X
as$he=>$W)$I.="<tr>".($X!=array_values($X)?"<th>".h($he):"")."<td>".select_value($W,$A,$o,$fi);return"<table cellspacing='0'>$I</table>";}if(!$A)$A=$b->selectLink($X,$o);if($A===null){if(is_mail($X))$A="mailto:$X";if(is_url($X))$A=$X;}$I=$b->editVal($X,$o);if($I!==null){if(!is_utf8($I))$I="\0";elseif($fi!=""&&is_shortable($o))$I=shorten_utf8($I,max(0,+$fi));else$I=h($I);}return$b->selectVal($I,$A,$o,$X);}function
is_mail($wc){$Ha='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$jc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$cg="$Ha+(\\.$Ha+)*@($jc?\\.)+$jc";return
is_string($wc)&&preg_match("(^$cg(,\\s*$cg)*\$)i",$wc);}function
is_url($P){$jc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($jc?\\.)+$jc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$P);}function
is_shortable($o){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$o["type"]);}function
count_rows($Q,$Z,$ce,$sd){global$y;$G=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ",$Z):"");return($ce&&($y=="sql"||count($sd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$sd).")$G":"SELECT COUNT(*)".($ce?" FROM (SELECT 1$G GROUP BY ".implode(", ",$sd).") x":$G));}function
slow_query($G){global$b,$qi,$m;$l=$b->database();$hi=$b->queryTimeout();$vh=$m->slowQuery($G,$hi);if(!$vh&&support("kill")&&is_object($h=connect())&&($l==""||$h->select_db($l))){$ke=$h->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$ke,'&token=',$qi,'\');
}, ',1000*$hi,');
</script>
';}else$h=null;ob_flush();flush();$I=@get_key_vals(($vh?$vh:$G),$h,false);if($h){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$I;}function
get_token(){$Ag=rand(1,1e6);return($Ag^$_SESSION["token"]).":$Ag";}function
verify_token(){list($qi,$Ag)=explode(":",$_POST["token"]);return($Ag^$_SESSION["token"])==$qi;}function
lzw_decompress($Ra){$gc=256;$Sa=8;$jb=array();$Pg=0;$Qg=0;for($t=0;$t<strlen($Ra);$t++){$Pg=($Pg<<8)+ord($Ra[$t]);$Qg+=8;if($Qg>=$Sa){$Qg-=$Sa;$jb[]=$Pg>>$Qg;$Pg&=(1<<$Qg)-1;$gc++;if($gc>>$Sa)$Sa++;}}$fc=range("\0","\xFF");$I="";foreach($jb
as$t=>$ib){$vc=$fc[$ib];if(!isset($vc))$vc=$nj.$nj[0];$I.=$vc;if($t)$fc[]=$nj.$vc[0];$nj=$vc;}return$I;}function
on_help($rb,$sh=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $rb, $sh) }, onmouseout: helpMouseout});","");}function
edit_form($Q,$p,$J,$Li){global$b,$y,$qi,$n;$Rh=$b->tableName(table_status1($Q,true));page_header(($Li?lang(10):lang(11)),$n,array("select"=>array($Q,$Rh)),$Rh);$b->editRowPrint($Q,$p,$J,$Li);if($J===false)echo"<p class='error'>".lang(12)."\n";echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$p)echo"<p class='error'>".lang(13)."\n";else{echo"<table cellspacing='0' class='layout'>".script("qsl('table').onkeydown = editingKeydown;");foreach($p
as$D=>$o){echo"<tr><th>".$b->fieldName($o);$Yb=$_GET["set"][bracket_escape($D)];if($Yb===null){$Yb=$o["default"];if($o["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$Yb,$Jg))$Yb=$Jg[1];}$Y=($J!==null?($J[$D]!=""&&$y=="sql"&&preg_match("~enum|set~",$o["type"])?(is_array($J[$D])?array_sum($J[$D]):+$J[$D]):(is_bool($J[$D])?+$J[$D]:$J[$D])):(!$Li&&$o["auto_increment"]?"":(isset($_GET["select"])?false:$Yb)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$o);$s=($_POST["save"]?(string)$_POST["function"][$D]:($Li&&preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Li&&$Y==$o["default"]&&preg_match('~^[\w.]+\(~',$Y))$s="SQL";if(preg_match("~time~",$o["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$s="now";}input($o,$Y,$s);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($p){echo"<input type='submit' value='".lang(14)."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Li?lang(15):lang(16))."' title='Ctrl+Shift+Enter'>\n",($Li?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".lang(17)."…', this); };"):"");}}echo($Li?"<input type='submit' name='delete' value='".lang(18)."'>".confirm()."\n":($_POST||!$p?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$qi,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
RVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");$Rf=array(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba);if(version_compare(PHP_VERSION,'5.2.0')>=0)$Rf[]=true;call_user_func_array('session_set_cookie_params',$Rf);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$ad);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);$pe=array('en'=>'English','ar'=>'العربية','bg'=>'Български','bn'=>'বাংলা','bs'=>'Bosanski','ca'=>'Català','cs'=>'Čeština','da'=>'Dansk','de'=>'Deutsch','el'=>'Ελληνικά','es'=>'Español','et'=>'Eesti','fa'=>'فارسی','fi'=>'Suomi','fr'=>'Français','gl'=>'Galego','he'=>'עברית','hu'=>'Magyar','id'=>'Bahasa Indonesia','it'=>'Italiano','ja'=>'日本語','ka'=>'ქართული','ko'=>'한국어','lt'=>'Lietuvių','ms'=>'Bahasa Melayu','nl'=>'Nederlands','no'=>'Norsk','pl'=>'Polski','pt'=>'Português','pt-br'=>'Português (Brazil)','ro'=>'Limba Română','ru'=>'Русский','sk'=>'Slovenčina','sl'=>'Slovenski','sr'=>'Српски','sv'=>'Svenska','ta'=>'த‌மிழ்','th'=>'ภาษาไทย','tr'=>'Türkçe','uk'=>'Українська','vi'=>'Tiếng Việt','zh'=>'简体中文','zh-tw'=>'繁體中文',);function
get_lang(){global$ca;return$ca;}function
lang($v,$hf=null){if(is_string($v)){$hg=array_search($v,get_translations("en"));if($hg!==false)$v=$hg;}global$ca,$wi;$vi=($wi[$v]?$wi[$v]:$v);if(is_array($vi)){$hg=($hf==1?0:($ca=='cs'||$ca=='sk'?($hf&&$hf<5?1:2):($ca=='fr'?(!$hf?0:1):($ca=='pl'?($hf%10>1&&$hf%10<5&&$hf/10%10!=1?1:2):($ca=='sl'?($hf%100==1?0:($hf%100==2?1:($hf%100==3||$hf%100==4?2:3))):($ca=='lt'?($hf%10==1&&$hf%100!=11?0:($hf%10>1&&$hf/10%10!=1?1:2)):($ca=='bs'||$ca=='ru'||$ca=='sr'||$ca=='uk'?($hf%10==1&&$hf%100!=11?0:($hf%10>1&&$hf%10<5&&$hf/10%10!=1?1:2)):1)))))));$vi=$vi[$hg];}$Ea=func_get_args();array_shift($Ea);$kd=str_replace("%d","%s",$vi);if($kd!=$vi)$Ea[0]=format_number($hf);return
vsprintf($kd,$Ea);}function
switch_lang(){global$ca,$pe;echo"<form action='' method='post'>\n<div id='lang'>",lang(19).": ".html_select("lang",$pe,$ca,"this.form.submit();")," <input type='submit' value='".lang(20)."' class='hidden'>\n","<input type='hidden' name='token' value='".get_token()."'>\n";echo"</div>\n</form>\n";}if(isset($_POST["lang"])&&verify_token()){cookie("adminer_lang",$_POST["lang"]);$_SESSION["lang"]=$_POST["lang"];$_SESSION["translations"]=array();redirect(remove_from_uri());}$ca="en";if(isset($pe[$_COOKIE["adminer_lang"]])){cookie("adminer_lang",$_COOKIE["adminer_lang"]);$ca=$_COOKIE["adminer_lang"];}elseif(isset($pe[$_SESSION["lang"]]))$ca=$_SESSION["lang"];else{$wa=array();preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~',str_replace("_","-",strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])),$Fe,PREG_SET_ORDER);foreach($Fe
as$C)$wa[$C[1]]=(isset($C[3])?$C[3]:1);arsort($wa);foreach($wa
as$z=>$xg){if(isset($pe[$z])){$ca=$z;break;}$z=preg_replace('~-.*~','',$z);if(!isset($wa[$z])&&isset($pe[$z])){$ca=$z;break;}}}$wi=$_SESSION["translations"];if($_SESSION["translations_version"]!=578941549){$wi=array();$_SESSION["translations_version"]=578941549;}function
Min_PDO{var$_result,$server_info,$affected_rows,$errno,$error,$pdo;function
__construct(){global$b;$hg=array_search("SQL",$b->operators);if($hg!==false)unset($b->operators[$hg]);}function
dsn($pc,$V,$F,$_f=array()){$_f[PDO::ATTR_ERRMODE]=PDO::ERRMODE_SILENT;$_f[PDO::ATTR_STATEMENT_CLASS]=array('Min_PDOStatement');try{$this->pdo=new
PDO($pc,$V,$F,$_f);}catch(Exception$Hc){auth_error(h($Hc->getMessage()));}$this->server_info=@$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);}function
quote($P){return$this->pdo->quote($P);}function
query($G,$Ei=false){$H=$this->pdo->query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error=lang(21);return
false;}$this->store_result($H);return$H;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result($H=null){if(!$H){$H=$this->_result;if(!$H)return
false;}if($H->columnCount()){$H->num_rows=$H->rowCount();return$H;}$this->affected_rows=$H->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($G,$o=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch();return$J[$o];}}class
Min_PDOStatement
extends
PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(PDO::FETCH_ASSOC);}function
fetch_row(){return$this->fetch(PDO::FETCH_NUM);}function
fetch_field(){$J=(object)$this->getColumnMeta($this->_offset++);$J->orgtable=$J->table;$J->orgname=$J->name;$J->charsetnr=(in_array("blob",(array)$J->flags)?63:0);return$J;}}}$kc=array();function
add_driver($u,$D){global$kc;$kc[$u]=$D;}class
Min_SQL{var$_conn;function
__construct($g){$this->_conn=$g;}function
select($Q,$L,$Z,$sd,$Bf=array(),$_=1,$E=0,$pg=false){global$b,$y;$ce=(count($sd)<count($L));$G=$b->selectQueryBuild($L,$Z,$sd,$Bf,$_,$E);if(!$G)$G="SELECT".limit(($_GET["page"]!="last"&&$_!=""&&$sd&&$ce&&$y=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$L)."\nFROM ".table($Q),($Z?"\nWHERE ".implode(" AND ",$Z):"").($sd&&$ce?"\nGROUP BY ".implode(", ",$sd):"").($Bf?"\nORDER BY ".implode(", ",$Bf):""),($_!=""?+$_:null),($E?$_*$E:0),"\n");$Fh=microtime(true);$I=$this->_conn->query($G);if($pg)echo$b->selectQuery($G,$Fh,!$I);return$I;}function
delete($Q,$zg,$_=0){$G="FROM ".table($Q);return
queries("DELETE".($_?limit1($Q,$G,$zg):" $G$zg"));}function
update($Q,$N,$zg,$_=0,$kh="\n"){$Wi=array();foreach($N
as$z=>$X)$Wi[]="$z = $X";$G=table($Q)." SET$kh".implode(",$kh",$Wi);return
queries("UPDATE".($_?limit1($Q,$G,$zg,$kh):" $G$zg"));}function
insert($Q,$N){return
queries("INSERT INTO ".table($Q).($N?" (".implode(", ",array_keys($N)).")\nVALUES (".implode(", ",$N).")":" DEFAULT VALUES"));}function
insertUpdate($Q,$K,$ng){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($G,$hi){}function
convertSearch($v,$X,$o){return$v;}function
value($X,$o){return(method_exists($this->_conn,'value')?$this->_conn->value($X,$o):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($ah){return
q($ah);}function
warnings(){return'';}function
tableHelp($D){}}$kc["sqlite"]="SQLite 3";$kc["sqlite2"]="SQLite 2";if(isset($_GET["sqlite"])||isset($_GET["sqlite2"])){define("DRIVER",(isset($_GET["sqlite"])?"sqlite":"sqlite2"));if(class_exists(isset($_GET["sqlite"])?"SQLite3":"SQLiteDatabase")){if(isset($_GET["sqlite"])){class
Min_SQLite{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error,$_link;function
__construct($q){$this->_link=new
SQLite3($q);$Zi=$this->_link->version();$this->server_info=$Zi["versionString"];}function
query($G){$H=@$this->_link->query($G);$this->error="";if(!$H){$this->errno=$this->_link->lastErrorCode();$this->error=$this->_link->lastErrorMsg();return
false;}elseif($H->numColumns())return
new
Min_Result($H);$this->affected_rows=$this->_link->changes();return
true;}function
quote($P){return(is_utf8($P)?"'".$this->_link->escapeString($P)."'":"x'".reset(unpack('H*',$P))."'");}function
store_result(){return$this->_result;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetchArray();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;}function
fetch_assoc(){return$this->_result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->_result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->_offset++;$T=$this->_result->columnType($d);return(object)array("name"=>$this->_result->columnName($d),"type"=>$T,"charsetnr"=>($T==SQLITE3_BLOB?63:0),);}function
__desctruct(){return$this->_result->finalize();}}}else{class
Min_SQLite{var$extension="SQLite",$server_info,$affected_rows,$error,$_link;function
__construct($q){$this->server_info=sqlite_libversion();$this->_link=new
SQLiteDatabase($q);}function
query($G,$Ei=false){$Se=($Ei?"unbufferedQuery":"query");$H=@$this->_link->$Se($G,SQLITE_BOTH,$n);$this->error="";if(!$H){$this->error=$n;return
false;}elseif($H===true){$this->affected_rows=$this->changes();return
true;}return
new
Min_Result($H);}function
quote($P){return"'".sqlite_escape_string($P)."'";}function
store_result(){return$this->_result;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetch();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;if(method_exists($H,'numRows'))$this->num_rows=$H->numRows();}function
fetch_assoc(){$J=$this->_result->fetch(SQLITE_ASSOC);if(!$J)return
false;$I=array();foreach($J
as$z=>$X)$I[idf_unescape($z)]=$X;return$I;}function
fetch_row(){return$this->_result->fetch(SQLITE_NUM);}function
fetch_field(){$D=$this->_result->fieldName($this->_offset++);$cg='(\[.*]|"(?:[^"]|"")*"|(.+))';if(preg_match("~^($cg\\.)?$cg\$~",$D,$C)){$Q=($C[3]!=""?$C[3]:idf_unescape($C[2]));$D=($C[5]!=""?$C[5]:idf_unescape($C[4]));}return(object)array("name"=>$D,"orgname"=>$D,"orgtable"=>$Q,);}}}}elseif(extension_loaded("pdo_sqlite")){class
Min_SQLite
extends
Min_PDO{var$extension="PDO_SQLite";function
__construct($q){$this->dsn(DRIVER.":$q","","");}}}if(class_exists("Min_SQLite")){class
Min_DB
extends
Min_SQLite{function
__construct(){parent::__construct(":memory:");$this->query("PRAGMA foreign_keys = 1");}function
select_db($q){if(is_readable($q)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$q)?$q:dirname($_SERVER["SCRIPT_FILENAME"])."/$q")." AS a")){parent::__construct($q);$this->query("PRAGMA foreign_keys = 1");$this->query("PRAGMA busy_timeout = 500");return
true;}return
false;}function
multi_query($G){return$this->_result=$this->query($G);}function
next_result(){return
false;}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$K,$ng){$Wi=array();foreach($K
as$N)$Wi[]="(".implode(", ",$N).")";return
queries("REPLACE INTO ".table($Q)." (".implode(", ",array_keys(reset($K))).") VALUES\n".implode(",\n",$Wi));}function
tableHelp($D){if($D=="sqlite_sequence")return"fileformat2.html#seqtab";if($D=="sqlite_master")return"fileformat2.html#$D";}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b;list(,,$F)=$b->credentials();if($F!="")return
lang(22);return
new
Min_DB;}function
get_databases(){return
array();}function
limit($G,$Z,$_,$kf=0,$kh=" "){return" $G$Z".($_!==null?$kh."LIMIT $_".($kf?" OFFSET $kf":""):"");}function
limit1($Q,$G,$Z,$kh="\n"){global$g;return(preg_match('~^INTO~',$G)||$g->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($G,$Z,1,0,$kh):" $G WHERE rowid = (SELECT rowid FROM ".table($Q).$Z.$kh."LIMIT 1)");}function
db_collation($l,$nb){global$g;return$g->result("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($k){return
array();}function
table_status($D=""){global$g;$I=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($D!=""?"AND name = ".q($D):"ORDER BY name"))as$J){$J["Rows"]=$g->result("SELECT COUNT(*) FROM ".idf_escape($J["Name"]));$I[$J["Name"]]=$J;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$J)$I[$J["name"]]["Auto_increment"]=$J["seq"];return($D!=""?$I[$D]:$I);}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){global$g;return!$g->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($Q){global$g;$I=array();$ng="";foreach(get_rows("PRAGMA table_info(".table($Q).")")as$J){$D=$J["name"];$T=strtolower($J["type"]);$Yb=$J["dflt_value"];$I[$D]=array("field"=>$D,"type"=>(preg_match('~int~i',$T)?"integer":(preg_match('~char|clob|text~i',$T)?"text":(preg_match('~blob~i',$T)?"blob":(preg_match('~real|floa|doub~i',$T)?"real":"numeric")))),"full_type"=>$T,"default"=>(preg_match("~'(.*)'~",$Yb,$C)?str_replace("''","'",$C[1]):($Yb=="NULL"?null:$Yb)),"null"=>!$J["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1),"primary"=>$J["pk"],);if($J["pk"]){if($ng!="")$I[$ng]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$T))$I[$D]["auto_increment"]=true;$ng=$D;}}$Ah=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$Ah,$Fe,PREG_SET_ORDER);foreach($Fe
as$C){$D=str_replace('""','"',preg_replace('~^"|"$~','',$C[1]));if($I[$D])$I[$D]["collation"]=trim($C[3],"'");}return$I;}function
indexes($Q,$h=null){global$g;if(!is_object($h))$h=$g;$I=array();$Ah=$h->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$Ah,$C)){$I[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$C[1],$Fe,PREG_SET_ORDER);foreach($Fe
as$C){$I[""]["columns"][]=idf_unescape($C[2]).$C[4];$I[""]["descs"][]=(preg_match('~DESC~i',$C[5])?'1':null);}}if(!$I){foreach(fields($Q)as$D=>$o){if($o["primary"])$I[""]=array("type"=>"PRIMARY","columns"=>array($D),"lengths"=>array(),"descs"=>array(null));}}$Dh=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($Q),$h);foreach(get_rows("PRAGMA index_list(".table($Q).")",$h)as$J){$D=$J["name"];$w=array("type"=>($J["unique"]?"UNIQUE":"INDEX"));$w["lengths"]=array();$w["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($D).")",$h)as$Zg){$w["columns"][]=$Zg["name"];$w["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($D).' ON '.idf_escape($Q),'~').' \((.*)\)$~i',$Dh[$D],$Jg)){preg_match_all('/("[^"]*+")+( DESC)?/',$Jg[2],$Fe);foreach($Fe[2]as$z=>$X){if($X)$w["descs"][$z]='1';}}if(!$I[""]||$w["type"]!="UNIQUE"||$w["columns"]!=$I[""]["columns"]||$w["descs"]!=$I[""]["descs"]||!preg_match("~^sqlite_~",$D))$I[$D]=$w;}return$I;}function
foreign_keys($Q){$I=array();foreach(get_rows("PRAGMA foreign_key_list(".table($Q).")")as$J){$r=&$I[$J["id"]];if(!$r)$r=$J;$r["source"][]=$J["from"];$r["target"][]=$J["to"];}return$I;}function
view($D){global$g;return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',$g->result("SELECT sql FROM sqlite_master WHERE name = ".q($D))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
check_sqlite_name($D){global$g;$Qc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Qc)\$~",$D)){$g->error=lang(23,str_replace("|",", ",$Qc));return
false;}return
true;}function
create_database($l,$mb){global$g;if(file_exists($l)){$g->error=lang(24);return
false;}if(!check_sqlite_name($l))return
false;try{$A=new
Min_SQLite($l);}catch(Exception$Hc){$g->error=$Hc->getMessage();return
false;}$A->query('PRAGMA encoding = "UTF-8"');$A->query('CREATE TABLE adminer (i)');$A->query('DROP TABLE adminer');return
true;}function
drop_databases($k){global$g;$g->__construct(":memory:");foreach($k
as$l){if(!@unlink($l)){$g->error=lang(24);return
false;}}return
true;}function
rename_database($D,$mb){global$g;if(!check_sqlite_name($D))return
false;$g->__construct(":memory:");$g->error=lang(24);return@rename(DB,$D);}function
auto_increment(){return" PRIMARY KEY".(DRIVER=="sqlite"?" AUTOINCREMENT":"");}function
alter_table($Q,$D,$p,$hd,$tb,$_c,$mb,$La,$Wf){global$g;$Pi=($Q==""||$hd);foreach($p
as$o){if($o[0]!=""||!$o[1]||$o[2]){$Pi=true;break;}}$c=array();$Kf=array();foreach($p
as$o){if($o[1]){$c[]=($Pi?$o[1]:"ADD ".implode($o[1]));if($o[0]!="")$Kf[$o[0]]=$o[1][0];}}if(!$Pi){foreach($c
as$X){if(!queries("ALTER TABLE ".table($Q)." $X"))return
false;}if($Q!=$D&&!queries("ALTER TABLE ".table($Q)." RENAME TO ".table($D)))return
false;}elseif(!recreate_table($Q,$D,$c,$Kf,$hd,$La))return
false;if($La){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $La WHERE name = ".q($D));if(!$g->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($D).", $La)");queries("COMMIT");}return
true;}function
recreate_table($Q,$D,$p,$Kf,$hd,$La,$x=array()){global$g;if($Q!=""){if(!$p){foreach(fields($Q)as$z=>$o){if($x)$o["auto_increment"]=0;$p[]=process_field($o,$o);$Kf[$z]=idf_escape($z);}}$og=false;foreach($p
as$o){if($o[6])$og=true;}$nc=array();foreach($x
as$z=>$X){if($X[2]=="DROP"){$nc[$X[1]]=true;unset($x[$z]);}}foreach(indexes($Q)as$ie=>$w){$e=array();foreach($w["columns"]as$z=>$d){if(!$Kf[$d])continue
2;$e[]=$Kf[$d].($w["descs"][$z]?" DESC":"");}if(!$nc[$ie]){if($w["type"]!="PRIMARY"||!$og)$x[]=array($w["type"],$ie,$e);}}foreach($x
as$z=>$X){if($X[0]=="PRIMARY"){unset($x[$z]);$hd[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($Q)as$ie=>$r){foreach($r["source"]as$z=>$d){if(!$Kf[$d])continue
2;$r["source"][$z]=idf_unescape($Kf[$d]);}if(!isset($hd[" $ie"]))$hd[]=" ".format_foreign_key($r);}queries("BEGIN");}foreach($p
as$z=>$o)$p[$z]="  ".implode($o);$p=array_merge($p,array_filter($hd));$bi=($Q==$D?"adminer_$D":$D);if(!queries("CREATE TABLE ".table($bi)." (\n".implode(",\n",$p)."\n)"))return
false;if($Q!=""){if($Kf&&!queries("INSERT INTO ".table($bi)." (".implode(", ",$Kf).") SELECT ".implode(", ",array_map('idf_escape',array_keys($Kf)))." FROM ".table($Q)))return
false;$Bi=array();foreach(triggers($Q)as$_i=>$ii){$zi=trigger($_i);$Bi[]="CREATE TRIGGER ".idf_escape($_i)." ".implode(" ",$ii)." ON ".table($D)."\n$zi[Statement]";}$La=$La?0:$g->result("SELECT seq FROM sqlite_sequence WHERE name = ".q($Q));if(!queries("DROP TABLE ".table($Q))||($Q==$D&&!queries("ALTER TABLE ".table($bi)." RENAME TO ".table($D)))||!alter_indexes($D,$x))return
false;if($La)queries("UPDATE sqlite_sequence SET seq = $La WHERE name = ".q($D));foreach($Bi
as$zi){if(!queries($zi))return
false;}queries("COMMIT");}return
true;}function
index_sql($Q,$T,$D,$e){return"CREATE $T ".($T!="INDEX"?"INDEX ":"").idf_escape($D!=""?$D:uniqid($Q."_"))." ON ".table($Q)." $e";}function
alter_indexes($Q,$c){foreach($c
as$ng){if($ng[0]=="PRIMARY")return
recreate_table($Q,$Q,array(),array(),array(),0,$c);}foreach(array_reverse($c)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($Q,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($S){return
apply_queries("DELETE FROM",$S);}function
drop_views($bj){return
apply_queries("DROP VIEW",$bj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
move_tables($S,$bj,$Zh){return
false;}function
trigger($D){global$g;if($D=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$v='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$Ai=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(".implode("|",$Ai["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",$g->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($D)),$C);$jf=$C[3];return
array("Timing"=>strtoupper($C[1]),"Event"=>strtoupper($C[2]).($jf?" OF":""),"Of"=>idf_unescape($jf),"Trigger"=>$D,"Statement"=>$C[4],);}function
triggers($Q){$I=array();$Ai=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q))as$J){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$Ai["Timing"]).')\s*(.*?)\s+ON\b~i',$J["sql"],$C);$I[$J["name"]]=array($C[1],$C[2]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ROWID()");}function
explain($g,$G){return$g->query("EXPLAIN QUERY PLAN $G");}function
found_rows($R,$Z){}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($dh){return
true;}function
create_sql($Q,$La,$Kh){global$g;$I=$g->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($Q));foreach(indexes($Q)as$D=>$w){if($D=='')continue;$I.=";\n\n".index_sql($Q,$w['type'],$D,"(".implode(", ",array_map('idf_escape',$w['columns'])).")");}return$I;}function
truncate_sql($Q){return"DELETE FROM ".table($Q);}function
use_sql($j){}function
trigger_sql($Q){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q)));}function
show_variables(){global$g;$I=array();foreach(array("auto_vacuum","cache_size","count_changes","default_cache_size","empty_result_callbacks","encoding","foreign_keys","full_column_names","fullfsync","journal_mode","journal_size_limit","legacy_file_format","locking_mode","page_size","max_page_count","read_uncommitted","recursive_triggers","reverse_unordered_selects","secure_delete","short_column_names","synchronous","temp_store","temp_store_directory","schema_version","integrity_check","quick_check")as$z)$I[$z]=$g->result("PRAGMA $z");return$I;}function
show_status(){$I=array();foreach(get_vals("PRAGMA compile_options")as$zf){list($z,$X)=explode("=",$zf,2);$I[$z]=$X;}return$I;}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Vc){return
preg_match('~^(columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Vc);}function
driver_config(){$U=array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0);return
array('possible_drivers'=>array((isset($_GET["sqlite"])?"SQLite3":"SQLite"),"PDO_SQLite"),'jush'=>"sqlite",'types'=>$U,'structured_types'=>array_keys($U),'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL"),'functions'=>array("hex","length","lower","round","unixepoch","upper"),'grouping'=>array("avg","count","count distinct","group_concat","max","min","sum"),'edit_functions'=>array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",)),);}}$kc["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){define("DRIVER","pgsql");if(extension_loaded("pgsql")){class
Min_DB{var$extension="PgSQL",$_link,$_result,$_string,$_database=true,$server_info,$affected_rows,$error,$timeout;function
_error($Cc,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($M,$V,$F){global$b;$l=$b->database();set_error_handler(array($this,'_error'));$this->_string="host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($F,"'\\")."'";$this->_link=@pg_connect("$this->_string dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->_link&&$l!=""){$this->_database=false;$this->_link=@pg_connect("$this->_string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->_link){$Zi=pg_version($this->_link);$this->server_info=$Zi["server"];pg_set_client_encoding($this->_link,"UTF8");}return(bool)$this->_link;}function
quote($P){return"'".pg_escape_string($this->_link,$P)."'";}function
value($X,$o){return($o["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
quoteBinary($P){return"'".pg_escape_bytea($this->_link,$P)."'";}function
select_db($j){global$b;if($j==$b->database())return$this->_database;$I=@pg_connect("$this->_string dbname='".addcslashes($j,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($I)$this->_link=$I;return$I;}function
close(){$this->_link=@pg_connect("$this->_string dbname='postgres'");}function
query($G,$Ei=false){$H=@pg_query($this->_link,$G);$this->error="";if(!$H){$this->error=pg_last_error($this->_link);$I=false;}elseif(!pg_num_fields($H)){$this->affected_rows=pg_affected_rows($H);$I=true;}else$I=new
Min_Result($H);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
pg_fetch_result($H->_result,0,$o);}function
warnings(){return
h(pg_last_notice($this->_link));}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=pg_num_rows($H);}function
fetch_assoc(){return
pg_fetch_assoc($this->_result);}function
fetch_row(){return
pg_fetch_row($this->_result);}function
fetch_field(){$d=$this->_offset++;$I=new
stdClass;if(function_exists('pg_field_table'))$I->orgtable=pg_field_table($this->_result,$d);$I->name=pg_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=pg_field_type($this->_result,$d);$I->charsetnr=($I->type=="bytea"?63:0);return$I;}function
__destruct(){pg_free_result($this->_result);}}}elseif(extension_loaded("pdo_pgsql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_PgSQL",$timeout;function
connect($M,$V,$F){global$b;$l=$b->database();$this->dsn("pgsql:host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' client_encoding=utf8 dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",$V,$F);return
true;}function
select_db($j){global$b;return($b->database()==$j);}function
quoteBinary($ah){return
q($ah);}function
query($G,$Ei=false){$I=parent::query($G,$Ei);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$I;}function
warnings(){return'';}function
close(){}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$K,$ng){global$g;foreach($K
as$N){$Li=array();$Z=array();foreach($N
as$z=>$X){$Li[]="$z = $X";if(isset($ng[idf_unescape($z)]))$Z[]="$z = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Li)." WHERE ".implode(" AND ",$Z))&&$g->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
slowQuery($G,$hi){$this->_conn->query("SET statement_timeout = ".(1000*$hi));$this->_conn->timeout=1000*$hi;return$G;}function
convertSearch($v,$X,$o){return(preg_match('~char|text'.(!preg_match('~LIKE~',$X["op"])?'|date|time(stamp)?|boolean|uuid|'.number_type():'').'~',$o["type"])?$v:"CAST($v AS text)");}function
quoteBinary($ah){return$this->_conn->quoteBinary($ah);}function
warnings(){return$this->_conn->warnings();}function
tableHelp($D){$ze=array("information_schema"=>"infoschema","pg_catalog"=>"catalog",);$A=$ze[$_GET["ns"]];if($A)return"$A-".str_replace("_","-",$D).".html";}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b,$U,$Jh;$g=new
Min_DB;$Mb=$b->credentials();if($g->connect($Mb[0],$Mb[1],$Mb[2])){if(min_version(9,0,$g)){$g->query("SET application_name = 'Adminer'");if(min_version(9.2,0,$g)){$Jh[lang(25)][]="json";$U["json"]=4294967295;if(min_version(9.4,0,$g)){$Jh[lang(25)][]="jsonb";$U["jsonb"]=4294967295;}}}return$g;}return$g->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");}function
limit($G,$Z,$_,$kf=0,$kh=" "){return" $G$Z".($_!==null?$kh."LIMIT $_".($kf?" OFFSET $kf":""):"");}function
limit1($Q,$G,$Z,$kh="\n"){return(preg_match('~^INTO~',$G)?limit($G,$Z,1,0,$kh):" $G".(is_view(table_status1($Q))?$Z:" WHERE ctid = (SELECT ctid FROM ".table($Q).$Z.$kh."LIMIT 1)"));}function
db_collation($l,$nb){global$g;return$g->result("SELECT datcollate FROM pg_database WHERE datname = ".q($l));}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT user");}function
tables_list(){$G="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support('materializedview'))$G.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$G.="
ORDER BY 1";return
get_key_vals($G);}function
count_tables($k){return
array();}function
table_status($D=""){$I=array();foreach(get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", ".(min_version(12)?"''":"CASE WHEN c.relhasoids THEN 'oid' ELSE '' END")." AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
".($D!=""?"AND relname = ".q($D):"ORDER BY relname"))as$J)$I[$J["Name"]]=$J;return($D!=""?$I[$D]:$I);}function
is_view($R){return
in_array($R["Engine"],array("view","materialized view"));}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Ca=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment".(min_version(10)?", a.attidentity":"")."
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($Q)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$J){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$J["full_type"],$C);list(,$T,$we,$J["length"],$xa,$Fa)=$C;$J["length"].=$Fa;$cb=$T.$xa;if(isset($Ca[$cb])){$J["type"]=$Ca[$cb];$J["full_type"]=$J["type"].$we.$Fa;}else{$J["type"]=$T;$J["full_type"]=$J["type"].$we.$xa.$Fa;}if(in_array($J['attidentity'],array('a','d')))$J['default']='GENERATED '.($J['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$J["null"]=!$J["attnotnull"];$J["auto_increment"]=$J['attidentity']||preg_match('~^nextval\(~i',$J["default"]);$J["privileges"]=array("insert"=>1,"select"=>1,"update"=>1);if(preg_match('~(.+)::[^,)]+(.*)~',$J["default"],$C))$J["default"]=($C[1]=="NULL"?null:idf_unescape($C[1]).$C[2]);$I[$J["field"]]=$J;}return$I;}function
indexes($Q,$h=null){global$g;if(!is_object($h))$h=$g;$I=array();$Sh=$h->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($Q));$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Sh AND attnum > 0",$h);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Sh AND ci.oid = i.indexrelid",$h)as$J){$Kg=$J["relname"];$I[$Kg]["type"]=($J["indispartial"]?"INDEX":($J["indisprimary"]?"PRIMARY":($J["indisunique"]?"UNIQUE":"INDEX")));$I[$Kg]["columns"]=array();foreach(explode(" ",$J["indkey"])as$Rd)$I[$Kg]["columns"][]=$e[$Rd];$I[$Kg]["descs"]=array();foreach(explode(" ",$J["indoption"])as$Sd)$I[$Kg]["descs"][]=($Sd&1?'1':null);$I[$Kg]["lengths"]=array();}return$I;}function
foreign_keys($Q){global$sf;$I=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($Q)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$J){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$J['definition'],$C)){$J['source']=array_map('idf_unescape',array_map('trim',explode(',',$C[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$C[2],$Ee)){$J['ns']=idf_unescape($Ee[2]);$J['table']=idf_unescape($Ee[4]);}$J['target']=array_map('idf_unescape',array_map('trim',explode(',',$C[3])));$J['on_delete']=(preg_match("~ON DELETE ($sf)~",$C[4],$Ee)?$Ee[1]:'NO ACTION');$J['on_update']=(preg_match("~ON UPDATE ($sf)~",$C[4],$Ee)?$Ee[1]:'NO ACTION');$I[$J['conname']]=$J;}}return$I;}function
constraints($Q){global$sf;$I=array();foreach(get_rows("SELECT conname, consrc
FROM pg_catalog.pg_constraint
INNER JOIN pg_catalog.pg_namespace ON pg_constraint.connamespace = pg_namespace.oid
INNER JOIN pg_catalog.pg_class ON pg_constraint.conrelid = pg_class.oid AND pg_constraint.connamespace = pg_class.relnamespace
WHERE pg_constraint.contype = 'c'
AND conrelid != 0 -- handle only CONSTRAINTs here, not TYPES
AND nspname = current_schema()
AND relname = ".q($Q)."
ORDER BY connamespace, conname")as$J)$I[$J['conname']]=$J['consrc'];return$I;}function
view($D){global$g;return
array("select"=>trim($g->result("SELECT pg_get_viewdef(".$g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($D)).")")));}function
collations(){return
array();}function
information_schema($l){return($l=="information_schema");}function
error(){global$g;$I=h($g->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$I,$C))$I=$C[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($C[3]).'})(.*)~','\1<b>\2</b>',$C[2]).$C[4];return
nl_br($I);}function
create_database($l,$mb){return
queries("CREATE DATABASE ".idf_escape($l).($mb?" ENCODING ".idf_escape($mb):""));}function
drop_databases($k){global$g;$g->close();return
apply_queries("DROP DATABASE",$k,'idf_escape');}function
rename_database($D,$mb){return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($D));}function
auto_increment(){return"";}function
alter_table($Q,$D,$p,$hd,$tb,$_c,$mb,$La,$Wf){$c=array();$yg=array();if($Q!=""&&$Q!=$D)$yg[]="ALTER TABLE ".table($Q)." RENAME TO ".table($D);foreach($p
as$o){$d=idf_escape($o[0]);$X=$o[1];if(!$X)$c[]="DROP $d";else{$Vi=$X[5];unset($X[5]);if($o[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$c[]=($Q!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$c[]=($Q!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($d!=$X[0])$yg[]="ALTER TABLE ".table($D)." RENAME $d TO $X[0]";$c[]="ALTER $d TYPE$X[1]";if(!$X[6]){$c[]="ALTER $d ".($X[3]?"SET$X[3]":"DROP DEFAULT");$c[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}}if($o[0]!=""||$Vi!="")$yg[]="COMMENT ON COLUMN ".table($D).".$X[0] IS ".($Vi!=""?substr($Vi,9):"''");}}$c=array_merge($c,$hd);if($Q=="")array_unshift($yg,"CREATE TABLE ".table($D)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($yg,"ALTER TABLE ".table($Q)."\n".implode(",\n",$c));if($Q!=""||$tb!="")$yg[]="COMMENT ON TABLE ".table($D)." IS ".q($tb);if($La!=""){}foreach($yg
as$G){if(!queries($G))return
false;}return
true;}function
alter_indexes($Q,$c){$i=array();$lc=array();$yg=array();foreach($c
as$X){if($X[0]!="INDEX")$i[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$lc[]=idf_escape($X[1]);else$yg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($i)array_unshift($yg,"ALTER TABLE ".table($Q).implode(",",$i));if($lc)array_unshift($yg,"DROP INDEX ".implode(", ",$lc));foreach($yg
as$G){if(!queries($G))return
false;}return
true;}function
truncate_tables($S){return
queries("TRUNCATE ".implode(", ",array_map('table',$S)));return
true;}function
drop_views($bj){return
drop_tables($bj);}function
drop_tables($S){foreach($S
as$Q){$O=table_status($Q);if(!queries("DROP ".strtoupper($O["Engine"])." ".table($Q)))return
false;}return
true;}function
move_tables($S,$bj,$Zh){foreach(array_merge($S,$bj)as$Q){$O=table_status($Q);if(!queries("ALTER ".strtoupper($O["Engine"])." ".table($Q)." SET SCHEMA ".idf_escape($Zh)))return
false;}return
true;}function
trigger($D,$Q){if($D=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$e=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q)." AND trigger_name = ".q($D);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$J)$e[]=$J["event_object_column"];$I=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers '."$Z ORDER BY event_manipulation DESC")as$J){if($e&&$J["Event"]=="UPDATE")$J["Event"].=" OF";$J["Of"]=implode(", ",$e);if($I)$J["Event"].=" OR $I[Event]";$I=$J;}return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q))as$J){$zi=trigger($J["trigger_name"],$Q);$I[$zi["Trigger"]]=array($zi["Timing"],$zi["Event"]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE","INSERT OR UPDATE","INSERT OR UPDATE OF","DELETE OR INSERT","DELETE OR UPDATE","DELETE OR UPDATE OF","DELETE OR INSERT OR UPDATE","DELETE OR INSERT OR UPDATE OF"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($D,$T){$K=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($D));$I=$K[0];$I["returns"]=array("type"=>$I["type_udt_name"]);$I["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($D).'
ORDER BY ordinal_position');return$I;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($D,$J){$I=array();foreach($J["fields"]as$o)$I[]=$o["type"];return
idf_escape($D)."(".implode(", ",$I).")";}function
last_id(){return
0;}function
explain($g,$G){return$g->query("EXPLAIN $G");}function
found_rows($R,$Z){global$g;if(preg_match("~ rows=([0-9]+)~",$g->result("EXPLAIN SELECT * FROM ".idf_escape($R["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Jg))return$Jg[1];return
false;}function
types(){return
get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){global$g;return$g->result("SELECT current_schema()");}function
set_schema($ch,$h=null){global$g,$U,$Jh;if(!$h)$h=$g;$I=$h->query("SET search_path TO ".idf_escape($ch));foreach(types()as$T){if(!isset($U[$T])){$U[$T]=0;$Jh[lang(26)][]=$T;}}return$I;}function
foreign_keys_sql($Q){$I="";$O=table_status($Q);$ed=foreign_keys($Q);ksort($ed);foreach($ed
as$dd=>$cd)$I.="ALTER TABLE ONLY ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." ADD CONSTRAINT ".idf_escape($dd)." $cd[definition] ".($cd['deferrable']?'DEFERRABLE':'NOT DEFERRABLE').";\n";return($I?"$I\n":$I);}function
create_sql($Q,$La,$Kh){global$g;$I='';$Sg=array();$mh=array();$O=table_status($Q);if(is_view($O)){$aj=view($Q);return
rtrim("CREATE VIEW ".idf_escape($Q)." AS $aj[select]",";");}$p=fields($Q);$x=indexes($Q);ksort($x);$Cb=constraints($Q);if(!$O||empty($p))return
false;$I="CREATE TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." (\n    ";foreach($p
as$Xc=>$o){$Tf=idf_escape($o['field']).' '.$o['full_type'].default_value($o).($o['attnotnull']?" NOT NULL":"");$Sg[]=$Tf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$o['default'],$Fe)){$lh=$Fe[1];$_h=reset(get_rows(min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q($lh):"SELECT * FROM $lh"));$mh[]=($Kh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $lh;\n":"")."CREATE SEQUENCE $lh INCREMENT $_h[increment_by] MINVALUE $_h[min_value] MAXVALUE $_h[max_value]".($La&&$_h['last_value']?" START $_h[last_value]":"")." CACHE $_h[cache_value];";}}if(!empty($mh))$I=implode("\n\n",$mh)."\n\n$I";foreach($x
as$Md=>$w){switch($w['type']){case'UNIQUE':$Sg[]="CONSTRAINT ".idf_escape($Md)." UNIQUE (".implode(', ',array_map('idf_escape',$w['columns'])).")";break;case'PRIMARY':$Sg[]="CONSTRAINT ".idf_escape($Md)." PRIMARY KEY (".implode(', ',array_map('idf_escape',$w['columns'])).")";break;}}foreach($Cb
as$zb=>$Ab)$Sg[]="CONSTRAINT ".idf_escape($zb)." CHECK $Ab";$I.=implode(",\n    ",$Sg)."\n) WITH (oids = ".($O['Oid']?'true':'false').");";foreach($x
as$Md=>$w){if($w['type']=='INDEX'){$e=array();foreach($w['columns']as$z=>$X)$e[]=idf_escape($X).($w['descs'][$z]?" DESC":"");$I.="\n\nCREATE INDEX ".idf_escape($Md)." ON ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." USING btree (".implode(', ',$e).");";}}if($O['Comment'])$I.="\n\nCOMMENT ON TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." IS ".q($O['Comment']).";";foreach($p
as$Xc=>$o){if($o['comment'])$I.="\n\nCOMMENT ON COLUMN ".idf_escape($O['nspname']).".".idf_escape($O['Name']).".".idf_escape($Xc)." IS ".q($o['comment']).";";}return
rtrim($I,';');}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
trigger_sql($Q){$O=table_status($Q);$I="";foreach(triggers($Q)as$yi=>$xi){$zi=trigger($yi,$O['Name']);$I.="\nCREATE TRIGGER ".idf_escape($zi['Trigger'])." $zi[Timing] $zi[Event] ON ".idf_escape($O["nspname"]).".".idf_escape($O['Name'])." $zi[Type] $zi[Statement];;\n";}return$I;}function
use_sql($j){return"\connect ".idf_escape($j);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
show_status(){}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Vc){return
preg_match('~^(database|table|columns|sql|indexes|descidx|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$Vc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){global$g;return$g->result("SHOW max_connections");}function
driver_config(){$U=array();$Jh=array();foreach(array(lang(27)=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),lang(28)=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),lang(25)=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),lang(29)=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),lang(30)=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"txid_snapshot"=>0),lang(31)=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),)as$z=>$X){$U+=$X;$Jh[$z]=array_keys($X);}return
array('possible_drivers'=>array("PgSQL","PDO_PgSQL"),'jush'=>"pgsql",'types'=>$U,'structured_types'=>$Jh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL"),'functions'=>array("char_length","lower","round","to_hex","to_timestamp","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",)),);}}$kc["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){define("DRIVER","oracle");if(extension_loaded("oci8")){class
Min_DB{var$extension="oci8",$_link,$_result,$server_info,$affected_rows,$errno,$error;var$_current_db;function
_error($Cc,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($M,$V,$F){$this->_link=@oci_new_connect($V,$F,$M,"AL32UTF8");if($this->_link){$this->server_info=oci_server_version($this->_link);return
true;}$n=oci_error();$this->error=$n["message"];return
false;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){$this->_current_db=$j;return
true;}function
query($G,$Ei=false){$H=oci_parse($this->_link,$G);$this->error="";if(!$H){$n=oci_error($this->_link);$this->errno=$n["code"];$this->error=$n["message"];return
false;}set_error_handler(array($this,'_error'));$I=@oci_execute($H);restore_error_handler();if($I){if(oci_num_fields($H))return
new
Min_Result($H);$this->affected_rows=oci_num_rows($H);oci_free_statement($H);}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=1){$H=$this->query($G);if(!is_object($H)||!oci_fetch($H->_result))return
false;return
oci_result($H->_result,$o);}}class
Min_Result{var$_result,$_offset=1,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$z=>$X){if(is_a($X,'OCI-Lob'))$J[$z]=$X->load();}return$J;}function
fetch_assoc(){return$this->_convert(oci_fetch_assoc($this->_result));}function
fetch_row(){return$this->_convert(oci_fetch_row($this->_result));}function
fetch_field(){$d=$this->_offset++;$I=new
stdClass;$I->name=oci_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=oci_field_type($this->_result,$d);$I->charsetnr=(preg_match("~raw|blob|bfile~",$I->type)?63:0);return$I;}function
__destruct(){oci_free_statement($this->_result);}}}elseif(extension_loaded("pdo_oci")){class
Min_DB
extends
Min_PDO{var$extension="PDO_OCI";var$_current_db;function
connect($M,$V,$F){$this->dsn("oci:dbname=//$M;charset=AL32UTF8",$V,$F);return
true;}function
select_db($j){$this->_current_db=$j;return
true;}}}class
Min_Driver
extends
Min_SQL{function
begin(){return
true;}function
insertUpdate($Q,$K,$ng){global$g;foreach($K
as$N){$Li=array();$Z=array();foreach($N
as$z=>$X){$Li[]="$z = $X";if(isset($ng[idf_unescape($z)]))$Z[]="$z = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Li)." WHERE ".implode(" AND ",$Z))&&$g->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect(){global$b;$g=new
Min_DB;$Mb=$b->credentials();if($g->connect($Mb[0],$Mb[1],$Mb[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT tablespace_name FROM user_tablespaces ORDER BY 1");}function
limit($G,$Z,$_,$kf=0,$kh=" "){return($kf?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= ".($_+$kf).") WHERE rnum > $kf":($_!==null?" * FROM (SELECT $G$Z) WHERE rownum <= ".($_+$kf):" $G$Z"));}function
limit1($Q,$G,$Z,$kh="\n"){return" $G$Z";}function
db_collation($l,$nb){global$g;return$g->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT USER FROM DUAL");}function
get_current_db(){global$g;$l=$g->_current_db?$g->_current_db:DB;unset($g->_current_db);return$l;}function
where_owner($lg,$Nf="owner"){if(!$_GET["ns"])return'';return"$lg$Nf = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($e){$Nf=where_owner('');return"(SELECT $e FROM all_views WHERE ".($Nf?$Nf:"rownum < 0").")";}function
tables_list(){$aj=views_table("view_name");$Nf=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$Nf
UNION SELECT view_name, 'view' FROM $aj
ORDER BY 1");}function
count_tables($k){global$g;$I=array();foreach($k
as$l)$I[$l]=$g->result("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($l));return$I;}function
table_status($D=""){$I=array();$eh=q($D);$l=get_current_db();$aj=views_table("view_name");$Nf=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($l).$Nf.($D!=""?" AND table_name = $eh":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $aj".($D!=""?" WHERE view_name = $eh":"")."
ORDER BY 1")as$J){if($D!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Nf=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($Q)."$Nf ORDER BY column_id")as$J){$T=$J["DATA_TYPE"];$we="$J[DATA_PRECISION],$J[DATA_SCALE]";if($we==",")$we=$J["CHAR_COL_DECL_LENGTH"];$I[$J["COLUMN_NAME"]]=array("field"=>$J["COLUMN_NAME"],"full_type"=>$T.($we?"($we)":""),"type"=>strtolower($T),"length"=>$we,"default"=>$J["DATA_DEFAULT"],"null"=>($J["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);}return$I;}function
indexes($Q,$h=null){$I=array();$Nf=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($Q)."$Nf
ORDER BY ac.constraint_type, aic.column_position",$h)as$J){$Md=$J["INDEX_NAME"];$qb=$J["DATA_DEFAULT"];$qb=($qb?trim($qb,'"'):$J["COLUMN_NAME"]);$I[$Md]["type"]=($J["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($J["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$I[$Md]["columns"][]=$qb;$I[$Md]["lengths"][]=($J["CHAR_LENGTH"]&&$J["CHAR_LENGTH"]!=$J["COLUMN_LENGTH"]?$J["CHAR_LENGTH"]:null);$I[$Md]["descs"][]=($J["DESCEND"]&&$J["DESCEND"]=="DESC"?'1':null);}return$I;}function
view($D){$aj=views_table("view_name, text");$K=get_rows('SELECT text "select" FROM '.$aj.' WHERE view_name = '.q($D));return
reset($K);}function
collations(){return
array();}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
explain($g,$G){$g->query("EXPLAIN PLAN FOR $G");return$g->query("SELECT * FROM plan_table");}function
found_rows($R,$Z){}function
auto_increment(){return"";}function
alter_table($Q,$D,$p,$hd,$tb,$_c,$mb,$La,$Wf){$c=$lc=array();$Hf=($Q?fields($Q):array());foreach($p
as$o){$X=$o[1];if($X&&$o[0]!=""&&idf_escape($o[0])!=$X[0])queries("ALTER TABLE ".table($Q)." RENAME COLUMN ".idf_escape($o[0])." TO $X[0]");$Gf=$Hf[$o[0]];if($X&&$Gf){$mf=process_field($Gf,$Gf);if($X[2]==$mf[2])$X[2]="";}if($X)$c[]=($Q!=""?($o[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($Q!=""?")":"");else$lc[]=idf_escape($o[0]);}if($Q=="")return
queries("CREATE TABLE ".table($D)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($Q)."\n".implode("\n",$c)))&&(!$lc||queries("ALTER TABLE ".table($Q)." DROP (".implode(", ",$lc).")"))&&($Q==$D||queries("ALTER TABLE ".table($Q)." RENAME TO ".table($D)));}function
alter_indexes($Q,$c){$lc=array();$yg=array();foreach($c
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$i=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($yg,"ALTER TABLE ".table($Q).$i);}elseif($X[2]=="DROP")$lc[]=idf_escape($X[1]);else$yg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($lc)array_unshift($yg,"DROP INDEX ".implode(", ",$lc));foreach($yg
as$G){if(!queries($G))return
false;}return
true;}function
foreign_keys($Q){$I=array();$G="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($Q);foreach(get_rows($G)as$J)$I[$J['NAME']]=array("db"=>$J['DEST_DB'],"table"=>$J['DEST_TABLE'],"source"=>array($J['SRC_COLUMN']),"target"=>array($J['DEST_COLUMN']),"on_delete"=>$J['ON_DELETE'],"on_update"=>null,);return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($bj){return
apply_queries("DROP VIEW",$bj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
last_id(){return
0;}function
schemas(){$I=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($I?$I:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){global$g;return$g->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($dh,$h=null){global$g;if(!$h)$h=$g;return$h->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($dh));}function
show_variables(){return
get_key_vals('SELECT name, display_value FROM v$parameter');}function
process_list(){return
get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
show_status(){$K=get_rows('SELECT * FROM v$instance');return
reset($K);}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Vc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$Vc);}function
driver_config(){$U=array();$Jh=array();foreach(array(lang(27)=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),lang(28)=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),lang(25)=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),lang(29)=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),)as$z=>$X){$U+=$X;$Jh[$z]=array_keys($X);}return
array('possible_drivers'=>array("OCI8","PDO_OCI"),'jush'=>"oracle",'types'=>$U,'structured_types'=>$Jh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL"),'functions'=>array("length","lower","round","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",)),);}}$kc["mssql"]="MS SQL (beta)";if(isset($_GET["mssql"])){define("DRIVER","mssql");if(extension_loaded("sqlsrv")){class
Min_DB{var$extension="sqlsrv",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_get_error(){$this->error="";foreach(sqlsrv_errors()as$n){$this->errno=$n["code"];$this->error.="$n[message]\n";}$this->error=rtrim($this->error);}function
connect($M,$V,$F){global$b;$l=$b->database();$_b=array("UID"=>$V,"PWD"=>$F,"CharacterSet"=>"UTF-8");if($l!="")$_b["Database"]=$l;$this->_link=@sqlsrv_connect(preg_replace('~:~',',',$M),$_b);if($this->_link){$Td=sqlsrv_server_info($this->_link);$this->server_info=$Td['SQLServerVersion'];}else$this->_get_error();return(bool)$this->_link;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($G,$Ei=false){$H=sqlsrv_query($this->_link,$G);$this->error="";if(!$H){$this->_get_error();return
false;}return$this->store_result($H);}function
multi_query($G){$this->_result=sqlsrv_query($this->_link,$G);$this->error="";if(!$this->_result){$this->_get_error();return
false;}return
true;}function
store_result($H=null){if(!$H)$H=$this->_result;if(!$H)return
false;if(sqlsrv_field_metadata($H))return
new
Min_Result($H);$this->affected_rows=sqlsrv_rows_affected($H);return
true;}function
next_result(){return$this->_result?sqlsrv_next_result($this->_result):null;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->fetch_row();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$z=>$X){if(is_a($X,'DateTime'))$J[$z]=$X->format("Y-m-d H:i:s");}return$J;}function
fetch_assoc(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->_fields)$this->_fields=sqlsrv_field_metadata($this->_result);$o=$this->_fields[$this->_offset++];$I=new
stdClass;$I->name=$o["Name"];$I->orgname=$o["Name"];$I->type=($o["Type"]==1?254:0);return$I;}function
seek($kf){for($t=0;$t<$kf;$t++)sqlsrv_fetch($this->_result);}function
__destruct(){sqlsrv_free_stmt($this->_result);}}}elseif(extension_loaded("mssql")){class
Min_DB{var$extension="MSSQL",$_link,$_result,$server_info,$affected_rows,$error;function
connect($M,$V,$F){$this->_link=@mssql_connect($M,$V,$F);if($this->_link){$H=$this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");if($H){$J=$H->fetch_row();$this->server_info=$this->result("sp_server_info 2",2)." [$J[0]] $J[1]";}}else$this->error=mssql_get_last_message();return(bool)$this->_link;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return
mssql_select_db($j);}function
query($G,$Ei=false){$H=@mssql_query($G,$this->_link);$this->error="";if(!$H){$this->error=mssql_get_last_message();return
false;}if($H===true){$this->affected_rows=mssql_rows_affected($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
mssql_next_result($this->_result->_result);}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;return
mssql_result($H->_result,0,$o);}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=mssql_num_rows($H);}function
fetch_assoc(){return
mssql_fetch_assoc($this->_result);}function
fetch_row(){return
mssql_fetch_row($this->_result);}function
num_rows(){return
mssql_num_rows($this->_result);}function
fetch_field(){$I=mssql_fetch_field($this->_result);$I->orgtable=$I->table;$I->orgname=$I->name;return$I;}function
seek($kf){mssql_data_seek($this->_result,$kf);}function
__destruct(){mssql_free_result($this->_result);}}}elseif(extension_loaded("pdo_dblib")){class
Min_DB
extends
Min_PDO{var$extension="PDO_DBLIB";function
connect($M,$V,$F){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$F);return
true;}function
select_db($j){return$this->query("USE ".idf_escape($j));}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$K,$ng){foreach($K
as$N){$Li=array();$Z=array();foreach($N
as$z=>$X){$Li[]="$z = $X";if(isset($ng[idf_unescape($z)]))$Z[]="$z = $X";}if(!queries("MERGE ".table($Q)." USING (VALUES(".implode(", ",$N).")) AS source (c".implode(", c",range(1,count($N))).") ON ".implode(" AND ",$Z)." WHEN MATCHED THEN UPDATE SET ".implode(", ",$Li)." WHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).");"))return
false;}return
true;}function
begin(){return
queries("BEGIN TRANSACTION");}}function
idf_escape($v){return"[".str_replace("]","]]",$v)."]";}function
table($v){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($v);}function
connect(){global$b;$g=new
Min_DB;$Mb=$b->credentials();if($g->connect($Mb[0],$Mb[1],$Mb[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($G,$Z,$_,$kf=0,$kh=" "){return($_!==null?" TOP (".($_+$kf).")":"")." $G$Z";}function
limit1($Q,$G,$Z,$kh="\n"){return
limit($G,$Z,1,0,$kh);}function
db_collation($l,$nb){global$g;return$g->result("SELECT collation_name FROM sys.databases WHERE name = ".q($l));}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($k){global$g;$I=array();foreach($k
as$l){$g->select_db($l);$I[$l]=$g->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$I;}function
table_status($D=""){$I=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment FROM sys.all_objects AS ao WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($D!=""?"AND name = ".q($D):"ORDER BY name"))as$J){if($D!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="VIEW";}function
fk_support($R){return
true;}function
fields($Q){$vb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($Q).", 'column', NULL)");$I=array();foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(".q(get_schema()).") AND o.type IN ('S', 'U', 'V') AND o.name = ".q($Q))as$J){$T=$J["type"];$we=(preg_match("~char|binary~",$T)?$J["max_length"]:($T=="decimal"?"$J[precision],$J[scale]":""));$I[$J["name"]]=array("field"=>$J["name"],"full_type"=>$T.($we?"($we)":""),"type"=>$T,"length"=>$we,"default"=>$J["default"],"null"=>$J["is_nullable"],"auto_increment"=>$J["is_identity"],"collation"=>$J["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"primary"=>$J["is_identity"],"comment"=>$vb[$J["name"]],);}return$I;}function
indexes($Q,$h=null){$I=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($Q),$h)as$J){$D=$J["name"];$I[$D]["type"]=($J["is_primary_key"]?"PRIMARY":($J["is_unique"]?"UNIQUE":"INDEX"));$I[$D]["lengths"]=array();$I[$D]["columns"][$J["key_ordinal"]]=$J["column_name"];$I[$D]["descs"][$J["key_ordinal"]]=($J["is_descending_key"]?'1':null);}return$I;}function
view($D){global$g;return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',$g->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($D))));}function
collations(){$I=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$mb)$I[preg_replace('~_.*~','',$mb)][]=$mb;return$I;}function
information_schema($l){return
false;}function
error(){global$g;return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',$g->error)));}function
create_database($l,$mb){return
queries("CREATE DATABASE ".idf_escape($l).(preg_match('~^[a-z0-9_]+$~i',$mb)?" COLLATE $mb":""));}function
drop_databases($k){return
queries("DROP DATABASE ".implode(", ",array_map('idf_escape',$k)));}function
rename_database($D,$mb){if(preg_match('~^[a-z0-9_]+$~i',$mb))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $mb");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($D));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($Q,$D,$p,$hd,$tb,$_c,$mb,$La,$Wf){$c=array();$vb=array();foreach($p
as$o){$d=idf_escape($o[0]);$X=$o[1];if(!$X)$c["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$vb[$o[0]]=$X[5];unset($X[5]);if($o[0]=="")$c["ADD"][]="\n  ".implode("",$X).($Q==""?substr($hd[$X[0]],16+strlen($X[0])):"");else{unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($Q).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";}}}if($Q=="")return
queries("CREATE TABLE ".table($D)." (".implode(",",(array)$c["ADD"])."\n)");if($Q!=$D)queries("EXEC sp_rename ".q(table($Q)).", ".q($D));if($hd)$c[""]=$hd;foreach($c
as$z=>$X){if(!queries("ALTER TABLE ".idf_escape($D)." $z".implode(",",$X)))return
false;}foreach($vb
as$z=>$X){$tb=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($D).", @level2type = N'Column', @level2name = ".q($z));queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = ".$tb.", @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($D).", @level2type = N'Column', @level2name = ".q($z));}return
true;}function
alter_indexes($Q,$c){$w=array();$lc=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$lc[]=idf_escape($X[1]);else$w[]=idf_escape($X[1])." ON ".table($Q);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q):"ALTER TABLE ".table($Q)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$w||queries("DROP INDEX ".implode(", ",$w)))&&(!$lc||queries("ALTER TABLE ".table($Q)." DROP ".implode(", ",$lc)));}function
last_id(){global$g;return$g->result("SELECT SCOPE_IDENTITY()");}function
explain($g,$G){$g->query("SET SHOWPLAN_ALL ON");$I=$g->query($G);$g->query("SET SHOWPLAN_ALL OFF");return$I;}function
found_rows($R,$Z){}function
foreign_keys($Q){$I=array();foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($Q))as$J){$r=&$I[$J["FK_NAME"]];$r["db"]=$J["PKTABLE_QUALIFIER"];$r["table"]=$J["PKTABLE_NAME"];$r["source"][]=$J["FKCOLUMN_NAME"];$r["target"][]=$J["PKCOLUMN_NAME"];}return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($bj){return
queries("DROP VIEW ".implode(", ",array_map('table',$bj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('table',$S)));}function
move_tables($S,$bj,$Zh){return
apply_queries("ALTER SCHEMA ".idf_escape($Zh)." TRANSFER",array_merge($S,$bj));}function
trigger($D){if($D=="")return
array();$K=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($D));$I=reset($K);if($I)$I["Statement"]=preg_replace('~^.+\s+AS\s+~isU','',$I["text"]);return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($Q))as$J)$I[$J["name"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){global$g;if($_GET["ns"]!="")return$_GET["ns"];return$g->result("SELECT SCHEMA_NAME()");}function
set_schema($ch){return
true;}function
use_sql($j){return"USE ".idf_escape($j);}function
show_variables(){return
array();}function
show_status(){return
array();}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Vc){return
preg_match('~^(comment|columns|database|drop_col|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$Vc);}function
driver_config(){$U=array();$Jh=array();foreach(array(lang(27)=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),lang(28)=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),lang(25)=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),lang(29)=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),)as$z=>$X){$U+=$X;$Jh[$z]=array_keys($X);}return
array('possible_drivers'=>array("SQLSRV","MSSQL","PDO_DBLIB"),'jush'=>"mssql",'types'=>$U,'structured_types'=>$Jh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL"),'functions'=>array("len","lower","round","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",)),);}}$kc["mongo"]="MongoDB (alpha)";if(isset($_GET["mongo"])){define("DRIVER","mongo");if(class_exists('MongoDB')){class
Min_DB{var$extension="Mongo",$server_info=MongoClient::VERSION,$error,$last_id,$_link,$_db;function
connect($Mi,$_f){try{$this->_link=new
MongoClient($Mi,$_f);if($_f["password"]!=""){$_f["password"]="";try{new
MongoClient($Mi,$_f);$this->error=lang(22);}catch(Exception$rc){}}}catch(Exception$rc){$this->error=$rc->getMessage();}}function
query($G){return
false;}function
select_db($j){try{$this->_db=$this->_link->selectDB($j);return
true;}catch(Exception$Hc){$this->error=$Hc->getMessage();return
false;}}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$fe){$J=array();foreach($fe
as$z=>$X){if(is_a($X,'MongoBinData'))$this->_charset[$z]=63;$J[$z]=(is_a($X,'MongoId')?"ObjectId(\"$X\")":(is_a($X,'MongoDate')?gmdate("Y-m-d H:i:s",$X->sec)." GMT":(is_a($X,'MongoBinData')?$X->bin:(is_a($X,'MongoRegex')?"$X":(is_object($X)?get_class($X):$X)))));}$this->_rows[]=$J;foreach($J
as$z=>$X){if(!isset($this->_rows[0][$z]))$this->_rows[0][$z]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$z=>$X)$I[$z]=$J[$z];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$je=array_keys($this->_rows[0]);$D=$je[$this->_offset++];return(object)array('name'=>$D,'charsetnr'=>$this->_charset[$D],);}}class
Min_Driver
extends
Min_SQL{public$ng="_id";function
select($Q,$L,$Z,$sd,$Bf=array(),$_=1,$E=0,$pg=false){$L=($L==array("*")?array():array_fill_keys($L,true));$xh=array();foreach($Bf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Ib);$xh[$X]=($Ib?-1:1);}return
new
Min_Result($this->_conn->_db->selectCollection($Q)->find(array(),$L)->sort($xh)->limit($_!=""?+$_:0)->skip($E*$_));}function
insert($Q,$N){try{$I=$this->_conn->_db->selectCollection($Q)->insert($N);$this->_conn->errno=$I['code'];$this->_conn->error=$I['err'];$this->_conn->last_id=$N['_id'];return!$I['err'];}catch(Exception$Hc){$this->_conn->error=$Hc->getMessage();return
false;}}}function
get_databases($fd){global$g;$I=array();$Wb=$g->_link->listDBs();foreach($Wb['databases']as$l)$I[]=$l['name'];return$I;}function
count_tables($k){global$g;$I=array();foreach($k
as$l)$I[$l]=count($g->_link->selectDB($l)->getCollectionNames(true));return$I;}function
tables_list(){global$g;return
array_fill_keys($g->_db->getCollectionNames(true),'table');}function
drop_databases($k){global$g;foreach($k
as$l){$Og=$g->_link->selectDB($l)->drop();if(!$Og['ok'])return
false;}return
true;}function
indexes($Q,$h=null){global$g;$I=array();foreach($g->_db->selectCollection($Q)->getIndexInfo()as$w){$ec=array();foreach($w["key"]as$d=>$T)$ec[]=($T==-1?'1':null);$I[$w["name"]]=array("type"=>($w["name"]=="_id_"?"PRIMARY":($w["unique"]?"UNIQUE":"INDEX")),"columns"=>array_keys($w["key"]),"lengths"=>array(),"descs"=>$ec,);}return$I;}function
fields($Q){return
fields_from_edit();}function
found_rows($R,$Z){global$g;return$g->_db->selectCollection($_GET["select"])->count($Z);}$xf=array("=");}elseif(class_exists('MongoDB\Driver\Manager')){class
Min_DB{var$extension="MongoDB",$server_info=MONGODB_VERSION,$affected_rows,$error,$last_id;var$_link;var$_db,$_db_name;function
connect($Mi,$_f){$hb='MongoDB\Driver\Manager';$this->_link=new$hb($Mi,$_f);$this->executeCommand('admin',array('ping'=>1));}function
executeCommand($l,$rb){$hb='MongoDB\Driver\Command';try{return$this->_link->executeCommand($l,new$hb($rb));}catch(Exception$rc){$this->error=$rc->getMessage();return
array();}}function
executeBulkWrite($Ze,$Xa,$Jb){try{$Rg=$this->_link->executeBulkWrite($Ze,$Xa);$this->affected_rows=$Rg->$Jb();return
true;}catch(Exception$rc){$this->error=$rc->getMessage();return
false;}}function
query($G){return
false;}function
select_db($j){$this->_db_name=$j;return
true;}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$fe){$J=array();foreach($fe
as$z=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->_charset[$z]=63;$J[$z]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'."$X\")":(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->getData():(is_a($X,'MongoDB\BSON\Regex')?"$X":(is_object($X)||is_array($X)?json_encode($X,256):$X)))));}$this->_rows[]=$J;foreach($J
as$z=>$X){if(!isset($this->_rows[0][$z]))$this->_rows[0][$z]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$z=>$X)$I[$z]=$J[$z];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$je=array_keys($this->_rows[0]);$D=$je[$this->_offset++];return(object)array('name'=>$D,'charsetnr'=>$this->_charset[$D],);}}class
Min_Driver
extends
Min_SQL{public$ng="_id";function
select($Q,$L,$Z,$sd,$Bf=array(),$_=1,$E=0,$pg=false){global$g;$L=($L==array("*")?array():array_fill_keys($L,1));if(count($L)&&!isset($L['_id']))$L['_id']=0;$Z=where_to_query($Z);$xh=array();foreach($Bf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Ib);$xh[$X]=($Ib?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$_=$_GET['limit'];$_=min(200,max(1,(int)$_));$uh=$E*$_;$hb='MongoDB\Driver\Query';try{return
new
Min_Result($g->_link->executeQuery("$g->_db_name.$Q",new$hb($Z,array('projection'=>$L,'limit'=>$_,'skip'=>$uh,'sort'=>$xh))));}catch(Exception$rc){$g->error=$rc->getMessage();return
false;}}function
update($Q,$N,$zg,$_=0,$kh="\n"){global$g;$l=$g->_db_name;$Z=sql_query_where_parser($zg);$hb='MongoDB\Driver\BulkWrite';$Xa=new$hb(array());if(isset($N['_id']))unset($N['_id']);$Lg=array();foreach($N
as$z=>$Y){if($Y=='NULL'){$Lg[$z]=1;unset($N[$z]);}}$Li=array('$set'=>$N);if(count($Lg))$Li['$unset']=$Lg;$Xa->update($Z,$Li,array('upsert'=>false));return$g->executeBulkWrite("$l.$Q",$Xa,'getModifiedCount');}function
delete($Q,$zg,$_=0){global$g;$l=$g->_db_name;$Z=sql_query_where_parser($zg);$hb='MongoDB\Driver\BulkWrite';$Xa=new$hb(array());$Xa->delete($Z,array('limit'=>$_));return$g->executeBulkWrite("$l.$Q",$Xa,'getDeletedCount');}function
insert($Q,$N){global$g;$l=$g->_db_name;$hb='MongoDB\Driver\BulkWrite';$Xa=new$hb(array());if($N['_id']=='')unset($N['_id']);$Xa->insert($N);return$g->executeBulkWrite("$l.$Q",$Xa,'getInsertedCount');}}function
get_databases($fd){global$g;$I=array();foreach($g->executeCommand('admin',array('listDatabases'=>1))as$Wb){foreach($Wb->databases
as$l)$I[]=$l->name;}return$I;}function
count_tables($k){$I=array();return$I;}function
tables_list(){global$g;$ob=array();foreach($g->executeCommand($g->_db_name,array('listCollections'=>1))as$H)$ob[$H->name]='table';return$ob;}function
drop_databases($k){return
false;}function
indexes($Q,$h=null){global$g;$I=array();foreach($g->executeCommand($g->_db_name,array('listIndexes'=>$Q))as$w){$ec=array();$e=array();foreach(get_object_vars($w->key)as$d=>$T){$ec[]=($T==-1?'1':null);$e[]=$d;}$I[$w->name]=array("type"=>($w->name=="_id_"?"PRIMARY":(isset($w->unique)?"UNIQUE":"INDEX")),"columns"=>$e,"lengths"=>array(),"descs"=>$ec,);}return$I;}function
fields($Q){global$m;$p=fields_from_edit();if(!$p){$H=$m->select($Q,array("*"),null,null,array(),10);if($H){while($J=$H->fetch_assoc()){foreach($J
as$z=>$X){$J[$z]=null;$p[$z]=array("field"=>$z,"type"=>"string","null"=>($z!=$m->primary),"auto_increment"=>($z==$m->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,),);}}}}return$p;}function
found_rows($R,$Z){global$g;$Z=where_to_query($Z);$pi=$g->executeCommand($g->_db_name,array('count'=>$R['Name'],'query'=>$Z))->toArray();return$pi[0]->n;}function
sql_query_where_parser($zg){$zg=preg_replace('~^\sWHERE \(?\(?(.+?)\)?\)?$~','\1',$zg);$lj=explode(' AND ',$zg);$mj=explode(') OR (',$zg);$Z=array();foreach($lj
as$jj)$Z[]=trim($jj);if(count($mj)==1)$mj=array();elseif(count($mj)>1)$Z=array();return
where_to_query($Z,$mj);}function
where_to_query($hj=array(),$ij=array()){global$b;$Rb=array();foreach(array('and'=>$hj,'or'=>$ij)as$T=>$Z){if(is_array($Z)){foreach($Z
as$Nc){list($kb,$vf,$X)=explode(" ",$Nc,3);if($kb=="_id"&&preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~',$X,$C)){list(,$hb,$X)=$C;$X=new$hb($X);}if(!in_array($vf,$b->operators))continue;if(preg_match('~^\(f\)(.+)~',$vf,$C)){$X=(float)$X;$vf=$C[1];}elseif(preg_match('~^\(date\)(.+)~',$vf,$C)){$Tb=new
DateTime($X);$hb='MongoDB\BSON\UTCDatetime';$X=new$hb($Tb->getTimestamp()*1000);$vf=$C[1];}switch($vf){case'=':$vf='$eq';break;case'!=':$vf='$ne';break;case'>':$vf='$gt';break;case'<':$vf='$lt';break;case'>=':$vf='$gte';break;case'<=':$vf='$lte';break;case'regex':$vf='$regex';break;default:continue
2;}if($T=='and')$Rb['$and'][]=array($kb=>array($vf=>$X));elseif($T=='or')$Rb['$or'][]=array($kb=>array($vf=>$X));}}}return$Rb;}$xf=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);}function
table($v){return$v;}function
idf_escape($v){return$v;}function
table_status($D="",$Uc=false){$I=array();foreach(tables_list()as$Q=>$T){$I[$Q]=array("Name"=>$Q);if($D==$Q)return$I[$Q];}return$I;}function
create_database($l,$mb){return
true;}function
last_id(){global$g;return$g->last_id;}function
error(){global$g;return
h($g->error);}function
collations(){return
array();}function
logged_user(){global$b;$Mb=$b->credentials();return$Mb[1];}function
connect(){global$b;$g=new
Min_DB;list($M,$V,$F)=$b->credentials();$_f=array();if($V.$F!=""){$_f["username"]=$V;$_f["password"]=$F;}$l=$b->database();if($l!="")$_f["db"]=$l;if(($Ka=getenv("MONGO_AUTH_SOURCE")))$_f["authSource"]=$Ka;$g->connect("mongodb://$M",$_f);if($g->error)return$g->error;return$g;}function
alter_indexes($Q,$c){global$g;foreach($c
as$X){list($T,$D,$N)=$X;if($N=="DROP")$I=$g->_db->command(array("deleteIndexes"=>$Q,"index"=>$D));else{$e=array();foreach($N
as$d){$d=preg_replace('~ DESC$~','',$d,1,$Ib);$e[$d]=($Ib?-1:1);}$I=$g->_db->selectCollection($Q)->ensureIndex($e,array("unique"=>($T=="UNIQUE"),"name"=>$D,));}if($I['errmsg']){$g->error=$I['errmsg'];return
false;}}return
true;}function
support($Vc){return
preg_match("~database|indexes|descidx~",$Vc);}function
db_collation($l,$nb){}function
information_schema(){}function
is_view($R){}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
foreign_keys($Q){return
array();}function
fk_support($R){}function
engines(){return
array();}function
alter_table($Q,$D,$p,$hd,$tb,$_c,$mb,$La,$Wf){global$g;if($Q==""){$g->_db->createCollection($D);return
true;}}function
drop_tables($S){global$g;foreach($S
as$Q){$Og=$g->_db->selectCollection($Q)->drop();if(!$Og['ok'])return
false;}return
true;}function
truncate_tables($S){global$g;foreach($S
as$Q){$Og=$g->_db->selectCollection($Q)->remove();if(!$Og['ok'])return
false;}return
true;}function
driver_config(){global$xf;return
array('possible_drivers'=>array("mongo","mongodb"),'jush'=>"mongo",'operators'=>$xf,'functions'=>array(),'grouping'=>array(),'edit_functions'=>array(array("json")),);}}$kc["elastic"]="Elasticsearch (beta)";if(isset($_GET["elastic"])){define("DRIVER","elastic");if(function_exists('json_decode')&&ini_bool('allow_url_fopen')){class
Min_DB{var$extension="JSON",$server_info,$errno,$error,$_url,$_db;function
rootQuery($ag,$Db=array(),$Se='GET'){@ini_set('track_errors',1);$Zc=@file_get_contents("$this->_url/".ltrim($ag,'/'),false,stream_context_create(array('http'=>array('method'=>$Se,'content'=>$Db===null?$Db:json_encode($Db),'header'=>'Content-Type: application/json','ignore_errors'=>1,))));if(!$Zc){$this->error=$php_errormsg;return$Zc;}if(!preg_match('~^HTTP/[0-9.]+ 2~i',$http_response_header[0])){$this->error=lang(32)." $http_response_header[0]";return
false;}$I=json_decode($Zc,true);if($I===null){$this->errno=json_last_error();if(function_exists('json_last_error_msg'))$this->error=json_last_error_msg();else{$Bb=get_defined_constants(true);foreach($Bb['json']as$D=>$Y){if($Y==$this->errno&&preg_match('~^JSON_ERROR_~',$D)){$this->error=$D;break;}}}}return$I;}function
query($ag,$Db=array(),$Se='GET'){return$this->rootQuery(($this->_db!=""?"$this->_db/":"/").ltrim($ag,'/'),$Db,$Se);}function
connect($M,$V,$F){preg_match('~^(https?://)?(.*)~',$M,$C);$this->_url=($C[1]?$C[1]:"http://")."$V:$F@$C[2]";$I=$this->query('');if($I)$this->server_info=$I['version']['number'];return(bool)$I;}function
select_db($j){$this->_db=$j;return
true;}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows;function
__construct($K){$this->num_rows=count($K);$this->_rows=$K;reset($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);next($this->_rows);return$I;}function
fetch_row(){return
array_values($this->fetch_assoc());}}}class
Min_Driver
extends
Min_SQL{function
select($Q,$L,$Z,$sd,$Bf=array(),$_=1,$E=0,$pg=false){global$b;$Rb=array();$G="$Q/_search";if($L!=array("*"))$Rb["fields"]=$L;if($Bf){$xh=array();foreach($Bf
as$kb){$kb=preg_replace('~ DESC$~','',$kb,1,$Ib);$xh[]=($Ib?array($kb=>"desc"):$kb);}$Rb["sort"]=$xh;}if($_){$Rb["size"]=+$_;if($E)$Rb["from"]=($E*$_);}foreach($Z
as$X){list($kb,$vf,$X)=explode(" ",$X,3);if($kb=="_id")$Rb["query"]["ids"]["values"][]=$X;elseif($kb.$X!=""){$ci=array("term"=>array(($kb!=""?$kb:"_all")=>$X));if($vf=="=")$Rb["query"]["filtered"]["filter"]["and"][]=$ci;else$Rb["query"]["filtered"]["query"]["bool"]["must"][]=$ci;}}if($Rb["query"]&&!$Rb["query"]["filtered"]["query"]&&!$Rb["query"]["ids"])$Rb["query"]["filtered"]["query"]=array("match_all"=>array());$Fh=microtime(true);$eh=$this->_conn->query($G,$Rb);if($pg)echo$b->selectQuery("$G: ".json_encode($Rb),$Fh,!$eh);if(!$eh)return
false;$I=array();foreach($eh['hits']['hits']as$Ed){$J=array();if($L==array("*"))$J["_id"]=$Ed["_id"];$p=$Ed['_source'];if($L!=array("*")){$p=array();foreach($L
as$z)$p[$z]=$Ed['fields'][$z];}foreach($p
as$z=>$X){if($Rb["fields"])$X=$X[0];$J[$z]=(is_array($X)?json_encode($X):$X);}$I[]=$J;}return
new
Min_Result($I);}function
update($T,$Cg,$zg,$_=0,$kh="\n"){$Yf=preg_split('~ *= *~',$zg);if(count($Yf)==2){$u=trim($Yf[1]);$G="$T/$u";return$this->_conn->query($G,$Cg,'POST');}return
false;}function
insert($T,$Cg){$u="";$G="$T/$u";$Og=$this->_conn->query($G,$Cg,'POST');$this->_conn->last_id=$Og['_id'];return$Og['created'];}function
delete($T,$zg,$_=0){$Id=array();if(is_array($_GET["where"])&&$_GET["where"]["_id"])$Id[]=$_GET["where"]["_id"];if(is_array($_POST['check'])){foreach($_POST['check']as$bb){$Yf=preg_split('~ *= *~',$bb);if(count($Yf)==2)$Id[]=trim($Yf[1]);}}$this->_conn->affected_rows=0;foreach($Id
as$u){$G="{$T}/{$u}";$Og=$this->_conn->query($G,'{}','DELETE');if(is_array($Og)&&$Og['found']==true)$this->_conn->affected_rows++;}return$this->_conn->affected_rows;}}function
connect(){global$b;$g=new
Min_DB;list($M,$V,$F)=$b->credentials();if($F!=""&&$g->connect($M,$V,""))return
lang(22);if($g->connect($M,$V,$F))return$g;return$g->error;}function
support($Vc){return
preg_match("~database|table|columns~",$Vc);}function
logged_user(){global$b;$Mb=$b->credentials();return$Mb[1];}function
get_databases(){global$g;$I=$g->rootQuery('_aliases');if($I){$I=array_keys($I);sort($I,SORT_STRING);}return$I;}function
collations(){return
array();}function
db_collation($l,$nb){}function
engines(){return
array();}function
count_tables($k){global$g;$I=array();$H=$g->query('_stats');if($H&&$H['indices']){$Qd=$H['indices'];foreach($Qd
as$Pd=>$Gh){$Od=$Gh['total']['indexing'];$I[$Pd]=$Od['index_total'];}}return$I;}function
tables_list(){global$g;if(min_version(6))return
array('_doc'=>'table');$I=$g->query('_mapping');if($I)$I=array_fill_keys(array_keys($I[$g->_db]["mappings"]),'table');return$I;}function
table_status($D="",$Uc=false){global$g;$eh=$g->query("_search",array("size"=>0,"aggregations"=>array("count_by_type"=>array("terms"=>array("field"=>"_type")))),"POST");$I=array();if($eh){$S=$eh["aggregations"]["count_by_type"]["buckets"];foreach($S
as$Q){$I[$Q["key"]]=array("Name"=>$Q["key"],"Engine"=>"table","Rows"=>$Q["doc_count"],);if($D!=""&&$D==$Q["key"])return$I[$D];}}return$I;}function
error(){global$g;return
h($g->error);}function
information_schema(){}function
is_view($R){}function
indexes($Q,$h=null){return
array(array("type"=>"PRIMARY","columns"=>array("_id")),);}function
fields($Q){global$g;$Be=array();if(min_version(6)){$H=$g->query("_mapping");if($H)$Be=$H[$g->_db]['mappings']['properties'];}else{$H=$g->query("$Q/_mapping");if($H){$Be=$H[$Q]['properties'];if(!$Be)$Be=$H[$g->_db]['mappings'][$Q]['properties'];}}$I=array();if($Be){foreach($Be
as$D=>$o){$I[$D]=array("field"=>$D,"full_type"=>$o["type"],"type"=>$o["type"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);if($o["properties"]){unset($I[$D]["privileges"]["insert"]);unset($I[$D]["privileges"]["update"]);}}}return$I;}function
foreign_keys($Q){return
array();}function
table($v){return$v;}function
idf_escape($v){return$v;}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
fk_support($R){}function
found_rows($R,$Z){return
null;}function
create_database($l){global$g;return$g->rootQuery(urlencode($l),null,'PUT');}function
drop_databases($k){global$g;return$g->rootQuery(urlencode(implode(',',$k)),array(),'DELETE');}function
alter_table($Q,$D,$p,$hd,$tb,$_c,$mb,$La,$Wf){global$g;$vg=array();foreach($p
as$Sc){$Xc=trim($Sc[1][0]);$Yc=trim($Sc[1][1]?$Sc[1][1]:"text");$vg[$Xc]=array('type'=>$Yc);}if(!empty($vg))$vg=array('properties'=>$vg);return$g->query("_mapping/{$D}",$vg,'PUT');}function
drop_tables($S){global$g;$I=true;foreach($S
as$Q)$I=$I&&$g->query(urlencode($Q),array(),'DELETE');return$I;}function
last_id(){global$g;return$g->last_id;}function
driver_config(){$U=array();$Jh=array();foreach(array(lang(27)=>array("long"=>3,"integer"=>5,"short"=>8,"byte"=>10,"double"=>20,"float"=>66,"half_float"=>12,"scaled_float"=>21),lang(28)=>array("date"=>10),lang(25)=>array("string"=>65535,"text"=>65535),lang(29)=>array("binary"=>255),)as$z=>$X){$U+=$X;$Jh[$z]=array_keys($X);}return
array('possible_drivers'=>array("json + allow_url_fopen"),'jush'=>"elastic",'operators'=>array("=","query"),'functions'=>array(),'grouping'=>array(),'edit_functions'=>array(array("json")),'types'=>$U,'structured_types'=>$Jh,);}}class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($i=false){return
password_file($i);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($M){return
h($M);}function
database(){return
DB;}function
databases($fd=true){return
get_databases($fd);}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$I=array();$q="adminer.css";if(file_exists($q))$I[]="$q?v=".crc32(file_get_contents($q));return$I;}function
loginForm(){global$kc;echo"<table cellspacing='0' class='layout'>\n",$this->loginFormField('driver','<tr><th>'.lang(33).'<td>',html_select("auth[driver]",$kc,DRIVER,"loginDriver(this);")."\n"),$this->loginFormField('server','<tr><th>'.lang(34).'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'."\n"),$this->loginFormField('username','<tr><th>'.lang(35).'<td>','<input name="auth[username]" id="username" value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.lang(36).'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'."\n"),$this->loginFormField('db','<tr><th>'.lang(37).'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'."\n"),"</table>\n","<p><input type='submit' value='".lang(38)."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],lang(39))."\n";}function
loginFormField($D,$Bd,$Y){return$Bd.$Y;}function
login($_e,$F){if($F=="")return
lang(40,target_blank());return
true;}function
tableName($Qh){return
h($Qh["Name"]);}function
fieldName($o,$Bf=0){return'<span title="'.h($o["full_type"]).'">'.h($o["field"]).'</span>';}function
selectLinks($Qh,$N=""){global$y,$m;echo'<p class="links">';$ze=array("select"=>lang(41));if(support("table")||support("indexes"))$ze["table"]=lang(42);if(support("table")){if(is_view($Qh))$ze["view"]=lang(43);else$ze["create"]=lang(44);}if($N!==null)$ze["edit"]=lang(45);$D=$Qh["Name"];foreach($ze
as$z=>$X)echo" <a href='".h(ME)."$z=".urlencode($D).($z=="edit"?$N:"")."'".bold(isset($_GET[$z])).">$X</a>";echo
doc_link(array($y=>$m->tableHelp($D)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$Ph){return
array();}function
backwardKeysPrint($Oa,$J){}function
selectQuery($G,$Fh,$Tc=false){global$y,$m;$I="</p>\n";if(!$Tc&&($ej=$m->warnings())){$u="warnings";$I=", <a href='#$u'>".lang(46)."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$I<div id='$u' class='hidden'>\n$ej</div>\n";}return"<p><code class='jush-$y'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($Fh).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".lang(10)."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($K,$id){return$K;}function
selectLink($X,$o){}function
selectVal($X,$A,$o,$Jf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$o["type"])&&!preg_match("~var~",$o["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$o["type"])&&!is_utf8($X))$I="<i>".lang(47,strlen($Jf))."</i>";if(preg_match('~json~',$o["type"]))$I="<code class='jush-js'>$I</code>";return($A?"<a href='".h($A)."'".(is_url($A)?target_blank():"").">$I</a>":$I);}function
editVal($X,$o){return$X;}function
tableStructurePrint($p){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>".lang(48)."<td>".lang(49).(support("comment")?"<td>".lang(50):"")."</thead>\n";foreach($p
as$o){echo"<tr".odd()."><th>".h($o["field"]),"<td><span title='".h($o["collation"])."'>".h($o["full_type"])."</span>",($o["null"]?" <i>NULL</i>":""),($o["auto_increment"]?" <i>".lang(51)."</i>":""),(isset($o["default"])?" <span title='".lang(52)."'>[<b>".h($o["default"])."</b>]</span>":""),(support("comment")?"<td>".h($o["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($x){echo"<table cellspacing='0'>\n";foreach($x
as$D=>$w){ksort($w["columns"]);$pg=array();foreach($w["columns"]as$z=>$X)$pg[]="<i>".h($X)."</i>".($w["lengths"][$z]?"(".$w["lengths"][$z].")":"").($w["descs"][$z]?" DESC":"");echo"<tr title='".h($D)."'><th>$w[type]<td>".implode(", ",$pg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$e){global$pd,$vd;print_fieldset("select",lang(53),$L);$t=0;$L[""]=array();foreach($L
as$z=>$X){$X=$_GET["columns"][$z];$d=select_input(" name='columns[$t][col]'",$e,$X["col"],($z!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($pd||$vd?"<select name='columns[$t][fun]'>".optionlist(array(-1=>"")+array_filter(array(lang(54)=>$pd,lang(55)=>$vd)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($z!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$x){print_fieldset("search",lang(56),$Z);foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('h',$w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}}$Za="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$t][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".lang(57).")"),html_select("where[$t][op]",$this->operators,$X["op"],$Za),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $Za }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($Bf,$e,$x){print_fieldset("sort",lang(58),$Bf);$t=0;foreach((array)$_GET["order"]as$z=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$e,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$z]),lang(59))."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$e,"","selectAddRow"),checkbox("desc[$t]",1,false,lang(59))."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($_){echo"<fieldset><legend>".lang(60)."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($_)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($fi){if($fi!==null){echo"<fieldset><legend>".lang(61)."</legend><div>","<input type='number' name='text_length' class='size' value='".h($fi)."'>","</div></fieldset>\n";}}function
selectActionPrint($x){echo"<fieldset><legend>".lang(62)."</legend><div>","<input type='submit' value='".lang(53)."'>"," <span id='noindex' title='".lang(63)."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($x
as$w){$Qb=reset($w["columns"]);if($w["type"]!="FULLTEXT"&&$Qb)$e[$Qb]=1;}$e[""]=1;foreach($e
as$z=>$X)json_row($z);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($xc,$e){}function
selectColumnsProcess($e,$x){global$pd,$vd;$L=array();$sd=array();foreach((array)$_GET["columns"]as$z=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$pd)||in_array($X["fun"],$vd)))){$L[$z]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$vd))$sd[]=$L[$z];}}return
array($L,$sd);}function
selectSearchProcess($p,$x){global$g,$m;$I=array();foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="")$I[]="MATCH (".implode(", ",array_map('idf_escape',$w["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$z=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$lg="";$wb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Ld=process_length($X["val"]);$wb.=" ".($Ld!=""?$Ld:"(NULL)");}elseif($X["op"]=="SQL")$wb=" $X[val]";elseif($X["op"]=="LIKE %%")$wb=" LIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$wb=" ILIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$lg="$X[op](".q($X["val"]).", ";$wb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$wb.=" ".$this->processInput($p[$X["col"]],$X["val"]);if($X["col"]!="")$I[]=$lg.$m->convertSearch(idf_escape($X["col"]),$X,$p[$X["col"]]).$wb;else{$pb=array();foreach($p
as$D=>$o){if((preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$o["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$o["type"]))&&(!preg_match('~date|timestamp~',$o["type"])||preg_match('~^\d+-\d+-\d+~',$X["val"])))$pb[]=$lg.$m->convertSearch(idf_escape($D),$X,$o).$wb;}$I[]=($pb?"(".implode(" OR ",$pb).")":"1 = 0");}}}return$I;}function
selectOrderProcess($p,$x){$I=array();foreach((array)$_GET["order"]as$z=>$X){if($X!="")$I[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$z])?" DESC":"");}return$I;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$id){return
false;}function
selectQueryBuild($L,$Z,$sd,$Bf,$_,$E){return"";}function
messageQuery($G,$gi,$Tc=false){global$y,$m;restart_session();$Cd=&get_session("queries");if(!$Cd[$_GET["db"]])$Cd[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\n…";$Cd[$_GET["db"]][]=array($G,time(),$gi);$Ch="sql-".count($Cd[$_GET["db"]]);$I="<a href='#$Ch' class='toggle'>".lang(64)."</a>\n";if(!$Tc&&($ej=$m->warnings())){$u="warnings-".count($Cd[$_GET["db"]]);$I="<a href='#$u' class='toggle'>".lang(46)."</a>, $I<div id='$u' class='hidden'>\n$ej</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$Ch' class='hidden'><pre><code class='jush-$y'>".shorten_utf8($G,1000)."</code></pre>".($gi?" <span class='time'>($gi)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($Cd[$_GET["db"]])-1)).'">'.lang(10).'</a>':'').'</div>';}function
editRowPrint($Q,$p,$J,$Li){}function
editFunctions($o){global$sc;$I=($o["null"]?"NULL/":"");$Li=isset($_GET["select"])||where($_GET);foreach($sc
as$z=>$pd){if(!$z||(!isset($_GET["call"])&&$Li)){foreach($pd
as$cg=>$X){if(!$cg||preg_match("~$cg~",$o["type"]))$I.="/$X";}}if($z&&!preg_match('~set|blob|bytea|raw|file|bool~',$o["type"]))$I.="/SQL";}if($o["auto_increment"]&&!$Li)$I=lang(51);return
explode("/",$I);}function
editInput($Q,$o,$Ia,$Y){if($o["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Ia value='-1' checked><i>".lang(8)."</i></label> ":"").($o["null"]?"<label><input type='radio'$Ia value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Ia,$o,$Y,0);return"";}function
editHint($Q,$o,$Y){return"";}function
processInput($o,$Y,$s=""){if($s=="SQL")return$Y;$D=$o["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$s))$I="$s()";elseif(preg_match('~^current_(date|timestamp)$~',$s))$I=$s;elseif(preg_match('~^([+-]|\|\|)$~',$s))$I=idf_escape($D)." $s $I";elseif(preg_match('~^[+-] interval$~',$s))$I=idf_escape($D)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$s))$I="$s(".idf_escape($D).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$s))$I="$s($I)";return
unconvert_field($o,$I);}function
dumpOutput(){$I=array('text'=>lang(65),'file'=>lang(66));if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
dumpFormat(){return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($l){}function
dumpTable($Q,$Kh,$ee=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($Kh)dump_csv(array_keys(fields($Q)));}else{if($ee==2){$p=array();foreach(fields($Q)as$D=>$o)$p[]=idf_escape($D)." $o[full_type]";$i="CREATE TABLE ".table($Q)." (".implode(", ",$p).")";}else$i=create_sql($Q,$_POST["auto_increment"],$Kh);set_utf8mb4($i);if($Kh&&$i){if($Kh=="DROP+CREATE"||$ee==1)echo"DROP ".($ee==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";if($ee==1)$i=remove_definer($i);echo"$i;\n\n";}}}function
dumpData($Q,$Kh,$G){global$g,$y;$He=($y=="sqlite"?0:1048576);if($Kh){if($_POST["format"]=="sql"){if($Kh=="TRUNCATE+INSERT")echo
truncate_sql($Q).";\n";$p=fields($Q);}$H=$g->query($G,1);if($H){$Xd="";$Wa="";$je=array();$Mh="";$Wc=($Q!=''?'fetch_assoc':'fetch_row');while($J=$H->$Wc()){if(!$je){$Wi=array();foreach($J
as$X){$o=$H->fetch_field();$je[]=$o->name;$z=idf_escape($o->name);$Wi[]="$z = VALUES($z)";}$Mh=($Kh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Wi):"").";\n";}if($_POST["format"]!="sql"){if($Kh=="table"){dump_csv($je);$Kh="INSERT";}dump_csv($J);}else{if(!$Xd)$Xd="INSERT INTO ".table($Q)." (".implode(", ",array_map('idf_escape',$je)).") VALUES";foreach($J
as$z=>$X){$o=$p[$z];$J[$z]=($X!==null?unconvert_field($o,preg_match(number_type(),$o["type"])&&!preg_match('~\[~',$o["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$ah=($He?"\n":" ")."(".implode(",\t",$J).")";if(!$Wa)$Wa=$Xd.$ah;elseif(strlen($Wa)+4+strlen($ah)+strlen($Mh)<$He)$Wa.=",$ah";else{echo$Wa.$Mh;$Wa=$Xd.$ah;}}}if($Wa)echo$Wa.$Mh;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$g->error)."\n";}}function
dumpFilename($Hd){return
friendly_url($Hd!=""?$Hd:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Hd,$Ve=false){$Mf=$_POST["output"];$Oc=(preg_match('~sql~',$_POST["format"])?"sql":($Ve?"tar":"csv"));header("Content-Type: ".($Mf=="gz"?"application/x-gzip":($Oc=="tar"?"application/x-tar":($Oc=="sql"||$Mf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Mf=="gz")ob_start('ob_gzencode',1e6);return$Oc;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.lang(67)."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?lang(68):lang(69))."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.lang(70)."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".lang(71)."</a>\n":"");return
true;}function
navigation($Ue){global$ia,$y,$kc,$g;echo'<h1>
',$this->name(),' <span class="version">',$ia,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</h1>
';if($Ue=="auth"){$Mf="";foreach((array)$_SESSION["pwds"]as$Yi=>$oh){foreach($oh
as$M=>$Ti){foreach($Ti
as$V=>$F){if($F!==null){$Wb=$_SESSION["db"][$Yi][$M][$V];foreach(($Wb?array_keys($Wb):array(""))as$l)$Mf.="<li><a href='".h(auth_url($Yi,$M,$V,$l))."'>($kc[$Yi]) ".h($V.($M!=""?"@".$this->serverName($M):"").($l!=""?" - $l":""))."</a>\n";}}}}if($Mf)echo"<ul id='logins'>\n$Mf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$S=array();if($_GET["ns"]!==""&&!$Ue&&DB!=""){$g->select_db(DB);$S=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=4.8.1");if(support("sql")){echo'<script',nonce(),'>
';if($S){$ze=array();foreach($S
as$Q=>$T)$ze[]=preg_quote($Q,'/');echo"var jushLinks = { $y: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$ze).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.$y;\n";}$nh=$g->server_info;echo'bodyLoad(\'',(is_object($g)?preg_replace('~^(\d\.?\d).*~s','\1',$nh):""),'\'',(preg_match('~MariaDB~',$nh)?", true":""),');
</script>
';}$this->databasesPrint($Ue);if(DB==""||!$Ue){echo"<p class='links'>".(support("sql")?"<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".lang(64)."</a>\n<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".lang(72)."</a>\n":"")."";if(support("dump"))echo"<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".lang(73)."</a>\n";}if($_GET["ns"]!==""&&!$Ue&&DB!=""){echo'<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".lang(74)."</a>\n";if(!$S)echo"<p class='message'>".lang(9)."\n";else$this->tablesPrint($S);}}}function
databasesPrint($Ue){global$b,$g;$k=$this->databases();if(DB&&$k&&!in_array(DB,$k))array_unshift($k,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Ub=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".lang(75)."'>".lang(76)."</span>: ".($k?"<select name='db'>".optionlist(array(""=>"")+$k,DB)."</select>$Ub":"<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".lang(20)."'".($k?" class='hidden'":"").">\n";if(support("scheme")){if($Ue!="db"&&DB!=""&&$g->select_db(DB)){echo"<br>".lang(77).": <select name='ns'>".optionlist(array(""=>"")+$b->schemas(),$_GET["ns"])."</select>$Ub";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$O){$D=$this->tableName($O);if($D!=""){echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select")." title='".lang(41)."'>".lang(78)."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($O)?"view":"structure"))." title='".lang(42)."'>$D</a>":"<span>$D</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);$kc=array("server"=>"MySQL")+$kc;if(!defined("DRIVER")){define("DRIVER","server");if(extension_loaded("mysqli")){class
Min_DB
extends
MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($M="",$V="",$F="",$j=null,$gg=null,$wh=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Fd,$gg)=explode(":",$M,2);$Eh=$b->connectSsl();if($Eh)$this->ssl_set($Eh['key'],$Eh['cert'],$Eh['ca'],'','');$I=@$this->real_connect(($M!=""?$Fd:ini_get("mysqli.default_host")),($M.$V!=""?$V:ini_get("mysqli.default_user")),($M.$V.$F!=""?$F:ini_get("mysqli.default_pw")),$j,(is_numeric($gg)?$gg:ini_get("mysqli.default_port")),(!is_numeric($gg)?$gg:$wh),($Eh?64:0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$I;}function
set_charset($ab){if(parent::set_charset($ab))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $ab");}function
result($G,$o=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch_array();return$J[$o];}function
quote($P){return"'".$this->escape_string($P)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Min_DB{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($M,$V,$F){if(ini_bool("mysql.allow_local_infile")){$this->error=lang(79,"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->_link=@mysql_connect(($M!=""?$M:ini_get("mysql.default_host")),("$M$V"!=""?$V:ini_get("mysql.default_user")),("$M$V$F"!=""?$F:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($ab){if(function_exists('mysql_set_charset')){if(mysql_set_charset($ab,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $ab");}function
quote($P){return"'".mysql_real_escape_string($P,$this->_link)."'";}function
select_db($j){return
mysql_select_db($j,$this->_link);}function
query($G,$Ei=false){$H=@($Ei?mysql_unbuffered_query($G,$this->_link):mysql_query($G,$this->_link));$this->error="";if(!$H){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($H===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
mysql_result($H->_result,0,$o);}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($H){$this->_result=$H;$this->num_rows=mysql_num_rows($H);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$I=mysql_fetch_field($this->_result,$this->_offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=($I->blob?63:0);return$I;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_MySQL";function
connect($M,$V,$F){global$b;$_f=array(PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$Eh=$b->connectSsl();if($Eh){if(!empty($Eh['key']))$_f[PDO::MYSQL_ATTR_SSL_KEY]=$Eh['key'];if(!empty($Eh['cert']))$_f[PDO::MYSQL_ATTR_SSL_CERT]=$Eh['cert'];if(!empty($Eh['ca']))$_f[PDO::MYSQL_ATTR_SSL_CA]=$Eh['ca'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$F,$_f);return
true;}function
set_charset($ab){$this->query("SET NAMES $ab");}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($G,$Ei=false){$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$Ei);return
parent::query($G,$Ei);}}}class
Min_Driver
extends
Min_SQL{function
insert($Q,$N){return($N?parent::insert($Q,$N):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));}function
insertUpdate($Q,$K,$ng){$e=array_keys(reset($K));$lg="INSERT INTO ".table($Q)." (".implode(", ",$e).") VALUES\n";$Wi=array();foreach($e
as$z)$Wi[$z]="$z = VALUES($z)";$Mh="\nON DUPLICATE KEY UPDATE ".implode(", ",$Wi);$Wi=array();$we=0;foreach($K
as$N){$Y="(".implode(", ",$N).")";if($Wi&&(strlen($lg)+$we+strlen($Y)+strlen($Mh)>1e6)){if(!queries($lg.implode(",\n",$Wi).$Mh))return
false;$Wi=array();$we=0;}$Wi[]=$Y;$we+=strlen($Y)+2;}return
queries($lg.implode(",\n",$Wi).$Mh);}function
slowQuery($G,$hi){if(min_version('5.7.8','10.1.2')){if(preg_match('~MariaDB~',$this->_conn->server_info))return"SET STATEMENT max_statement_time=$hi FOR $G";elseif(preg_match('~^(SELECT\b)(.+)~is',$G,$C))return"$C[1] /*+ MAX_EXECUTION_TIME(".($hi*1000).") */ $C[2]";}}function
convertSearch($v,$X,$o){return(preg_match('~char|text|enum|set~',$o["type"])&&!preg_match("~^utf8~",$o["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($v USING ".charset($this->_conn).")":$v);}function
warnings(){$H=$this->_conn->query("SHOW WARNINGS");if($H&&$H->num_rows){ob_start();select($H);return
ob_get_clean();}}function
tableHelp($D){$Ce=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower(($Ce?"information-schema-$D-table/":str_replace("_","-",$D)."-table.html"));if(DB=="mysql")return($Ce?"mysql$D-table/":"system-database.html");}}function
idf_escape($v){return"`".str_replace("`","``",$v)."`";}function
table($v){return
idf_escape($v);}function
connect(){global$b,$U,$Jh;$g=new
Min_DB;$Mb=$b->credentials();if($g->connect($Mb[0],$Mb[1],$Mb[2])){$g->set_charset(charset($g));$g->query("SET sql_quote_show_create = 1, autocommit = 1");if(min_version('5.7.8',10.2,$g)){$Jh[lang(25)][]="json";$U["json"]=4294967295;}return$g;}$I=$g->error;if(function_exists('iconv')&&!is_utf8($I)&&strlen($ah=iconv("windows-1250","utf-8",$I))>strlen($I))$I=$ah;return$I;}function
get_databases($fd){$I=get_session("dbs");if($I===null){$G=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME":"SHOW DATABASES");$I=($fd?slow_query($G):get_vals($G));restart_session();set_session("dbs",$I);stop_session();}return$I;}function
limit($G,$Z,$_,$kf=0,$kh=" "){return" $G$Z".($_!==null?$kh."LIMIT $_".($kf?" OFFSET $kf":""):"");}function
limit1($Q,$G,$Z,$kh="\n"){return
limit($G,$Z,1,0,$kh);}function
db_collation($l,$nb){global$g;$I=null;$i=$g->result("SHOW CREATE DATABASE ".idf_escape($l),1);if(preg_match('~ COLLATE ([^ ]+)~',$i,$C))$I=$C[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$i,$C))$I=$nb[$C[1]][-1];return$I;}function
engines(){$I=array();foreach(get_rows("SHOW ENGINES")as$J){if(preg_match("~YES|DEFAULT~",$J["Support"]))$I[]=$J["Engine"];}return$I;}function
logged_user(){global$g;return$g->result("SELECT USER()");}function
tables_list(){return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");}function
count_tables($k){$I=array();foreach($k
as$l)$I[$l]=count(get_vals("SHOW TABLES IN ".idf_escape($l)));return$I;}function
table_status($D="",$Uc=false){$I=array();foreach(get_rows($Uc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($D!=""?"AND TABLE_NAME = ".q($D):"ORDER BY Name"):"SHOW TABLE STATUS".($D!=""?" LIKE ".q(addcslashes($D,"%_\\")):""))as$J){if($J["Engine"]=="InnoDB")$J["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$J["Comment"]);if(!isset($J["Engine"]))$J["Comment"]="";if($D!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]===null;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"])||(preg_match('~NDB~i',$R["Engine"])&&min_version(5.6));}function
fields($Q){$I=array();foreach(get_rows("SHOW FULL COLUMNS FROM ".table($Q))as$J){preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$J["Type"],$C);$I[$J["Field"]]=array("field"=>$J["Field"],"full_type"=>$J["Type"],"type"=>$C[1],"length"=>$C[2],"unsigned"=>ltrim($C[3].$C[4]),"default"=>($J["Default"]!=""||preg_match("~char|set~",$C[1])?(preg_match('~text~',$C[1])?stripslashes(preg_replace("~^'(.*)'\$~",'\1',$J["Default"])):$J["Default"]):null),"null"=>($J["Null"]=="YES"),"auto_increment"=>($J["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i',$J["Extra"],$C)?$C[1]:""),"collation"=>$J["Collation"],"privileges"=>array_flip(preg_split('~, *~',$J["Privileges"])),"comment"=>$J["Comment"],"primary"=>($J["Key"]=="PRI"),"generated"=>preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$J["Extra"]),);}return$I;}function
indexes($Q,$h=null){$I=array();foreach(get_rows("SHOW INDEX FROM ".table($Q),$h)as$J){$D=$J["Key_name"];$I[$D]["type"]=($D=="PRIMARY"?"PRIMARY":($J["Index_type"]=="FULLTEXT"?"FULLTEXT":($J["Non_unique"]?($J["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$I[$D]["columns"][]=$J["Column_name"];$I[$D]["lengths"][]=($J["Index_type"]=="SPATIAL"?null:$J["Sub_part"]);$I[$D]["descs"][]=null;}return$I;}function
foreign_keys($Q){global$g,$sf;static$cg='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$I=array();$Kb=$g->result("SHOW CREATE TABLE ".table($Q),1);if($Kb){preg_match_all("~CONSTRAINT ($cg) FOREIGN KEY ?\\(((?:$cg,? ?)+)\\) REFERENCES ($cg)(?:\\.($cg))? \\(((?:$cg,? ?)+)\\)(?: ON DELETE ($sf))?(?: ON UPDATE ($sf))?~",$Kb,$Fe,PREG_SET_ORDER);foreach($Fe
as$C){preg_match_all("~$cg~",$C[2],$yh);preg_match_all("~$cg~",$C[5],$Zh);$I[idf_unescape($C[1])]=array("db"=>idf_unescape($C[4]!=""?$C[3]:$C[4]),"table"=>idf_unescape($C[4]!=""?$C[4]:$C[3]),"source"=>array_map('idf_unescape',$yh[0]),"target"=>array_map('idf_unescape',$Zh[0]),"on_delete"=>($C[6]?$C[6]:"RESTRICT"),"on_update"=>($C[7]?$C[7]:"RESTRICT"),);}}return$I;}function
view($D){global$g;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',$g->result("SHOW CREATE VIEW ".table($D),1)));}function
collations(){$I=array();foreach(get_rows("SHOW COLLATION")as$J){if($J["Default"])$I[$J["Charset"]][-1]=$J["Collation"];else$I[$J["Charset"]][]=$J["Collation"];}ksort($I);foreach($I
as$z=>$X)asort($I[$z]);return$I;}function
information_schema($l){return(min_version(5)&&$l=="information_schema")||(min_version(5.5)&&$l=="performance_schema");}function
error(){global$g;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$g->error));}function
create_database($l,$mb){return
queries("CREATE DATABASE ".idf_escape($l).($mb?" COLLATE ".q($mb):""));}function
drop_databases($k){$I=apply_queries("DROP DATABASE",$k,'idf_escape');restart_session();set_session("dbs",null);return$I;}function
rename_database($D,$mb){$I=false;if(create_database($D,$mb)){$S=array();$bj=array();foreach(tables_list()as$Q=>$T){if($T=='VIEW')$bj[]=$Q;else$S[]=$Q;}$I=(!$S&&!$bj)||move_tables($S,$bj,$D);drop_databases($I?array(DB):array());}return$I;}function
auto_increment(){$Ma=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$w){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$w["columns"],true)){$Ma="";break;}if($w["type"]=="PRIMARY")$Ma=" UNIQUE";}}return" AUTO_INCREMENT$Ma";}function
alter_table($Q,$D,$p,$hd,$tb,$_c,$mb,$La,$Wf){$c=array();foreach($p
as$o)$c[]=($o[1]?($Q!=""?($o[0]!=""?"CHANGE ".idf_escape($o[0]):"ADD"):" ")." ".implode($o[1]).($Q!=""?$o[2]:""):"DROP ".idf_escape($o[0]));$c=array_merge($c,$hd);$O=($tb!==null?" COMMENT=".q($tb):"").($_c?" ENGINE=".q($_c):"").($mb?" COLLATE ".q($mb):"").($La!=""?" AUTO_INCREMENT=$La":"");if($Q=="")return
queries("CREATE TABLE ".table($D)." (\n".implode(",\n",$c)."\n)$O$Wf");if($Q!=$D)$c[]="RENAME TO ".table($D);if($O)$c[]=ltrim($O);return($c||$Wf?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$c).$Wf):true);}function
alter_indexes($Q,$c){foreach($c
as$z=>$X)$c[$z]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($Q).implode(",",$c));}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($bj){return
queries("DROP VIEW ".implode(", ",array_map('table',$bj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('table',$S)));}function
move_tables($S,$bj,$Zh){global$g;$Mg=array();foreach($S
as$Q)$Mg[]=table($Q)." TO ".idf_escape($Zh).".".table($Q);if(!$Mg||queries("RENAME TABLE ".implode(", ",$Mg))){$bc=array();foreach($bj
as$Q)$bc[table($Q)]=view($Q);$g->select_db($Zh);$l=idf_escape(DB);foreach($bc
as$D=>$aj){if(!queries("CREATE VIEW $D AS ".str_replace(" $l."," ",$aj["select"]))||!queries("DROP VIEW $l.$D"))return
false;}return
true;}return
false;}function
copy_tables($S,$bj,$Zh){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($S
as$Q){$D=($Zh==DB?table("copy_$Q"):idf_escape($Zh).".".table($Q));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $D"))||!queries("CREATE TABLE $D LIKE ".table($Q))||!queries("INSERT INTO $D SELECT * FROM ".table($Q)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J){$zi=$J["Trigger"];if(!queries("CREATE TRIGGER ".($Zh==DB?idf_escape("copy_$zi"):idf_escape($Zh).".".idf_escape($zi))." $J[Timing] $J[Event] ON $D FOR EACH ROW\n$J[Statement];"))return
false;}}foreach($bj
as$Q){$D=($Zh==DB?table("copy_$Q"):idf_escape($Zh).".".table($Q));$aj=view($Q);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $D"))||!queries("CREATE VIEW $D AS $aj[select]"))return
false;}return
true;}function
trigger($D){if($D=="")return
array();$K=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($D));return
reset($K);}function
triggers($Q){$I=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J)$I[$J["Trigger"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($D,$T){global$g,$Bc,$Vd,$U;$Ca=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$zh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Di="((".implode("|",array_merge(array_keys($U),$Ca)).")\\b(?:\\s*\\(((?:[^'\")]|$Bc)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$cg="$zh*(".($T=="FUNCTION"?"":$Vd).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Di";$i=$g->result("SHOW CREATE $T ".idf_escape($D),2);preg_match("~\\(((?:$cg\\s*,?)*)\\)\\s*".($T=="FUNCTION"?"RETURNS\\s+$Di\\s+":"")."(.*)~is",$i,$C);$p=array();preg_match_all("~$cg\\s*,?~is",$C[1],$Fe,PREG_SET_ORDER);foreach($Fe
as$Qf)$p[]=array("field"=>str_replace("``","`",$Qf[2]).$Qf[3],"type"=>strtolower($Qf[5]),"length"=>preg_replace_callback("~$Bc~s",'normalize_enum',$Qf[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Qf[8] $Qf[7]"))),"null"=>1,"full_type"=>$Qf[4],"inout"=>strtoupper($Qf[1]),"collation"=>strtolower($Qf[9]),);if($T!="FUNCTION")return
array("fields"=>$p,"definition"=>$C[11]);return
array("fields"=>$p,"returns"=>array("type"=>$C[12],"length"=>$C[13],"unsigned"=>$C[15],"collation"=>$C[16]),"definition"=>$C[17],"language"=>"SQL",);}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));}function
routine_languages(){return
array();}function
routine_id($D,$J){return
idf_escape($D);}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ID()");}function
explain($g,$G){return$g->query("EXPLAIN ".(min_version(5.1)&&!min_version(5.7)?"PARTITIONS ":"").$G);}function
found_rows($R,$Z){return($Z||$R["Engine"]!="InnoDB"?null:$R["Rows"]);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($ch,$h=null){return
true;}function
create_sql($Q,$La,$Kh){global$g;$I=$g->result("SHOW CREATE TABLE ".table($Q),1);if(!$La)$I=preg_replace('~ AUTO_INCREMENT=\d+~','',$I);return$I;}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
use_sql($j){return"USE ".idf_escape($j);}function
trigger_sql($Q){$I="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")),null,"-- ")as$J)$I.="\nCREATE TRIGGER ".idf_escape($J["Trigger"])." $J[Timing] $J[Event] ON ".table($J["Table"])." FOR EACH ROW\n$J[Statement];;\n";return$I;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($o){if(preg_match("~binary~",$o["type"]))return"HEX(".idf_escape($o["field"]).")";if($o["type"]=="bit")return"BIN(".idf_escape($o["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($o["field"]).")";}function
unconvert_field($o,$I){if(preg_match("~binary~",$o["type"]))$I="UNHEX($I)";if($o["type"]=="bit")$I="CONV($I, 2, 10) + 0";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))$I=(min_version(8)?"ST_":"")."GeomFromText($I, SRID($o[field]))";return$I;}function
support($Vc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view")))."~",$Vc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$g;return$g->result("SELECT @@max_connections");}function
driver_config(){$U=array();$Jh=array();foreach(array(lang(27)=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),lang(28)=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),lang(25)=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),lang(80)=>array("enum"=>65535,"set"=>64),lang(29)=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),lang(31)=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$z=>$X){$U+=$X;$Jh[$z]=array_keys($X);}return
array('possible_drivers'=>array("MySQLi","MySQL","PDO_MySQL"),'jush'=>"sql",'types'=>$U,'structured_types'=>$Jh,'unsigned'=>array("unsigned","zerofill","unsigned zerofill"),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL"),'functions'=>array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper"),'grouping'=>array("avg","count","count distinct","group_concat","max","min","sum"),'edit_functions'=>array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",)),);}}$xb=driver_config();$kg=$xb['possible_drivers'];$y=$xb['jush'];$U=$xb['types'];$Jh=$xb['structured_types'];$Ki=$xb['unsigned'];$xf=$xb['operators'];$pd=$xb['functions'];$vd=$xb['grouping'];$sc=$xb['edit_functions'];if($b->operators===null)$b->operators=$xf;define("SERVER",$_GET[DRIVER]);define("DB",$_GET["db"]);define("ME",preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));$ia="4.8.1";function
page_header($ji,$n="",$Va=array(),$ki=""){global$ca,$ia,$b,$kc,$y;page_headers();if(is_ajax()&&$n){page_messages($n);exit;}$li=$ji.($ki!=""?": $ki":"");$mi=strip_tags($li.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="',$ca,'" dir="',lang(81),'">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$mi,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=4.8.1"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=4.8.1");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.8.1"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.8.1"),'">
';foreach($b->css()as$Ob){echo'<link rel="stylesheet" type="text/css" href="',h($Ob),'">
';}}echo'
<body class="',lang(81),' nojs">
';$q=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($q)&&filemtime($q)+86400>time()){$Zi=unserialize(file_get_contents($q));$wg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($Zi["version"],base64_decode($Zi["signature"]),$wg)==1)$_COOKIE["adminer_version"]=$Zi["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape(lang(82)),'\';
var thousandsSeparator = \'',js_escape(lang(5)),'\';
</script>

<div id="help" class="jush-',$y,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Va!==null){$A=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($A?$A:".").'">'.$kc[DRIVER].'</a> &raquo; ';$A=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=$b->serverName(SERVER);$M=($M!=""?$M:lang(34));if($Va===false)echo"$M\n";else{echo"<a href='".h($A)."' accesskey='1' title='Alt+Shift+1'>$M</a> &raquo; ";if($_GET["ns"]!=""||(DB!=""&&is_array($Va)))echo'<a href="'.h($A."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> &raquo; ';if(is_array($Va)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> &raquo; ';foreach($Va
as$z=>$X){$dc=(is_array($X)?$X[1]:h($X));if($dc!="")echo"<a href='".h(ME."$z=").urlencode(is_array($X)?$X[0]:$X)."'>$dc</a> &raquo; ";}}echo"$ji\n";}}echo"<h2>$li</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($n);$k=&get_session("dbs");if(DB!=""&&$k&&!in_array(DB,$k,true))$k=null;stop_session();define("PAGE_HEADER",1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Nb){$Ad=array();foreach($Nb
as$z=>$X)$Ad[]="$z $X";header("Content-Security-Policy: ".implode("; ",$Ad));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$ef;if(!$ef)$ef=base64_encode(rand_string());return$ef;}function
page_messages($n){$Mi=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Re=$_SESSION["messages"][$Mi];if($Re){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Re)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Mi]);}if($n)echo"<div class='error'>$n</div>\n";}function
page_footer($Ue=""){global$b,$qi;echo'</div>

';switch_lang();if($Ue!="auth"){echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="',lang(83),'" id="logout">
<input type="hidden" name="token" value="',$qi,'">
</p>
</form>
';}echo'<div id="menu">
';$b->navigation($Ue);echo'</div>
',script("setupSubmitHighlight(document);");}function
int32($Xe){while($Xe>=2147483648)$Xe-=4294967296;while($Xe<=-2147483649)$Xe+=4294967296;return(int)$Xe;}function
long2str($W,$dj){$ah='';foreach($W
as$X)$ah.=pack('V',$X);if($dj)return
substr($ah,0,end($W));return$ah;}function
str2long($ah,$dj){$W=array_values(unpack('V*',str_pad($ah,4*ceil(strlen($ah)/4),"\0")));if($dj)$W[]=strlen($ah);return$W;}function
xxtea_mx($pj,$oj,$Nh,$he){return
int32((($pj>>5&0x7FFFFFF)^$oj<<2)+(($oj>>3&0x1FFFFFFF)^$pj<<4))^int32(($Nh^$oj)+($he^$pj));}function
encrypt_string($Ih,$z){if($Ih=="")return"";$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($Ih,true);$Xe=count($W)-1;$pj=$W[$Xe];$oj=$W[0];$xg=floor(6+52/($Xe+1));$Nh=0;while($xg-->0){$Nh=int32($Nh+0x9E3779B9);$rc=$Nh>>2&3;for($Of=0;$Of<$Xe;$Of++){$oj=$W[$Of+1];$We=xxtea_mx($pj,$oj,$Nh,$z[$Of&3^$rc]);$pj=int32($W[$Of]+$We);$W[$Of]=$pj;}$oj=$W[0];$We=xxtea_mx($pj,$oj,$Nh,$z[$Of&3^$rc]);$pj=int32($W[$Xe]+$We);$W[$Xe]=$pj;}return
long2str($W,false);}function
decrypt_string($Ih,$z){if($Ih=="")return"";if(!$z)return
false;$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($Ih,false);$Xe=count($W)-1;$pj=$W[$Xe];$oj=$W[0];$xg=floor(6+52/($Xe+1));$Nh=int32($xg*0x9E3779B9);while($Nh){$rc=$Nh>>2&3;for($Of=$Xe;$Of>0;$Of--){$pj=$W[$Of-1];$We=xxtea_mx($pj,$oj,$Nh,$z[$Of&3^$rc]);$oj=int32($W[$Of]-$We);$W[$Of]=$oj;}$pj=$W[$Xe];$We=xxtea_mx($pj,$oj,$Nh,$z[$Of&3^$rc]);$oj=int32($W[0]-$We);$W[0]=$oj;$Nh=int32($Nh-0x9E3779B9);}return
long2str($W,true);}$g='';$_d=$_SESSION["token"];if(!$_d)$_SESSION["token"]=rand(1,1e6);$qi=get_token();$eg=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($z)=explode(":",$X);$eg[$z]=$X;}}function
add_invalid_login(){global$b;$nd=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$nd)return;$ae=unserialize(stream_get_contents($nd));$gi=time();if($ae){foreach($ae
as$be=>$X){if($X[0]<$gi)unset($ae[$be]);}}$Zd=&$ae[$b->bruteForceKey()];if(!$Zd)$Zd=array($gi+30*60,0);$Zd[1]++;file_write_unlock($nd,serialize($ae));}function
check_invalid_login(){global$b;$ae=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$Zd=($ae?$ae[$b->bruteForceKey()]:array());$df=($Zd[1]>29?$Zd[0]-time():0);if($df>0)auth_error(lang(84,ceil($df/60)));}$Ja=$_POST["auth"];if($Ja){session_regenerate_id();$Yi=$Ja["driver"];$M=$Ja["server"];$V=$Ja["username"];$F=(string)$Ja["password"];$l=$Ja["db"];set_password($Yi,$M,$V,$F);$_SESSION["db"][$Yi][$M][$V][$l]=true;if($Ja["permanent"]){$z=base64_encode($Yi)."-".base64_encode($M)."-".base64_encode($V)."-".base64_encode($l);$qg=$b->permanentLogin(true);$eg[$z]="$z:".base64_encode($qg?encrypt_string($F,$qg):"");cookie("adminer_permanent",implode(" ",$eg));}if(count($_POST)==1||DRIVER!=$Yi||SERVER!=$M||$_GET["username"]!==$V||DB!=$l)redirect(auth_url($Yi,$M,$V,$l));}elseif($_POST["logout"]&&(!$_d||verify_token())){foreach(array("pwds","db","dbs","queries")as$z)set_session($z,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),lang(85).' '.lang(86));}elseif($eg&&!$_SESSION["pwds"]){session_regenerate_id();$qg=$b->permanentLogin();foreach($eg
as$z=>$X){list(,$gb)=explode(":",$X);list($Yi,$M,$V,$l)=array_map('base64_decode',explode("-",$z));set_password($Yi,$M,$V,decrypt_string(base64_decode($gb),$qg));$_SESSION["db"][$Yi][$M][$V][$l]=true;}}function
unset_permanent(){global$eg;foreach($eg
as$z=>$X){list($Yi,$M,$V,$l)=array_map('base64_decode',explode("-",$z));if($Yi==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$l==DB)unset($eg[$z]);}cookie("adminer_permanent",implode(" ",$eg));}function
auth_error($n){global$b,$_d;$ph=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$ph]||$_GET[$ph])&&!$_d)$n=lang(87);else{restart_session();add_invalid_login();$F=get_password();if($F!==null){if($F===false)$n.=($n?'<br>':'').lang(88,target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$ph]&&$_GET[$ph]&&ini_bool("session.use_only_cookies"))$n=lang(89);$Rf=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()),$Rf["lifetime"]);page_header(lang(38),$n,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".lang(90)."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists("Min_DB")){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header(lang(91),lang(92,implode(", ",$kg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Fd,$gg)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$gg,$C)&&($C[1]<1024||$C[1]>65535))auth_error(lang(93));check_invalid_login();$g=connect();$m=new
Min_Driver($g);}$_e=null;if(!is_object($g)||($_e=$b->login($_GET["username"],get_password()))!==true){$n=(is_string($g)?h($g):(is_string($_e)?$_e:lang(32)));auth_error($n.(preg_match('~^ | $~',get_password())?'<br>'.lang(94):''));}if($_POST["logout"]&&$_d&&!verify_token()){page_header(lang(83),lang(95));page_footer("db");exit;}if($Ja&&$_POST["token"])$_POST["token"]=$qi;$n='';if($_POST){if(!verify_token()){$Ud="max_input_vars";$Le=ini_get($Ud);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$z){$X=ini_get($z);if($X&&(!$Le||$X<$Le)){$Ud=$z;$Le=$X;}}}$n=(!$_POST["token"]&&$Le?lang(96,"'$Ud'"):lang(95).' '.lang(97));}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$n=lang(98,"'post_max_size'");if(isset($_GET["sql"]))$n.=' '.lang(99);}function
select($H,$h=null,$Ef=array(),$_=0){global$y;$ze=array();$x=array();$e=array();$Ta=array();$U=array();$I=array();odd('');for($t=0;(!$_||$t<$_)&&($J=$H->fetch_row());$t++){if(!$t){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr>";for($ge=0;$ge<count($J);$ge++){$o=$H->fetch_field();$D=$o->name;$Df=$o->orgtable;$Cf=$o->orgname;$I[$o->table]=$Df;if($Ef&&$y=="sql")$ze[$ge]=($D=="table"?"table=":($D=="possible_keys"?"indexes=":null));elseif($Df!=""){if(!isset($x[$Df])){$x[$Df]=array();foreach(indexes($Df,$h)as$w){if($w["type"]=="PRIMARY"){$x[$Df]=array_flip($w["columns"]);break;}}$e[$Df]=$x[$Df];}if(isset($e[$Df][$Cf])){unset($e[$Df][$Cf]);$x[$Df][$Cf]=$ge;$ze[$ge]=$Df;}}if($o->charsetnr==63)$Ta[$ge]=true;$U[$ge]=$o->type;echo"<th".($Df!=""||$o->name!=$Cf?" title='".h(($Df!=""?"$Df.":"").$Cf)."'":"").">".h($D).($Ef?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($D),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr".odd().">";foreach($J
as$z=>$X){$A="";if(isset($ze[$z])&&!$e[$ze[$z]]){if($Ef&&$y=="sql"){$Q=$J[array_search("table=",$ze)];$A=ME.$ze[$z].urlencode($Ef[$Q]!=""?$Ef[$Q]:$Q);}else{$A=ME."edit=".urlencode($ze[$z]);foreach($x[$ze[$z]]as$kb=>$ge)$A.="&where".urlencode("[".bracket_escape($kb)."]")."=".urlencode($J[$ge]);}}elseif(is_url($X))$A=$X;if($X===null)$X="<i>NULL</i>";elseif($Ta[$z]&&!is_utf8($X))$X="<i>".lang(47,strlen($X))."</i>";else{$X=h($X);if($U[$z]==254)$X="<code>$X</code>";}if($A)$X="<a href='".h($A)."'".(is_url($A)?target_blank():'').">$X</a>";echo"<td>$X";}}echo($t?"</table>\n</div>":"<p class='message'>".lang(12))."\n";return$I;}function
referencable_primary($ih){$I=array();foreach(table_status('',true)as$Rh=>$Q){if($Rh!=$ih&&fk_support($Q)){foreach(fields($Rh)as$o){if($o["primary"]){if($I[$Rh]){unset($I[$Rh]);break;}$I[$Rh]=$o;}}}}return$I;}function
adminer_settings(){parse_str($_COOKIE["adminer_settings"],$rh);return$rh;}function
adminer_setting($z){$rh=adminer_settings();return$rh[$z];}function
set_adminer_settings($rh){return
cookie("adminer_settings",http_build_query($rh+adminer_settings()));}function
textarea($D,$Y,$K=10,$pb=80){global$y;echo"<textarea name='$D' rows='$K' cols='$pb' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
edit_type($z,$o,$nb,$jd=array(),$Rc=array()){global$Jh,$U,$Ki,$sf;$T=$o["type"];echo'<td><select name="',h($z),'[type]" class="type" aria-labelledby="label-type">';if($T&&!isset($U[$T])&&!isset($jd[$T])&&!in_array($T,$Rc))$Rc[]=$T;if($jd)$Jh[lang(100)]=$jd;echo
optionlist(array_merge($Rc,$Jh),$T),'</select><td><input name="',h($z),'[length]" value="',h($o["length"]),'" size="3"',(!$o["length"]&&preg_match('~var(char|binary)$~',$T)?" class='required'":"");echo' aria-labelledby="label-length"><td class="options">',"<select name='".h($z)."[collation]'".(preg_match('~(char|text|enum|set)$~',$T)?"":" class='hidden'").'><option value="">('.lang(101).')'.optionlist($nb,$o["collation"]).'</select>',($Ki?"<select name='".h($z)."[unsigned]'".(!$T||preg_match(number_type(),$T)?"":" class='hidden'").'><option>'.optionlist($Ki,$o["unsigned"]).'</select>':''),(isset($o['on_update'])?"<select name='".h($z)."[on_update]'".(preg_match('~timestamp|datetime~',$T)?"":" class='hidden'").'>'.optionlist(array(""=>"(".lang(102).")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?"CURRENT_TIMESTAMP":$o["on_update"])).'</select>':''),($jd?"<select name='".h($z)."[on_delete]'".(preg_match("~`~",$T)?"":" class='hidden'")."><option value=''>(".lang(103).")".optionlist(explode("|",$sf),$o["on_delete"])."</select> ":" ");}function
process_length($we){global$Bc;return(preg_match("~^\\s*\\(?\\s*$Bc(?:\\s*,\\s*$Bc)*+\\s*\\)?\\s*\$~",$we)&&preg_match_all("~$Bc~",$we,$Fe)?"(".implode(",",$Fe[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$we)));}function
process_type($o,$lb="COLLATE"){global$Ki;return" $o[type]".process_length($o["length"]).(preg_match(number_type(),$o["type"])&&in_array($o["unsigned"],$Ki)?" $o[unsigned]":"").(preg_match('~char|text|enum|set~',$o["type"])&&$o["collation"]?" $lb ".q($o["collation"]):"");}function
process_field($o,$Ci){return
array(idf_escape(trim($o["field"])),process_type($Ci),($o["null"]?" NULL":" NOT NULL"),default_value($o),(preg_match('~timestamp|datetime~',$o["type"])&&$o["on_update"]?" ON UPDATE $o[on_update]":""),(support("comment")&&$o["comment"]!=""?" COMMENT ".q($o["comment"]):""),($o["auto_increment"]?auto_increment():null),);}function
default_value($o){$Yb=$o["default"];return($Yb===null?"":" DEFAULT ".(preg_match('~char|binary|text|enum|set~',$o["type"])||preg_match('~^(?![a-z])~i',$Yb)?q($Yb):$Yb));}function
type_class($T){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$z=>$X){if(preg_match("~$z|$X~",$T))return" class='$z'";}}function
edit_fields($p,$nb,$T="TABLE",$jd=array()){global$Vd;$p=array_values($p);$Zb=(($_POST?$_POST["defaults"]:adminer_setting("defaults"))?"":" class='hidden'");$ub=(($_POST?$_POST["comments"]:adminer_setting("comments"))?"":" class='hidden'");echo'<thead><tr>
';if($T=="PROCEDURE"){echo'<td>';}echo'<th id="label-name">',($T=="TABLE"?lang(104):lang(105)),'<td id="label-type">',lang(49),'<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">',lang(106),'<td>',lang(107);if($T=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="',lang(51),'">AI</acronym>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype.html#DATATYPE-SERIAL",'mssql'=>"ms186775.aspx",)),'<td id="label-default"',$Zb,'>',lang(52),(support("comment")?"<td id='label-comment'$ub>".lang(50):"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($p))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".lang(108)."'>".script("row_count = ".count($p).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($p
as$t=>$o){$t++;$Ff=$o[($_POST?"orig":"field")];$hc=(isset($_POST["add"][$t-1])||(isset($o["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$Ff=="");echo'<tr',($hc?"":" style='display: none;'"),'>
',($T=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$Vd),$o["inout"]):""),'<th>';if($hc){echo'<input name="fields[',$t,'][field]" value="',h($o["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';}echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($Ff),'">';edit_type("fields[$t]",$o,$nb,$jd);if($T=="TABLE"){echo'<td>',checkbox("fields[$t][null]",1,$o["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"';if($o["auto_increment"]){echo' checked';}echo' aria-labelledby="label-ai"></label><td',$Zb,'>',checkbox("fields[$t][has_default]",1,$o["has_default"],"","","","label-default"),'<input name="fields[',$t,'][default]" value="',h($o["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td$ub><input name='fields[$t][comment]' value='".h($o["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".lang(108)."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=4.8.1")."' alt='↑' title='".lang(109)."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=4.8.1")."' alt='↓' title='".lang(110)."'> ":""),($Ff==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.8.1")."' alt='x' title='".lang(111)."'>":"");}}function
process_fields(&$p){$kf=0;if($_POST["up"]){$qe=0;foreach($p
as$z=>$o){if(key($_POST["up"])==$z){unset($p[$z]);array_splice($p,$qe,0,array($o));break;}if(isset($o["field"]))$qe=$kf;$kf++;}}elseif($_POST["down"]){$ld=false;foreach($p
as$z=>$o){if(isset($o["field"])&&$ld){unset($p[key($_POST["down"])]);array_splice($p,$kf,0,array($ld));break;}if(key($_POST["down"])==$z)$ld=$o;$kf++;}}elseif($_POST["add"]){$p=array_values($p);array_splice($p,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($C){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($C[0][0].$C[0][0],$C[0][0],substr($C[0],1,-1))),'\\'))."'";}function
grant($qd,$sg,$e,$rf){if(!$sg)return
true;if($sg==array("ALL PRIVILEGES","GRANT OPTION"))return($qd=="GRANT"?queries("$qd ALL PRIVILEGES$rf WITH GRANT OPTION"):queries("$qd ALL PRIVILEGES$rf")&&queries("$qd GRANT OPTION$rf"));return
queries("$qd ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$e, ",$sg).$e).$rf);}function
drop_create($lc,$i,$mc,$di,$oc,$B,$Qe,$Oe,$Pe,$of,$bf){if($_POST["drop"])query_redirect($lc,$B,$Qe);elseif($of=="")query_redirect($i,$B,$Pe);elseif($of!=$bf){$Lb=queries($i);queries_redirect($B,$Oe,$Lb&&queries($lc));if($Lb)queries($mc);}else
queries_redirect($B,$Oe,queries($di)&&queries($oc)&&queries($lc)&&queries($i));}function
create_trigger($rf,$J){global$y;$ii=" $J[Timing] $J[Event]".(preg_match('~ OF~',$J["Event"])?" $J[Of]":"");return"CREATE TRIGGER ".idf_escape($J["Trigger"]).($y=="mssql"?$rf.$ii:$ii.$rf).rtrim(" $J[Type]\n$J[Statement]",";").";";}function
create_routine($Wg,$J){global$Vd,$y;$N=array();$p=(array)$J["fields"];ksort($p);foreach($p
as$o){if($o["field"]!="")$N[]=(preg_match("~^($Vd)\$~",$o["inout"])?"$o[inout] ":"").idf_escape($o["field"]).process_type($o,"CHARACTER SET");}$ac=rtrim("\n$J[definition]",";");return"CREATE $Wg ".idf_escape(trim($J["name"]))." (".implode(", ",$N).")".(isset($_GET["function"])?" RETURNS".process_type($J["returns"],"CHARACTER SET"):"").($J["language"]?" LANGUAGE $J[language]":"").($y=="pgsql"?" AS ".q($ac):"$ac;");}function
remove_definer($G){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$G);}function
format_foreign_key($r){global$sf;$l=$r["db"];$ff=$r["ns"];return" FOREIGN KEY (".implode(", ",array_map('idf_escape',$r["source"])).") REFERENCES ".($l!=""&&$l!=$_GET["db"]?idf_escape($l).".":"").($ff!=""&&$ff!=$_GET["ns"]?idf_escape($ff).".":"").table($r["table"])." (".implode(", ",array_map('idf_escape',$r["target"])).")".(preg_match("~^($sf)\$~",$r["on_delete"])?" ON DELETE $r[on_delete]":"").(preg_match("~^($sf)\$~",$r["on_update"])?" ON UPDATE $r[on_update]":"");}function
tar_file($q,$ni){$I=pack("a100a8a8a8a12a12",$q,644,0,0,decoct($ni->size),decoct(time()));$fb=8*32;for($t=0;$t<strlen($I);$t++)$fb+=ord($I[$t]);$I.=sprintf("%06o",$fb)."\0 ";echo$I,str_repeat("\0",512-strlen($I));$ni->send();echo
str_repeat("\0",511-($ni->size+511)%512);}function
ini_bytes($Ud){$X=ini_get($Ud);switch(strtolower(substr($X,-1))){case'g':$X*=1024;case'm':$X*=1024;case'k':$X*=1024;}return$X;}function
doc_link($bg,$ei="<sup>?</sup>"){global$y,$g;$nh=$g->server_info;$Zi=preg_replace('~^(\d\.?\d).*~s','\1',$nh);$Oi=array('sql'=>"https://dev.mysql.com/doc/refman/$Zi/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$Zi/",'mssql'=>"https://msdn.microsoft.com/library/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$nh)."&id=",);if(preg_match('~MariaDB~',$nh)){$Oi['sql']="https://mariadb.com/kb/en/library/";$bg['sql']=(isset($bg['mariadb'])?$bg['mariadb']:str_replace(".html","/",$bg['sql']));}return($bg[$y]?"<a href='".h($Oi[$y].$bg[$y])."'".target_blank().">$ei</a>":"");}function
ob_gzencode($P){return
gzencode($P);}function
db_size($l){global$g;if(!$g->select_db($l))return"?";$I=0;foreach(table_status()as$R)$I+=$R["Data_length"]+$R["Index_length"];return
format_number($I);}function
set_utf8mb4($i){global$g;static$N=false;if(!$N&&preg_match('~\butf8mb4~i',$i)){$N=true;echo"SET NAMES ".charset($g).";\n\n";}}function
connect_error(){global$b,$g,$qi,$n,$kc;if(DB!=""){header("HTTP/1.1 404 Not Found");page_header(lang(37).": ".h(DB),lang(112),true);}else{if($_POST["db"]&&!$n)queries_redirect(substr(ME,0,-1),lang(113),drop_databases($_POST["db"]));page_header(lang(114),$n,false);echo"<p class='links'>\n";foreach(array('database'=>lang(115),'privileges'=>lang(71),'processlist'=>lang(116),'variables'=>lang(117),'status'=>lang(118),)as$z=>$X){if(support($z))echo"<a href='".h(ME)."$z='>$X</a>\n";}echo"<p>".lang(119,$kc[DRIVER],"<b>".h($g->server_info)."</b>","<b>$g->extension</b>")."\n","<p>".lang(120,"<b>".h(logged_user())."</b>")."\n";$k=$b->databases();if($k){$dh=support("scheme");$nb=collations();echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".lang(37)." - <a href='".h(ME)."refresh=1'>".lang(121)."</a>"."<td>".lang(122)."<td>".lang(123)."<td>".lang(124)." - <a href='".h(ME)."dbsize=1'>".lang(125)."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$k=($_GET["dbsize"]?count_tables($k):array_flip($k));foreach($k
as$l=>$S){$Vg=h(ME)."db=".urlencode($l);$u=h("Db-".$l);echo"<tr".odd().">".(support("database")?"<td>".checkbox("db[]",$l,in_array($l,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$Vg' id='$u'>".h($l)."</a>";$mb=h(db_collation($l,$nb));echo"<td>".(support("database")?"<a href='$Vg".($dh?"&amp;ns=":"")."&amp;database=' title='".lang(67)."'>$mb</a>":$mb),"<td align='right'><a href='$Vg&amp;schema=' id='tables-".h($l)."' title='".lang(70)."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($l)."'>".($_GET["dbsize"]?db_size($l):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".lang(126)." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".lang(127)."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$qi'>\n","</form>\n",script("tableCheck();");}}page_footer("db");}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$g->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}connect_error();exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header(lang(77).": ".h($_GET["ns"]),lang(128),true);page_footer("ns");exit;}}}$sf="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($Eb){$this->size+=strlen($Eb);fwrite($this->handler,$Eb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}$Bc="'(?:''|[^'\\\\]|\\\\.)*'";$Vd="IN|OUT|INOUT";if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$p=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$m->select($a,$L,array(where($_GET,$p)),$L);$J=($H?$H->fetch_row():array());echo$m->value($J[0],$p[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$p=fields($a);if(!$p)$n=error();$R=table_status1($a,true);$D=$b->tableName($R);page_header(($p&&is_view($R)?$R['Engine']=='materialized view'?lang(129):lang(130):lang(131)).": ".($D!=""?$D:h($a)),$n);$b->selectLinks($R);$tb=$R["Comment"];if($tb!="")echo"<p class='nowrap'>".lang(50).": ".h($tb)."\n";if($p)$b->tableStructurePrint($p);if(!is_view($R)){if(support("indexes")){echo"<h3 id='indexes'>".lang(132)."</h3>\n";$x=indexes($a);if($x)$b->tableIndexesPrint($x);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.lang(133)."</a>\n";}if(fk_support($R)){echo"<h3 id='foreign-keys'>".lang(100)."</h3>\n";$jd=foreign_keys($a);if($jd){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(134)."<td>".lang(135)."<td>".lang(103)."<td>".lang(102)."<td></thead>\n";foreach($jd
as$D=>$r){echo"<tr title='".h($D)."'>","<th><i>".implode("</i>, <i>",array_map('h',$r["source"]))."</i>","<td><a href='".h($r["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($r["db"]),ME):($r["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($r["ns"]),ME):ME))."table=".urlencode($r["table"])."'>".($r["db"]!=""?"<b>".h($r["db"])."</b>.":"").($r["ns"]!=""?"<b>".h($r["ns"])."</b>.":"").h($r["table"])."</a>","(<i>".implode("</i>, <i>",array_map('h',$r["target"]))."</i>)","<td>".h($r["on_delete"])."\n","<td>".h($r["on_update"])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($D)).'">'.lang(136).'</a>';}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.lang(137)."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".lang(138)."</h3>\n";$Bi=triggers($a);if($Bi){echo"<table cellspacing='0'>\n";foreach($Bi
as$z=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($z)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($z))."'>".lang(136)."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.lang(139)."</a>\n";}}elseif(isset($_GET["schema"])){page_header(lang(70),"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Th=array();$Uh=array();$ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Fe,PREG_SET_ORDER);foreach($Fe
as$t=>$C){$Th[$C[1]]=array($C[2],$C[3]);$Uh[]="\n\t'".js_escape($C[1])."': [ $C[2], $C[3] ]";}$ri=0;$Qa=-1;$ch=array();$Hg=array();$ue=array();foreach(table_status('',true)as$Q=>$R){if(is_view($R))continue;$hg=0;$ch[$Q]["fields"]=array();foreach(fields($Q)as$D=>$o){$hg+=1.25;$o["pos"]=$hg;$ch[$Q]["fields"][$D]=$o;}$ch[$Q]["pos"]=($Th[$Q]?$Th[$Q]:array($ri,0));foreach($b->foreignKeys($Q)as$X){if(!$X["db"]){$se=$Qa;if($Th[$Q][1]||$Th[$X["table"]][1])$se=min(floatval($Th[$Q][1]),floatval($Th[$X["table"]][1]))-1;else$Qa-=.1;while($ue[(string)$se])$se-=.0001;$ch[$Q]["references"][$X["table"]][(string)$se]=array($X["source"],$X["target"]);$Hg[$X["table"]][$Q][(string)$se]=$X["target"];$ue[(string)$se]=true;}}$ri=max($ri,$ch[$Q]["pos"][0]+2.5+$hg);}echo'<div id="schema" style="height: ',$ri,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Uh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$ri,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($ch
as$D=>$Q){echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($D).'"><b>'.h($D)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($Q["fields"]as$o){$X='<span'.type_class($o["type"]).' title="'.h($o["full_type"].($o["null"]?" NULL":'')).'">'.h($o["field"]).'</span>';echo"<br>".($o["primary"]?"<i>$X</i>":$X);}foreach((array)$Q["references"]as$ai=>$Ig){foreach($Ig
as$se=>$Eg){$te=$se-$Th[$D][1];$t=0;foreach($Eg[0]as$yh)echo"\n<div class='references' title='".h($ai)."' id='refs$se-".($t++)."' style='left: $te"."em; top: ".$Q["fields"][$yh]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$te)."em;'></div></div>";}}foreach((array)$Hg[$D]as$ai=>$Ig){foreach($Ig
as$se=>$e){$te=$se-$Th[$D][1];$t=0;foreach($e
as$Zh)echo"\n<div class='references' title='".h($ai)."' id='refd$se-".($t++)."' style='left: $te"."em; top: ".$Q["fields"][$Zh]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=4.8.1")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$te)."em;'></div></div>";}}echo"\n</div>\n";}foreach($ch
as$D=>$Q){foreach((array)$Q["references"]as$ai=>$Ig){foreach($Ig
as$se=>$Eg){$Te=$ri;$Je=-10;foreach($Eg[0]as$z=>$yh){$ig=$Q["pos"][0]+$Q["fields"][$yh]["pos"];$jg=$ch[$ai]["pos"][0]+$ch[$ai]["fields"][$Eg[1][$z]]["pos"];$Te=min($Te,$ig,$jg);$Je=max($Je,$ig,$jg);}echo"<div class='references' id='refl$se' style='left: $se"."em; top: $Te"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Je-$Te)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">',lang(140),'</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$n){$Hb="";foreach(array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$z)$Hb.="&$z=".urlencode($_POST[$z]);cookie("adminer_export",substr($Hb,1));$S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Oc=dump_headers((count($S)==1?key($S):DB),(DB==""||count($S)>1));$de=preg_match('~sql~',$_POST["format"]);if($de){echo"-- Adminer $ia ".$kc[DRIVER]." ".str_replace("\n"," ",$g->server_info)." dump\n\n";if($y=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$g->query("SET time_zone = '+00:00'");$g->query("SET sql_mode = ''");}}$Kh=$_POST["db_style"];$k=array(DB);if(DB==""){$k=$_POST["databases"];if(is_string($k))$k=explode("\n",rtrim(str_replace("\r","",$k),"\n"));}foreach((array)$k
as$l){$b->dumpDatabase($l);if($g->select_db($l)){if($de&&preg_match('~CREATE~',$Kh)&&($i=$g->result("SHOW CREATE DATABASE ".idf_escape($l),1))){set_utf8mb4($i);if($Kh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($l).";\n";echo"$i;\n";}if($de){if($Kh)echo
use_sql($l).";\n\n";$Lf="";if($_POST["routines"]){foreach(array("FUNCTION","PROCEDURE")as$Wg){foreach(get_rows("SHOW $Wg STATUS WHERE Db = ".q($l),null,"-- ")as$J){$i=remove_definer($g->result("SHOW CREATE $Wg ".idf_escape($J["Name"]),2));set_utf8mb4($i);$Lf.=($Kh!='DROP+CREATE'?"DROP $Wg IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$i;;\n\n";}}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$J){$i=remove_definer($g->result("SHOW CREATE EVENT ".idf_escape($J["Name"]),3));set_utf8mb4($i);$Lf.=($Kh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$i;;\n\n";}}if($Lf)echo"DELIMITER ;;\n\n$Lf"."DELIMITER ;\n\n";}if($_POST["table_style"]||$_POST["data_style"]){$bj=array();foreach(table_status('',true)as$D=>$R){$Q=(DB==""||in_array($D,(array)$_POST["tables"]));$Rb=(DB==""||in_array($D,(array)$_POST["data"]));if($Q||$Rb){if($Oc=="tar"){$ni=new
TmpFile;ob_start(array($ni,'write'),1e5);}$b->dumpTable($D,($Q?$_POST["table_style"]:""),(is_view($R)?2:0));if(is_view($R))$bj[]=$D;elseif($Rb){$p=fields($D);$b->dumpData($D,$_POST["data_style"],"SELECT *".convert_fields($p,$p)." FROM ".table($D));}if($de&&$_POST["triggers"]&&$Q&&($Bi=trigger_sql($D)))echo"\nDELIMITER ;;\n$Bi\nDELIMITER ;\n";if($Oc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$l/")."$D.csv",$ni);}elseif($de)echo"\n";}}if(function_exists('foreign_keys_sql')){foreach(table_status('',true)as$D=>$R){$Q=(DB==""||in_array($D,(array)$_POST["tables"]));if($Q&&!is_view($R))echo
foreign_keys_sql($D);}}foreach($bj
as$aj)$b->dumpTable($aj,$_POST["table_style"],1);if($Oc=="tar")echo
pack("x512");}}}if($de)echo"-- ".$g->result("SELECT NOW()")."\n";exit;}page_header(lang(73),$n,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
';$Vb=array('','USE','DROP+CREATE','CREATE');$Vh=array('','DROP+CREATE','CREATE');$Sb=array('','TRUNCATE+INSERT','INSERT');if($y=="sql")$Sb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$J);if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".lang(141)."<td>".html_select("output",$b->dumpOutput(),$J["output"],0)."\n";echo"<tr><th>".lang(142)."<td>".html_select("format",$b->dumpFormat(),$J["format"],0)."\n";echo($y=="sqlite"?"":"<tr><th>".lang(37)."<td>".html_select('db_style',$Vb,$J["db_style"]).(support("routine")?checkbox("routines",1,$J["routines"],lang(143)):"").(support("event")?checkbox("events",1,$J["events"],lang(144)):"")),"<tr><th>".lang(123)."<td>".html_select('table_style',$Vh,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],lang(51)).(support("trigger")?checkbox("triggers",1,$J["triggers"],lang(138)):""),"<tr><th>".lang(145)."<td>".html_select('data_style',$Sb,$J["data_style"]),'</table>
<p><input type="submit" value="',lang(73),'">
<input type="hidden" name="token" value="',$qi,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");$mg=array();if(DB!=""){$db=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$db>".lang(123)."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".lang(145)."<input type='checkbox' id='check-data'$db></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$bj="";$Wh=tables_list();foreach($Wh
as$D=>$T){$lg=preg_replace('~_.*~','',$D);$db=($a==""||$a==(substr($a,-1)=="%"?"$lg%":$D));$pg="<tr><td>".checkbox("tables[]",$D,$db,$D,"","block");if($T!==null&&!preg_match('~table~i',$T))$bj.="$pg\n";else
echo"$pg<td align='right'><label class='block'><span id='Rows-".h($D)."'></span>".checkbox("data[]",$D,$db)."</label>\n";$mg[$lg]++;}echo$bj;if($Wh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".lang(37)."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$k=$b->databases();if($k){foreach($k
as$l){if(!information_schema($l)){$lg=preg_replace('~_.*~','',$l);echo"<tr><td>".checkbox("databases[]",$l,$a==""||$a=="$lg%",$l,"","block")."\n";$mg[$lg]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$bd=true;foreach($mg
as$z=>$X){if($z!=""&&$X>1){echo($bd?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$z%")."'>".h($z)."</a>";$bd=false;}}}elseif(isset($_GET["privileges"])){page_header(lang(71));echo'<p class="links"><a href="'.h(ME).'user=">'.lang(146)."</a>";$H=$g->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$qd=$H;if(!$H)$H=$g->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($qd?"":"<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>".lang(35)."<th>".lang(34)."<th></thead>\n";while($J=$H->fetch_assoc())echo'<tr'.odd().'><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.lang(10)."</a>\n";if(!$qd||DB!="")echo"<tr".odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".lang(10)."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$n&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$Dd=&get_session("queries");$Cd=&$Dd[DB];if(!$n&&$_POST["clear"]){$Cd=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?lang(72):lang(64)),$n);if(!$n&&$_POST){$nd=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$Bh=$b->importServerPath();$nd=@fopen((file_exists($Bh)?$Bh:"compress.zlib://$Bh.gz"),"rb");$G=($nd?fread($nd,1e6):false);}else$G=get_file("sql_file",true);if(is_string($G)){if(function_exists('memory_get_usage'))@ini_set("memory_limit",max(ini_bytes("memory_limit"),2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$xg=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$Cd||reset(end($Cd))!=$xg){restart_session();$Cd[]=array($xg,time());set_session("queries",$Dd);stop_session();}}$zh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$cc=";";$kf=0;$zc=true;$h=connect();if(is_object($h)&&DB!=""){$h->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$h);}$sb=0;$Dc=array();$Sf='[\'"'.($y=="sql"?'`#':($y=="sqlite"?'`[':($y=="mssql"?'[':''))).']|/\*|-- |$'.($y=="pgsql"?'|\$[^$]*\$':'');$si=microtime(true);parse_str($_COOKIE["adminer_export"],$ya);$qc=$b->dumpFormat();unset($qc["sql"]);while($G!=""){if(!$kf&&preg_match("~^$zh*+DELIMITER\\s+(\\S+)~i",$G,$C)){$cc=$C[1];$G=substr($G,strlen($C[0]));}else{preg_match('('.preg_quote($cc)."\\s*|$Sf)",$G,$C,PREG_OFFSET_CAPTURE,$kf);list($ld,$hg)=$C[0];if(!$ld&&$nd&&!feof($nd))$G.=fread($nd,1e5);else{if(!$ld&&rtrim($G)=="")break;$kf=$hg+strlen($ld);if($ld&&rtrim($ld)!=$cc){while(preg_match('('.($ld=='/*'?'\*/':($ld=='['?']':(preg_match('~^-- |^#~',$ld)?"\n":preg_quote($ld)."|\\\\."))).'|$)s',$G,$C,PREG_OFFSET_CAPTURE,$kf)){$ah=$C[0][0];if(!$ah&&$nd&&!feof($nd))$G.=fread($nd,1e5);else{$kf=$C[0][1]+strlen($ah);if($ah[0]!="\\")break;}}}else{$zc=false;$xg=substr($G,0,$hg);$sb++;$pg="<pre id='sql-$sb'><code class='jush-$y'>".$b->sqlCommandQuery($xg)."</code></pre>\n";if($y=="sqlite"&&preg_match("~^$zh*+ATTACH\\b~i",$xg,$C)){echo$pg,"<p class='error'>".lang(147)."\n";$Dc[]=" <a href='#sql-$sb'>$sb</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$pg;ob_flush();flush();}$Fh=microtime(true);if($g->multi_query($xg)&&is_object($h)&&preg_match("~^$zh*+USE\\b~i",$xg))$h->query($xg);do{$H=$g->store_result();if($g->error){echo($_POST["only_errors"]?$pg:""),"<p class='error'>".lang(148).($g->errno?" ($g->errno)":"").": ".error()."\n";$Dc[]=" <a href='#sql-$sb'>$sb</a>";if($_POST["error_stops"])break
2;}else{$gi=" <span class='time'>(".format_time($Fh).")</span>".(strlen($xg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($xg))."'>".lang(10)."</a>":"");$_a=$g->affected_rows;$ej=($_POST["only_errors"]?"":$m->warnings());$fj="warnings-$sb";if($ej)$gi.=", <a href='#$fj'>".lang(46)."</a>".script("qsl('a').onclick = partial(toggle, '$fj');","");$Lc=null;$Mc="explain-$sb";if(is_object($H)){$_=$_POST["limit"];$Ef=select($H,$h,array(),$_);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$gf=$H->num_rows;echo"<p>".($gf?($_&&$gf>$_?lang(149,$_):"").lang(150,$gf):""),$gi;if($h&&preg_match("~^($zh|\\()*+SELECT\\b~i",$xg)&&($Lc=explain($h,$xg)))echo", <a href='#$Mc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Mc');","");$u="export-$sb";echo", <a href='#$u'>".lang(73)."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$ya["output"])." ".html_select("format",$qc,$ya["format"])."<input type='hidden' name='query' value='".h($xg)."'>"." <input type='submit' name='export' value='".lang(73)."'><input type='hidden' name='token' value='$qi'></span>\n"."</form>\n";}}else{if(preg_match("~^$zh*+(CREATE|DROP|ALTER)$zh++(DATABASE|SCHEMA)\\b~i",$xg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($g->info)."'>".lang(151,$_a)."$gi\n";}echo($ej?"<div id='$fj' class='hidden'>\n$ej</div>\n":"");if($Lc){echo"<div id='$Mc' class='hidden'>\n";select($Lc,$h,$Ef);echo"</div>\n";}}$Fh=microtime(true);}while($g->next_result());}$G=substr($G,$kf);$kf=0;}}}}if($zc)echo"<p class='message'>".lang(152)."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".lang(153,$sb-count($Dc))," <span class='time'>(".format_time($si).")</span>\n";}elseif($Dc&&$sb>1)echo"<p class='error'>".lang(148).": ".implode("",$Dc)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Jc="<input type='submit' value='".lang(154)."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$xg=$_GET["sql"];if($_POST)$xg=$_POST["query"];elseif($_GET["history"]=="all")$xg=$Cd;elseif($_GET["history"]!="")$xg=$Cd[$_GET["history"]][0];echo"<p>";textarea("query",$xg,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>$Jc\n",lang(155).": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".lang(156)."</legend><div>";$wd=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$wd (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Jc":lang(157)),"</div></fieldset>\n";$Kd=$b->importServerPath();if($Kd){echo"<fieldset><legend>".lang(158)."</legend><div>",lang(159,"<code>".h($Kd)."$wd</code>"),' <input type="submit" name="webfile" value="'.lang(160).'">',"</div></fieldset>\n";}echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),lang(161))."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),lang(162))."\n","<input type='hidden' name='token' value='$qi'>\n";if(!isset($_GET["import"])&&$Cd){print_fieldset("history",lang(163),$_GET["history"]!="");for($X=end($Cd);$X;$X=prev($Cd)){$z=key($Cd);list($xg,$gi,$uc)=$X;echo'<a href="'.h(ME."sql=&history=$z").'">'.lang(10)."</a>"." <span class='time' title='".@date('Y-m-d',$gi)."'>".@date("H:i:s",$gi)."</span>"." <code class='jush-$y'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$xg)))),80,"</code>").($uc?" <span class='time'>($uc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".lang(164)."'>\n","<a href='".h(ME."sql=&history=all")."'>".lang(165)."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$p=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$p):""):where($_GET,$p));$Li=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($p
as$D=>$o){if(!isset($o["privileges"][$Li?"update":"insert"])||$b->fieldName($o)==""||$o["generated"])unset($p[$D]);}if($_POST&&!$n&&!isset($_GET["select"])){$B=$_POST["referer"];if($_POST["insert"])$B=($Li?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$B))$B=ME."select=".urlencode($a);$x=indexes($a);$Gi=unique_array($_GET["where"],$x);$_g="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($B,lang(166),$m->delete($a,$_g,!$Gi));else{$N=array();foreach($p
as$D=>$o){$X=process_input($o);if($X!==false&&$X!==null)$N[idf_escape($D)]=$X;}if($Li){if(!$N)redirect($B);queries_redirect($B,lang(167),$m->update($a,$N,$_g,!$Gi));if(is_ajax()){page_headers();page_messages($n);exit;}}else{$H=$m->insert($a,$N);$re=($H?last_id():0);queries_redirect($B,lang(168,($re?" $re":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($p
as$D=>$o){if(isset($o["privileges"]["select"])){$Ga=convert_field($o);if($_POST["clone"]&&$o["auto_increment"])$Ga="''";if($y=="sql"&&preg_match("~enum|set~",$o["type"]))$Ga="1*".idf_escape($D);$L[]=($Ga?"$Ga AS ":"").idf_escape($D);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$m->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$n=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$p){if(!$Z){$H=$m->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($m->primary=>"");}if($J){foreach($J
as$z=>$X){if(!$Z)$J[$z]=null;$p[$z]=array("field"=>$z,"null"=>($z!=$m->primary),"auto_increment"=>($z==$m->primary));}}}edit_form($a,$p,$J,$Li);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Uf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$z)$Uf[$z]=$z;$Gg=referencable_primary($a);$jd=array();foreach($Gg
as$Rh=>$o)$jd[str_replace("`","``",$Rh)."`".str_replace("`","``",$o["field"])]=$Rh;$Hf=array();$R=array();if($a!=""){$Hf=fields($a);$R=table_status($a);if(!$R)$n=lang(9);}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST)set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($J["fields"])&&!$n){if($_POST["drop"])queries_redirect(substr(ME,0,-1),lang(169),drop_tables(array($a)));else{$p=array();$Da=array();$Pi=false;$hd=array();$Gf=reset($Hf);$Ba=" FIRST";foreach($J["fields"]as$z=>$o){$r=$jd[$o["type"]];$Ci=($r!==null?$Gg[$r]:$o);if($o["field"]!=""){if(!$o["has_default"])$o["default"]=null;if($z==$J["auto_increment_col"])$o["auto_increment"]=true;$ug=process_field($o,$Ci);$Da[]=array($o["orig"],$ug,$Ba);if(!$Gf||$ug!=process_field($Gf,$Gf)){$p[]=array($o["orig"],$ug,$Ba);if($o["orig"]!=""||$Ba)$Pi=true;}if($r!==null)$hd[idf_escape($o["field"])]=($a!=""&&$y!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$jd[$o["type"]],'source'=>array($o["field"]),'target'=>array($Ci["field"]),'on_delete'=>$o["on_delete"],));$Ba=" AFTER ".idf_escape($o["field"]);}elseif($o["orig"]!=""){$Pi=true;$p[]=array($o["orig"]);}if($o["orig"]!=""){$Gf=next($Hf);if(!$Gf)$Ba="";}}$Wf="";if($Uf[$J["partition_by"]]){$Xf=array();if($J["partition_by"]=='RANGE'||$J["partition_by"]=='LIST'){foreach(array_filter($J["partition_names"])as$z=>$X){$Y=$J["partition_values"][$z];$Xf[]="\n  PARTITION ".idf_escape($X)." VALUES ".($J["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Wf.="\nPARTITION BY $J[partition_by]($J[partition])".($Xf?" (".implode(",",$Xf)."\n)":($J["partitions"]?" PARTITIONS ".(+$J["partitions"]):""));}elseif(support("partitioning")&&preg_match("~partitioned~",$R["Create_options"]))$Wf.="\nREMOVE PARTITIONING";$Ne=lang(170);if($a==""){cookie("adminer_engine",$J["Engine"]);$Ne=lang(171);}$D=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($D),$Ne,alter_table($a,$D,($y=="sqlite"&&($Pi||$hd)?$Da:$p),$hd,($J["Comment"]!=$R["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$R["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$R["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$Wf));}}page_header(($a!=""?lang(44):lang(74)),$n,array("table"=>$a),h($a));if(!$_POST){$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($U["int"])?"int":(isset($U["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$R;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($Hf
as$o){$o["has_default"]=isset($o["default"]);$J["fields"][]=$o;}if(support("partitioning")){$od="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($a);$H=$g->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $od ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");list($J["partition_by"],$J["partitions"],$J["partition"])=$H->fetch_row();$Xf=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $od AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$Xf[""]="";$J["partition_names"]=array_keys($Xf);$J["partition_values"]=array_values($Xf);}}}$nb=collations();$Ac=engines();foreach($Ac
as$_c){if(!strcasecmp($_c,$J["Engine"])){$J["Engine"]=$_c;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo
lang(172),': <input name="name" data-maxlength="64" value="',h($J["name"]),'" autocapitalize="off">
';if($a==""&&!$_POST)echo
script("focus(qs('#form')['name']);");echo($Ac?"<select name='Engine'>".optionlist(array(""=>"(".lang(173).")")+$Ac,$J["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($nb&&!preg_match("~sqlite|mssql~",$y)?html_select("Collation",array(""=>"(".lang(101).")")+$nb,$J["Collation"]):""),' <input type="submit" value="',lang(14),'">
';}echo'
';if(support("columns")){echo'<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';edit_fields($J["fields"],$nb,"TABLE",$jd);echo'</table>
',script("editFields();"),'</div>
<p>
',lang(51),': <input type="number" name="Auto_increment" size="6" value="',h($J["Auto_increment"]),'">
',checkbox("defaults",1,($_POST?$_POST["defaults"]:adminer_setting("defaults")),lang(174),"columnShow(this.checked, 5)","jsonly"),(support("comment")?checkbox("comments",1,($_POST?$_POST["comments"]:adminer_setting("comments")),lang(50),"editingCommentsClick(this, true);","jsonly").' <input name="Comment" value="'.h($J["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'">':''),'<p>
<input type="submit" value="',lang(14),'">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$a));}if(support("partitioning")){$Vf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",lang(176),$J["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Uf,$J["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($J["partition"]),'">)
',lang(177),': <input type="number" name="partitions" class="size',($Vf||!$J["partition_by"]?" hidden":""),'" value="',h($J["partitions"]),'">
<table cellspacing="0" id="partition-table"',($Vf?"":" class='hidden'"),'>
<thead><tr><th>',lang(178),'<th>',lang(179),'</thead>
';foreach($J["partition_names"]as$z=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($z==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$z]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Nd=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Nd[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Nd[]="SPATIAL";$x=indexes($a);$ng=array();if($y=="mongo"){$ng=$x["_id_"];unset($Nd[0]);unset($x["_id_"]);}$J=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$w){$D=$w["name"];if(in_array($w["type"],$Nd)){$e=array();$xe=array();$ec=array();$N=array();ksort($w["columns"]);foreach($w["columns"]as$z=>$d){if($d!=""){$we=$w["lengths"][$z];$dc=$w["descs"][$z];$N[]=idf_escape($d).($we?"(".(+$we).")":"").($dc?" DESC":"");$e[]=$d;$xe[]=($we?$we:null);$ec[]=$dc;}}if($e){$Kc=$x[$D];if($Kc){ksort($Kc["columns"]);ksort($Kc["lengths"]);ksort($Kc["descs"]);if($w["type"]==$Kc["type"]&&array_values($Kc["columns"])===$e&&(!$Kc["lengths"]||array_values($Kc["lengths"])===$xe)&&array_values($Kc["descs"])===$ec){unset($x[$D]);continue;}}$c[]=array($w["type"],$D,$N);}}}foreach($x
as$D=>$Kc)$c[]=array($Kc["type"],$D,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),lang(180),alter_indexes($a,$c));}page_header(lang(132),$n,array("table"=>$a),h($a));$p=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$z=>$w){if($w["columns"][count($w["columns"])]!="")$J["indexes"][$z]["columns"][]="";}$w=end($J["indexes"]);if($w["type"]||array_filter($w["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($x
as$z=>$w){$x[$z]["name"]=$z;$x[$z]["columns"][]="";}$x[]=array("columns"=>array(1=>""));$J["indexes"]=$x;}echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">',lang(181),'<th><input type="submit" class="wayoff">',lang(182),'<th id="label-name">',lang(183),'<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".lang(108)."'>",'</noscript>
</thead>
';if($ng){echo"<tr><td>PRIMARY<td>";foreach($ng["columns"]as$z=>$d){echo
select_input(" disabled",$p,$d),"<label><input disabled type='checkbox'>".lang(59)."</label> ";}echo"<td><td>\n";}$ge=1;foreach($J["indexes"]as$w){if(!$_POST["drop_col"]||$ge!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ge][type]",array(-1=>"")+$Nd,$w["type"],($ge==count($J["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($w["columns"]);$t=1;foreach($w["columns"]as$z=>$d){echo"<span>".select_input(" name='indexes[$ge][columns][$t]' title='".lang(48)."'",($p?array_combine($p,$p):$p),$d,"partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($y=="sql"?"":$_GET["indexes"]."_")."')"),($y=="sql"||$y=="mssql"?"<input type='number' name='indexes[$ge][lengths][$t]' class='size' value='".h($w["lengths"][$z])."' title='".lang(106)."'>":""),(support("descidx")?checkbox("indexes[$ge][descs][$t]",1,$w["descs"][$z],lang(59)):"")," </span>";$t++;}echo"<td><input name='indexes[$ge][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$ge]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.8.1")."' alt='x' title='".lang(111)."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ge++;}echo'</table>
</div>
<p>
<input type="submit" value="',lang(14),'">
<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$n&&!isset($_POST["add_x"])){$D=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),lang(184),drop_databases(array(DB)));}elseif(DB!==$D){if(DB!=""){$_GET["db"]=$D;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($D),lang(185),rename_database($D,$J["collation"]));}else{$k=explode("\n",str_replace("\r","",$D));$Lh=true;$qe="";foreach($k
as$l){if(count($k)==1||$l!=""){if(!create_database($l,$J["collation"]))$Lh=false;$qe=$l;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($qe),lang(186),$Lh);}}else{if(!$J["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($D).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),lang(187));}}page_header(DB!=""?lang(67):lang(115),$n,array(),h(DB));$nb=collations();$D=DB;if($_POST)$D=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$nb);elseif($y=="sql"){foreach(get_vals("SHOW GRANTS")as$qd){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$qd,$C)&&$C[1]){$D=stripcslashes(idf_unescape("`$C[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($D,"\n")?'<textarea id="name" name="name" rows="10" cols="40">'.h($D).'</textarea><br>':'<input name="name" id="name" value="'.h($D).'" data-maxlength="64" autocapitalize="off">')."\n".($nb?html_select("collation",array(""=>"(".lang(101).")")+$nb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"ms187963.aspx",)):""),script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';if(DB!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.8.1")."' alt='+' title='".lang(108)."'>\n";echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$n){$A=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$A,lang(188));else{$D=trim($J["name"]);$A.=urlencode($D);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($D),$A,lang(189));elseif($_GET["ns"]!=$D)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($D),$A,lang(190));else
redirect($A);}}page_header($_GET["ns"]!=""?lang(68):lang(69),$n);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" id="name" value="',h($J["name"]),'" autocapitalize="off">
',script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?$_GET["name"]:$_GET["call"]);page_header(lang(191).": ".h($da),$n);$Wg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Ld=array();$Lf=array();foreach($Wg["fields"]as$t=>$o){if(substr($o["inout"],-3)=="OUT")$Lf[$t]="@".idf_escape($o["field"])." AS ".idf_escape($o["field"]);if(!$o["inout"]||substr($o["inout"],0,2)=="IN")$Ld[]=$t;}if(!$n&&$_POST){$Ya=array();foreach($Wg["fields"]as$z=>$o){if(in_array($z,$Ld)){$X=process_input($o);if($X===false)$X="''";if(isset($Lf[$z]))$g->query("SET @".idf_escape($o["field"])." = $X");}$Ya[]=(isset($Lf[$z])?"@".idf_escape($o["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Ya).")";$Fh=microtime(true);$H=$g->multi_query($G);$_a=$g->affected_rows;echo$b->selectQuery($G,$Fh,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$h=connect();if(is_object($h))$h->select_db(DB);do{$H=$g->store_result();if(is_object($H))select($H,$h);else
echo"<p class='message'>".lang(192,$_a)." <span class='time'>".@date("H:i:s")."</span>\n";}while($g->next_result());if($Lf)select($g->query("SELECT ".implode(", ",$Lf)));}}echo'
<form action="" method="post">
';if($Ld){echo"<table cellspacing='0' class='layout'>\n";foreach($Ld
as$z){$o=$Wg["fields"][$z];$D=$o["field"];echo"<tr><th>".$b->fieldName($o);$Y=$_POST["fields"][$D];if($Y!=""){if($o["type"]=="enum")$Y=+$Y;if($o["type"]=="set")$Y=array_sum($Y);}input($o,$Y,(string)$_POST["function"][$D]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="',lang(191),'">
<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$D=$_GET["name"];$J=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){$Ne=($_POST["drop"]?lang(193):($D!=""?lang(194):lang(195)));$B=ME."table=".urlencode($a);if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$Zh=array();foreach($J["source"]as$z=>$X)$Zh[$z]=$J["target"][$z];$J["target"]=$Zh;}if($y=="sqlite")queries_redirect($B,$Ne,recreate_table($a,$a,array(),array(),array(" $D"=>($_POST["drop"]?"":" ".format_foreign_key($J)))));else{$c="ALTER TABLE ".table($a);$lc="\nDROP ".($y=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($D);if($_POST["drop"])query_redirect($c.$lc,$B,$Ne);else{query_redirect($c.($D!=""?"$lc,":"")."\nADD".format_foreign_key($J),$B,$Ne);$n=lang(196)."<br>$n";}}}page_header(lang(197),$n,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($D!=""){$jd=foreign_keys($a);$J=$jd[$D];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}echo'
<form action="" method="post">
';$yh=array_keys(fields($a));if($J["db"]!="")$g->select_db($J["db"]);if($J["ns"]!="")set_schema($J["ns"]);$Fg=array_keys(array_filter(table_status('',true),'fk_support'));$Zh=array_keys(fields(in_array($J["table"],$Fg)?$J["table"]:reset($Fg)));$tf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".lang(198).": ".html_select("table",$Fg,$J["table"],$tf)."\n";if($y=="pgsql")echo
lang(77).": ".html_select("ns",$b->schemas(),$J["ns"]!=""?$J["ns"]:$_GET["ns"],$tf);elseif($y!="sqlite"){$Wb=array();foreach($b->databases()as$l){if(!information_schema($l))$Wb[]=$l;}echo
lang(76).": ".html_select("db",$Wb,$J["db"]!=""?$J["db"]:$_GET["db"],$tf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="',lang(199),'"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">',lang(134),'<th id="label-target">',lang(135),'</thead>
';$ge=0;foreach($J["source"]as$z=>$X){echo"<tr>","<td>".html_select("source[".(+$z)."]",array(-1=>"")+$yh,$X,($ge==count($J["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$z)."]",$Zh,$J["target"][$z],1,"label-target");$ge++;}echo'</table>
<p>
',lang(103),': ',html_select("on_delete",array(-1=>"")+explode("|",$sf),$J["on_delete"]),' ',lang(102),': ',html_select("on_update",array(-1=>"")+explode("|",$sf),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"ms174979.aspx",'oracle'=>"https://docs.oracle.com/cd/B19306_01/server.102/b14200/clauses002.htm#sthref2903",)),'<p>
<input type="submit" value="',lang(14),'">
<noscript><p><input type="submit" name="add" value="',lang(200),'"></noscript>
';if($D!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$D));}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$If="VIEW";if($y=="pgsql"&&$a!=""){$O=table_status($a);$If=strtoupper($O["Engine"]);}if($_POST&&!$n){$D=trim($J["name"]);$Ga=" AS\n$J[select]";$B=ME."table=".urlencode($D);$Ne=lang(201);$T=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$D&&$y!="sqlite"&&$T=="VIEW"&&$If=="VIEW")query_redirect(($y=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($D).$Ga,$B,$Ne);else{$bi=$D."_adminer_".uniqid();drop_create("DROP $If ".table($a),"CREATE $T ".table($D).$Ga,"DROP $T ".table($D),"CREATE $T ".table($bi).$Ga,"DROP $T ".table($bi),($_POST["drop"]?substr(ME,0,-1):$B),lang(202),$Ne,lang(203),$a,$D);}}if(!$_POST&&$a!=""){$J=view($a);$J["name"]=$a;$J["materialized"]=($If!="VIEW");if(!$n)$n=error();}page_header(($a!=""?lang(43):lang(204)),$n,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>',lang(183),': <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],lang(129)):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($a!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$a));}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Yd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Hh=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$n){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),lang(205));elseif(in_array($J["INTERVAL_FIELD"],$Yd)&&isset($Hh[$J["STATUS"]])){$bh="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?lang(206):lang(207)),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$bh.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$bh)."\n".$Hh[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?lang(208).": ".h($aa):lang(209)),$n);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(183),'<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">',lang(210),'<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">',lang(211),'<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>',lang(212),'<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Yd,$J["INTERVAL_FIELD"]),'<tr><th>',lang(118),'<td>',html_select("STATUS",$Hh,$J["STATUS"]),'<tr><th>',lang(50),'<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",lang(213)),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($aa!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$aa));}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);$Wg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$n){$Ff=routine($_GET["procedure"],$Wg);$bi="$J[name]_adminer_".uniqid();drop_create("DROP $Wg ".routine_id($da,$Ff),create_routine($Wg,$J),"DROP $Wg ".routine_id($J["name"],$J),create_routine($Wg,array("name"=>$bi)+$J),"DROP $Wg ".routine_id($bi,$J),substr(ME,0,-1),lang(214),lang(215),lang(216),$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?lang(217):lang(218)).": ".h($da):(isset($_GET["function"])?lang(219):lang(220))),$n);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Wg);$J["name"]=$da;}$nb=get_vals("SHOW CHARACTER SET");sort($nb);$Xg=routine_languages();echo'
<form action="" method="post" id="form">
<p>',lang(183),': <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',($Xg?lang(19).": ".html_select("language",$Xg,$J["language"])."\n":""),'<input type="submit" value="',lang(14),'">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';edit_fields($J["fields"],$nb,$Wg);if(isset($_GET["function"])){echo"<tr><td>".lang(221);edit_type("returns",$J["returns"],$nb,array(),($y=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($da!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$da));}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$J=$_POST;if($_POST&&!$n){$A=substr(ME,0,-1);$D=trim($J["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$A,lang(222));elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($D),$A,lang(223));elseif($fa!=$D)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($D),$A,lang(224));else
redirect($A);}page_header($fa!=""?lang(225).": ".h($fa):lang(226),$n);if(!$J)$J["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="',lang(14),'">
';if($fa!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,$fa))."\n";echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$J=$_POST;if($_POST&&!$n){$A=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$A,lang(227));else
query_redirect("CREATE TYPE ".idf_escape(trim($J["name"]))." $J[as]",$A,lang(228));}page_header($ga!=""?lang(229).": ".h($ga):lang(230),$n);if(!$J)$J["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,$ga))."\n";else{echo"<input name='name' value='".h($J['name'])."' autocapitalize='off'>\n";textarea("as",$J["as"]);echo"<p><input type='submit' value='".lang(14)."'>\n";}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$D=$_GET["name"];$Ai=trigger_options();$J=(array)trigger($D,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$n&&in_array($_POST["Timing"],$Ai["Timing"])&&in_array($_POST["Event"],$Ai["Event"])&&in_array($_POST["Type"],$Ai["Type"])){$rf=" ON ".table($a);$lc="DROP TRIGGER ".idf_escape($D).($y=="pgsql"?$rf:"");$B=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($lc,$B,lang(231));else{if($D!="")queries($lc);queries_redirect($B,($D!=""?lang(232):lang(233)),queries(create_trigger($rf,$_POST)));if($D!="")queries(create_trigger($rf,$J+array("Type"=>reset($Ai["Type"]))));}}$J=$_POST;}page_header(($D!=""?lang(234).": ".h($D):lang(235)),$n,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>',lang(236),'<td>',html_select("Timing",$Ai["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>',lang(237),'<td>',html_select("Event",$Ai["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$Ai["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>',lang(49),'<td>',html_select("Type",$Ai["Type"],$J["Type"]),'</table>
<p>',lang(183),': <input name="Trigger" value="',h($J["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($D!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$D));}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$sg=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$Fb)$sg[$Fb][$J["Privilege"]]=$J["Comment"];}$sg["Server Admin"]+=$sg["File access on server"];$sg["Databases"]["Create routine"]=$sg["Procedures"]["Create routine"];unset($sg["Procedures"]["Create routine"]);$sg["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$sg["Columns"][$X]=$sg["Tables"][$X];unset($sg["Server Admin"]["Usage"]);foreach($sg["Tables"]as$z=>$X)unset($sg["Databases"][$z]);$af=array();if($_POST){foreach($_POST["objects"]as$z=>$X)$af[$X]=(array)$af[$X]+(array)$_POST["grants"][$z];}$rd=array();$pf="";if(isset($_GET["host"])&&($H=$g->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$C)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$C[1],$Fe,PREG_SET_ORDER)){foreach($Fe
as$X){if($X[1]!="USAGE")$rd["$C[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$rd["$C[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$C))$pf=$C[1];}}if($_POST&&!$n){$qf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $qf",ME."privileges=",lang(238));else{$cf=q($_POST["user"])."@".q($_POST["host"]);$Zf=$_POST["pass"];if($Zf!=''&&!$_POST["hashed"]&&!min_version(8)){$Zf=$g->result("SELECT PASSWORD(".q($Zf).")");$n=!$Zf;}$Lb=false;if(!$n){if($qf!=$cf){$Lb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $cf IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Zf));$n=!$Lb;}elseif($Zf!=$pf)queries("SET PASSWORD FOR $cf = ".q($Zf));}if(!$n){$Tg=array();foreach($af
as$if=>$qd){if(isset($_GET["grant"]))$qd=array_filter($qd);$qd=array_keys($qd);if(isset($_GET["grant"]))$Tg=array_diff(array_keys(array_filter($af[$if],'strlen')),$qd);elseif($qf==$cf){$nf=array_keys((array)$rd[$if]);$Tg=array_diff($nf,$qd);$qd=array_diff($qd,$nf);unset($rd[$if]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$if,$C)&&(!grant("REVOKE",$Tg,$C[2]," ON $C[1] FROM $cf")||!grant("GRANT",$qd,$C[2]," ON $C[1] TO $cf"))){$n=true;break;}}}if(!$n&&isset($_GET["host"])){if($qf!=$cf)queries("DROP USER $qf");elseif(!isset($_GET["grant"])){foreach($rd
as$if=>$Tg){if(preg_match('~^(.+)(\(.*\))?$~U',$if,$C))grant("REVOKE",array_keys($Tg),$C[2]," ON $C[1] FROM $cf");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?lang(239):lang(240)),!$n);if($Lb)$g->query("DROP USER $cf");}}page_header((isset($_GET["host"])?lang(35).": ".h("$ha@$_GET[host]"):lang(146)),$n,array("privileges"=>array('',lang(71))));if($_POST){$J=$_POST;$rd=$af;}else{$J=$_GET+array("host"=>$g->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$pf;if($pf!="")$J["hashed"]=true;$rd[(DB==""||$rd?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(34),'<td><input name="host" data-maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>',lang(35),'<td><input name="user" data-maxlength="80" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>',lang(36),'<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
';if(!$J["hashed"])echo
script("typePassword(qs('#pass'));");echo(min_version(8)?"":checkbox("hashed",1,$J["hashed"],lang(241),"typePassword(this.form['pass'], this.checked);")),'</table>

';echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".lang(71).doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($rd
as$if=>$qd){echo'<th>'.($if!="*.*"?"<input name='objects[$t]' value='".h($if)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>lang(34),"Databases"=>lang(37),"Tables"=>lang(131),"Columns"=>lang(48),"Procedures"=>lang(242),)as$Fb=>$dc){foreach((array)$sg[$Fb]as$rg=>$tb){echo"<tr".odd()."><td".($dc?">$dc<td":" colspan='2'").' lang="en" title="'.h($tb).'">'.h($rg);$t=0;foreach($rd
as$if=>$qd){$D="'grants[$t][".h(strtoupper($rg))."]'";$Y=$qd[strtoupper($rg)];if($Fb=="Server Admin"&&$if!=(isset($rd["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$D><option><option value='1'".($Y?" selected":"").">".lang(243)."<option value='0'".($Y=="0"?" selected":"").">".lang(244)."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$D value='1'".($Y?" checked":"").($rg=="All privileges"?" id='grants-$t-all'>":">".($rg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";}$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="',lang(14),'">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$n){$le=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$le++;}queries_redirect(ME."processlist=",lang(245,$le),$le||!$_POST["kill"]);}}page_header(lang(116),$n);echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$J){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($J
as$z=>$X)echo"<th>$z".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($z),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr".odd().">".(support("kill")?"<td>".checkbox("kill[]",$J[$y=="sql"?"Id":"pid"],0):"");foreach($J
as$z=>$X)echo"<td>".(($y=="sql"&&$z=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||($y=="pgsql"&&$z=="current_query"&&$X!="<IDLE>")||($y=="oracle"&&$z=="sql_text"&&$X!="")?"<code class='jush-$y'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.lang(246).'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill")){echo($t+1)."/".lang(247,max_connections()),"<p><input type='submit' value='".lang(248)."'>\n";}echo'<input type="hidden" name="token" value="',$qi,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$x=indexes($a);$p=fields($a);$jd=column_foreign_keys($a);$lf=$R["Oid"];parse_str($_COOKIE["adminer_import"],$za);$Ug=array();$e=array();$fi=null;foreach($p
as$z=>$o){$D=$b->fieldName($o);if(isset($o["privileges"]["select"])&&$D!=""){$e[$z]=html_entity_decode(strip_tags($D),ENT_QUOTES);if(is_shortable($o))$fi=$b->selectLengthProcess();}$Ug+=$o["privileges"];}list($L,$sd)=$b->selectColumnsProcess($e,$x);$ce=count($sd)<count($L);$Z=$b->selectSearchProcess($p,$x);$Bf=$b->selectOrderProcess($p,$x);$_=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Hi=>$J){$Ga=convert_field($p[key($J)]);$L=array($Ga?$Ga:idf_escape(key($J)));$Z[]=where_check($Hi,$p);$I=$m->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$ng=$Ji=null;foreach($x
as$w){if($w["type"]=="PRIMARY"){$ng=array_flip($w["columns"]);$Ji=($L?$ng:array());foreach($Ji
as$z=>$X){if(in_array(idf_escape($z),$L))unset($Ji[$z]);}break;}}if($lf&&!$ng){$ng=$Ji=array($lf=>0);$x[]=array("type"=>"PRIMARY","columns"=>array($lf));}if($_POST&&!$n){$kj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$eb=array();foreach($_POST["check"]as$bb)$eb[]=where_check($bb,$p);$kj[]="((".implode(") OR (",$eb)."))";}$kj=($kj?"\nWHERE ".implode(" AND ",$kj):"");if($_POST["export"]){cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$od=($L?implode(", ",$L):"*").convert_fields($e,$p,$L)."\nFROM ".table($a);$ud=($sd&&$ce?"\nGROUP BY ".implode(", ",$sd):"").($Bf?"\nORDER BY ".implode(", ",$Bf):"");if(!is_array($_POST["check"])||$ng)$G="SELECT $od$kj$ud";else{$Fi=array();foreach($_POST["check"]as$X)$Fi[]="(SELECT".limit($od,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p).$ud,1).")";$G=implode(" UNION ALL ",$Fi);}$b->dumpData($a,"table",$G);exit;}if(!$b->selectEmailProcess($Z,$jd)){if($_POST["save"]||$_POST["delete"]){$H=true;$_a=0;$N=array();if(!$_POST["delete"]){foreach($e
as$D=>$X){$X=process_input($p[$D]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($D)]=($X!==false?$X:idf_escape($D));}}if($_POST["delete"]||$N){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a);if($_POST["all"]||($ng&&is_array($_POST["check"]))||$ce){$H=($_POST["delete"]?$m->delete($a,$kj):($_POST["clone"]?queries("INSERT $G$kj"):$m->update($a,$N,$kj)));$_a=$g->affected_rows;}else{foreach((array)$_POST["check"]as$X){$gj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p);$H=($_POST["delete"]?$m->delete($a,$gj,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$gj)):$m->update($a,$N,$gj,1)));if(!$H)break;$_a+=$g->affected_rows;}}}$Ne=lang(249,$_a);if($_POST["clone"]&&$H&&$_a==1){$re=last_id();if($re)$Ne=lang(168," $re");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Ne,$H);if(!$_POST["delete"]){edit_form($a,$p,(array)$_POST["fields"],!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$n=lang(250);else{$H=true;$_a=0;foreach($_POST["val"]as$Hi=>$J){$N=array();foreach($J
as$z=>$X){$z=bracket_escape($z,1);$N[idf_escape($z)]=(preg_match('~char|text~',$p[$z]["type"])||$X!=""?$b->processInput($p[$z],$X):"NULL");}$H=$m->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Hi,$p),!$ce&&!$ng," ");if(!$H)break;$_a+=$g->affected_rows;}queries_redirect(remove_from_uri(),lang(249,$_a),$H);}}elseif(!is_string($Zc=get_file("csv_file",true)))$n=upload_error($Zc);elseif(!preg_match('~~u',$Zc))$n=lang(251);else{cookie("adminer_import","output=".urlencode($za["output"])."&format=".urlencode($_POST["separator"]));$H=true;$pb=array_keys($p);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$Zc,$Fe);$_a=count($Fe[0]);$m->begin();$kh=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($Fe[0]as$z=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$kh]*)$kh~",$X.$kh,$Ge);if(!$z&&!array_diff($Ge[1],$pb)){$pb=$Ge[1];$_a--;}else{$N=array();foreach($Ge[1]as$t=>$kb)$N[idf_escape($pb[$t])]=($kb==""&&$p[$pb[$t]]["null"]?"NULL":q(str_replace('""','"',preg_replace('~^"|"$~','',$kb))));$K[]=$N;}}$H=(!$K||$m->insertUpdate($a,$K,$ng));if($H)$H=$m->commit();queries_redirect(remove_from_uri("page"),lang(252,$_a),$H);$m->rollback();}}}$Rh=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header(lang(53).": $Rh",$n);$N=null;if(isset($Ug["insert"])||!support("table")){$N="";foreach((array)$_GET["where"]as$X){if($jd[$X["col"]]&&count($jd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&!preg_match('~[_%]~',$X["val"]))))$N.="&set".urlencode("[".bracket_escape($X["col"])."]")."=".urlencode($X["val"]);}}$b->selectLinks($R,$N);if(!$e&&support("table"))echo"<p class='error'>".lang(253).($p?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$e);$b->selectSearchPrint($Z,$e,$x);$b->selectOrderPrint($Bf,$e,$x);$b->selectLimitPrint($_);$b->selectLengthPrint($fi);$b->selectActionPrint($x);echo"</form>\n";$E=$_GET["page"];if($E=="last"){$md=$g->result(count_rows($a,$Z,$ce,$sd));$E=floor(max(0,$md-1)/$_);}$fh=$L;$td=$sd;if(!$fh){$fh[]="*";$Gb=convert_fields($e,$p,$L);if($Gb)$fh[]=substr($Gb,2);}foreach($L
as$z=>$X){$o=$p[idf_unescape($X)];if($o&&($Ga=convert_field($o)))$fh[$z]="$Ga AS $X";}if(!$ce&&$Ji){foreach($Ji
as$z=>$X){$fh[]=idf_escape($z);if($td)$td[]=idf_escape($z);}}$H=$m->select($a,$fh,$Z,$td,$Bf,$_,$E,true);if(!$H)echo"<p class='error'>".error()."\n";else{if($y=="mssql"&&$E)$H->seek($_*$E);$yc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($E&&$y=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$_!=""&&$sd&&$ce&&$y=="sql")$md=$g->result(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".lang(12)."\n";else{$Pa=$b->backwardKeys($a,$Rh);echo"<div class='scrollable'>","<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$sd&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".lang(254)."</a>");$Ye=array();$pd=array();reset($L);$Bg=1;foreach($K[0]as$z=>$X){if(!isset($Ji[$z])){$X=$_GET["columns"][key($L)];$o=$p[$L?($X?$X["col"]:current($L)):$z];$D=($o?$b->fieldName($o,$Bg):($X["fun"]?"*":$z));if($D!=""){$Bg++;$Ye[$z]=$D;$d=idf_escape($z);$Gd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($z);$dc="&desc%5B0%5D=1";echo"<th id='th[".h(bracket_escape($z))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($Gd.($Bf[0]==$d||$Bf[0]==$z||(!$Bf&&$ce&&$sd[0]==$d)?$dc:'')).'">';echo
apply_sql_function($X["fun"],$D)."</a>";echo"<span class='column hidden'>","<a href='".h($Gd.$dc)."' title='".lang(59)."' class='text'> ↓</a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.lang(56).'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($z)."');");}echo"</span>";}$pd[$z]=$X["fun"];next($L);}}$xe=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$z=>$X)$xe[$z]=max($xe[$z],min(40,strlen(utf8_decode($X))));}}echo($Pa?"<th>".lang(255):"")."</thead>\n";if(is_ajax()){if($_%2==1&&$E%2==1)odd();ob_end_clean();}foreach($b->rowDescriptions($K,$jd)as$Xe=>$J){$Gi=unique_array($K[$Xe],$x);if(!$Gi){$Gi=array();foreach($K[$Xe]as$z=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$z))$Gi[$z]=$X;}}$Hi="";foreach($Gi
as$z=>$X){if(($y=="sql"||$y=="pgsql")&&preg_match('~char|text|enum|set~',$p[$z]["type"])&&strlen($X)>64){$z=(strpos($z,'(')?$z:idf_escape($z));$z="MD5(".($y!='sql'||preg_match("~^utf8~",$p[$z]["collation"])?$z:"CONVERT($z USING ".charset($g).")").")";$X=md5($X);}$Hi.="&".($X!==null?urlencode("where[".bracket_escape($z)."]")."=".urlencode($X):"null%5B%5D=".urlencode($z));}echo"<tr".odd().">".(!$sd&&$L?"":"<td>".checkbox("check[]",substr($Hi,1),in_array(substr($Hi,1),(array)$_POST["check"])).($ce||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Hi)."' class='edit'>".lang(256)."</a>"));foreach($J
as$z=>$X){if(isset($Ye[$z])){$o=$p[$z];$X=$m->value($X,$o);if($X!=""&&(!isset($yc[$z])||$yc[$z]!=""))$yc[$z]=(is_mail($X)?$Ye[$z]:"");$A="";if(preg_match('~blob|bytea|raw|file~',$o["type"])&&$X!="")$A=ME.'download='.urlencode($a).'&field='.urlencode($z).$Hi;if(!$A&&$X!==null){foreach((array)$jd[$z]as$r){if(count($jd[$z])==1||end($r["source"])==$z){$A="";foreach($r["source"]as$t=>$yh)$A.=where_link($t,$r["target"][$t],$K[$Xe][$yh]);$A=($r["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($r["db"]),ME):ME).'select='.urlencode($r["table"]).$A;if($r["ns"])$A=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($r["ns"]),$A);if(count($r["source"])==1)break;}}}if($z=="COUNT(*)"){$A=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Gi))$A.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($Gi
as$he=>$W)$A.=where_link($t++,$he,$W);}$X=select_value($X,$A,$o,$fi);$u=h("val[$Hi][".bracket_escape($z)."]");$Y=$_POST["val"][$Hi][bracket_escape($z)];$tc=!is_array($J[$z])&&is_utf8($X)&&$K[$Xe][$z]==$J[$z]&&!$pd[$z];$ei=preg_match('~text|lob~',$o["type"]);echo"<td id='$u'";if(($_GET["modify"]&&$tc)||$Y!==null){$xd=h($Y!==null?$Y:$J[$z]);echo">".($ei?"<textarea name='$u' cols='30' rows='".(substr_count($J[$z],"\n")+1)."'>$xd</textarea>":"<input name='$u' value='$xd' size='$xe[$z]'>");}else{$Ae=strpos($X,"<i>…</i>");echo" data-text='".($Ae?2:($ei?1:0))."'".($tc?"":" data-warning='".h(lang(257))."'").">$X</td>";}}}if($Pa)echo"<td>";$b->backwardKeysPrint($Pa,$K[$Xe]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($K||$E){$Ic=true;if($_GET["page"]!="last"){if($_==""||(count($K)<$_&&($K||!$E)))$md=($E?$E*$_:0)+count($K);elseif($y!="sql"||!$ce){$md=($ce?false:found_rows($R,$Z));if($md<max(1e4,2*($E+1)*$_))$md=reset(slow_query(count_rows($a,$Z,$ce,$sd)));else$Ic=false;}}$Pf=($_!=""&&($md===false||$md>$_||$E));if($Pf){echo(($md===false?count($K)+1:$md-$E*$_)>$_?'<p><a href="'.h(remove_from_uri("page")."&page=".($E+1)).'" class="loadmore">'.lang(258).'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$_).", '".lang(259)."…');",""):''),"\n";}}echo"<div class='footer'><div>\n";if($K||$E){if($Pf){$Ie=($md===false?$E+(count($K)>=$_?2:1):floor(($md-1)/$_));echo"<fieldset>";if($y!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".lang(260)."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".lang(260)."', '".($E+1)."')); return false; };"),pagination(0,$E).($E>5?" …":"");for($t=max(1,$E-4);$t<min($Ie,$E+5);$t++)echo
pagination($t,$E);if($Ie>0){echo($E+5<$Ie?" …":""),($Ic&&$md!==false?pagination($Ie,$E):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Ie'>".lang(261)."</a>");}}else{echo"<legend>".lang(260)."</legend>",pagination(0,$E).($E>1?" …":""),($E?pagination($E,$E):""),($Ie>$E?pagination($E+1,$E).($Ie>$E+1?" …":""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".lang(262)."</legend>";$ic=($Ic?"":"~ ").$md;echo
checkbox("all",1,0,($md!==false?($Ic?"":"~ ").lang(150,$md):""),"var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$ic' : checked); selectCount('selected2', this.checked || !checked ? '$ic' : checked);")."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>',lang(254),'</legend><div>
<input type="submit" value="',lang(14),'"',($_GET["modify"]?'':' title="'.lang(250).'"'),'>
</div></fieldset>
<fieldset><legend>',lang(126),' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="',lang(10),'">
<input type="submit" name="clone" value="',lang(246),'">
<input type="submit" name="delete" value="',lang(18),'">',confirm(),'</div></fieldset>
';}$kd=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($kd['sql']);break;}}if($kd){print_fieldset("export",lang(73)." <span id='selected2'></span>");$Mf=$b->dumpOutput();echo($Mf?html_select("output",$Mf,$za["output"])." ":""),html_select("format",$kd,$za["format"])," <input type='submit' name='export' value='".lang(73)."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($yc,'strlen'),$e);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".lang(72)."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$za["format"],1);echo" <input type='submit' name='import' value='".lang(72)."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$qi'>\n","</form>\n",(!$sd&&$L?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$O=isset($_GET["status"]);page_header($O?lang(118):lang(117));$Xi=($O?show_status():show_variables());if(!$Xi)echo"<p class='message'>".lang(12)."\n";else{echo"<table cellspacing='0'>\n";foreach($Xi
as$z=>$X){echo"<tr>","<th><code class='jush-".$y.($O?"status":"set")."'>".h($z)."</code>","<td>".h($X);}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Oh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$D=>$R){json_row("Comment-$D",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$z)json_row("$z-$D",h($R[$z]));foreach($Oh+array("Auto_increment"=>0,"Rows"=>0)as$z=>$X){if($R[$z]!=""){$X=format_number($R[$z]);json_row("$z-$D",($z=="Rows"&&$X&&$R["Engine"]==($Ah=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Oh[$z]))$Oh[$z]+=($R["Engine"]!="InnoDB"||$z!="Data_free"?$R[$z]:0);}elseif(array_key_exists($z,$R))json_row("$z-$D");}}}foreach($Oh
as$z=>$X)json_row("sum-$z",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$g->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$l=>$X){json_row("tables-$l",$X);json_row("size-$l",db_size($l));}json_row("");}exit;}else{$Xh=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Xh&&!$n&&!$_POST["search"]){$H=true;$Ne="";if($y=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$Ne=lang(263);}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Ne=lang(264);}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Ne=lang(265);}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$Ne=lang(266);}elseif($y!="sql"){$H=($y=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Ne=lang(267);}elseif(!$_POST["tables"])$Ne=lang(9);elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$Ne.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Ne,$H);}page_header(($_GET["ns"]==""?lang(37).": ".h(DB):lang(77).": ".h($_GET["ns"])),$n,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".lang(268)."</h3>\n";$Wh=tables_list();if(!$Wh)echo"<p class='message'>".lang(9)."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".lang(269)." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".lang(56)."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]="LIKE %%";search_tables();}}echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.lang(131),'<td>'.lang(270).doc_link(array('sql'=>'storage-engines.html')),'<td>'.lang(122).doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.lang(271).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.lang(272).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.lang(273).doc_link(array('sql'=>'show-table-status.html')),'<td>'.lang(51).doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.lang(274).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.lang(50).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$S=0;foreach($Wh
as$D=>$T){$aj=($T!==null&&!preg_match('~table|sequence~i',$T));$u=h("Table-".$D);echo'<tr'.odd().'><td>'.checkbox(($aj?"views[]":"tables[]"),$D,in_array($D,$Xh,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($D)."' title='".lang(42)."' id='$u'>".h($D).'</a>':h($D));if($aj){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($D).'" title="'.lang(43).'">'.(preg_match('~materialized~i',$T)?lang(129):lang(130)).'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($D).'" title="'.lang(41).'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",lang(44)),"Index_length"=>array("indexes",lang(133)),"Data_free"=>array("edit",lang(45)),"Auto_increment"=>array("auto_increment=1&create",lang(44)),"Rows"=>array("select",lang(41)),)as$z=>$A){$u=" id='$z-".h($D)."'";echo($A?"<td align='right'>".(support("table")||$z=="Rows"||(support("indexes")&&$z!="Data_length")?"<a href='".h(ME."$A[0]=").urlencode($D)."'$u title='$A[1]'>?</a>":"<span$u>?</span>"):"<td id='$z-".h($D)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($D)."'>":"");}echo"<tr><td><th>".lang(247,count($Wh)),"<td>".h($y=="sql"?$g->result("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$z)echo"<td align='right' id='sum-$z'>";echo"</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Ui="<input type='submit' value='".lang(275)."'> ".on_help("'VACUUM'");$yf="<input type='submit' name='optimize' value='".lang(276)."'> ".on_help($y=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".lang(126)." <span id='selected'></span></legend><div>".($y=="sqlite"?$Ui:($y=="pgsql"?$Ui.$yf:($y=="sql"?"<input type='submit' value='".lang(277)."'> ".on_help("'ANALYZE TABLE'").$yf."<input type='submit' name='check' value='".lang(278)."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".lang(279)."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".lang(280)."'> ".on_help($y=="sqlite"?"'DELETE'":"'TRUNCATE".($y=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".lang(127)."'>".on_help("'DROP TABLE'").confirm()."\n";$k=(support("scheme")?$b->schemas():$b->databases());if(count($k)!=1&&$y!="sqlite"){$l=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".lang(281).": ",($k?html_select("target",$k,$l):'<input name="target" value="'.h($l).'" autocapitalize="off">')," <input type='submit' name='move' value='".lang(282)."'>",(support("copy")?" <input type='submit' name='copy' value='".lang(283)."'> ".checkbox("overwrite",1,$_POST["overwrite"],lang(284)):""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$qi'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.lang(74)."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.lang(204)."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".lang(143)."</h3>\n";$Yg=routines();if($Yg){echo"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(183).'<td>'.lang(49).'<td>'.lang(221)."<td></thead>\n";odd('');foreach($Yg
as$J){$D=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr'.odd().'>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$D).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$D).'">'.lang(136)."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.lang(220).'</a>':'').'<a href="'.h(ME).'function=">'.lang(219)."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".lang(285)."</h3>\n";$mh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($mh){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(183)."</thead>\n";odd('');foreach($mh
as$X)echo"<tr".odd()."><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".lang(226)."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".lang(26)."</h3>\n";$Si=types();if($Si){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(183)."</thead>\n";odd('');foreach($Si
as$X)echo"<tr".odd()."><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".lang(230)."</a>\n";}if(support("event")){echo"<h3 id='events'>".lang(144)."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(183)."<td>".lang(286)."<td>".lang(210)."<td>".lang(211)."<td></thead>\n";foreach($K
as$J){echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?lang(287)."<td>".$J["Execute at"]:lang(212)." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.lang(136).'</a>';}echo"</table>\n";$Gc=$g->result("SELECT @@event_scheduler");if($Gc&&$Gc!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($Gc)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.lang(209)."</a>\n";}if($Wh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();
