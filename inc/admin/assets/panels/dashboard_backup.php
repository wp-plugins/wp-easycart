<h3>Backup Your Store</h3>
<p>The links below will allow you to download everything that makes up your WP EasyCart store. You should download these weekly to ensure you have a reasonible backup to return to in the case your hosting company has a failure or another mistake is made. To replace your current install with the backup you must do the following:
<ul>
	<li>Upload the designs folder to wp-content/plugins/wp-easycart-data/design and be sure to replace all files that are in this folder.</li>
	<li>Upload the products folder to wp-content/plugins/wp-easycart-data/products and be sure to replace all files that are in this folder.</li>
	<li>Use a mysql editor (phpmyadmin for most) and run the backup script to insert the data into your store. Notice: This script inserts all data that you backed up. If you did not lose your store DB, then do not run this script! You can run this script on a fresh EasyCart install to move all the EasyCart data to a new site.</li>
</ul>
</p>
<div class="ec_backup_folders">
	<div class="ec_backup_column">
    	<a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store&ec_action=download_designs" class="ec_download_folder_button"></a>
    </div>
    <div class="ec_backup_column">
    	<a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store&ec_action=download_products" class="ec_download_folder_button"></a>
    </div>
    <div class="ec_backup_column">
    	<a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store&ec_action=download_db" class="ec_download_db_button"></a>
    </div>
</div>
<div class="ec_backup_folders">
	<div class="ec_backup_column">
    	<a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store&ec_action=download_designs" class="ec_download_backup_link">DOWNLOAD DESIGNS</a>
    </div>
    <div class="ec_backup_column">
    	<a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store&ec_action=download_products" class="ec_download_backup_link">DOWNLOAD PRODUCTS</a>
    </div>
    <div class="ec_backup_column">
    	<a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store&ec_action=download_db" class="ec_download_backup_link">DOWNLOAD DATABASE</a>
    </div>
</div>