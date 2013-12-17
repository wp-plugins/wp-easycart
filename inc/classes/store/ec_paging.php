<?php

class ec_paging{
	
	public $current_page;								// INT
	public $total_pages;								// INT
	
	private $total_products;							// INT
	private $num_per_page;								// INT
	private $start_item;								// INT
	
	const MAX_PAGES_SHOWN = 5;							// INT
	
	function __construct( $num_per_page ){
		$this->total_products = 0;
		$this->num_per_page = $num_per_page;
		$this->current_page = $this->get_current_page( );
		$this->total_pages = 0;
		$this->start_item = ( ( $this->current_page - 1 ) * $this->num_per_page );
	}
	
	public function update_product_count( $total_products ){
		$this->total_products = $total_products;
		$this->total_pages = $this->get_total_pages();
		
	}
	
	private function get_current_page( ){
		if(isset($_GET['pagenum']))									return $_GET['pagenum'];
		else														return 1;
	}
	
	private function get_total_pages( ){
		if( $this->num_per_page > 0 )
			return ceil($this->total_products / $this->num_per_page);
		else
			return 0;
	}
	
	private function start_page(){
		if($this->current_page <= ceil( self::MAX_PAGES_SHOWN / 2 ) )		return 1;
		else if( ($this->current_page + ceil( self::MAX_PAGES_SHOWN / 2 ) ) > $this->total_pages )
																			return ($this->total_pages - self::MAX_PAGES_SHOWN + 1);
		else																return ($this->current_page - ceil(self::MAX_PAGES_SHOWN/2) + 1);
	}
	
	private function end_page(){
		if($this->total_pages < self::MAX_PAGES_SHOWN)						return $this->total_pages;
		else if($this->current_page <= ceil( self::MAX_PAGES_SHOWN / 2 ) )		return self::MAX_PAGES_SHOWN;
		else if( ($this->current_page + ceil( self::MAX_PAGES_SHOWN / 2 ) ) > $this->total_pages )
																			return $this->total_pages;
		else																return ($this->current_page + ceil(self::MAX_PAGES_SHOWN/2) - 1);
	}
	
	public function display_paging_links( $divider, $link_string ){
		
																	$ret_string = "";
														
		if($this->start_page() != 1)								$ret_string .= "<a href=\"".$link_string."&amp;pagenum=".$this->start_page()."\" class=\"ec_prev_link\">< Prev</a>" . $divider;
		
		for($i = $this->start_page(); $i<=$this->end_page(); $i++){
			
			if($i == $this->current_page)							$ret_string .= $this->get_selected_link( $i );
			else													$ret_string .= $this->get_link( $i, $link_string );
			
			if($i != $this->total_pages)							$ret_string .= $divider;
			
		}
		
		if($this->end_page() != $this->total_pages)					$ret_string .= $divider . "<a href=\"".$link_string."&amp;pagenum=".$this->end_page()."\" class=\"ec_next_link\">Next ></a>";
		
																	return $ret_string;
		
	}
	
	private function get_selected_link( $i ){
		return "<span class=\"ec_selected_page\">" . ($i) . "</span>";
	}
	
	private function get_link( $i, $link_string ){
		return "<a href=\"" . $link_string . "&amp;pagenum=" .  $i . "\" class=\"ec_page_link\">" . $i . "</a>";
	}
	
	public function get_limit_query( ){
		return sprintf( " LIMIT %d, %d", mysql_real_escape_string( $this->start_item ), mysql_real_escape_string( $this->num_per_page ) );
	}
	
}

?>