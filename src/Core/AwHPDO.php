<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 14/12/15
 * Time: 20:18
 */

namespace Core;


class AwHPDO extends \PDO {

    public function prepareQuery($statement) {
        $sth = $this->prepare($statement);
        if ($sth->errorInfo()[2] != null) $this->logError($sth);
        $sth->execute();
        if ($sth->errorInfo()[2] != null) {
            $this->logError($sth);
        } else {
            $file = __DIR__."/../../access.log";
            if (!file_exists($file)) {
                file_put_contents($file, "LOGS ACCESS: \n");
            }
            file_put_contents($file, date("\[d/m/y H:i:s\]")." : ".$statement." \n", FILE_APPEND);

        }
        return $sth;
    }
    public function logError($sth) {
        $file = __DIR__."/../../error.log";
        if (!file_exists($file)) {
            file_put_contents($file, "LOGS ERRORS: \n");
        }
        file_put_contents($file, date("\[d/m/y H:i:s\]")." : ".$sth->errorInfo()[2]." \n", FILE_APPEND);
    }
}