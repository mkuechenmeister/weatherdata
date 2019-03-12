<?php
    /**
     * Created by PhpStorm.
     * User: Martin
     * Date: 07.03.2019
     * Time: 16:00
     */

    include("DatabaseObject.php");

    class Weatherdata implements DatabaseObject, JsonSerializable
    {
        private $id;
        private $time;
        private $temperature;
        private $humidity;

        private $errors = "OOPS Something went wrong";

        /**
         * Weatherdata constructor.
         * @param $id
         * @param $time
         * @param $temperature
         * @param $humidity
         */
        public function __construct($id=null, $time=null, $temperature=null, $humidity=null)
        {
            $this->id = $id;
            $this->time = $time;
            $this->temperature = $temperature;
            $this->humidity = $humidity;
        }

        /**
         * @return mixed
         */
        public function getErrors()
        {
            return $this->errors;
        }

        /**
         * @param mixed $errors
         */
        public function setErrors($errors): void
        {
            $this->errors = $errors;
        }



        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id): void
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getTime()
        {
            return $this->time;
        }

        /**
         * @param mixed $time
         */
        public function setTime($time): void
        {
            $this->time = $time;
        }

        /**
         * @return mixed
         */
        public function getTemperature()
        {
            return $this->temperature;
        }

        /**
         * @param mixed $temperature
         */
        public function setTemperature($temperature): void
        {
            $this->temperature = $temperature;
        }

        /**
         * @return mixed
         */
        public function getHumidity()
        {
            return $this->humidity;
        }

        /**
         * @param mixed $humidity
         */
        public function setHumidity($humidity): void
        {
            $this->humidity = $humidity;
        }


        /**
         * create or update an object
         * @return boolean true on success
         */
        public function save()
        {

            if ($this->id != null && $this->id > 0) {
                $id=$this->update();
            } else {
               $id= $this->id = $this->create();
            }

            return $id;


        }

        public function create()

        {
            $db = Database::connect();
            $sql = "INSERT INTO weatherdata (time, temperature, humidity) values(?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($this->time,$this->temperature, $this->humidity));
            $lastId = $db->lastInsertId();
            Database::disconnect();
            return $lastId;
        }



        public function update()
        {
            $db = Database::connect();
            $sql = "UPDATE weatherdata set time = ?, temperature = ?, humidity = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($this->time, $this->temperature, $this->humidity, $this->id));
            Database::disconnect();
        }

        public static function get($id)
        {
            if (!is_numeric($id)) {
                return null;
            }

            $db = Database::connect();
            $sql = "SELECT * FROM weatherdata where id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($id));
            $d = $stmt->fetch(PDO::FETCH_NUM);
            Database::disconnect();

            if ($d == null) {
                return null;
            } else {
                return new Weatherdata($d[0],$d[1], $d[2], $d[3]);
            }
        }

        public static function getAll($filter = null)
        {
            $wd = [];
            $db = Database::connect();

            if ($filter != null) {
                $sql = "SELECT * FROM weatherdata WHERE time LIKE ? ORDER BY time ASC";
            } else {
                $sql = 'SELECT * FROM weatherdata ORDER BY time ASC';
            }

            $stmt = $db->prepare($sql);
            if ($filter != null) {
                $stmt->execute(array('%' . $filter . '%'));
            } else {
                $stmt->execute();
            }
            $data = $stmt->fetchAll(PDO::FETCH_NUM);
            Database::disconnect();

            foreach ($data as $d) {
                $wd[] = new Weatherdata($d[0],$d[1], $d[2], $d[3]);
            }
            return $wd;
        }

        public static function delete($id)

        {
            if (!is_numeric($id)) {
                return false;
            }

            $db = Database::connect();
            $sql = "DELETE FROM weatherdata WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($id));
            Database::disconnect();
            return true;
        }

        public function validate()
        {
            return
                $this->validateHelper($this->temperature) &
                $this->validateHelper($this->humidity);
        }

        /**
         * helper method for validating strings
         * @param $label used in error message
         * @param $key identification for array element
         * @param $value gonna checked
         * @param $maxLength used for value checking
         * @return boolean true if value is valid, else false
         */
        private function validateHelper($value)
        {
            if ($value == null) {
                return false;
            }
            else if (is_string($value)) {
                return true;
            }else{
                return false;
            }

        }


        /**
         * Specify data which should be serialized to JSON
         * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
         * @return mixed data which can be serialized by <b>json_encode</b>,
         * which is a value of any type other than a resource.
         * @since 5.4.0
         */
        public function jsonSerialize()
        {
            return [
                "id" => $this->id,
                "time" => $this->time,
                "temperature" => $this->temperature,
                "humidity" => $this->humidity,
            ];
        }
    }