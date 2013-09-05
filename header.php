<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2008-03-25
// $Id: header.php,v 1.1 2008/04/04 07:10:34 tad Exp $
// ------------------------------------------------------------------------- //

include "../../mainfile.php";
include "function.php";


$isAdmin=false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin=$xoopsUser->isAdmin($module_id);
}

if($isAdmin){
    $interface_menu[_TO_ADMIN_PAGE]="admin/index.php";
}

?>