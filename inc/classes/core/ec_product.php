<?php

class ec_product{
	protected $mysqli;							// ec_db structure
	
	public $product_id;							// INT
	public $model_number;						// VARCHAR 255
	public $activate_in_store;					// BOOL
	public $title;								// VARCHAR 255
	public $description;						// Text
	public $specifications;						// Text
	public $price;								// Float 7,2
	public $list_price;							// Float 7,2
	public $vat_rate;							// FLOAT 11,2
	public $stock_quantity;						// INT
	public $weight;								// Float 9,2
	public $show_stock_quantity;				// BOOL
	
	public $seo_description;					// Text
	public $seo_keywords;						// VARCHAR 255
	
	public $use_specifications;					// Bool
	public $use_customer_reviews;				// Bool
	
	public $manufacturer_id;					// INT
	public $manufacturer_name;					// VARCHAR 255
	
	public $download_file_name;					// VARCHAR 255
	
	public $options;							// ec_prodoptions structure
	
	public $images;								// ec_prodimages structure
	
	public $featured_products;					// ec_featuredproducts structure
	
	public $is_giftcard;						// Bool
	public $is_special;							// Bool
	public $is_taxable;							// Bool
	public $is_download;						// Bool
	public $is_donation;						// Bool
	
	public $rating;								// ec_rating structure
	public $reviews = array();		 			// Array of ec_review structures
	
	public $use_optionitem_images;				// Bool
	public $first_selection;					// INT
	public $total_products;						// INT
	
	public $show_on_startup;					// Bool
	public $use_optionitem_quantity_tracking;	// Bool
	public $views;								// INT
	
	public $pricetiers;							// Array of Array(Price, Quantity)
	
	private $is_featured_product;				// BOOL
	private $is_product_details;				// BOOL
	private $is_widget;
	
	public $social_icons;						// ec_social_media structure
	
	private $cart_page;
	private $store_page;
	private $permalink_divider;
	
	private $currency;							// ec_currency structure
	
	private $promotion;							// ec_promotion structure
	private $promotion_text;					// TEXT
	
	private $customfields = array();			// array of ec_customfield objects
	
	function __construct($product_data, $is_featured_product=0, $is_product_details=0, $is_widget=0 ){
		$this->mysqli = new ec_db();
		$this->is_featured_product = $is_featured_product;
		$this->is_product_details = $is_product_details;
		$this->is_widget = $is_widget;
		$this->setup_product($product_data);
		
		$storepageid = get_option( 'ec_option_storepage' );
		$cartpageid = get_option( 'ec_option_cartpage' );
		
		$this->store_page = get_permalink( $storepageid );
		$this->cart_page = get_permalink( $cartpageid );
		
		if( substr_count( $this->store_page, '?' ) )						$this->permalink_divider = "&";
		else																$this->permalink_divider = "?";
		
		$this->currency = new ec_currency( );
	}
	
