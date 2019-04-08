<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2008-03-25
// $Id:$
// ------------------------------------------------------------------------- //

define('_MI_TADCBOX_NAME', 'Chat Box');
define('_MI_TADCBOX_AUTHOR', 'Tad');
define('_MI_TADCBOX_CREDITS', 'TNC');
define('_MI_TADCBOX_DESC', 'A small and easy instant chat box module.');
define('_MI_TADCBOX_ADMENU1', 'Messages');
define('_MI_TADCBOX_TEMPLATE_DESC1', 'Template of tadcbox_index_tpl.html');
define('_MI_TADCBOX_BNAME1', 'Chat Box');
define('_MI_TADCBOX_BDESC1', 'Display an instant chat box block');

define('_MI_TADCBOX_NEED_LOGIN', '<span style="font-weight: bold;">Login to post messages</span>');
define('_MI_TADCBOX_NEED_LOGIN_DESC', 'Only registered members are authorized to post.');
define('_MI_TADCBOX_AUTO_ID', '<span style="font-weight: bold;">Idetify User ID Automatically</span>');
define('_MI_TADCBOX_AUTO_ID_DESC', 'Force logged-in users to post in the name of User ID; "Guest" as the prefix for unlogged users and guests.');
define('_MI_TADCBOX_INPUT_MIN', '<span style="font-weight: bold;">Minimum words for each post</span>');
define('_MI_TADCBOX_INPUT_MIN_DESC', 'How many minimum words for one post? e.g. "5" means 5 words at minimum per message.');
define('_MI_TADCBOX_INPUT_MAX', '<span style="font-weight: bold;">Maximum words for each post</span>');
define('_MI_TADCBOX_INPUT_MAX_DESC', 'How many maximum words for one post? e.g. "100" means 100 words maximum per message.');
define('_MI_TADCBOX_ALLOW_HTML', '<span style="font-weight: bold;">HTML Available?</span>');
define('_MI_TADCBOX_ALLOW_HTML_DESC', 'Much more risks with this option on...');
define('_MI_TADCBOX_SECURITY_IMAGES', '<span style="font-weight: bold;">Captcha Available?</span>');
define('_MI_TADCBOX_SECURITY_IMAGES_DESC', 'Use Captcha to prevent garbage posts created by robots.');
define('_MI_TADCBOX_NO_NEED_CHK', '<span style="font-weight: bold;">Permitted Groups without Captcha?</span>');
define('_MI_TADCBOX_NO_NEED_CHK_DESC', 'Appoint groups which can post without Captcha.');
define('_MI_TADCBOX_COL1_COLOR', '<span style="font-weight: bold;">Font Color of Style 1</span>');
define('_MI_TADCBOX_COL1_COLOR_DESC', 'Font color of 1st style， please use CSS color code such as #000000 or rgb(0,0,0).');
define('_MI_TADCBOX_COL1_BGCOLOR', '<span style="font-weight: bold;">Background Color of Style 1</span>');
define('_MI_TADCBOX_COL1_BGCOLOR_DESC', 'Background color of 1st style, please use CSS color code such as #000000 or rgb(0,0,0).');
define('_MI_TADCBOX_COL2_COLOR', '<span style="font-weight: bold;">Font Color of Style 2</span>');
define('_MI_TADCBOX_COL2_COLOR_DESC', 'Font color of 2nd style， please use CSS color code such as #000000 or rgb(0,0,0).');
define('_MI_TADCBOX_COL2_BGCOLOR', '<span style="font-weight: bold;">Background Color of Style 2</span>');
define('_MI_TADCBOX_COL2_BGCOLOR_DESC', 'Background color of 2nd style, please use CSS color code such as #000000 or rgb(0,0,0).');
define('_MI_TADCBOX_WORDWRAP', '<span style="font-weight: bold;">Break Lines?</span>');
define('_MI_TADCBOX_WORDWRAP_DESC', 'Break English lines automatically and effectively, but there could be wrong break line points in bilingual sentences (e.g. Chinese and English).');

define('_MI_TADCBOX_OPT1', 'Welcome to ChatBox! Please post your Message!');

/** v 1.6 **/
define('_MI_TADCBOX_SMILE_NUM', '<span style="font-weight: bold;">Number of emoticons?</span>');
define('_MI_TADCBOX_SMILE_NUM_DESC', 'Set the number of emoticons');

define('_MI_TADCBOX_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADCBOX_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADCBOX_BACK_2_ADMIN', 'Back to Administration of ');

//help
define('_MI_TADCBOX_HELP_OVERVIEW', 'Overview');
