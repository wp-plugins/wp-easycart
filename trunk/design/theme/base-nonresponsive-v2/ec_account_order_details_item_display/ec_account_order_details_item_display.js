////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Order Details Item Display Javascript Document
function update_download_count( orderdetail_id ){
	if( document.getElementById( 'ec_download_count_' + orderdetail_id ) ){
		var count = Number(document.getElementById( 'ec_download_count_' + orderdetail_id ).innerHTML);
		var max_count = Number(document.getElementById( 'ec_download_count_max_' + orderdetail_id ).innerHTML);
		if( count < max_count ){
			count++;
			document.getElementById( 'ec_download_count_' + orderdetail_id ).innerHTML = count;
		}
	}
}