	private function setup_product( $product_data ){
		
		$this->product_id = $product_data['product_id'];
		$this->model_number = $product_data['model_number'];
		$this->activate_in_store = $product_data['activate_in_store'];
		$this->title = $product_data['title'];
		$this->description = $product_data['description'];
		$this->specifications = $product_data['specifications'];
		$this->price = $product_data['price']; 
		$this->list_price = $product_data['list_price'];
		$this->vat_rate = $product_data['vat_rate'];
		$this->stock_quantity = $product_data['stock_quantity'];
		$this->weight = $product_data['weight'];
		$this->show_stock_quantity = $product_data['show_stock_quantity'];
		
		$this->seo_description = $product_data['seo_description'];
		$this->seo_keywords = $product_data['seo_keywords'];
		
		$this->use_specifications = $product_data['use_specifications'];
		$this->use_customer_reviews = $product_data['use_customer_reviews'];
		
		$this->manufacturer_id = $product_data['manufacturer_id'];
		$this->manufacturer_name = $product_data['manufacturer_name'];
		
		$this->download_file_name = $product_data['download_file_name'];
		
		$this->options = new ec_prodoptions($this->product_id, $product_data['option1'], $product_data['option2'], $product_data['option3'], $product_data['option4'], $product_data['option5'], $product_data['use_optionitem_quantity_tracking']);
		
		if( $this->is_featured_product )
			$this->images = new ec_prodimages($this->product_id, $this->options, $this->model_number, $product_data['use_optionitem_images'], $product_data['image1'], $product_data['image2'], $product_data['image3'], $product_data['image4'], $product_data['image5'], $product_data['optionitemimage_data'], "" );
		else
			$this->images = new ec_prodimages($this->product_id, $this->options, $this->model_number, $product_data['use_optionitem_images'], $product_data['image1'], $product_data['image2'], $product_data['image3'], $product_data['image4'], $product_data['image5'], $product_data['optionitemimage_data'], $this->get_additional_link_options() );
		
		if(!$this->is_featured_product)
		$this->featured_products = new ec_featuredproducts($product_data['featured_product_id_1'], $product_data['featured_product_id_2'], $product_data['featured_product_id_3'], $product_data['featured_product_id_4']);
		
		$this->is_giftcard = $product_data['is_giftcard'];
		$this->is_special = $product_data['is_special'];
		$this->is_taxable = $product_data['is_taxable'];
		$this->is_download = $product_data['is_download'];
		$this->is_donation = $product_data['is_donation'];
		
		$this->rating = new ec_rating( $product_data['review_data'] );
		
		//if( $this->is_product_details )
		$this->reviews = $this->mysqli->get_customer_reviews( $this->product_id );
		
		
		$this->use_optionitem_images = $product_data['use_optionitem_images'];
		$this->total_products = $product_data['product_count'];
		
		$this->show_on_startup = $product_data['show_on_startup'];
		$this->use_optionitem_quantity_tracking = $product_data['use_optionitem_quantity_tracking'];
		$this->views = $product_data['views'];
		
		if( isset( $product_data['pricetier_data'] ) )
		$this->pricetiers = $product_data['pricetier_data'];
		
		if( isset( $product_data['customfield_data'] ) )
		$this->customfields = $product_data['customfield_data'];
		
		$this->update_stock_quantity( session_id() );
		
		if ($product_data['use_optionitem_images']) {
			$social_image1 = $this->images->get_single_image( );
		} else {
			$social_image1 = $product_data['image1'];
		}
		$this->social_icons = new ec_social_media( $this->model_number, $this->title, $this->description, $social_image1);
		
		$this->first_selection = $this->get_first_selection();
		
		// First we should check if there is a special price for this user
		if( isset( $_SESSION['ec_email'] ) && isset( $_SESSION['ec_password'] ) ){
			$roleprice = $this->mysqli->get_roleprice( $_SESSION['ec_email'], $_SESSION['ec_password'], $this->product_id );
			if( isset( $roleprice ) )
				$this->price = $roleprice;
		}
		
		// Now check promotions, even if special price based on user role, use the promo price!
		$this->promotion = new ec_promotion( );
		$promotion_price = $this->promotion->single_product_promotion( $this->product_id, $this->manufacturer_id, $this->price, $this->promotion_text );
		if( $promotion_price < $this->price ){
			if( $this->list_price == "0.00" )
				$this->list_price = $this->price;
				
			$this->price = $promotion_price;
		}else{
			$this->promotion_text = 0;	
		}
		
	}
	
	public function get_first_selection( ){
		
		// Use the following to determine the selected image and swatch.
		// If a optionitem_id is avaialable, then we want to match that up. Otherwise randomize it.
		$tot_items = count( $this->options->optionset1->optionset );
		
		if( isset( $_GET['optionitem_id'] ) && $_GET['optionitem_id'] != "" ){
			for( $i=0; $i<$tot_items; $i++ ){
				if(	$_GET['optionitem_id'] == $this->options->optionset1->optionset[$i]->optionitem_id ){
					if( !$this->use_optionitem_quantity_tracking || ( $this->use_optionitem_quantity_tracking && $this->options->quantity_array[$i][1] > 0 ) ){
						return $i;
					}
				}
			}
		}else if( $this->use_optionitem_quantity_tracking ){
			for( $i=0; $i<$tot_items; $i++ ){
				if(	$this->options->quantity_array[$i][1] > 0 ){
					return $i;
				}
			}
			return 0;
		}else{
			return 0;
		}
		
	}
	
	public function update_stock_quantity( $session_id ){
		
		$quantity = $this->mysqli->get_tempcart_product_quantity( $session_id, $this->product_id );
		$this->stock_quantity = $this->stock_quantity - $quantity;
		
	}
	
	public function display_product_quick_view( $link_text ){
		
		echo "<div class=\"ec_product_quick_view\" id=\"ec_product_quick_view_" . $this->model_number . "\"><a href=\"#\" onclick=\"ec_product_show_quick_view('" . $this->model_number . "'); return false;\">" . $link_text . "</a></div>";
			
	}
	
	/* Display the form start */
	public function display_product_details_form_start( ){
		echo "<form action=\"" . $this->cart_page . "\" method=\"post\">";
	}
	
