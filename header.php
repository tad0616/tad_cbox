<?php
require dirname(dirname(__DIR__)) . '/mainfile.php';
require __DIR__ . '/function.php';

$isAdmin = false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin = $xoopsUser->isAdmin($module_id);
}

if ($isAdmin) {
    $interface_menu[_TO_ADMIN_PAGE] = 'admin/main.php';
}
