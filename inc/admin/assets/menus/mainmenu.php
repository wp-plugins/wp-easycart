<div class="ec_admin_mainmenu">
	<div class="ec_admin_mainmenu_inner">
    	<div class="ec_admin_mainmenu_item<?php if( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "dashboard" ) ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=statistics">DASHBOARD</a></div>
    	<div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "store-setup" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">STORE SETUP</a></div>
    	<div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "store-admin" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin">STORE ADMIN</a></div>
    	<div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "online-demos" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=online-demos&ec_panel=demos">ONLINE DEMOS</a></div>
    	<div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "help-support" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=help-support&ec_panel=support">HELP AND SUPPORT</a></div>
    </div>
</div>