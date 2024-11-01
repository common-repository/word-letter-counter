<?php 
/*
Plugin Name:  Word-Letter Counter
Plugin URI: http://www.abacsys.com
Description: Plugin for counting the no of words and letters in a post.
Author: Abacsys Technologies
Version: 1.0
Author URI: http://www.abacsys.com
*/
function woletcount_install_post_counter()
{
	global $wpdb;
	$creat="CREATE TABLE count_alpha(id int(100) UNIQUE, word int(100), letter int(100))";
	$exe=$wpdb->query($creat);
}
register_activation_hook( __FILE__, 'woletcount_install_post_counter' );

add_action( 'save_post', 'woletcount_counts_letter' );

 function woletcount_counts_letter($id)
 {
 	global $wpdb;
 	
 	
 	
 	$con=$_POST['post_content'];	//get the content
 	//echo $con;
 	
 	$v=str_word_count($con, 0);		//counts words.
 	
 	$cc=strlen($con);
 	//echo $cc;
 	$id=$GLOBALS['post']->ID;
 	$v1=$wpdb->get_results("SELECT id FROM count_alpha where id=$id");
 	//var_dump($v1);
 	
 		if(count($v1)>0) {
 			$vv="UPDATE count_alpha SET word=$v,letter=$cc WHERE id=$id";
 			//echo $vv;
 			$v2=$wpdb->query($vv);
 			//echo $v2;
 			//exit();	
 		}
 		else {
 			$conn= "INSERT INTO `count_alpha`(`id`, `word`, `letter`) VALUES ($id,$v,$cc)";
 			$insert=$wpdb->query($conn);
 		}
 	
 	
 	
 	
 	//exit();
 /* 	
 	$se="SELECT * FROM `counts` WHERE id=$id"; */
 	
 }
 
 
 
 class woletcount_wp_my_plugin extends WP_Widget {

  	function woletcount_wp_my_plugin() {
 
  		parent::WP_Widget(false, $name = __('Word Letter Counter', 'wp_widget_plugin') );
 	}
 

 		function form($instance) {
 	
 			if( $instance) {
 			
 				$title = esc_attr($instance['title']);
 		
 				$text = esc_attr($instance['text']);
 	
 				$textarea = esc_textarea($instance['textarea']);
 		
 			} else {
 			
 				$title = '';
 		
 				$text = '';
 		
 				$textarea = '';
 			
 			}
 	
 			?>
 	
 		<p>
 		
 		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
 	
 		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
 	
 		</p>
 
 		<p>
 	
 		<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'wp_widget_plugin'); ?></label>
 
 		<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
 	
 		</p>
 
 		<p>
 		
 		<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'wp_widget_plugin'); ?></label>
 	
 		<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
 	
 		</p>
 	
 		<?php
 	
 		}
 		 		
 



 	
 	function update($new_instance, $old_instance) {
 		$instance = $old_instance;
 		$instance['title'] = strip_tags($new_instance['title']);
 		$instance['text'] = strip_tags($new_instance['text']);
 $instance['textarea'] = strip_tags($new_instance['textarea']);
 		
 		return $instance;
 			
 	}
 	

 	
 	function widget($args, $instance) {
 		
 		extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
   $text = $instance['text'];
   $textarea = $instance['textarea'];
   echo $before_widget;
   // Display the widget
   echo '<div class="widget-text wp_widget_plugin_box">';

   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }

   // Check if text is set
   if( $text ) {
      echo '<p class="wp_widget_plugin_text">'.$text.'</p>';
   }
   // Check if textarea is set
   if( $textarea ) {
     echo '<p class="wp_widget_plugin_textarea">'.$textarea.'</p>';
   }
   echo '</div>';
   echo $after_widget;
   
   $id12=$GLOBALS['post']->ID;
  // echo $id12;
   global $wpdb;
   
  $c1="SELECT * FROM count_alpha where id=$id12";
  $r3=$wpdb->get_results($c1);
  
  echo "</br>";
   echo "</br>Number of words :".$r3[0]->word;
   echo "</br>Number of letters".$r3[0]->letter;
    
   ?>
   
   <?php
}
 
 }
  // register widget

 add_action('widgets_init', create_function('', 'return register_widget("woletcount_wp_my_plugin");'));

 
 
?>
