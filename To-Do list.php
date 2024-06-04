<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://himanshu@gmail.com
 * @since             1.0.0
 * @package           forx
 *
 * @wordpress-plugin
 * Plugin Name:       forx_plugin
 * Plugin URI:        https://forx@gmail.com
 * Description:       It is my first plugin 
 * Version:           1.0.0
 * Author:            himanshu
 * Author URI:        https://himanshu@gmail.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       forx
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined( 'WPINC' ) ) {
	die;
}

define( 'FORX_VERSION', '1.0.0' );

function forx_plugin_activation() {
	global $wpdb, $table_prefix; //create database and table
	$wp_tasky= $table_prefix. 'tasky'; // provide the table name 
	$list= "CREATE TABLE IF NOT EXISTS `$wp_tasky` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `task` VARCHAR(200) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB;";    // create table
			
			$wpdb->query($list); // to run the query need query function
	
	
}

register_activation_hook( __FILE__, 'forx_plugin_activation' );
function forx_plugin_deactivation() {
//
}


register_deactivation_hook( __FILE__, 'forx_plugin_deactivation' );




//function op_del(){
	
//}

function op_name(){
	global $wpdb, $table_prefix;
	

	
	if(isset($_POST['submit'])){
		if(isset($_POST['task'])) {
$task=$_POST['task'];
$data= array(
	'task'=> $task
);
$format= array(
	'%s'
);								//store in string

$wpdb -> insert($table_prefix.'tasky', $data, $format); // insert data into table 



print_r($data);



		}

}
global $wpdb, $table_prefix;
if(isset($_POST['delete'])){
	$task_id=intval($_POST['delete']);

	$wpdb->delete($table_prefix.'tasky',array('id' => $task_id), array('%d')); // delete the task using delete query
}

global $wpdb, $table_prefix;
$h="SELECT * FROM ". $table_prefix.'tasky'; // display the list to user using select query
$result= $wpdb->get_results($h);

ob_start(); // start html structure
	?>
	<center>
	<form method="post">
		<h1>TO-DO List</h1>
		<ul>
			<input type="text" name="task" placeholder="Enter the name"/></br>
			<input type="submit" name="submit" placeholder="Create your list  "/>

			
		<?php

		
		foreach($result as $row){
		?>

		<li><?php echo $row->task; ?></li>
		<button type="sumit" name="delete" value="<?php echo esc_attr($row->id);?>">Delete</button>
		
		</ul>
		<?php
			
		}
	
		?>


	    </ul>
	

	</form>
</center>
	<?php

	$html=ob_get_clean(); //end html structure

	return $html;


	}

add_shortcode('form', 'op_name'); // call function in shortcode and tag the function with form.

?>


