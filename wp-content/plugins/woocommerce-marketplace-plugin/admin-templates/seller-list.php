<?php
class Seller_List_Table extends WMP_List_Table {

public function sellers_data(){
    remove_action( 'pre_user_query', 'wmp_user_query' );
	$args = array(
		'blog_id'      => $GLOBALS['blog_id'],
		'role'         => 'seller',
		'meta_key'     => '',
		'meta_value'   => '',
		'meta_compare' => '',
		'meta_query'   => array(),
		'include'      => array(),
		'exclude'      => array(),
		'orderby'      => 'login',
		'order'        => 'ASC',
		'offset'       => '',
		'search'       => '',
		'number'       => '',
		'count_total'  => false,
		'fields'       => array('ID','user_login','user_email'),
		'who'          => ''
		);


	$sellers = json_decode(json_encode(get_users( $args )), true);

	return $sellers;
}



    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'seller',     //singular name of the listed records
            'plural'    => 'sellers',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }


    
    function column_default($item, $column_name){
        switch($column_name){
            case 'seller_name':
            	return $this->column_title($item);
            case 'user_login':
                return $item[$column_name];
            case 'user_email':
                return $item[$column_name];
            case 'total_products':
                return $this->getProductCount($item);
            case 'status':
                return $this->getStatus($item);
            default:
               // return print_r($item,false); //Show the whole array for troubleshooting purposes
        }
    }




    
    function getSellerName($item){
       return get_user_meta( $item['ID'], 'seller_name', true ); 
    }

    function getStatus($item){
       $status = get_user_meta( $item['ID'], 'seller_activate', true );
       if($status=='1'){
        return 'Active';
       }else{
        return 'Inactive';
       }
    }

    function getProductCount($item){
     global $wpdb;
     $seller = $item['ID'];
     $count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $seller AND post_type IN ('product') and post_status = 'publish'" );
     return $count;
 }


    function column_title($item){
        
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&seller=%s">Edit</a>','edit-seller','edit',$item['ID']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&seller=%s">Delete</a>',$_REQUEST['page'],'remove',$item['ID']),
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $this->getSellerName($item),
            /*$2%s*/ $item['ID'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }


    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("seller")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }


    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'seller_name'     => 'Seller Name',
            'user_login'    => 'Username',
            'user_email'  => 'Email',
            'total_products'  => 'Products',
            'status'  => 'Status'
        );
        return $columns;
    }


    
    function get_sortable_columns() {
        $sortable_columns = array(
            //'seller_name'     => array('ID',false),     //true means it's already sorted
            'user_login'    => array('user_login',false),
            'user_email'  => array('user_email',false)
        );
        return $sortable_columns;
    }


    
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }


   
    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }


    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 5;
        
        
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
       
        $this->_column_headers = array($columns, $hidden, $sortable);
        
       
        $this->process_bulk_action();
        
        

        $data = $this->sellers_data();
                
        
       
         
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'seller_name'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        
        
        
        $current_page = $this->get_pagenum();
        
        
        $total_items = count($data);
        
       
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
       
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }

}















$messages = array();
    if ( isset($_GET['update']) ) :
        switch($_GET['update']) {
        case 'del':
        case 'del_many':
            $delete_count = isset($_GET['delete_count']) ? (int) $_GET['delete_count'] : 0;
            $messages[] = '<div id="message" class="updated"><p>' . sprintf( _n( 'Seller deleted.', '%s sellers deleted.', $delete_count ), number_format_i18n( $delete_count ) ) . '</p></div>';
            break;
        case 'add':
            if ( isset( $_GET['id'] ) && ( $user_id = $_GET['id'] ) && current_user_can( 'edit_user', $user_id ) ) {
                $messages[] = '<div id="message" class="updated"><p>' . sprintf( __( 'New seller added. <a href="%s">Edit seller</a>' ),
                    esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
                        self_admin_url( 'user-edit.php?user_id=' . $user_id ) ) ) ) . '</p></div>';
            } else {
                $messages[] = '<div id="message" class="updated"><p>' . __( 'New seller added.' ) . '</p></div>';
            }
            break;
        case 'remove':
            $messages[] = '<div id="message" class="updated fade"><p>' . __('Seller removed from this site.') . '</p></div>';
            break;
        case 'err_admin_remove':
            $messages[] = '<div id="message" class="error"><p>' . __("You can't remove the current seller.") . '</p></div>';
            $messages[] = '<div id="message" class="updated fade"><p>' . __('Other sellers have been removed.') . '</p></div>';
            break;
        }
    endif;



    //Perform delete action
    if ( isset($_GET['action']) && isset($_GET['seller']) ) :
        switch($_GET['action']) {
         case 'remove':
            global $wpdb;
            $seller_id = $_GET['seller'];
            $count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $seller_id AND post_type IN ('product') and post_status = 'publish'" );
            if($count>0){
                $messages[] = '<div id="message" class="error"><p>' . __( 'Seller cannot be deleted, seller has products.' ) . '</p></div>';
            }else{
                wp_delete_user( $seller_id );
                $messages[] = '<div id="message" class="updated"><p>' . __( 'seller deleted.' ) . '</p></div>';
            }
    
            break;
        }
    endif;



if ( ! empty($messages) ) {
    foreach ( $messages as $msg )
        echo $msg;
}


?>




<div class="wrap">
<h2><?php echo __( 'Sellers', 'wmp' ); ?><a href="?page=add-new-seller" class="add-new-h2">Add New</a></h2>

<?php
$seller_lt = new Seller_List_Table();
$seller_lt->prepare_items();
$seller_lt->display();
?>

</div>