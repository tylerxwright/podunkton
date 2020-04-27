<?php
	if($session->user){
?>
<script type="text/javascript">
	
	function lightup1(obj){
			obj.src = "/theme/images/store/buy_now1_hover.png";
	}
	
	function turnoff1(obj){
			obj.src = "/theme/images/store/buy_now1.png";
	}
	
	function lightup2(obj){
			obj.src = "/theme/images/store/buy_now2_hover.png";
	}
	
	function turnoff2(obj){
			obj.src = "/theme/images/store/buy_now2.png";
	}
	
</script>

<link rel="stylesheet" type="text/css" href="/theme/scripts/store.css" />

<div id="storePage">
	<div id="storeTop">
		<div id="paypal_link_button">
			<a href="http://www.paypal.com/" target="_blank"><img src="/theme/images/store/paypal_link_button.png" /></a>
		</div>
	</div>
	<div id="storeMiddle">
		<div id="store_middle_left">
			<div id="buyNow_button01">
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick">
				<!--<input type="hidden" name="business" value="cycongod@yahoo.com">-->
				<input type="hidden" name="business" value="seller_1224638542_biz@gmail.com ">
				<input type="hidden" name="item_name" value="<?php echo MONTHLY_NAME; ?>">
				<input type="hidden" name="item_number" value="<?php echo MONTHLY_ITEMID; ?>">
				<input type="hidden" name="amount" value="<?php echo MONTHLY_PRICE; ?>">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="on0" value="<?php echo $session->user; ?>">
				<!--<input type="hidden" name="on1" value="1">-->
				<input type="hidden" name="no_note"value="1">
				<input type="hidden" name="shipping" value="0">
				<input type="hidden" name="shipping2" value="0">
				<input type="hidden" name="handling" value="0">
				<input type="hidden" name="cbt" value="Return to Podunkton!">
				<input type="hidden" name="cpp_headerback_color" value="#CDDAF9">
				<input type="hidden" name="cpp_headerborder_color" value="#333333">
				<input type="hidden" name="no_shipping" value="1">
				<input type="hidden" name="return" value="<?php echo RETURN_URL; ?>">
				<input type="hidden" name="cancel_return" value="<?php echo CANCEL_URL; ?>">
				<input type="hidden" name="bn"  value="PodunktonStudios_BuyNow_US">
				<input onmouseover="lightup1(this);" onmouseout="turnoff1(this);" type="image" src="/theme/images/store/buy_now1.png" border="0" name="submit" alt="" style="behavior: url(/iepngfix.htc);">
				<img alt="" border="0" src="/theme/images/store/buy_now1.png" width="1" height="1" style="behavior: url(/iepngfix.htc);">
				</form>
			</div>
		</div>
		<div id="store_middle_right"></div>
		<div style="clear: both;"></div>
	</div>

	<div id="storeBottom">
		<div class="buyNow_button02" style="padding-left: 270px; padding-top: 155px;">
			<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<!--<input type="hidden" name="business" value="cycongod@yahoo.com">-->
			<input type="hidden" name="business" value="seller_1224638542_biz@gmail.com ">
			<input type="hidden" name="item_name" value="<?php echo CREDITS_50_NAME; ?>">
			<input type="hidden" name="item_number" value="<?php echo CREDITS_50_ITEMID; ?>">
			<input type="hidden" name="amount" value="<?php echo CREDITS_50_PRICE; ?>">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="on0" value="<?php echo $session->user; ?>">
			<!--<input type="hidden" name="on1" value="1">-->
			<input type="hidden" name="no_note"value="1">
			<input type="hidden" name="shipping" value="0">
			<input type="hidden" name="shipping2" value="0">
			<input type="hidden" name="handling" value="0">
			<input type="hidden" name="cbt" value="Return to Podunkton!">
			<input type="hidden" name="cpp_headerback_color" value="#CDDAF9">
			<input type="hidden" name="cpp_headerborder_color" value="#333333">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="<?php echo RETURN_URL; ?>">
			<input type="hidden" name="cancel_return" value="<?php echo CANCEL_URL; ?>">
			<input type="hidden" name="bn"  value="PodunktonStudios_BuyNow_US">
			<input onmouseover="lightup2(this);" onmouseout="turnoff2(this);" type="image" src="/theme/images/store/buy_now2.png" border="0" name="submit" alt="" style="behavior: url(/iepngfix.htc);">
			<img alt="" border="0" src="/theme/images/store/buy_now2.png" width="1" height="1" style="behavior: url(/iepngfix.htc);">
			</form>
		</div>
		
		<div class="buyNow_button02" style="padding-left: 90px; padding-top: 155px;">
			<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<!--<input type="hidden" name="business" value="cycongod@yahoo.com">-->
			<input type="hidden" name="business" value="seller_1224638542_biz@gmail.com ">
			<input type="hidden" name="item_name" value="<?php echo CREDITS_100_NAME; ?>">
			<input type="hidden" name="item_number" value="<?php echo CREDITS_100_ITEMID; ?>">
			<input type="hidden" name="amount" value="<?php echo CREDITS_100_PRICE; ?>">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="on0" value="<?php echo $session->user; ?>">
			<!--<input type="hidden" name="on1" value="1">-->
			<input type="hidden" name="no_note"value="1">
			<input type="hidden" name="shipping" value="0">
			<input type="hidden" name="shipping2" value="0">
			<input type="hidden" name="handling" value="0">
			<input type="hidden" name="cbt" value="Return to Podunkton!">
			<input type="hidden" name="cpp_headerback_color" value="#CDDAF9">
			<input type="hidden" name="cpp_headerborder_color" value="#333333">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="<?php echo RETURN_URL; ?>">
			<input type="hidden" name="cancel_return" value="<?php echo CANCEL_URL; ?>">
			<input type="hidden" name="bn"  value="PodunktonStudios_BuyNow_US">
			<input onmouseover="lightup2(this);" onmouseout="turnoff2(this);" type="image" src="/theme/images/store/buy_now2.png" border="0" name="submit" alt="" style="behavior: url(/iepngfix.htc);">
			<img alt="" border="0" src="/theme/images/store/buy_now2.png" width="1" height="1" style="behavior: url(/iepngfix.htc);">
			</form>
		</div>
		
		<div class="buyNow_button02" style="padding-left: 95px; padding-top: 155px;">
			<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<!--<input type="hidden" name="business" value="cycongod@yahoo.com">-->
			<input type="hidden" name="business" value="seller_1224638542_biz@gmail.com ">
			<input type="hidden" name="item_name" value="<?php echo CREDITS_200_NAME; ?>">
			<input type="hidden" name="item_number" value="<?php echo CREDITS_200_ITEMID; ?>">
			<input type="hidden" name="amount" value="<?php echo CREDITS_200_PRICE; ?>">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="on0" value="<?php echo $session->user; ?>">
			<!--<input type="hidden" name="on1" value="1">-->
			<input type="hidden" name="no_note"value="1">
			<input type="hidden" name="shipping" value="0">
			<input type="hidden" name="shipping2" value="0">
			<input type="hidden" name="handling" value="0">
			<input type="hidden" name="cbt" value="Return to Podunkton!">
			<input type="hidden" name="cpp_headerback_color" value="#CDDAF9">
			<input type="hidden" name="cpp_headerborder_color" value="#333333">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="<?php echo RETURN_URL; ?>">
			<input type="hidden" name="cancel_return" value="<?php echo CANCEL_URL; ?>">
			<input type="hidden" name="bn"  value="PodunktonStudios_BuyNow_US">
			<input onmouseover="lightup2(this);" onmouseout="turnoff2(this);" type="image" src="/theme/images/store/buy_now2.png" border="0" name="submit" alt="" style="behavior: url(/iepngfix.htc);">
			<img alt="" border="0" src="/theme/images/store/buy_now2.png" width="1" height="1" style="behavior: url(/iepngfix.htc);">
			</form>
		</div>
		<div style="clear: both"></div>
	</div>
	
	<div style="width: 792px; height: 6px; line-height: 0px; font-size: 1px;"></div>
	<div id="store_ad">
		<img src="/theme/images/forums_ad2.png" />
	</div>
	
</div>
<?php 
	} else {
		include_once("theme/errordocs/permission.tpl.php");
	}
?>

