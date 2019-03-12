<?php
    /**
     * Created by PhpStorm.
     * User: Martin
     * Date: 07.03.2019
     * Time: 19:42
     */
    require_once("RESTController.php");
    require_once("models/Weatherdata.php");

    class WeatherdataRestController extends RESTController
    {

        public function handleRequest()


        {
            switch ($this->method) :
                case 'GET':
                    $this->handleGETRequest();
                    break;
                case 'POST':
                    $this->handlePOSTRequest();
                    break;
                case 'PUT':
                    $this->handlePUTRequest();
                    break;
                case 'DELETE':
                    $this->handleDELETERequest();
                    break;
                default:
                    $this->response('Method Not Allowed', 405);
                    break;
            endswitch;


        }

        /**
         * get single/all credentials or search credentials
         * all credentials: GET api.php?r=credentials
         * single credentials: GET api.php?r=credentials/25 -> args[0] = 25
         * search credentials: GET api.php?r=credentials/search/domain.at -> verb = search, args[0] = domain.at
         */
        private function handleGETRequest()
        {
            if ($this->verb == null && sizeof($this->args) == 0) {
                $model = Weatherdata::getAll();
                $this->response($model);
            } else if ($this->verb == null && sizeof($this->args) == 1) {
                $model = Weatherdata::get($this->args[0]);
                $this->response($model);
            } else if ($this->verb == 'search' && sizeof($this->args) == 1) {
                $model = Weatherdata::getAll($this->args[0]);
                $this->response($model);
            }else if ($this->verb == 'day' && sizeof($this->args) == 1) {

                $model = Weatherdata::getAll($this->args[0]);
                $this->response($model);
            }else if ($this->verb == 'month' && sizeof($this->args) == 1) {
                $temp = $this->args[0];
                $temp = explode("-", $temp);
                $temp = $temp[0] . "-" . $temp[1];
                $model = Weatherdata::getAll($temp);
                $this->response($model);
            }else if ($this->verb == 'year' && sizeof($this->args) == 1) {
                $temp = $this->args[0];
                $temp = explode("-", $temp);
                $temp = $temp[0];
                $model = Weatherdata::getAll($temp);
                $this->response($model);
            }
            else {
                $this->response("Bad request", 400);
            }
        }

        /**
         * create credentials: POST api.php?r=credentials
         */
        private function handlePOSTRequest()

        {
            $model = new Weatherdata();
            $time = isset($this->file['time']) ? $this->file['time'] : null;
            $temperature = isset($this->file['temperature']) ? $this->file['temperature'] : null;
            $humidity = isset($this->file['humidity']) ? $this->file['humidity'] : null;

            $model->setTime($time);
            $model->setTemperature($temperature);
            $model->setHumidity($humidity);

            if ($model->validate()) {
                $id=$model->save();
                $this->response(Weatherdata::get($id), 201);
            }

//            if ($temperature != null & $humidity != null) {
//                $id = Weatherdata::createNewData($temperature, $humidity);
//                $this->response(Weatherdata::get($id), 201);

            else
                $this->response("Eingangsdaten Fehlerhaft", 400);


        }

        /**
         * update credentials: PUT api.php?r=credentials/25 -> args[0] = 25
         */
        private function handlePUTRequest()
        {
            if ($this->verb == null && sizeof($this->args) == 1) {

                $model = Weatherdata::get($this->args[0]);
                if ($model != null) {


                    $temperature = isset($this->file['temperature']) ? $this->file['temperature'] : null;
                    $humidity = isset($this->file['humidity']) ? $this->file['humidity'] : null;


                    $model->setTemperature($temperature);
                    $model->setHumidity($humidity);
                    $id=$model->getId();

                    if ($model->validate()) {
                        $model->save();
                        $this->response(Weatherdata::get($id), 200);
                    } else {
                        $this->response("Put konnte nocht durchgeführt werden", 400);
                    }
                }
                $this->response("Not Found", 404);

            } else {

                $this->response("Not Found", 404);
            }
        }

        /**
         * delete credentials: DELETE api.php?r=credentials/25 -> args[0] = 25
         */
        private function handleDELETERequest()
        {
            if ($this->verb == null && sizeof($this->args) == 1) {
                Weatherdata::delete($this->args[0]);
                $this->response("OK", 200);
            } else {
                $this->response("Not Found", 404);
            }
        }


    }