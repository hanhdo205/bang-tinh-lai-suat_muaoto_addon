<?php
function add_laisuat_form() { 
	ob_start();
	$options = get_option('laisuat');
  
	global $muaoto_settings;
	$muaoto_settings  = get_options();
	wp_enqueue_style('devvn-muaoto-style');
	wp_enqueue_script('devvn-muaoto-script');
	$noi_mua = $muaoto_settings['noi_dang_ky'];
	$phi_truoc_ba = $muaoto_settings['phi_truoc_ba'];
	$bao_hiem_vat_chat = $muaoto_settings['bao_hiem_vat_chat'];
	$phi_duong_bo = $muaoto_settings['phi_duong_bo'];
	$dang_kiem = $muaoto_settings['dang_kiem'];
	$dich_vu_dang_ky = $muaoto_settings['dich_vu_dang_ky'];
	$bao_hiem_bat_buoc = $muaoto_settings['bao_hiem_bat_buoc'];
	$mess_dutoan = $muaoto_settings['mess_dutoan'];
  ?>
  <div class="laisuat_muaoto_left">
    <form class="input-form devvn_muaoto_wrap">
          <label for="mauxe"><?php _e('Car model', 'laisuat');?></label>
          <div class="input-box">
                <?php wp_dropdown_categories('show_count=0&selected=-1&hierarchical=1&depth=1&hide_empty=0&exclude=1&show_option_none=Model&name=devvn_nhomxe&taxonomy=dong_xe');?>
          </div>
      	  
      	  <label for="dongxe"><?php _e('Car type', 'laisuat');?></label>
          <div class="input-box">
      		<select name="devvn_phienbanxe" id="devvn_phienbanxe" class="input_to_calc">
      			<option value=""><?php _e('Select', 'laisuat');?></option>
      		</select>
          </div>
  	  
  	       <label for="dongxe"><?php _e('City', 'laisuat');?></label>
    	     <div class="input-box">
    			   <select name="devvn_chonnoimua" id="devvn_chonnoimua" class="input_to_calc">
    			     <option value=""><?php _e('City', 'laisuat');?></option>
      				  <?php if($noi_mua && !empty($noi_mua)):?>
      					<?php foreach($noi_mua as $k=>$v):
      						$name = isset($v['name']) ? esc_attr($v['name']) : '';
      						$price = isset($v['price']) ? floatval($v['price']) : '';
      						?>
      						<option value="<?php echo $price;?>"><?php echo $name;?></option>
      					<?php endforeach;?>
      				  <?php endif;?>
    			   </select>
          </div> 
          <input type="hidden" id="phitruocba_val" value="0" class="input_to_calc">
      	  <input type="hidden" id="baohiemvatchat_val" value="0" class="input_to_calc">
      	  <input type="hidden" value="<?php echo $phi_duong_bo;?>" class="input_to_calc">
      	  <input type="hidden" value="<?php echo $dang_kiem;?>" class="input_to_calc">
      	  <input type="hidden" value="<?php echo $dich_vu_dang_ky;?>" class="input_to_calc">
      	  <input type="hidden" value="<?php echo $bao_hiem_bat_buoc;?>" class="input_to_calc">
      	  <label for="amount"><?php _e('Amount', 'laisuat'); ?></label>
          <div class="input-box">
              <input type="text" class="form-control" name="amount_txt" id="amount_txt" class="amount_txt" value="" size="30" required>
              <input type="hidden" class="form-control" name="total" id="total" class="total" value="" size="30" >
          </div>
          <label for="prepaid"><?php _e('Prepaid', 'laisuat'); ?></label>
          <div class="input-box">
              <select id="first_price" name="first_price" class="form-control width-r">
                  <option><?php _e('Prepaid', 'laisuat'); ?></option>
                  <option value="0">0 %</option>
                  <option value="10">10 %</option>
                  <option value="20">20 %</option>
                  <option value="30">30 %</option>
                  <option value="40">40 %</option>
                  <option value="50">50 %</option>
                  <option value="60">60 %</option>
                  <option value="70">70 %</option>
                  <option value="80">80 %</option>
              </select>
          </div>
          <label for="month"><?php _e('Month', 'laisuat'); ?></label>
          <div class="input-box">
              <input type="number" class="form-control" name="month" id="month" class="month" value="" size="30" required>
          </div>
          <label for="rate"><?php _e('Rate (%)', 'laisuat'); ?></label>
          <div class="input-box">
            <input type="number" class="form-control" name="rate" id="rate" class="rate" value="" size="30" required>
          </div>
          <div class="button-div">
    		    <button type="button" class="button_dutoanchiphi show"><?php _e('Xem dự toán', 'laisuat');?></button>
          </div>
    </form>
  </div>
  <div class="laisuat_muaoto_right">
    <div id="show-rate-result">
      <table class="bangtinh">
        <thead>
          <th colspan="2">
            Kỳ thanh toán
          </th>
          <th>
            Ngày tính lãi
          </th>
          <th>
            Tiền còn phải trả
          </th>
          <th>
            Tiền gốc phải trả/tháng
          </th>
          <th>
            Tiền lãi phải trả/tháng
          </th>
          <th>
            Tổng tiền trả hàng tháng
          </th>
        </thead>
        <tbody class="result-body">
          <tr>
            <td>0</td>
            <td class="ky-thanh-toan"></td>
            <td></td>
            <td class="amount-start"></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      
      <div>Tổng lãi gộp: <span class="tong-lai-gop">0</span></div>
      <div>Tổng gốc + lãi gộp: <span class="tong-goc-lai-gop">0</span></div>
    </div>
  </div>
  <script type = 'text/javascript'>
    var congthuc = "<?php echo $options['basic_rate']; ?>";
    var BASE_URL = "<?php echo plugins_url(); ?>/laisuat";
  </script>
<?php 
$result = ob_get_contents();
ob_end_clean();
return $result;

} 

add_shortcode('laisuat','add_laisuat_form');
?>