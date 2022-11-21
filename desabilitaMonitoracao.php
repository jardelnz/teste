<?php 
include('funcoes.php');
desabilitaMonitoracao($_GET['emp'], $_GET['imp']);
header("Location: impressoras.php?id=".$_GET['emp']);
?>