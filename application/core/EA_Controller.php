<?php

/**
 * Расширения ядра под нагибаку
 * Создано под контролем Nagibaka.Ru
 */


    define( 'MVC_DIR', 'mvc' );


        /**
         * 
         * Подключение оболочки 
         * пользовательского контента
         * 
         */

         include_once ( MVC_DIR . '/user_interface.php' );


        /**
         * 
         * Подключение оболочки 
         * админ панели (контента)
         * 
         */

        include_once ( MVC_DIR . '/admin_interface.php' );