<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2008-03-25
// $Id: post.php,v 1.1 2008/04/04 07:10:34 tad Exp $
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header.php";
/*-----------function區--------------*/

if($_GET['mode']=="mkpic"){
  if($xoopsModuleConfig['security_images']=='1'){
		$num1=rand(0,9);
		$num2=rand(0,9);
		$num3=rand(0,9);
		$num=$num1.$num2.$num3;
		$_SESSION['security_code']=$num;
		mkpic($num);
		exit;
	}
}


//tad_cbox編輯表單
function tad_cbox_form($sn=""){
	global $xoopsDB,$xoopsUser,$xoopsModuleConfig;
	
	//判斷是否需要登入才能留言
	if(empty($xoopsUser) and $xoopsModuleConfig['need_login']=='1'){
	  $main="<div class='need_login'>"._MD_TADCBOX_NEED_LOGIN."</div>";
		return $main;
		exit;
	}
	
	//秀出管理員回覆訊息，當開啟辨識身份時，要抓取使用者名稱
	if($xoopsModuleConfig['auto_id']=='1' and !empty($xoopsUser) ){
    $loginname=$xoopsUser->getVar('loginname');
	  $name=$xoopsUser->getVar('name');
	  if(!empty($name)){
			$publisher=$name;
		}elseif(!empty($loginname)){
      $publisher=$loginname;
		}else{
      $publisher=$xoopsUser->getVar('uname');
		}
		$publisher_txt=(!empty($sn))?"<div class='remsg'>".sprintf(_MA_TADCBOX_RE_MSG,$sn)."</div>":"<div class='remsg'>".sprintf(_MA_TADCBOX_ADD_MSG,$publisher)."</div>";
		$publisher_txt.="<input type='hidden' name='publisher' value='$publisher'>";
	}else{
		$publisher=(empty($_SESSION['publisher']))?_MA_TADCBOX_DEFAULT_PUBLISHER:$_SESSION['publisher'];
	  $publisher_txt=(!empty($sn))?"<div class='remsg'>".sprintf(_MA_TADCBOX_RE_MSG,$sn)."</div>":"<input type='text' class='name' name='publisher' value='$publisher' style='width: 100%' onClick=\"if(this.value=='"._MA_TADCBOX_DEFAULT_PUBLISHER."')this.value=''\">";
  }

	//檢查是否是屬於不需要認證的群組
	$no_chk=is_no_chk();
  if($xoopsModuleConfig['security_images']=='1' and !$no_chk){
    $security_images="<tr><td colspan=2 class='col'><img src='".XOOPS_URL."/modules/tad_cbox/post.php?mode=mkpic' align=absmiddle hspace=3>"._MA_TADCBOX_INPUT_CODE."<input type='text' name='security_images' size=2></td></tr>";
	}else{
    $security_images="";
	}
  
  $op=(!empty($sn))?"<input type='hidden' name='sn' value='{$sn}'><input type='hidden' name='op' value='update_tad_cbox'>":"<input type='hidden' name='op' value='insert_tad_cbox'>";
  $textarea_name=(!empty($sn))?"root_msg":"msg";

  $js=$smile_all="";
  if($_SESSION['cbox_use_smile']=='1'){
  	//找出表情圖
  	$dir = "images/smiles/";
  	if (is_dir($dir)) {
  	  if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
          if(substr($file,0,1)==".")continue;
          $key=substr($file,1,-4);
          $smile_gif[$key]=$file;
        }
        closedir($dh);
  	  }
  	}

    sort($smile_gif);
    $smile_li="";
  	foreach($smile_gif as $file){
      $smile_li.="<li><img src='".XOOPS_URL."/modules/tad_cbox/{$dir}{$file}'  width='19' height='19' alt='{$file}' onClick='insertAtCursor(document.myForm.{$textarea_name},\"[{$file}]\")' ></li>\n";

    }
    
    $js="
    jQuery(document).ready(function() {

        var w=$('.carousel').width();
        if(w > 600) w=600;
        var smile_num=Math.floor((w-60)/19);
        jQuery(\".jCarouselLite\").jCarouselLite({
            btnNext: \".next\",
            btnPrev: \".prev\",
            visible: smile_num,
            scroll: smile_num
        });
    });


    function insertAtCursor(myField, myValue) {
    	//IE support
    	if (document.selection) {
    		myField.focus();
    		sel = document.selection.createRange();
    		sel.text = myValue;
    	}
    	//MOZILLA/NETSCAPE support
    	else if (myField.selectionStart || myField.selectionStart == '0') {
    		var startPos = myField.selectionStart;
    		var endPos = myField.selectionEnd;
    		myField.value = myField.value.substring(0, startPos)
    		+ myValue
    		+ myField.value.substring(endPos, myField.value.length);
    	} else {
    		myField.value += myValue;
    	}
    }";
    $smile_all="<tr><td colspan=2 id='smile'>
	<div class='carousel' style='height:24px;'>
    <a href='#' class='prev'>&nbsp</a>
    <div class='jCarouselLite' align=center><ul>$smile_li</ul></div>
    <a href='#' class='next'>&nbsp</a>
    <div class='clear'></div>
  </div> </td></tr>";
  }

  $jquery=get_jquery();

	$main="$jquery
	<script type='text/javascript' src='".XOOPS_URL."/modules/tad_cbox/class/jcarousellite_1.0.1.min.js'></script>

  <script type='text/javascript'>
  $js

  var minChr = {$xoopsModuleConfig['input_min']};
  var maxChr = {$xoopsModuleConfig['input_max']};
  var nowChr = 0;
  function count(value){
     nowChr = value.length;
  }
  function check(){
      if(nowChr < minChr){
        alert('".sprintf(_MA_TADCBOX_MSG_MIN,$xoopsModuleConfig['input_min'])."');
        return;
  		} else if(nowChr > maxChr){
  			alert('".sprintf(_MA_TADCBOX_MSG_MAX,$xoopsModuleConfig['input_max'])."');
        return;
  		}
  		document.myForm.submit();
  }
  </script>
  <div class='cbox'>
  <form action='{$_SERVER['PHP_SELF']}' method='post' name='myForm' id='myForm' enctype='multipart/form-data' >
  <table class='cbox_tbl' style='width:98%'>
	<tr><td class='col'>
	{$publisher_txt}</td><td><img src='images/reload.png' alt='reload' align='absmiddle' hspace=2 onclick=\"window.open('".XOOPS_URL."/modules/tad_cbox/show.php?mode=box','cboxmain')\"><font onclick=\"window.open('".XOOPS_URL."/modules/tad_cbox/show.php?mode=box','cboxmain')\" style='cursor:pointer;color:#3366CC'>"._MA_TADCBOX_RELOAD."</font></td></tr>
	<tr>
  <td class='col' rowspan=2 >
	<textarea name='{$textarea_name}' id='{$textarea_name}' style='width:96%' onkeyUp='count(this.value)' onClick=\"if(this.value=='"._MA_TADCBOX_MSG."')this.value=''\">"._MA_TADCBOX_MSG."</textarea></td>
	<td class='col' width=50 style='width: 50px;' nowrap>
	<input type='checkbox' name='only_root' value='1'>"._MA_TADCBOX_ONLY_ROOT."</td></tr>
	<tr><td class='col' style='width: 60px;'>
	$op
  <input type='button' value='"._MA_SAVE."' style='height:100%' onClick='check();'></td>
	</tr>
	$security_images
	$smile_all
	
  </table>
  </form></div>";


	return $main;
}

