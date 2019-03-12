<div class="container">

    <div class="row">
        <h1 class="display-4">Wetterstation</h1>


        <div class="container ">


            <div class="form-check-inline">
                <input id="filter" type="date" class="form-control" name="date">

                <input id="day" type="radio" name="detail" checked value="day">Tag <br>
                <input id="month" type="radio" name="detail" value="month">Monat <br>
                <input id="year" type="radio" name="detail"  value="year">Jahr <br>

            </div>



            <button class="btn btn-info" id="btnSearch" ><i data-feather="eye"></i> anzeigen</button>
            <button class="btn btn-danger" id="btnClear" ><i data-feather="trash"></i> x</button>
            <a href="index.php?r=measurement/create" class="btn btn-success" ><i data-feather="plus"></i> Neu</a>
        </div>




    </div>


    <div class="chart">
        <canvas id="myChart"></canvas>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Zeitpunkt</th>
            <th>Temperatur</th>
            <th>Luftfeuchtigkeit</th>
            <th><i class="fa fa-address-card-o" aria-hidden="true"></i></th>
        </tr>
        </thead>
        <tbody id="weatherdata">
        <?php
            $label = [];
            $temp = [];
            $hum = [];
            foreach ($model as $c) {
                echo '<tr>';
                echo '<td>' . $c->getTime() . '</td>';
                echo '<td>' . $temp[]=floatval($c->getTemperature()) . '°C</td>';
                echo '<td>' . $hum[]=floatval($c->getHumidity()) . '%</td>';
                echo '<td>';
                echo '<a class="btn btn-info" href="index.php?r=measurement/view&id=' . $c->getId(). '"><i data-feather="eye"></i></a>';
                echo '&nbsp;';
                echo '<a class="btn btn-primary" href="index.php?r=measurement/update&id=' . $c->getId() . '"><i data-feather="edit"></i></a>';
                echo '&nbsp;';
                echo '<a class="btn btn-danger" href="index.php?r=measurement/delete&id=' . $c->getId() . '"><i data-feather="trash-2"></i></span></a>';
                echo '</td>';
                echo '</tr>';

                $label[] = $c->getId();
            }











        ?>



        </tbody>
    </table>



</div> <!-- /container -->


<script src="js/chart.js">
    setLabel(<?php
        $label;
        ?>);
    setTemperature(<?php
        $temp;?>);
    setHumidity(<?php
        $hum;?>);
    updateChart();
</script>




