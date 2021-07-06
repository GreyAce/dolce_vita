<?php

namespace App\Helper;

class Helper
{
    private static function renderTask($task)
    {
        $taskJson = json_encode($task);

        $html = "";
        $html .= "<li class='mt-task' data-task='$taskJson'>";
        $html .= "<p class='mt-list-item'>" . $task["id"] . "</p>";
        $html .= "<p class='mt-list-item'>" . $task["title"] . "</p>";
        $html .= "<p class='mt-list-item'>" . $task['status'] . "</p>";
        $html .= "<p class='mt-list-item'>" . $task['datetime_start'] . "</p>";
        $html .= "<p class='mt-list-item'>" . $task['datetime_end'] . "</p>";
        $html .= "</li>";

        return $html;
    }

    public static function renderTasksList(array $arrTasks)
    {
        $html = "";
        foreach ($arrTasks as $id => $task) {
            $task['seq'] = $id + 1;
            $html .= self::renderTask($task);
        }

        return $html;
    }

    public static function renderTaskWindow()
    {
        echo "Task window is Alive!";
    }

    public static function renderTasksStatusBar()
    {
        // echo "HERE!";
    }
}
