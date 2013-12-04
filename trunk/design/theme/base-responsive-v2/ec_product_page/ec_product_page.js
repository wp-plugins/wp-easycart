// EC Product Page JavaScript Document
function change_product_sort(menu_id, menu_name, submenu_id, submenu_name, subsubmenu_id, subsubmenu_name, manufacturer_id, pricepoint_id, currentpage_selected, perpage, URL, divider){
	
	var url_string = URL + divider + "filternum=" + document.getElementById('sortfield').value;
	
	if( subsubmenu_id != 0 ){
		url_string = url_string + "&subsubmenuid=" + subsubmenu_id;
		
		if( subsubmenu_name != 0 )
			url_string = url_string + "&subsubmenu=" + subsubmenu_name;
	
	}else if( submenu_id != 0 ){
		url_string = url_string + "&submenuid=" + submenu_id;
		
		if( submenu_name != 0 )
			url_string = url_string + "&submenu=" + submenu_name;
			
	}else if( menu_id != 0 ){
		url_string = url_string + "&menuid=" + menu_id;
		
		if( menu_name != 0 )
			url_string = url_string + "&menu=" + menu_name;
		
	}
	
	if( manufacturer_id > 0 )
		url_string = url_string + "&manufacturer=" + manufacturer_id;
		
	if( pricepoint_id > 0 )
		url_string = url_string + "&pricepoint=" + pricepoint_id;
	
	if( currentpage_selected )
		url_string = url_string + "&pagenum=" + currentpage_selected;
	
	if( perpage )
		url_string = url_string + "&perpage=" + perpage; 
	
	window.location = url_string;
}