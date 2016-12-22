
<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th colspan="2" class="center aligned">Resultado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Resultado do mês</td>
            <td class="right aligned collapsing <?=$cor_mes;?>"><?php echo formata_numero($saldo_mes_atual);?></td>
        </tr>
        <tr>
            <td>Mês Anterior</td>
            <td class="right aligned collapsing <?=$cor_anterior;?>"><?php echo formata_numero($saldo_mes_anterior);?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="left aligned">Saldo Final</th>
            <th class="right aligned collapsing <?=$cor_final;?>"><?php echo formata_numero($saldo_final);?></th>
        </tr>
    </tfoot>
</table>

<script>
//    inicializa acordion
$('.ui.accordion').accordion();

</script>