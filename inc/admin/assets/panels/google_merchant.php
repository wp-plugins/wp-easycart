<?php
if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save-google-merchant" ){
	global $wpdb;
	$i=1;
	$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.model_number FROM ec_product" );
	foreach( $products as $product ){ 
		
		// Save your Google Merchant Product Options
		$attribute_array = array( 	"google_product_category" => $_POST['google_product_category_' . $product->model_number],
									"product_type" => $_POST['product_type_' . $product->model_number],
									"condition" => $_POST['condition_' . $product->model_number],
									"gtin" => $_POST['gtin_' . $product->model_number],
									"mpn" => $_POST['mpn_' . $product->model_number],
									"identifier_exists" => $_POST['identifier_exists_' . $product->model_number],
									"gender" => $_POST['gender_' . $product->model_number],
									"age_group" => $_POST['age_group_' . $product->model_number],
									"size_type" => $_POST['size_type_' . $product->model_number],
									"size_system" => $_POST['size_system_' . $product->model_number],
									"item_group_id" => $_POST['item_group_id_' . $product->model_number],
									"color" => $_POST['color_' . $product->model_number],
									"material" => $_POST['material_' . $product->model_number],
									"pattern" => $_POST['pattern_' . $product->model_number],
									"size" => $_POST['size_' . $product->model_number],
									"weight_type" => $_POST['weight_type_' . $product->model_number],
									"shipping_label" => $_POST['shipping_label_' . $product->model_number] );
									
		$attribute_json = json_encode( $attribute_array );
		$wpdb->query( $wpdb->prepare( "DELETE FROM ec_product_google_attributes WHERE product_id = %d", $product->product_id ) );
		$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_google_attributes(product_id, attribute_value) VALUES( %d, %s )", $product->product_id, $attribute_json ) );
		
	}
	
}
?>

<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Google Merchant data has been saved.</strong></p></div>
<?php }?>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_action=save-google-merchant" method="POST" enctype="multipart/form-data">
<div class="ec_admin_page_title">Setup Products for Google Merchant Feed</div>
<div class="ec_adin_page_intro"><p>Setting up Google Merchant requires you to set a lot of options that do not apply to the store, but are useful in the Google Merchant system. Please select as many options as possible that apply and save. Once you complete the setup, add the feed to your Google Merchant account. You should first setup the options as you expect, then run the xml file generate by downloading below through the feed debugger. Once you get the file processed without errors, use it to create a live product feed for your products.</p>
<ul>
	<li>Select and save all product settings below, the minimum required settings to include are condition and a value for gtin or mpn.</li>
    <li>Download your <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_action=download-feed">XML feed</a> and manually upload as a test feed type &quot;regular uploads by user&quot; in your Google Merchant Account.</li>
    <li>Once the test is successful, download your latest <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_action=download-feed">XML feed</a> and manually upload as a standard feed type &quot;regular uploads by user&quot; to your Google Merchant Account.</li>
    <li>You must visit this page, download, and reupload the XML file whenever you need the data refreshed in your Google Merchant Account.</li>
    <li>While inserting Google Product Categories, please use data from <a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank">this list</a>.</li>
</ul>

</div>


