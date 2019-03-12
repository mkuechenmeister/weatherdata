<?php
    /**
     * Created by PhpStorm.
     * User: Martin
     * Date: 07.03.2019
     * Time: 19:42
     */
    require_once("Controller.php");
    require_once("models/Weatherdata.php");

    class WeatherdataController extends Controller
    {

        public function handleRequest($route)
        {
            $operation = sizeof($route) > 1 ? $route[1] : 'index';
            $id = isset($_GET['id']) ? $_GET['id'] : 0;


            switch ($operation) :
                case "index":
                    $this->actionIndex();
                    break;
                case  "view":
                    $this->actionView($id);
                    break;
                case  "create":
                    $this->actionCreate();
                    break;
                case "update":
                    $this->actionUpdate($id);
                    break;
                case "delete":
                    $this->actionDelete($id);
                    break;
                default:
                    Controller::showError("Page not found", "page for operation " . htmlspecialchars($operation) ." was not found");
                    break;

            endswitch;


        }

        public function actionIndex()
        {
            $model = Weatherdata::getAll();
            $this->render("measurement/index", $model);
        }

        public function actionView($id)
        {
            $model = Weatherdata::get($id);
            $this->render("measurement/view", $model);


        }

        public function actionCreate()
        {
            $model = new Weatherdata(null, '', '', '', '');

            if (!empty($_POST)) {

                $temperature = htmlspecialchars($_POST['temperature']);
                $humidity = htmlspecialchars($_POST['humidity']);

                $model->setTemperature($temperature);
                $model->setHumidity($humidity);
                $model->validate();
                $model->save();


//                Weatherdata::createNewData($temperature, $humidity);


                    $this->redirect('measurement/index');
                    return;

            }

            $this->render('measurement/create', $model);
        }

        public function actionUpdate($id)
        {
            $model = Weatherdata::get($id);

            if (!empty($_POST)) {

                //$model->setTime(date("y-m-d H:m:s"));
                $model->setTemperature(isset($_POST['temperature']) ? $_POST['temperature'] : '');
                $model->setHumidity(isset($_POST['humidity']) ? $_POST['humidity'] : '');


                if ($model->save()) {
                    $this->redirect('measurement/index');
                    return;
                }
            }

            $this->render('measurement/update', $model);
        }

        public function actionDelete($id)
        {
            if (!empty($_POST)) {
                Weatherdata::delete($id);
                $this->redirect('measurement/index');
                return;
            }

            $this->render('measurement/delete', Weatherdata::get($id));
        }


    }