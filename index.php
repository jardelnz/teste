<?php
include('cabecalho.php');
?>

<div class="container">
    <br>
    <h1>Lista de Empresas</h1>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Empresa</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php

            $reposta = removeCaracteresDeString(retornaEmpresas(), $caracteresChamadaPadrao);
            $arrayDeEmpresas = converteStringEmArray($reposta, $caractereTransformarArrayPadrao);

            foreach ($arrayDeEmpresas as $empresa) {
                if (strpos($empresa, "EnterpriseID")) {
                    echo "<tr>";
                    $idEmpresa = '';
                    $empresa = removeCaracteresDeString($empresa, $caracteresChamadaEmpresa);
                    $empresa = converteStringEmArray($empresa, $caractereTransformarArrayImpressora);
                    foreach ($empresa as $emp) {
                        echo "<td>" . $emp . "</td>";
                        if (valorEhInteiro($emp)) {
                            $idEmpresa = $emp;
                        }
                    }
                    echo "<td><a href='impressoras.php?id=$idEmpresa'>Vizualizar impressoras</a></td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('rodape.php') ?>