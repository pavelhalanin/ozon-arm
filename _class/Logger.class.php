<?php

class Logger {    
    private function getLogDate() {
        return date('Y-m-d h:i:s');
    }

    private function generatePath() {
        $HOME = $_SERVER['DOCUMENT_ROOT'];
        $date = date('Y-m-d_H');
        return "$HOME/logs/$date.log.txt";
    }

    public function log($message) {
        $date = $this->getLogDate();
        $text = "\n$date\n$message\n";
        $path = $this->generatePath();
        file_put_contents($path, $text, FILE_APPEND);
    }
}
