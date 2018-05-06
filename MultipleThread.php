<?php

    // $cmd = 'start cmd.exe @cmd /k "cd .. & java -jar selenium-server-standalone-3.11.0.jar"';
    // $cmd = 'start cmd.exe @cmd /k "pause"';
    class SeleniumThread extends Thread {
        public function run() {
            /** ... **/
        }
    }
    $my = new SeleniumThread();
    var_dump($my->start());
    // exec($cmd);
?>