	/* Display the form end */
	public function display_product_details_form_end( ){
		global $language_data;
		
		echo "<input name=\"is_donation\" id=\"is_donation_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->is_donation . "\" />";
		echo "<input name=\"product_id\" id=\"product_id\" type=\"hidden\" value=\"" . $this->product_id . "\" />";
		echo "<input name=\"session_id\" id=\"session_id\" type=\"hidden\" value=\"" . session_id() . "\" />";
		echo "<input name=\"model_number\" id=\"model_number\" type=\"hidden\" value=\"" . $this->model_number . "\" />";
		echo "<input name=\"quantity\" id=\"quantity_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->stock_quantity . "\" />";
		echo "<input name=\"show_stock_quantity\" id=\"show_stock_quantity_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->show_stock_quantity . "\" />";
		echo "<input name=\"pricetier_quantity\" id=\"pricetier_quantity_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->get_price_tier_quantity_string( ) . "\" />";
		echo "<input name=\"pricetier_price\" id=\"pricetier_price_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->get_price_tier_price_string( ) . "\" />";
		echo "<input name=\"use_optionitem_quantity_tracking\" id=\"use_optionitem_quantity_tracking_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->use_optionitem_quantity_tracking . "\" />";
		echo "<input name=\"use_optionitem_images\" id=\"use_optionitem_images_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->use_optionitem_images . "\" />";
		echo "<input name=\"initial_swatch_selected\" id=\"initial_swatch_selected_" . $this->model_number . "\" type=\"hidden\" value=\"" . $this->first_selection . "\" />";
		echo "<input type=\"hidden\" name=\"ec_product_details_base_path\" id=\"ec_product_details_base_path_" . $this->model_number . "\" value=\"" . plugins_url( ) . "\" />";
		echo "<input type=\"hidden\" name=\"ec_product_details_form_action\" id=\"ec_product_details_form_action_" . $this->model_number . "\" value=\"add_to_cart\" />";
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) ."/ec_product_details_page/ec_product_details_page_get_stock_quantity.php" ) )	
			echo "<input name=\"ec_jquery_get_stock_quantity_file\" id=\"ec_jquery_get_stock_quantity_file_" . $this->model_number . "\" type=\"hidden\" value=\"" . plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) ."/ec_product_details_page/ec_product_details_page_get_stock_quantity.php" ) . "\" />";
		else
			echo "<input name=\"ec_jquery_get_stock_quantity_file\" id=\"ec_jquery_get_stock_quantity_file_" . $this->model_number . "\" type=\"hidden\" value=\"" . plugins_url( EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_base_theme' ) ."/ec_product_details_page/ec_product_details_page_get_stock_quantity.php" ) . "\" />";
		echo "<input name=\"ec_cart_form_action\" id=\"ec_cart_form_action_" . $this->model_number . "\" value=\"add_to_cart\" type=\"hidden\" />";
		echo "</form>";
		echo "<div id=\"ec_product_details_loader_" . $this->model_number . "\" class=\"ec_product_details_loader_div\">LOADING</div>";
		echo "<div id=\"ec_product_details_temp_cart_holder_" . $this->model_number . "\" class=\"ec_product_details_temp_cart_holder\"><div id=\"ec_product_details_temp_cart\" class=\"ec_product_details_temp_cart\">LOAD CART HERE!</div><div class=\"ec_product_details_temp_cart_button_holder\"><div class=\"ec_product_details_temp_cart_button_1\"><a href=\"#\" onclick=\"ec_continue_shopping_click();\">" . $language_data[11] . "</a></div><div class=\"ec_product_details_temp_cart_button_2\"><a href=\"" . $this->cart_page . "\">" . $language_data[12] . "</a></div></div></div>";
	}
	
	public function display_product_category_links( $divider, $featured_product_text ){
		
		// If has menu level 1, show link
		if( isset( $_GET['menuid'] ) && isset( $_GET['menu'] ) )
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "menuid=" . $_GET['menuid'] . "&menu=" . $_GET['menu'] . "\" class=\"ec_product_title_link\">" . $_GET['menu'] . "</a>" . $divider;
		
		// If has menu level 2, show link
		if( isset( $_GET['submenuid'] ) && isset( $_GET['submenu'] ) )
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "submenuid=" . $_GET['submenuid'] . "&submenu=" . $_GET['submenu'] . "\" class=\"ec_product_title_link\">" . $_GET['submenu'] . "</a>" . $divider;
		
		// If has menu level 3, show link
		if( isset( $_GET['subsubmenuid'] ) && isset( $_GET['subsubmenu'] ) )
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "subsubmenuid=" . $_GET['subsubmenuid'] . "&subsubmenu=" . $_GET['subsubmenu'] . "\" class=\"ec_product_title_link\">" . $_GET['subsubmenu'] . "</a>" . $divider;
		
		// If no menu, but is a store startup product, show link
		if( $this->show_on_startup && !isset( $_GET['menuid'] ) && !isset( $_GET['submenuid'] ) && !isset( $_GET['subsubmenuid'] ) )
		echo "<a href=\"" . $this->store_page . "\" class=\"ec_product_title_link\">" . $featured_product_text . "</a>" . $divider;
		
		// show product link
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->model_number . $this->get_additional_link_options() . "\" class=\"ec_product_title_link\">" . $this->title . "</a>";
	
	}
	
	/* Display the product title with a link to the product details page */
	public function display_product_title_link( ){
		
		if( $this->is_featured_product ) 
			echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->model_number . "\" class=\"ec_product_title_link\">" . $this->title . "</a>";
		else
			echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->model_number . $this->get_additional_link_options() . "\" class=\"ec_product_title_link\">" . $this->title . "</a>";
		
	}
	
	/* Display the link to the product details page */
	public function display_product_link( $link_text ){
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->model_number . $this->get_additional_link_options() . "\" class=\"ec_product_title_link\">" . $link_text . "</a>";
	}
	
	public function has_promotion_text( ){
		if( $this->promotion_text )
			return true;
		else
			return false;	
	}
	
	public function display_promotion_text( ){
		echo $this->promotion_text;
	}
		
	/* Display the product title text */
	public function display_product_title( ){
		echo $this->title;
	}
	
	/* Display the star icons for the product */
	public function display_product_stars( ){
		$total = 0;
		for( $i=0; $i<count( $this->reviews ); $i++ ){
			$total = $total + $this->reviews[$i]->rating;	
		}
		if( $i > 0 )
			$average = ceil( $total/$i );
		else
			$average = 0;
		echo $this->rating->display_stars( $average );	
	}
	
	/* Does this product have reviews yet?*/
	public function has_reviews( ){
		if( count( $this->reviews ) > 0 )
			return true;
		else
			return false;
	}
	
	/* Display the number of reviews for the product */
	public function display_product_number_reviews( ){
		echo count( $this->reviews );
	}
	
	/* Return the number of reviews for the product */
	public function get_product_number_reviews( ){
		return $this->rating->display_number_reviews( );
	}
	
	/* Display the input price for product */
	public function display_price_input( ){
		echo "<input type=\"text\" name=\"ec_product_input_price\" id=\"ec_product_input_price\" value=\"" . $this->currency->get_number_only( $this->price ) . "\" />";
		echo "<input type=\"hidden\" name=\"ec_product_min_donation_amount\" id=\"ec_product_min_donation_amount\" value=\"" . $this->currency->get_number_only( $this->price ) . "\" />";
	}
	
	/* Display the product price */
	public function display_price( ){
		
		if( $this->list_price != "0.00" )
			echo "<span class=\"ec_product_sale_price\">";
		else
			echo "<span class=\"ec_product_price\">";
		
			echo  $this->currency->get_currency_display( $this->price ) . "</span>";
	}
	
	public function display_list_price( ){
		if( $this->list_price != "0.00" )
		echo "<span class=\"ec_product_old_price\">" . $this->currency->get_currency_display( $this->list_price ) . "</span>";
	}
	
	public function display_product_price( ){
		
		$p_arr = explode( ".", $this->price );
		$p_dollar = $p_arr[0];
		$p_cent = $this->currency->format_cents( $p_arr[1] );
		
		if( $this->list_price != "0.000" )
			echo "<span class=\"ec_product_sale_price\"><span class=\"currency\">" . get_option( 'ec_option_currency' ) . "</span><span class=\"dollar\">" . $p_dollar . "</span><span class=\"cent\">" . $p_cent . "</span></span>";
		
		else
			echo "<span class=\"ec_product_price\"><span class=\"currency\">" . get_option( 'ec_option_currency' ) . "</span><span class=\"dollar\">" . $p_dollar . "</span><span class=\"cent\">" . $p_cent . "</span></span>";
	}
	
	/* Display the product list price (if available it is the "old price" */
	public function display_product_list_price( ){
		
		$p_arr = explode( ".", $this->list_price );
		$p_dollar = $p_arr[0];
		$p_cent = $this->currency->format_cents( $p_arr[1] );
		
		if( $this->list_price != "0.000" )
			echo "<span class=\"ec_product_old_price\"><span class=\"currency\">" . get_option( 'ec_option_currency' ) . "</span><span class=\"dollar\">" . $p_dollar . "</span><span class=\"cent\">." . $p_cent . "</span></span>";
		
	}
	
	/* Display the percentage number for the discount percentage */
	public function display_product_discount_percentage( ){
		if( $this->list_price != "0.00" )				echo round( 100 - ( ( $this->price / $this->list_price ) * 100 ) );
	}
	
	/* Display the product in stock quantity */
	public function display_product_stock_quantity( ){
		if( $this->use_optionitem_quantity_tracking )
			echo $this->options->quantity_array[$this->first_selection][1];
		else
			echo $this->stock_quantity;
	}
	
	/* Display the product model number */
	public function display_product_model_number( ){
		echo $this->model_number;
	}
	
	/* Display the quantity input box */
	public function display_product_quantity_input( $default ){
		echo "<input type=\"number\" value=\"" . $default . "\" name=\"product_quantity\" id=\"product_quantity_" . $this->model_number . "\" class=\"product_quantity_input\" />";
	}
	
	/* Display the add to cart button */
	public function display_product_add_to_cart_button( $title, $id ){
		echo "<input type=\"submit\" value=\"" . $title . "\" name=\"ec_product_details_add_to_cart_button\" id=\"ec_product_details_add_to_cart_button\" class=\"ec_product_details_add_to_cart_button\" onclick=\"return ec_product_details_add_to_cart( '" . $this->model_number . "' );\" />";
		echo "<div class=\"ec_error_message_box\" id=\"" . $id . "_" . $this->model_number . "\">error text here</div>";
	}
	
	/* Display the product image set */
	public function display_product_image_set( $size, $id_prefix, $js_function_name ){
		echo $this->images->get_product_images( $size, $this->first_selection, $id_prefix, $js_function_name );
	}
	
	/* Display the product details image set */
	public function display_product_details_image_set( $size, $id_prefix, $js_function_name ){
		echo $this->images->get_product_details_images( $size, $this->first_selection, $id_prefix, $js_function_name );
	}
	
	/* Display the product image thumbnails */
	public function display_product_image_thumbnails( $size, $id_prefix, $js_function_name ){
		echo $this->images->get_product_thumbnails( $size, $this->first_selection, $id_prefix, $js_function_name );
	}
	
	public function has_thumbnails( ){
		if( $this->images->has_thumbnails( ) )		return true;
		else										return false;	
	}
	
	/* Get random selection */
	private function get_random_selection( $tot_items ){
		return rand( 0, $tot_items-1 );	
	}
	
	/* */
	public function product_has_swatches( &$optionset ){
		if( $optionset->is_swatch() )
			return true;
		else
			return false;
	}
	
	public function product_has_combo( $optionset ){
		if( $optionset->is_combo() )						
			return true;
		else
			return false;
	}
	
	/* Display the product option drop down or swatches*/
	public function display_product_option( &$optionset, $size, $level, $id_prefix, $js_function_name ){
		
		if( $optionset->is_combo() )						$this->display_product_option_combo( $optionset, $level, $id_prefix, $js_function_name );
		else if( $optionset->is_swatch() )					$this->display_product_option_swatches( $optionset, $size, $level, $id_prefix, $js_function_name );
		
	}
	
	/* Display product option swatches */
	public function display_product_option_swatches( &$optionset, $size, $level, $id_prefix, $js_function_name, $show_input=true ){
		global $language_data;
		$selected_accepted = 0;
		if( count( $optionset->optionset ) > 0 && $optionset->optionset[0]->optionitem_icon ){
			
			for( $i=0; $i<count( $optionset->optionset ); $i++ ){
				
				$test_src = ABSPATH . "wp-content/plugins/wp-easycart-data/products/swatches/" . $optionset->optionset[$i]->optionitem_icon;
				$test_src2 = ABSPATH . "wp-content/plugins/" . EC_PLUGIN_DIRECTORY . "/products/swatches/" . $optionset->optionset[$i]->optionitem_icon;
				
				if( file_exists( $test_src ) && !is_dir( $test_src ) )
					$thumb_src = plugins_url( "wp-easycart-data/products/swatches/" . $optionset->optionset[$i]->optionitem_icon );
				else if( file_exists( $test_src2 ) && !is_dir( $test_src2 ) )
					$thumb_src = plugins_url( EC_PLUGIN_DIRECTORY . "/products/swatches/" . $optionset->optionset[$i]->optionitem_icon );
				else
					$thumb_src = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_image_not_found.jpg" );
				
				echo "<img src=\"" . $thumb_src . "\" alt=\"" . $optionset->optionset[$i]->optionitem_name . "\" class=\"";
				
				if( $this->use_optionitem_quantity_tracking && $this->options->quantity_array[$i][1] < 1 )
					echo "ec_product_swatch_out_of_stock";
				else if( $i == $this->first_selection ){
					$selected_accepted++; echo "ec_product_swatch_selected";
				}else
					echo "ec_product_swatch";
				
				if( $this->use_optionitem_quantity_tracking )
					echo "\" onclick=\"" . $js_function_name . "('" . $this->model_number . "', " . $level . ", " . $i . ");\" id=\"" . $id_prefix . $this->model_number . "_" . $level . "_" . $i . "\" data-optionitemid=\"" . $optionset->optionset[$i]->optionitem_id . "\" data-quantitystring=\"" . $this->options->get_quantity_string( $level, $i ) . "\" width=\"" . get_option( 'ec_option_swatch_' . $size . '_width' ) . "\" height=\"" . get_option( 'ec_option_swatch_' . $size . '_height' ) . "\" \>";
				else
					echo "\" onclick=\"" . $js_function_name . "('" . $this->model_number . "', " . $level . ", " . $i . ");\" id=\"" . $id_prefix . $this->model_number . "_" . $level . "_" . $i . "\" data-optionitemid=\"" . $optionset->optionset[$i]->optionitem_id . "\" data-quantitystring=\"9999\" width=\"" . get_option( 'ec_option_swatch_' . $size . '_width' ) . "\" height=\"" . get_option( 'ec_option_swatch_' . $size . '_height' ) . "\" \>";
					
			}
			
			echo "<div id=\"ec_option_" . $level . "_error\" class=\"ec_product_details_option_error_text\">" . $language_data[10] . "</div>";
			
			$optionitem_id = 0;
			if( isset( $_GET['optionitem_id'] ) )
				$optionitem_id = $_GET['optionitem_id'];
			else if( $level == 1 || !$this->use_optionitem_quantity_tracking )
				$optionitem_id = $optionset->optionset[$this->first_selection]->optionitem_id;
			
			if( $show_input )
				echo "<input type=\"hidden\" name=\"ec_option" . $level . "\" id=\"ec_option" . $level . "_" . $this->model_number . "\" value=\"" . $optionitem_id . "\" />";
			
		}
	}
	
	/* Display product option combo box */
	public function display_product_option_combo( &$optionset, $level, $id_prefix, $js_function_name ){
		if( count( $optionset->optionset ) > 0 && $optionset->option_name != "" ){
			echo "<select name=\"ec_option" . $level . "\" id=\"ec_option" . $level . "_" . $this->model_number . "\" class=\"ec_product_details_option_combo\" onchange=\"ec_product_details_combo_change(" . $level . ", '" . $this->model_number . "');\">";
			echo "<option value=\"0\" data-quantitystring=\"" . $this->stock_quantity . "\">" . $optionset->option_label . "</option>";
			for( $i=0; $i<count( $optionset->optionset ); $i++ ){
				echo "<option data-quantitystring=\"" . $this->options->get_quantity_string( $level, $i ) . "\" value=\"" . $optionset->optionset[$i]->optionitem_id . "\">" . $optionset->optionset[$i]->get_optionitem_label() . "</option>";
			}
			echo "</select>";
		}
	}
	
	/* Display Description */
	public function display_product_description( ){
		echo nl2br( $this->description );
	}
	
	/* Does this product have a description */
	public function product_has_description( ){
		if( $this->description )								return true;
		else													return false;	
	}
	
	/* Display Specifications */
	public function display_product_specifications( ){
		echo nl2br( $this->specifications );
	}
	
	/* Does this product have specifications */
	public function product_has_specifications( ){
		if( $this->use_specifications )							return true;
		else													return false;	
	}
	
	/* Display Ratings */
	public function display_product_reviews( ){
		foreach( $this->reviews as $review_row ){
			$review = new ec_review( $review_row );
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_customer_review.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_customer_review.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_customer_review.php' );
		}
	}
	
	/* Does this product have a customer reviews */
	public function product_has_customer_reviews( ){
		if( $this->use_customer_reviews )						return true;
		else													return false;	
	}
	
	/* Display Customer Review Open Button */
	public function display_product_customer_review_open_button( $review_text, $complete_text ){
		echo "<a href=\"#\" onclick=\"product_details_customer_review_open( ); return false;\" id=\"ec_open_review_button\" />" . $review_text . "</a><div id=\"ec_open_review_button_submitted\">" . $complete_text . "</div>";
	}
	
	/* Display Customer Review Close Button */
	public function display_product_customer_review_close_button( $review_text ){
		echo "<a href=\"#\" onclick=\"product_details_customer_review_close( ); return false;\" />" . $review_text . "</a>";
	}
	
	/* Print Out Customer Review Form Tag */
	public function display_product_customer_review_form_start( ){
		if( isset( $_GET['optionitem_id'] ) ){
			echo "<form action=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $_GET['model_number'] . "&optionitem_id=" . $_GET['optionitem_id'] . "\" method=\"post\" id=\"customer_review_form\">";
		}else{
			echo "<form action=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $_GET['model_number'] . "\" method=\"post\" id=\"customer_review_form\">";
		}
	}
	
	/* Print Out Customer Review Closing Form Tag */
	public function display_product_customer_review_form_end( ){
		echo "<input type=\"hidden\" name=\"ec_customer_review_base_path\" id=\"ec_customer_review_base_path\" value=\"" . plugins_url( ) . "\" />";
		echo "<input type=\"hidden\" name=\"ec_customer_review_form_action\" id=\"ec_customer_review_form_action\" value=\"submit_review\" />";
		echo "<input type=\"hidden\" name=\"ec_customer_review_product_id\" value=\"".$this->product_id."\" />";
		echo "</form>";
		echo "<div id=\"ec_customer_review_loader\" class=\"ec_product_details_loader_div\">LOADING</div>";
	}
	
	/* Display the selection stars to rate the product*/
	public function display_product_customer_review_rating_stars( ){
		global $language_data;
		for( $i=0; $i<5; $i++ )
			echo "<div class=\"ec_customer_review_star_off\" onmouseover=\"ec_customer_review_star_hover(" . $i . ");\" onmouseout=\"ec_customer_review_star_rollout(" . $i . ");\" onclick=\"ec_customer_review_star_click(" . $i . ");\" id=\"ec_customer_review_star_" . $i . "\"></div>";
		
		echo "<div class=\"ec_product_details_customer_review_error_text\" id=\"ec_customer_review_rating_error\">".$language_data[7]."</div>";
		echo "<input type=\"hidden\" id=\"ec_customer_review_rating\" name=\"ec_customer_review_rating\" value=\"0\" />";
	}
	
	
	/* Display the input box for the customer review title */
	public function display_product_customer_review_title_input( ){
		echo "<input type=\"text\" name=\"ec_customer_review_title\" id=\"ec_customer_review_title\" class=\"ec_customer_review_title\" />";
	}
	
	/* Display the input box for the customer review description */
	public function display_product_customer_review_description_input( ){
		echo "<textarea name=\"ec_customer_review_description\" id=\"ec_customer_review_description\" class=\"ec_customer_review_description\"></textarea>";
	}
	
	/* Display the submit button for the customer review*/
	public function display_product_customer_review_submit_button( $text_label ){
		echo "<input type=\"submit\" name=\"ec_customer_review_submit_button\" id=\"ec_customer_review_submit_button\" value=\"" . $text_label . "\" onclick=\"return submit_customer_review();\" />";
	}
	
	/* Does this product have a discount */
	public function product_has_discount( ){
		if( $this->list_price == "0.000" )						return false;
		else													return true;	
	}
	
	/* Display the Featured Products */
	public function product_has_featured_products( ){
		if( $this->featured_products->product1 || $this->featured_products->product2 || $this->featured_products->product3 || $this->featured_products->product4 )
			return true;
		else
			return false;
	}
	
	public function display_featured_products( ){
		if( $this->featured_products->product1->product_id != 0 ){
			$i=1;
			$featured_product = $this->featured_products->product1;
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_featured_product.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
		}
		
		if( $this->featured_products->product2->product_id != 0 ){
			$i=2;
			$featured_product = $this->featured_products->product2;
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_featured_product.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
		}
		
		if( $this->featured_products->product3->product_id != 0 ){
			$i=3;
			$featured_product = $this->featured_products->product3;
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_featured_product.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
		}
		
		if( $this->featured_products->product4->product_id != 0 ){
			$i=4;
			$featured_product = $this->featured_products->product4;
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_featured_product.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout') . '/ec_featured_product.php' );
		}
	}
	
	/* Display the Gift Card Input Fields */
	public function display_gift_card_input( ){
		if( $this->is_giftcard ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_gift_card_input.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_gift_card_input.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_gift_card_input.php' );	
		}
	}
	
	public function display_gift_card_message_input_field( ){
		echo "<textarea name=\"ec_gift_card_message\" id=\"ec_gift_card_message_" . $this->model_number . "\" class=\"ec_gift_card_message\"></textarea>";
	}
	
	public function display_gift_card_to_name_input_field( ){
		echo "<input type=\"text\" name=\"ec_gift_card_to_name\" id=\"ec_gift_card_to_name_" . $this->model_number . "\" class=\"ec_gift_card_to_name\" />";
	}
	
	public function display_gift_card_from_name_input_field( ){
		echo "<input type=\"text\" name=\"ec_gift_card_from_name\" id=\"ec_gift_card_from_name_" . $this->model_number . "\" class=\"ec_gift_card_from_name\" />";
	}
	
	/* Price Tier Functions */
	public function get_price_tier_quantity_string( ){
								$ret_string = "";
		for( $i=0; $i<count( $this->pricetiers ); $i++ ){
			if( $i > 0 )		$ret_string .= ",";
			if( count( $this->pricetiers[$i] ) > 1 )
								$ret_string .= $this->pricetiers[$i][1];
		}
								return $ret_string;
	}
	
	public function get_price_tier_price_string( ){
								$ret_string = "";
		for( $i=0; $i<count( $this->pricetiers ); $i++ ){
			if( $i>0 )			$ret_string .= ",";
								$ret_string .= $this->pricetiers[$i][0];
		}
								return $ret_string;
	}
	
	public function display_product_price_tiers( ){
		for( $i=0; $i<count( $this->pricetiers ) && count( $this->pricetiers[$i] ) == 2; $i++ ){
			$Price = $GLOBALS['currency']->get_currency_display( $this->pricetiers[$i][0] );
			$Quantity = $this->pricetiers[$i][1];
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_price_tier.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_price_tier.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_price_tier.php' );	
		}
	}
	
	public function display_product_custom_fields( $divider, $spacer ){
		for( $i=0; $i<count( $this->customfields ) && count( $this->customfields[$i] ) == 3; $i++ ){
			$field_name = $this->customfields[$i][0];
			$field_label = $this->customfields[$i][1];
			$field_data = $this->customfields[$i][2];
			
			echo $field_label . $divider . " " . $field_data . $spacer;
		}
	}
	
	public function display_product_custom_field_label( $field_name_input ){
		for( $i=0; $i<count( $this->customfields ) && count( $this->customfields[$i] ) == 3; $i++ ){
			$field_name = $this->customfields[$i][0];
			if( $field_name_input == $field_name ){
				$field_label = $this->customfields[$i][1];
				echo $field_label;
			}
		}
	}
	
	public function display_product_custom_field_data( $field_name_input ){
		for( $i=0; $i<count( $this->customfields ) && count( $this->customfields[$i] ) == 3; $i++ ){
			$field_name = $this->customfields[$i][0];
			if( $field_name_input == $field_name ){
				$field_data = $this->customfields[$i][2];
				echo $field_data;
			}
		}
	}
	
	public function display_model_number( ){
		echo $this->model_number;	
	}
	
	public function get_additional_link_options( ){
		
		$link_text = "";
		
		if( !$this->is_widget ){
			if( isset( $_GET['subsubmenuid'] ) ){
				$link_text .= "&amp;subsubmenuid=" . $_GET['subsubmenuid'];
				
				if( isset( $_GET['subsubmenu'] ) )
					$link_text .= "&amp;subsubmenu=" . $_GET['subsubmenu'];
			
				if( isset( $_GET['pagenum'] ) )
					$link_text .= "&amp;pagenum=" . $_GET['pagenum'];
			
			}else if( isset( $_GET['submenuid'] ) ){
				$link_text .= "&amp;submenuid=" . $_GET['submenuid'];
				
				if( isset( $_GET['submenu'] ) )
					$link_text .= "&amp;submenu=" . $_GET['submenu'];
			
				if( isset( $_GET['pagenum'] ) )
					$link_text .= "&amp;pagenum=" . $_GET['pagenum'];
			
			}else if( isset( $_GET['menuid'] ) ){
				$link_text .= "&amp;menuid=" . $_GET['menuid'];
			
				if( isset( $_GET['menu'] ) )
					$link_text .= "&amp;menu=" . $_GET['menu'];
					
				
				if( isset( $_GET['pagenum'] ) )
					$link_text .= "&amp;pagenum=" . $_GET['pagenum'];	
			
			}else if( isset( $_GET['ec_search'] ) ){
				$link_text .= "&amp;ec_search=" . $_GET['ec_search'];
			}else if( !isset( $_GET['manufacturer'] ) && !isset( $_GET['group_id'] ) && $this->show_on_startup ){
				$link_text .= "&amp;featured=true";
				
				if( isset( $_GET['pagenum'] ) )
					$link_text .= "&amp;pagenum=" . $_GET['pagenum'];
			}
			
			if( isset( $_GET['manufacturer'] ) ){
				$link_text .= "&amp;manufacturer=" . $_GET['manufacturer'];	
			}
			
			if( isset( $_GET['group_id'] ) ){
				$link_text .= "&amp;group_id=" . $_GET['group_id'];	
			}
			
			if( isset( $_GET['pricepoint'] ) ){
				$link_text .= "&amp;pricepoint=" . $_GET['pricepoint'];	
			}
			
		}
		
		return $link_text;
		
	}
	
}

?>