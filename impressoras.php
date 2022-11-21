<?php
include('cabecalho.php');
$cliente = $_GET['id'];
?>
<div class="container">
    <br>
    <h1>Lista de Impresoras</h1>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Impressora</th>
                <th scope="col">Série</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $resposta = removeCaracteresDeString(retornaImpressoras($cliente), $caracteresChamadaPadrao);
            $arrayDeImpressoras = converteStringEmArray($resposta, $caractereTransformarArrayPadrao);

            foreach ($arrayDeImpressoras as $impressora) {
                if (strpos($impressora, "PrinterDeviceID")) {
                    echo "<tr>";
                    $idImpressora = '';
                    $impressora = removeCaracteresDeString($impressora, $caracteresChamadaImpressora);
                    $impressora = converteStringEmArray($impressora, $caractereTransformarArrayImpressora);
                    foreach ($impressora as $imp) {
                        echo "<td>" . $imp . "</td>";
                        if (valorEhInteiro($imp)) {
                            $idImpressora = $imp;
                        }
                    }
                    echo "  <td>
                                <a href='contatoImpressora.php?emp=$cliente&imp=$idImpressora'>Alterar Contato</a>
                                <a href='desabilitaMonitoracao.php?emp=$cliente&imp=$idImpressora'>Desabilitar monitoração</a>
                            </td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('rodape.php') ?>