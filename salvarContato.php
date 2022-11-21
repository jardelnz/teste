<?php
include('funcoes.php');
echo alterarContatoDaImpressora($_POST['cliente'], $_POST['impressora'], $_POST['contato']);
header("Location: impressoras.php?id=".$_POST['cliente']);
?>