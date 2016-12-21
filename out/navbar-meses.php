<div class="ui three item inverted menu">
    <a class="item" href="index.php?mes=<?=$mes_anterior;?>">
    <i class="chevron left icon"></i>
    <?=formata_mes($mes_anterior);?>
  </a>
  <a class="active green item">
    <!--<i class="calendar outline icon"></i>-->
    <?=formata_mes($mes);?>
  </a>
  <a class="item" href="index.php?mes=<?=$mes_seguinte;?>">
        <?=formata_mes($mes_seguinte);?>
      <i class="chevron right icon"></i>
  </a>
</div>