//	<tr><td colspan=2><ul id='mycarousel' class='jcarousel-skin-tango'>$smile_li</ul></td></tr>

//新增資料到tad_cbox中
function insert_tad_cbox(){
	global $xoopsDB,$xoopsModuleConfig,$xoopsConfig,$xoopsUser;
	
	$no_chk=is_no_chk();
  if($xoopsModuleConfig['security_images']=='1' and !$no_chk){
		if($_SESSION['security_code']!=$_POST['security_images'] or empty($_POST['security_images'])){
   		return _MD_TADCBOX_SECURITY_CODE_ERROR;
		}
  }
  
	//姓名
	if($xoopsModuleConfig['auto_id']=='1'){
	  if(empty($xoopsUser)){
			$publisher=(empty($_POST['publisher']) or $_POST['publisher']==_MA_TADCBOX_DEFAULT_PUBLISHER)?_MA_TADCBOX_DEFAULT_PUBLISHER:_MA_TADCBOX_DEFAULT_PUBLISHER."_{$_POST['publisher']}";
		}else{
		  $name=$xoopsUser->getVar('name');
		  if(!empty($name)){
				$publisher=$name;
			}else{
        $publisher=$xoopsUser->getVar('uname');
			}
		}
	}else{
    $publisher=(empty($_POST['publisher']))?_MA_TADCBOX_DEFAULT_PUBLISHER:$_POST['publisher'];
	}

	//留言
	if(empty($_POST['msg']) or $_POST['msg']==_MA_TADCBOX_MSG)return;

	$str_num=strlen(strip_tags($_POST['msg']));
	
	if($str_num < $xoopsModuleConfig['input_min']){
		return;
	}elseif($str_num > $xoopsModuleConfig['input_max']*2){
		return;
	}

	if (empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	    $myip = $_SERVER['REMOTE_ADDR'];
	} else {
	    $myip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	    $myip = $myip[0];
	}
	
	$myts =& MyTextSanitizer::getInstance();
	$publisher=$myts->htmlSpecialChars($myts->addSlashes ($publisher));
	$msg=($xoopsModuleConfig['allow_html']=='1')?$myts->addSlashes($_POST['msg']):$myts->htmlSpecialChars($myts->addSlashes ($_POST['msg']));
  $only_root=empty($_POST['only_root'])?'0':'1';

  $now=date("Y-m-d H:i:s" , xoops_getUserTimestamp(time()));
	$sql = "insert into ".$xoopsDB->prefix("tad_cbox")." (`publisher`,`msg`,`post_date`,`ip`,`only_root`,`root_msg`,`uid`,`box_sn`,`re_sn`) values('{$publisher}','{$msg}','{$now}','{$myip}','{$only_root}','','0','0','0')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	//取得最後新增資料的流水編號
	$_SESSION['publisher']=$_POST['publisher'];
	if($xoopsUser)$xoopsUser->incrementPost();
}


