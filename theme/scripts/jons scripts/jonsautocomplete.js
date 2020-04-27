<?php
include_once("config.php");
?>  


<script src="/theme/scripts/jons scripts/prototype.js" script type="text/javascript"></script>
<script src="/theme/scripts/jons scripts/scriptaculous.js" script type="text/javascript"></script>

<style type="text/css">
<!--
body,td,th {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}

.page_name_auto_complete li{
border: solid thin; 
padding:5px; 
list-style:none;
}

.page_name_auto_complete li:hover{
border: solid thin; 
padding:5px;
background-color:#333333;
color:#FFFFFF;
list-style:none;
}
-->
</style>
  

<label for="bands_from_the_70s"></label>
 <form name="form1" method="post" action="">
  <label for="bands_from_the_70s"></label>
  <input name="text" type="text" id="bands_from_the_70s" value="" size="15" autocomplete="off" />
  </p>

  <label></label>
  <input name="Go" type="submit" id="Go" value="Go">
</form>
<div class="page_name_auto_complete" id="band_list"></div>

  <?php

    echo "<script type=\"text/javascript\">
    new Autocompleter.Local('bands_from_the_70s', 'band_list',[";
    ?>
  <?php
    $get = mysql_query("SELECT * FROM band")or die(mysql_error());
    while($r = mysql_fetch_array($get)){
    echo "'$r[band]',";}
    echo "'No DVD'],{}";
    echo "); \n</script>";
?> 