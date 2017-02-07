
<?php
/*
Plugin Name: Woocommerce Add On
Plugin URI: http://www.optimizaclick.com
Description: Plugin para el acceso de usuarios a traves del panel de usuario
Author: Departamento de Desarrollo
Version: 0.2.2 Beta
*/

if ( ! class_exists( 'Woocommerce_Add_On' ) ) {
	class Woocommerce_Add_On {
		
        function __construct() {
            	add_action( 'woocommerce_after_order_itemmeta', 'woocommerce_variable_add_on',10, 3 );
        }
    
function woocommerce_variable_add_on( $item_id, $item, $product ){
	if($product->product_type == 'variation') {
    $all_meta_data=get_metadata( 'order_item', $item_id, "", "");
 
    $codes = new WC_Product_Variable( $all_meta_data['_product_id'][0]);
    $variables = $codes->get_variation_attributes();   ?>
    
    <h4>Editar productos variables <span style="font-weight:300">(marcar el boton para selecionar los campos a editar)</span></h4>
    
    <?php foreach($variables as $variable => $name): echo '<p>' . $variable; ?>
        <select name="<?= $variable ?>" class="taskOption_1">
    <?php foreach($name as $single_name):?>
        <option value="<?= $single_name ?>[]" name="<?= $single_name ?>[]"><?= $single_name ?></option>
    <?php endforeach;?>
        </select>
        <input type="radio" name="edit" value="1">
    <?php endforeach; ?>


    <?php foreach($variables as $variable => $name):
        $replace = "/(" . $variable . "=)([\w&.\-]+)/";
            preg_match_all($replace, $_POST['items'], $output_array);
        
            preg_match_all("/(edit=)(\w+)/", $_POST['items'], $update);
        
            if($update[2][0] == 1) {
                wc_update_order_item_meta($item_id, $variable, $output_array[2][0]);
                 echo '<script>parent.window.location.reload(true);</script>';
            }
      ?>
    
	<?php endforeach; } } }
	new Woocommerce_Add_On();
} 