//更新tad_cbox某一筆資料
function update_tad_cbox($sn=""){
	global $xoopsDB,$xoopsUser;
	$uid_name=$xoopsUser->getVar('uname');
	$sql = "update ".$xoopsDB->prefix("tad_cbox")." set `root_msg` = '{$_POST['root_msg']} (by {$uid_name})' where sn='{$sn}'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $sn;
}

//檢查是否在「不需檢查的群組中」
function is_no_chk(){
	global $xoopsModuleConfig,$xoopsUser;
  if($xoopsUser){
    $no_chk=false;
    $group=$xoopsUser->getGroups();
    foreach($group as $g){
      if(in_array($g,$xoopsModuleConfig['no_need_chk'])){
        return true;
			}
		}
	}else{
    return in_array(3,$xoopsModuleConfig['no_need_chk']);
	}
}


function mkpic($num=0){
	header("Content-type: image/png");
	$im = @imagecreatetruecolor(28, 18);
	$text_color = imagecolorallocate($im, 255, 255, 255);
	imagestring($im, 2, 5, 2, $num, $text_color);
	imagepng($im);
	imagedestroy($im);
}

/*-----------執行動作判斷區----------*/
$_REQUEST['op']=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
switch($_REQUEST['op']){
	//更新資料
	case "update_tad_cbox";
	update_tad_cbox($_POST['sn']);
	header("location: {$_SERVER['PHP_SELF']}?op=reload");
	break;

	//新增資料
	case "insert_tad_cbox":
	$msg=insert_tad_cbox();
	header("location: {$_SERVER['PHP_SELF']}?op=reload&msg={$msg}");
	break;

	default:
	$main=tad_cbox_form($_GET['sn']);
	break;
}

/*-----------秀出結果區--------------*/
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">
<html>
<head>
<meta http-equiv='content-type' content='text/html; charset="._CHARSET."'>
<link rel='stylesheet' type='text/css' media='screen' href='".XOOPS_URL."/modules/tad_cbox/module.css' />";

if($_GET['op']=="reload"){
  echo "<script type='text/javascript'>window.open('".XOOPS_URL."/modules/tad_cbox/show.php?mode=box','cboxmain')</script>";
}

if(!empty($_GET['msg'])){
  echo "<script type='text/javascript'>alert('{$_GET['msg']}')</script>";
}


echo "

</head>
<body bgcolor='#FFFFFF'>";
echo $main;
echo "</body>
</html>";

?>
