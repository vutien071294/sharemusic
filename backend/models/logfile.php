<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for save log file.
 
 */
class Logfile
{
    public function save_log_to_db($user_id,$arr){
        if ($arr) {
            $messages = $arr[0];
            $level = $arr[1];
            $action = $arr[2];
            $resource = $arr[3];
            $time = time();
            $sql = "INSERT INTO log (decription,action,resource,user_id,create_time) VALUES ('".$messages."','".$action."','".$resource."','".$user_id."',".$time.")";
            Yii::$app->db->createCommand($sql)->execute();
        }

    }
}
