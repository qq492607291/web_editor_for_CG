<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(9, "mi_config_occupation", $Language->MenuPhrase("9", "MenuText"), "config_occupationlist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_occupation'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(5, "mi_config_goods", $Language->MenuPhrase("5", "MenuText"), "config_goodslist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_goods'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_config_map", $Language->MenuPhrase("7", "MenuText"), "config_maplist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_map'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_config_monster", $Language->MenuPhrase("8", "MenuText"), "config_monsterlist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_monster'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(16, "mi_config_task", $Language->MenuPhrase("16", "MenuText"), "config_tasklist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_task'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(13, "mi_config_skills", $Language->MenuPhrase("13", "MenuText"), "config_skillslist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_skills'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_config_composite", $Language->MenuPhrase("3", "MenuText"), "config_compositelist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_composite'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_config_decomposition", $Language->MenuPhrase("4", "MenuText"), "config_decompositionlist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_decomposition'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_config_help", $Language->MenuPhrase("6", "MenuText"), "config_helplist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_help'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(12, "mi_config_shop", $Language->MenuPhrase("12", "MenuText"), "config_shoplist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}config_shop'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(39, "mi_ext_sell", $Language->MenuPhrase("39", "MenuText"), "ext_selllist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}ext_sell'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(50, "mi_messagetemplate", $Language->MenuPhrase("50", "MenuText"), "messagetemplatelist.php", -1, "", IsLoggedIn() || AllowListMenu('{5DAF7451-EE21-4ABF-A979-870614CA82FC}messagetemplate'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
