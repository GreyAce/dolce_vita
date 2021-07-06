<?php

namespace App\Views;

class Base_View
{
    public function init()
    {
        $this->render();
    }

    private function render()
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
            <link href="./css/style.css" rel="stylesheet" type="text/css">
            <title>Dolce Vita Test</title>
        </head>

        <body>
            <div class="my-tasks">
                <div class="mt-tasks-display">
                    <div class="mt-tasks-body">
                        <div class="mt-tasks-list">
                            <div class="mt-tasks-list-header">
                                <p class="mt-list-item mt-index">#
                                </p>
                                <p class="mt-list-item mt-name">Name
                                </p>
                                <p class="mt-list-item mt-status">Status
                                </p>
                                <p class="mt-list-item mt-start">Start
                                </p>
                                <p class="mt-list-item mt-end">End
                                </p>
                            </div>
                            <ul class="mt-tasks-list-content">
                            </ul>

                        </div>
                    </div>

                </div>
                <div class="mt-tasks-window">
                    <div class="mt-create-new-task">
                        <div class="btn-create-new-task">
                            <h4>Add New Task</h4>
                        </div>
                    </div>
                    <div class="mt-window-display active">
                        <div class="mt-tasks-window-content diaplay active">
                            <h4>Title</h4>
                            <p class="mt-task-title">- - -</p>
                            <h4>Status</h4>
                            <div class="mt-task-status">
                                <div>
                                    <input class="mt-status-radio" type="radio" id="start" name="drone" value="started">
                                    <label for="start">Started</label>
                                </div>
                                <div>
                                    <input class="mt-status-radio" type="radio" id="huey" name="drone" value="work in progress">
                                    <label for="huey">Work In Progress</label>
                                </div>
                                <div>
                                    <input class="mt-status-radio" type="radio" id="huey" name="drone" value="done">
                                    <label for="huey">Done</label>
                                </div>
                            </div>
                            <h4>End</h4>
                            <p class="mt-task-date">
                                <span class="mt-window-time-end"> </span>
                            </p>
                            <h4>Description</h4>
                            <p class="mt-task-description">- - -</p>
                            <div class="mt-tasks-window-buttons">
                                <button class="mt-tasks-window-btn" id="mt-btn-save">Save</button>
                                <button class="mt-tasks-window-btn" id="mt-btn-delete">Delete</button>
                            </div>

                        </div>

                        <div class="mt-tasks-window-content add-new">
                            <h4>Title</h4>
                            <p class="mt-task-title"></p>
                            <h4>Status</h4>
                            <div class="mt-task-status">
                                <div>
                                    <input class="mt-status-radio" type="radio" id="start" name="drone" value="started">
                                    <label for="start">Started</label>
                                </div>
                                <div>
                                    <input class="mt-status-radio" type="radio" id="huey" name="drone" value="work in progress">
                                    <label for="huey">Work In Progress</label>
                                </div>
                                <div>
                                    <input class="mt-status-radio" type="radio" id="huey" name="drone" value="done">
                                    <label for="huey">Done</label>
                                </div>
                            </div>
                            <h4>End</h4>
                            <p class="mt-task-date">
                                <input id="datepicker" class="mt-window-time-end datepicker">
                                <input id="timepicker" class="mt-window-time-end timepicker">
                            </p>
                            <h4>Description</h4>
                            <p class="mt-task-description"></p>
                            <div class="mt-tasks-window-buttons">
                                <button class="mt-tasks-window-btn" id="mt-btn-add">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-extra-btns">

                        <div class="mt-btn get-tasks-all">Get All Tasks</div>
                        <div class="mt-tasks-by-dates">
                            <div class="mt-btn get-tasks-by-dates">Get Tasks By Dates Range!</div>
                            <input type="text" id="datepicker-start" class="datepicker datepicker-start"> -
                            <input type="text" id="datepicker-end" class="datepicker datepicker-end">
                        </div>
                        <div class="mt-tasks-by-status">
                            <div class="mt-btn get-tasks-by-status">Get Tasks By Status!</div>
                            <div class="mt-status-radio-box">
                                <div>
                                    <input class="mt-status-radio" type="radio" id="start" name="drone" value="started">
                                    <label for="start">Started</label>
                                </div>
                                <div>
                                    <input class="mt-status-radio" type="radio" id="huey" name="drone" value="work in progress">
                                    <label for="huey">Work In Progress</label>
                                </div>
                                <div>
                                    <input class="mt-status-radio" type="radio" id="huey" name="drone" value="done">
                                    <label for="huey">Done</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <script src="./js/main.js"></script>
        </body>

        </html>

<?php
    }
}

?>