<table class="wp-list-table widefat">
	<thead>
    	<tr>
        	<th>Model Number</th>
            <th>Title</th>
            <th>price</th>
            <th>sale_price</th>
            <th>brand</th>
        	<th>google_product_category</th>
            <th>product_type</th>
            <th>condition</th>
            <th>gtin</th>
            <th>mpn</th>
            <th>identifier_exists</th>
            <th>gender</th>
            <th>age_group</th>
            <th>size_type</th>
            <th>size_system</th>
            <th>item_group_id</th>
            <th>color</th>
            <th>material</th>
            <th>pattern</th>
            <th>size</th>
            <th>shipping_weight</th>
            <th>shipping_label</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		global $wpdb;
		$i=1;
		$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.model_number, ec_product.title, ec_product.price, ec_product.list_price, ec_product.weight, ec_manufacturer.name as manufacturer_name FROM ec_product LEFT JOIN ec_manufacturer ON ec_manufacturer.manufacturer_id = ec_product.manufacturer_id WHERE ec_product.activate_in_store = 1 ORDER BY ec_product.title ASC" );
		foreach( $products as $product ){ 
		$attributes_result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ec_product_google_attributes WHERE product_id = %d", $product->product_id ) );
		if( $attributes_result ){
			$attributes = json_decode( $attributes_result->attribute_value, true );
		}else{
			$attributes = array( 	"google_product_category" => "None Selected",
									"product_type" => "",
									"condition" => "",
									"gtin" => "",
									"mpn" => "",
									"identifier_exists" => "",
									"gender" => "",
									"age_group" => "",
									"size_type" => "",
									"size_system" => "",
									"item_group_id" => "",
									"color" => "",
									"material" => "",
									"pattern" => "",
									"size" => "",
									"weight_type" => "lb",
									"shipping_label" => "" );
		}
		?>
    	<tr<?php if( $i%2 ){ echo " class=\"alternate\""; } $i++; ?>>
        	<td><?php echo $product->model_number; ?></td>
            <td><?php echo $product->title; ?></td>
            <td><?php echo $product->price; ?></td>
            <td><?php echo $product->list_price; ?></td>
            <td><?php echo $product->manufacturer_name; ?></td>
        	<td><input type="text" name="google_product_category_<?php echo $product->model_number; ?>" /></td>
            <td><input type="text" name="product_type_<?php echo $product->model_number; ?>" value="<?php echo $attributes["product_type"]; ?>" /></td>
            <td><select name="condition_<?php echo $product->model_number; ?>"><option value=""<?php if( $attributes["condition"] == "" ){ echo " selected=\"selected\""; }?>>None Selected</option><option value="new"<?php if( $attributes["condition"] == "new" ){ echo " selected=\"selected\""; }?>>New</option><option value="used"<?php if( $attributes["condition"] == "used" ){ echo " selected=\"selected\""; }?>>Used</option><option value="refurbished"<?php if( $attributes["condition"] == "refurbished" ){ echo " selected=\"selected\""; }?>>Refurbished</option></select></td>
            <td><input type="text" name="gtin_<?php echo $product->model_number; ?>" value="<?php echo $attributes["gtin"]; ?>" /></td>
            <td><input type="text" name="mpn_<?php echo $product->model_number; ?>" value="<?php echo $attributes["mpn"]; ?>" /></td>
            <td><select name="identifier_exists_<?php echo $product->model_number; ?>"><option value=""<?php if( $attributes["identifier_exists"] == "" ){ echo " selected=\"selected\""; }?>>None Selected</option><option value="TRUE"<?php if( $attributes["identifier_exists"] == "TRUE" ){ echo " selected=\"selected\""; }?>>Identifier Exists</option><option value="FALSE"<?php if( $attributes["identifier_exists"] == "FALSE" ){ echo " selected=\"selected\""; }?>>Identifier Does NOT Exist</option></select></td>
            <td><select name="gender_<?php echo $product->model_number; ?>"><option value=""<?php if( $attributes["gender"] == "" ){ echo " selected=\"selected\""; }?>>None Selected</option><option value="male"<?php if( $attributes["gender"] == "male" ){ echo " selected=\"selected\""; }?>>Male</option><option value="female"<?php if( $attributes["gender"] == "female" ){ echo " selected=\"selected\""; }?>>Female</option><option value="unisex"<?php if( $attributes["gender"] == "unisex" ){ echo " selected=\"selected\""; }?>>Unisex</option></select></td>
            <td><select name="age_group_<?php echo $product->model_number; ?>"><option value=""<?php if( $attributes["age_group"] == "" ){ echo " selected=\"selected\""; }?>>None Selected</option><option value="newborn"<?php if( $attributes["age_group"] == "newborn" ){ echo " selected=\"selected\""; }?>>Newborn</option><option value="infant"<?php if( $attributes["age_group"] == "infant" ){ echo " selected=\"selected\""; }?>>Infant</option><option value="toddler"<?php if( $attributes["age_group"] == "toddler" ){ echo " selected=\"selected\""; }?>>Toddler</option><option value="kids"<?php if( $attributes["age_group"] == "kids" ){ echo " selected=\"selected\""; }?>>Kids</option><option value="adult"<?php if( $attributes["age_group"] == "adult" ){ echo " selected=\"selected\""; }?>>Adult</option></select></td>
            <td><select name="size_type_<?php echo $product->model_number; ?>"><option value=""<?php if( $attributes["size_type"] == "" ){ echo " selected=\"selected\""; }?>>None Selected</option><option value="regular"<?php if( $attributes["size_type"] == "regular" ){ echo " selected=\"selected\""; }?>>Regular</option><option value="petite"<?php if( $attributes["size_type"] == "petite" ){ echo " selected=\"selected\""; }?>>Petite</option><option value="plus"<?php if( $attributes["size_type"] == "plus" ){ echo " selected=\"selected\""; }?>>Plus</option><option value="big and tall"<?php if( $attributes["size_type"] == "big and tall" ){ echo " selected=\"selected\""; }?>>Big and Tall</option><option value="maternity"<?php if( $attributes["size_type"] == "maternity" ){ echo " selected=\"selected\""; }?>>Maternity</option></select></td>
            <td><select name="size_system_<?php echo $product->model_number; ?>"><option value=""<?php if( $attributes["size_system"] == "" ){ echo " selected=\"selected\""; }?>>None Selected</option><option value="US"<?php if( $attributes["size_system"] == "US" ){ echo " selected=\"selected\""; }?>>US</option><option value="UK"<?php if( $attributes["size_system"] == "UK" ){ echo " selected=\"selected\""; }?>>UK</option><option value="EU"<?php if( $attributes["size_system"] == "EU" ){ echo " selected=\"selected\""; }?>>EU</option><option value="DE"<?php if( $attributes["size_system"] == "DE" ){ echo " selected=\"selected\""; }?>>DE</option><option value="FR"<?php if( $attributes["size_system"] == "FR" ){ echo " selected=\"selected\""; }?>>FR</option><option value="JP"<?php if( $attributes["size_system"] == "JP" ){ echo " selected=\"selected\""; }?>>JP</option><option value="CN"<?php if( $attributes["size_system"] == "CN" ){ echo " selected=\"selected\""; }?>>CN</option><option value="IT"<?php if( $attributes["size_system"] == "IT" ){ echo " selected=\"selected\""; }?>>IT</option><option value="BR"<?php if( $attributes["size_system"] == "BR" ){ echo " selected=\"selected\""; }?>>BR</option><option value="MEX"<?php if( $attributes["size_system"] == "MEX" ){ echo " selected=\"selected\""; }?>>MEX</option><option value="AU"<?php if( $attributes["size_system"] == "AU" ){ echo " selected=\"selected\""; }?>>AU</option></select></td>
            <td><input type="text" name="item_group_id_<?php echo $product->model_number; ?>" value="<?php echo $attributes["item_group_id"]; ?>" /></td>
            <td><input type="text" name="color_<?php echo $product->model_number; ?>" value="<?php echo $attributes["color"]; ?>" /></td>
            <td><input type="text" name="material_<?php echo $product->model_number; ?>" value="<?php echo $attributes["material"]; ?>" /></td>
            <td><input type="text" name="pattern_<?php echo $product->model_number; ?>" value="<?php echo $attributes["pattern"]; ?>" /></td>
            <td><input type="text" name="size_<?php echo $product->model_number; ?>" value="<?php echo $attributes["size"]; ?>" /></td>
            <td><?php echo $product->weight; ?> <select name="weight_type_<?php echo $product->model_number; ?>"><option value="lb"<?php if( $attributes["weight_type"] == "lb" ){ echo " selected=\"selected\""; }?>>LB</option><option value="oz"<?php if( $attributes["weight_type"] == "oz" ){ echo " selected=\"selected\""; }?>>OZ</option><option value="g"<?php if( $attributes["weight_type"] == "g" ){ echo " selected=\"selected\""; }?>>G</option><option value="kg"<?php if( $attributes["weight_type"] == "kg" ){ echo " selected=\"selected\""; }?>>KG</option></select></td>
            <td><input type="text" name="shipping_label_<?php echo $product->model_number; ?>" value="<?php echo $attributes["shipping_label"]; ?>" /></td>
        </tr>
        <?php } ?>
    </tbody>

</table>

<div class="ec_save_changes_row"><input type="submit" value="SAVE PRODUCT SETTINGS" class="ec_save_changes_button" /></div>

</form>