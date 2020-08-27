<?php
/**
 * php function for fetching the orders from the database
 */
function wp_woocommerce_ordered_items(){
    global $wpdb;
    $sql_query = "SELECT * FROM wp_woocommerce_order_items";
    $result = $wpdb->get_results($sql_query);
    return $result;
}


/**
 * php function responsible for returning the variation id
 */
function wp_product_lookup_variation_id($order_id, $order_item_id){
    global $wpdb;
    $sql_query = "SELECT variation_id FROM wp_wc_order_product_lookup WHERE order_id = $order_id and order_item_id = $order_item_id";
    $result = $wpdb->get_results($sql_query);
    return $result;
}

/**
 * the php  function responsible for fetching the variation image
 */
function wp_variation_picture($variation_id_array){
    global $wpdb;
    $img_arr[] = array();
    foreach ($variation_id_array as $var_id){
        if(!empty($var_id)){
            $object_var = get_object_vars($var_id);
            $sql_query = "SELECT post_content FROM wp_posts WHERE ID = ".(int)$object_var['variation_id'];
            $result = $wpdb->get_results($sql_query);
            array_push($img_arr, $result);
        }
    }
    return $img_arr;
}




/**
 * /php function for fetching the items for each  order and return a new mapping containing the following information:
 * 1) order nr : array(size, color, size, design, variation, status: array(printing, packaging, shippinh)
 * The fields that are needed are:
 * 1) order_name (variation)
 *  a) Color
 *  b) Size
 * 2) order number
 */
function table_ordered_items($sql_result){
    $new_arr[] = array();
    foreach ($sql_result as $ordered_item){
        $result_decode = get_object_vars($ordered_item);
        $order_id = $result_decode['order_id'];
        $order_item_id = $result_decode['order_item_id'];
        $order_item_name = $result_decode['order_item_name'];
        $variation_query_result= wp_product_lookup_variation_id($order_id, $order_item_id);
        $img_array = wp_variation_picture($variation_query_result);
        $order_item_name_elements = order_name_tokenizer($order_item_name);
        if(count($order_item_name_elements) != 1){
            array_push($new_arr, [$order_id, $order_item_name, $order_item_name_elements[1], $order_item_name_elements[2],$img_array[0]]);
        }
    }
    return $new_arr;
}

/**
 * Function for tokenizing the name of the product
 */
function order_name_tokenizer($order_item_name){
    $order_item_name_tokens[] = array();
    $design_types = ["Bold", "Plain"];
    $order_item_design = "";
    $order_item_size = "";
    $order_item_name =  explode(",", $order_item_name);
    if(count($order_item_name) == 2){
        $order_item_size = $order_item_name[1];
        $order_item_name = $order_item_name[0];
        $order_item_name  = explode(" ", $order_item_name);
        $order_item_color = $order_item_name[count($order_item_name) - 1];
        foreach ($order_item_name as $token_order_name){
            if(in_array($token_order_name, $design_types)){
                $order_item_design = $token_order_name;
            }
        }
        array_push($order_item_name_tokens, $order_item_color);
        array_push($order_item_name_tokens, $order_item_size);
        //array_push($order_item_name_tokens, $order_item_design);
    }

    return $order_item_name_tokens;
}

$order_items_array = wp_woocommerce_ordered_items();
$table_items_array = table_ordered_items($order_items_array);
array_shift($table_items_array);
$chunked_table_items = array_chunk($table_items_array, 30, true);

?>
<!DOCTYPE html>
<html lang="en">
    <header>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script type="text/javascript">
             function table_elements(index) {
                let chunked_content = <?php echo json_encode($table_items_array, true)?>;
                let text = "";
                for(var i = (index-1)*30; i < index*30; i++){
                    var chunked_text = chunked_content[i].toString().split(",");
                    text += "<tr><th scope='row'>"+chunked_text[0]+"</th>";
                    text += "<td>"+chunked_text[1]+"</td>";
                    text += "<td>"+chunked_text[3]+"</td>";
                    text += "<td>"+chunked_text[2]+"</td>";
                    text += "<td> the variation image </td>";
                    var id_status = "status-bar-".i;
                    var id_button = "button-id".i;
                    text += "<td><span class=\"badge badge-primary\" id=\""+id_status+"\">Printing</span>";
                    text += "<button style=\"float: right\" class=\"btn btn-primary\" id=\""+id_button+"\">SEGUENTE</button>";
                    text+="</tr>";
                }
                document.getElementById("table_content").innerHTML = text;
                window.alert(index);
             }

             function status_update(){
                 //TO DO FUNCTION FOR CHENGING THE STATUS
             }
        </script>
    </header>
    <body onload="table_elements(1)">
    <div class="container-fluid">
        <h3 style="color: #0A246A; padding: 20px; text-decoration: underline"><?php echo strtoupper($_GET['page'])?></h3>
    </div>
    <div class="container-fluid">
        <table class="table">
            <thead class="thead-dark">
            <tr style="background-color: #6610f2">
                <th scope="col">#Nr Ordine</th>
                <th scope="col">Prodotto</th>
                <th scope="col">Colore</th>
                <th scope="col">Taglia</th>
                <th scope="col">Variazione</th>
                <th scope="col">Stato</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <?php
            ?>
            <tbody id="table_content"></tbody>
        </table>
        <div class="container-fluid" id="pagination_links">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                        for($i = 1; $i <= count($chunked_table_items);$i++){
                            $index = $i-1;
                            echo "<li class=\"page-item\" onclick=\"table_elements($i)\"><a class=\"page-link\">$i</a></li>";
                        }
                     ?>

                </ul>
            </nav>
        </div>
    </div>
    </body>
    <footer>

    </footer>
</html>
