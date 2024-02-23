<?php 
/*
Plugin Name:Category Faq
Description:Custom plugin for category faq fields
*/
function create_custom_field_on_category( $tag ) {
$question_data_get = get_term_meta( $tag->term_id, 'question_data', true );
$answers_data_get = get_term_meta( $tag->term_id, 'answers_data', true );
$category_head_title = get_term_meta( $tag->term_id, 'category_head_title', true );
$question_data_get = unserialize($question_data_get);
$answers_data_get = unserialize($answers_data_get);
$question_data_get = array_filter($question_data_get);
$answers_data_get = array_filter($answers_data_get);
$count_array1 = count($question_data_get);
?>	  
<style>
#edittag input[type="text"] {
    height: 38px;
}
#edittag textarea {
    height: 100px;
}
 #edittag td:first-child {
    width: 5% !important;
}
#edittag input#remove_field_el {
    height: 37px;
    width: 80px;
}
#edittag button.add_more {
    height: 37px;
    width: 90px;
}
#edittag {
    max-width: 1300px;
}

#edittag .form-table td {
    width: 30%;
}
</style>
<tr class="form-field">  
<th>Category Title</th>
<td><input type="text" name="category_title" value="<?php echo $category_head_title;?>"></td>
</tr>
<?php
if(!empty($question_data_get) && !empty($answers_data_get)) {

$counter=1;
echo"<pre>";  
print_r($question_data_get);
echo"</pre>";
for($i=0;$i<10;$i++){ 

?>
  <tr class="form-field  newfield_get field_index_<?php echo $i?>" data-no="<?php echo $i;?>" data-counter="<?php echo $counter;?>">
    <td class="counts_number"><?php echo $counter;?></td>  
	<td><input type="text" name="question_<?php echo $i;?>" value="<?php if(empty($question_data_get[$i])){ }else{ echo $question_data_get[$i]; }?>"></td>
    <td><textarea type="text" name="answer_<?php echo $i;?>"><?php if(empty($answers_data_get[$i])){ }else{ echo $answers_data_get[$i]; }?></textarea></td>	
	<!--<td><input type="button" id="remove_field_el" value="Remove"></td>-->
	</tr>
    <?php 
    $counter++;
	}
    
}
else{
$counter=1;
for($i=0;$i<10;$i++){   	
?>
  <tr class="form-field  newfield_get field_index_<?php echo $i?>" data-no="<?php echo $i;?>" data-counter="<?php echo $counter;?>">
    <td class="counts_number"><?php echo $counter;?></td>
	<td><input type="text" name="question_<?php echo $i;?>" value=""></td>
    <td><textarea type="text" name="answer_<?php echo $i;?>"></textarea></td>	
	<!--<td><input type="button" id="remove_field_el" value="Remove"></td>-->
	</tr>
    <?php 
    $counter++;
	}
}
	?>	
	
	
    <!--<tr class="form-field add_more_sec">
    <td><button type="button" class="add_more">Add More</button></td>
    </tr>-->	
<script>
jQuery(document).on("click",'#remove_field_el',function(){
	var sr_no = jQuery(this).parent().parent().attr("data-no");
	
    if(sr_no == 0){
		
	}
	else{
	jQuery(this).parent().parent('.field_index_'+sr_no).remove();	
	}
});
jQuery(document).on("click",'.add_more',function(){
var curr_data_val = jQuery(".newfield_get").last().attr("data-counter");
var data_no = jQuery(".newfield_get").last().attr("data-no");
var data_no = parseInt(data_no) + 1; 
var curr_data_val = parseInt(curr_data_val) + 1; 
//alert(curr_data_val);
var resulthtml ='<tr class="form-field newfield_get field_index_'+data_no+'" data-no="'+data_no+'" data-counter='+curr_data_val+'><td class="counts_number">'+curr_data_val+'</td><td><input type="text" name="question_'+curr_data_val+'"></td><td><textarea type="text" name="answer_'+curr_data_val+'"></textarea></td><td><input type="button" id="remove_field_el" value="Remove"></td></tr>';
var output = jQuery(resulthtml);
jQuery(output).insertBefore('.add_more_sec');

});
</script>	
<?php	
}
//add_action('product_cat_add_form_fields', 'create_custom_field_on_category', 22, 1);
add_action('product_cat_edit_form_fields', 'create_custom_field_on_category', 22, 1);

add_action ( 'edited_product_cat', function( $term_id ) {
		$q_arr=array();
        $ans_arr=array();
	    $question = $_POST['question'];
		$answer = $_POST['answer'];
	
		$category_title = $_POST['category_title'];
		for($i=0;$i<15;$i++){	
		$question_field = $_POST['question_'.$i];
	    $answer_field = $_POST['answer_'.$i];
		$q_arr[]=$question_field;
		$ans_arr[]=$answer_field;
		}
		$serialize_arr1 = serialize($q_arr);
		$serialize_arr2 = serialize($ans_arr);
		update_term_meta( $term_id ,'question_data',$serialize_arr1);
        update_term_meta( $term_id ,'answers_data',$serialize_arr2); update_term_meta( $term_id ,'category_head_title',$category_title);		       
});
function show_ans_ques(){
$current_category = get_queried_object();	
$cat_idd = $current_category->term_id;
$question_data_get = get_term_meta( $cat_idd, 'question_data', true );
$answers_data_get = get_term_meta( $cat_idd, 'answers_data', true );
$category_head_title = get_term_meta( $cat_idd, 'category_head_title', true );	
$question_data_get = unserialize($question_data_get);
$answers_data_get = unserialize($answers_data_get);

$question_data_get = array_filter($question_data_get);
$answers_data_get = array_filter($answers_data_get);
$count_array = count($question_data_get);
?>
<style>
li{
list-style:none;	
}
.answer_faq{
display:none;	
}
.common_q_a img {
    width: 17px;
}
</style>
<div class="acordion_question">
<h2 class="heading_faq"><?php echo $category_head_title;?></h2>  

<?php 
for($i=0;$i<$count_array;$i++){
	?>
	<div class="common_q_a">
	<div class="q_img_sec">
	<h2 class="q_show_faq"><?php echo $question_data_get[$i];?></h2>
	<img class="arrow_img_faq" src="<?php echo site_url()?>/wp-content/uploads/2023/09/free-arrow-down-icon-3101-thumb.png">
	</div>
	<div class="answer_faq"><?php echo $answers_data_get[$i];?></div>
	</div>
	<?php
}

?>
</div>	
<script>
jQuery(document).ready(function(){
jQuery(".arrow_img_faq").click(function(){
if(jQuery(this).parent().hasClass("current_active")){
jQuery(this).parent('.current_active').parent().children('.answer_faq').slideUp();
jQuery('.common_q_a .answer_faq').slideUp();
jQuery(this).parent().removeClass('current_active');
}
else{
jQuery('.common_q_a .q_img_sec').removeClass('current_active');
jQuery(this).parent().addClass('current_active');	
jQuery('.common_q_a .answer_faq').slideUp();

jQuery(this).parent('.current_active').parent().children('.answer_faq').slideDown();
} 	 
});
});
</script>
<?php }
add_shortcode("show_question_ans","show_ans_ques");
