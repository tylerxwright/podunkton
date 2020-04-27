<?php
/*
 * Created on Oct 6, 2008
 */
?>
<style type="text/css">

div#trading_pass {
	margin: 40px auto;
	width: 747px;
}

div#trading_top {
	width: 747px;
	height: 9px;
	background-image: url("/theme/images/tradingPassTop.png");
}

div#trading_bot {
	width: 747px;
	height: 9px;
	background-image: url("/theme/images/tradingPassBot.png");
}

div#trading_mid {
	width: 727px;
	height: 88px;
	background-color: #CDDAF9;
	border-left: solid 1px #7E7E7E;
	border-right: solid 1px #7E7E7E;
	padding: 0px 10px;
	color: #3A3A3A;
	text-align: center;
}

</style>
<div style="width: 100%;">
	<div id="trading_pass">
		<div id="trading_top"></div>
		<div id="trading_mid">
			<span style="font-weight: bold">TRADE AUTHENTICATION PASS REQUIRED!!</span><br/>
			<span style="font-size: 10pt;">
			Before you can trade, you'll need to verify your citizenship with the Podunkton Trade Bureau. To do so, you will need
			to purchase the Trade Authentication Pass. It costs <b><?php echo TRADING_PASS_COST; ?> Munniez</b>. Would you like to purchase your Trade Authentication
			Pass now?
			</span><br/>
			<img border="0" src="/theme/images/purchasePass.png" style="cursor: pointer;" onclick="location='/process/buyTradingPass';"/>
		</div>
		<div id="trading_bot"></div>
	</div>
</div>