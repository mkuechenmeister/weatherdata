<div class="container">
    <div class="row">
        <h2>Zugangsdaten bearbeiten</h2>
    </div>

    <form class="form-horizontal" action="index.php?r=measurement/update&id=<?= $model->getId() ?>" method="post">

        <div class="row">
            <div class="col-md-5">
                <div class="form-group required <?php echo !empty($model->errors['temperature']) ? 'has-error' : ''; ?>">
                    <label class="control-label">Temperatur</label>
                    <input type="number" step=".01" class="form-control" name="temperature"
                           value="<?= $model->getTemperature(); ?>">

                    <?php if (!empty($model->errors['name'])): ?>
                        <div class="help-block"><?= $model->errors['name'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <div class="form-group required <?php echo !empty($model->errors['humidity']) ? 'has-error' : ''; ?>">
                    <label class="control-label">Luftfeuchtigkeit</label>
                    <input type="number" step=".1" class="form-control" name="humidity"
                           value="<?= $model->getHumidity(); ?>">

                    <?php if (!empty($model->errors['domain'])): ?>
                        <div class="help-block"><?= $model->errors['domain'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Aktualisieren</button>
            <a class="btn btn-default" href="index.php?r=measurement/index">Abbruch</a>
        </div>
    </form>

</div> <!-- /container -->