<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th class="center aligned">Meios de Pagamento</th>
        </tr>
        <tr>
            <th>Meio de Pagamento</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($lista as $item){
            echo '<tr>';
            
            echo "<td>";
            echo $item['mp'];
            echo "</td>";
            
            echo '</tr>';
        }
        ?>
    </tbody>
    
</table>