<?php

namespace App\Http\Factories;

use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FeedbackFactory
{
    /**
     * * Send params into chosen db
     * * DB TYPES: mysql, mysql2, file
     * 
     * @param string $connection
     * @param array $params
     */
    public function sendTo($connection = "mysql", $params)
    {
        switch ($connection) {
            case "mysql":
                return $this->save_into_db($params, "mysql");
                break;
            case "mysql2":
                return $this->save_into_db($params, "mysql2");
                break;
            case "file":
                // * add current formated datetime in saving params 
                $params["created_at"] = Carbon::now()->format("d.m.y_H:i:s");
                // * convert array to string with separator
                $stringed_feedback_info = join("|", $params);
                // * set saving filename
                $filename = "feedback" . "_" . Carbon::now()->format("d_m_Y__H_i_s") . ".txt";
                // * save stringed feedback info into file
                if (Storage::put($filename, $stringed_feedback_info)) {
                    return ["message" => "Ваш отзыв успешно записан в файл $filename"];
                }
                return ["errors" => "При добавлении в файл произошла подлая ошибка"];
                break;
            default:
                throw new \Exception("Unknown send location type: $connection");
        }
    }

    /**
     * * Save info into db by info params and db name
     * 
     * @param array $params
     * @param string $connection
     */
    private function save_into_db($params, $connection)
    {
        $feedback_to_db1 = new Feedback();
        $feedback_to_db1->setConnection($connection);
        $feedback_to_db1->fill($params);
        if ($feedback_to_db1->save()) {
            return ["message" => "Ваш отзыв успешно добавлен в базу данных $connection"];
        }
        return ["errors" => "При добавлении в базу данных произошла подлая ошибка"];
    }
}
