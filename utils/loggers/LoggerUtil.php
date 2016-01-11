<?php

/** USAGE
 * include './loggers/LoggerUtil.php';
 * - LoggerUtil::trace('trace string');
 * - LoggerUtil::consoleTrace('trace string');
 */

class LoggerUtil{

    private static $LOG_PATH = '';
    private static $DEFAULT_PATH = 'phplog.txt';
    const LOG_LIMIT = 15000;

    public static function config($filename)
    {
        // CONFIG PATH TO LOGFILE
        self::$LOG_PATH = $filename;
    }

    public static function trace($s)
    {
        // DISABLE FOR NON-LOCAL ENVIRONMENTS
        if($_SERVER['SERVER_NAME'] == 'localhost')
        {
            ///NEED TO UPDATE PERMISSIONS TO BE ABLE TO WRITE FILES :(
            // open file
            if(self::$LOG_PATH == '') self::$LOG_PATH = self::$DEFAULT_PATH;
            $filePath = $_SERVER['DOCUMENT_ROOT'].'/utils/loggers/'.self::$LOG_PATH;

            $contents = file_get_contents($filePath);
            $mode = (strlen($contents) > self::LOG_LIMIT) ? 'w' : 'a';
            $fd = fopen($filePath, $mode) or die('could not open or create phplog file!');

            // write string
            fwrite($fd, $s . "\r\n");
//            fwrite($fd, 'count: '.strlen($contents) . "\r\n");

            // close file
            fclose($fd);
        }
    }

    public static function traceObject($obj, $s=null)
    {
        if(isset($s))
        {
            self::trace($s . "\r\n"
                . '--------------------------------------' . "\r\n"
                . print_r($obj, true));
        }
        else self::trace(print_r($obj, true));
    }

    public static function consoleTrace($s)
    {
        ?>
        <script type="text/javascript">
            console.log('<?php echo $s; ?>');
        </script>
        <?php
    }

}

?>