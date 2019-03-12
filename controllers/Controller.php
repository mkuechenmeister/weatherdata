<?php
    /**
     * Created by PhpStorm.
     * User: Martin
     * Date: 07.03.2019
     * Time: 17:24
     */

    abstract class controller

    {
        public function render($view, $model=null)
        {
            $pageTitle = $view;
            include_once("view/layouts/top.php");
            include_once("view/$view.php");
            include_once("view/layouts/bottom.php");
        }


        protected function redirect($location)
        {
            header("Location: index.php?r=$location");


        }

        public static function showError($title, $message)
        {
            include_once("view/error.php");
        }






    }