<?php
include('cabecalho.php');
?>

<div class="container">
    <br>
    <h1>Novo contato</h1>
    <br>
    <form method="post" action="salvarContato.php">
        <input hidden name="cliente" value="<?=$_GET['emp'] ?>">
        <input hidden name="impressora" value="<?=$_GET['imp'] ?>">
        <div class="mb-3">
            <label for="contato" class="form-label">Informe o novo contato</label>
            <input type="text" class="form-control" name="contato" id="contato" aria-describedby="contatoHelp">
            <div id="contatoHelp" class="form-text">Digite um novo contato para a impressora.</div>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>

<?php include('rodape.php') ?>