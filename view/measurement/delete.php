<div class="container">
    <h2>Wettereintrag ID:<?=$model->getId();?> löschen</h2>

    <form class="form-horizontal" action="index.php?r=measurement/delete&id=<?= $model->getId() ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $model->getid(); ?>"/>
        <p class="alert alert-error">Wollen Sie die Wetterdaten
            vom <?= $model->getTime() . " / Temperatur: " . $model->getTemperature(). " / Luftfeuchtigkeit:  " . $model->getHumidity() ?> wirklich löschen?</p>
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-default" href="index.php?r=measurement/index">Abbruch</a>
        </div>
    </form>

</div> <!-- /container -->