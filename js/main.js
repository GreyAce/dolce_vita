
const Main = function () {

    let g_objMyTasks, g_objMyTasksDisplay, g_objMyTasksWindow, g_objMyTasksList;
    let g_objWindowTitle, g_objWindowStatus, g_objWindowDateTime, g_objWindowDescription;
    let lastClickedDivClass;
    function init() {
        g_objMyTasks = jQuery(".my-tasks")
        g_objMyTasksDisplay = g_objMyTasks.find(".mt-tasks-display")
        g_objMyTasksWindow = g_objMyTasks.find(".mt-tasks-window")
        g_objMyTasksList = g_objMyTasksDisplay.find(".mt-tasks-list-content")
        g_objWindowTitle = g_objMyTasksWindow.find(".mt-task-title");
        g_objWindowStatus = g_objMyTasksWindow.find(".mt-task-status");
        g_objWindowDateTime = g_objMyTasksWindow.find(".mt-task-date");
        g_objWindowDescription = g_objMyTasksWindow.find(".mt-task-description");
        g_objWindowButtons = g_objMyTasksWindow.find(".mt-tasks-window-buttons");

        initEvents()
    }

    async function initEvents() {

        g_objMyTasksList.on("click", ".mt-task", onTaskClick)
        g_objMyTasksWindow.on("click", ".mt-task-title", divClicked)
        g_objMyTasksWindow.on("click", ".mt-task-description", divClicked)
        g_objWindowButtons.on("click", "#mt-btn-add", onWindowBtnAddClick)
        g_objWindowButtons.on("click", "#mt-btn-save", onWindowBtnSaveClick)
        g_objWindowButtons.on("click", "#mt-btn-delete", onWindowBtnDeleteClick)
        g_objMyTasksWindow.on("click", ".btn-create-new-task", toggleWindowDisplay)
        g_objMyTasksWindow.on("click", ".mt-btn.get-tasks-by-dates", onGetTasksByRangeClick)
        g_objMyTasksWindow.on("click", ".mt-btn.get-tasks-by-status", onGetTasksByStatusClick)
        g_objMyTasksWindow.on("click", ".mt-btn.get-tasks-all", getAllTasks);
        g_objMyTasks.on("click", ".mt-tasks-list-header .mt-list-item", sortTable);

        let tasks = await getAllTasks();
        let tasksHtml = renderTasksList(tasks);
        jQuery(".mt-tasks-list-content").html(tasksHtml);
        initDateTimePicker();
    }

    function sortTable(e) {
        let objBtn = jQuery(this);
        objBtn.addClass("sorted");
        let arrListItems = jQuery(".mt-task");
        let sortBy;
        let className;
        let arrTasksData = [];

        if (objBtn.hasClass("mt-index")) {
            sortBy = "id";
            className = "mt-id";
        } else if (objBtn.hasClass("mt-name")) {
            sortBy = "title";
            className = "mt-name";
        } else if (objBtn.hasClass("mt-status")) {
            sortBy = "status";
            className = "mt-status";
        } else if (objBtn.hasClass("mt-start")) {
            sortBy = "start_time";
            className = "mt-start";
        } else if (objBtn.hasClass("mt-end")) {
            sortBy = "end_time";
            className = "mt-end";
        } else {
            return false;
        }

        jQuery.each(arrListItems, function (index, item) {
            let objItem = jQuery(item);
            let itemData = objItem.data('task');
            arrTasksData.push(itemData);
        })

        if (objBtn.hasClass("sorted-asc")) {
            objBtn.removeClass("sorted-asc");
            objBtn.addClass("sorted-des");
            arrTasksData.sort(function (a, b) {

                if (a[`${sortBy}`] > b[`${sortBy}`]) {
                    return -1;
                }
                if (a[`${sortBy}`] < b[`${sortBy}`]) {
                    return 1;
                }
                return 0
            });

        } else {
            arrTasksData.sort(function (a, b) {
                objBtn.removeClass("sorted-des");
                objBtn.addClass("sorted-asc");

                if (a[`${sortBy}`] < b[`${sortBy}`]) {
                    return -1;
                }
                if (a[`${sortBy}`] > b[`${sortBy}`]) {
                    return 1;
                }
                return 0
            });
        }
        let tasksHtml = renderTasksList(arrTasksData);
        jQuery(".mt-tasks-list-content").html(tasksHtml);
    }

    function toggleWindowDisplay() {
        let objCurrentTaskWindow = jQuery(".mt-tasks-window-content.diaplay");
        let objAddNewTaskWindow = jQuery(".mt-tasks-window-content.add-new");
        let objAddNewTaskBtn = jQuery(".btn-create-new-task");
        if (objCurrentTaskWindow.hasClass("active")) {
            objAddNewTaskBtn.addClass("active");
            objCurrentTaskWindow.removeClass("active");
            objAddNewTaskWindow.addClass("active");
        } else {
            objAddNewTaskBtn.removeClass("active");
            objCurrentTaskWindow.addClass("active");
            objAddNewTaskWindow.removeClass("active");
        }
    }

    function initDateTimePicker() {

        jQuery(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            showAnim: "fold",
            dateFormat: 'yy-mm-dd'
        });
        jQuery(".datepicker-start").datepicker({
            changeMonth: true,
            changeYear: true,
            showAnim: "fold",
            dateFormat: 'yy-mm-dd'
        });
        jQuery(".datepicker-end").datepicker({
            changeMonth: true,
            changeYear: true,
            showAnim: "fold",
            dateFormat: 'yy-mm-dd'
        });

        jQuery('#timepicker').timepicker({
            timeFormat: 'h:mm',
            interval: 30,
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });


    }

    function getCheckedRadioValue(objBtn) {
        let objParent = objBtn.parents(".mt-tasks-by-status");
        let radioBtns = objParent.find("input");
        let checked;
        jQuery.each(radioBtns, function (index, button) {
            if (button.checked == true) {
                checked = button.value;
            }
        })
        return checked;
    }

    function onGetTasksByStatusClick() {
        console.log("Get tasks by status.");
        let objBtn = jQuery(this);
        let checked = getCheckedRadioValue(objBtn);
        // if (!checked) { return }

        let url = 'http://localhost/Web/tests/Dolce_Vita/src/api.tasks.service.php?action=get-by-status&status=' + checked;

        var ajaxOptions = {
            type: "GET",
            url: url,
            dataType: "json",
            processData: true,
            success: function (res) {
                let tasksHtml = renderTasksList(res);
                jQuery(".mt-tasks-list-content").html(tasksHtml);
                return res;
            },
            error: e => {
                console.log("ERROR!!");
                console.log(e);
            }
        };

        return jQuery.ajax(ajaxOptions);

    }

    function onGetTasksByRangeClick() {
        console.log("Get tasks by dates");
        let objBtn = jQuery(this);
        let objBtns = objBtn.parents(".mt-extra-btns");
        let arrRangeInputs = objBtns.find("input.datepicker");
        let objRanges = {};

        jQuery.each(arrRangeInputs, function (index, input) {
            let objInput = jQuery(input);
            let inputVal = input.value;
            if (objInput.hasClass("datepicker-start")) {
                objRanges.start = inputVal
            } else {
                objRanges.end = inputVal
            }
        })

        let url = 'http://localhost/Web/tests/Dolce_Vita/src/api.tasks.service.php?action=get-by-dates&start=' + objRanges.start + '&end=' + objRanges.end;

        var ajaxOptions = {
            type: "GET",
            url: url,
            dataType: "json",
            processData: true,
            success: function (res) {
                let tasksHtml = renderTasksList(res);
                jQuery(".mt-tasks-list-content").html(tasksHtml);
                return res;
            },
            error: e => {
                console.log("ERROR!!");
                console.log(e);
            }
        };

        return jQuery.ajax(ajaxOptions);

    }

    async function onWindowBtnAddClick(e) {
        e.preventDefault();
        let activeTaskData = getUpdatedTaskDataFromWindow();
        activeTaskData.action = "add";
        let url = 'http://localhost/Web/tests/Dolce_Vita/src/api.tasks.service.php';

        var ajaxOptions = {
            type: "POST",
            url: url,
            data: activeTaskData,
            dataType: "text",
            processData: true,
            success: async function (res) {
                let tasks = await getAllTasks();
                let tasksHtml = renderTasksList(tasks);
                jQuery(".mt-tasks-list-content").html(tasksHtml);
                clearWindow();
                toggleWindowDisplay();
                return res;
            },
            error: e => {
                console.log("ERROR!!");
                console.log(e);
            }
        };

        jQuery.ajax(ajaxOptions);
    }

    function getUpdatedTaskDataFromWindow(getBy) {

        let activeWindow = jQuery(".mt-tasks-window-content.active");
        let title = activeWindow.find(".mt-task-title").html();
        let status = getWindowCheckedStatus();
        let desc = activeWindow.find(".mt-task-description").html();
        let endDateTime;

        if (getBy == 'save') {
            objWindow = jQuery(".mt-tasks-window-content.active");
            endDateTime = objWindow.find(".mt-window-time-end").html();
        } else {
            let endTime = activeWindow.find("#timepicker").val();
            let endDate = activeWindow.find("#datepicker").val();
            endDate = endDate.split("/").reverse().join("-");
            endDateTime = endDate + " " + endTime;

        }

        return {
            title: title,
            status: status,
            description: desc,
            end_time: endDateTime
        }
    }

    function getWindowCheckedStatus() {
        let objWindow = jQuery(".mt-tasks-window-content.active");
        let statuses = objWindow.find(".mt-status-radio");
        let checked;
        jQuery.each(statuses, function (index, status) {
            if (status.checked == true) {

                checked = status.value;
            }
        })
        return checked;
    }

    function onWindowBtnSaveClick(e) {
        e.preventDefault();
        let objBtn = jQuery(this);
        let activeTaskWindow = objBtn.parents(".mt-tasks-window");
        let activeTaskId = activeTaskWindow.data("task").id;
        let activeTaskData = getUpdatedTaskDataFromWindow('save');
        activeTaskData.id = activeTaskId
        activeTaskData.action = "save";
        let url = 'http://localhost/Web/tests/Dolce_Vita/src/api.tasks.service.php';

        var ajaxOptions = {
            type: "POST",
            url: url,
            data: activeTaskData,
            dataType: "text",
            processData: true,
            success: async function (res) {
                let tasks = await getAllTasks();
                let tasksHtml = renderTasksList(tasks);
                jQuery(".mt-tasks-list-content").html(tasksHtml);
                clearWindow()
            },
            error: e => {
                console.log("ERROR!!");
                console.log(e);
            }
        };

        jQuery.ajax(ajaxOptions);
    }

    function getAllTasks() {
        console.log("Get all tasks.")
        let url = 'http://localhost/Web/tests/Dolce_Vita/src/api.tasks.service.php?action=get-all';

        var ajaxOptions = {
            type: "GET",
            url: url,
            dataType: "json",
            processData: true,
            success: function (res) {
                let tasksHtml = renderTasksList(res);
                jQuery(".mt-tasks-list-content").html(tasksHtml);
            },
            error: e => {
                console.log("ERROR!!");
                console.log(e);
            }
        };

        return jQuery.ajax(ajaxOptions);
    }

    function onWindowBtnDeleteClick() {
        let objBtn = jQuery(this);

        let taskID = objBtn.parents(".mt-tasks-window").data('task').id;

        let url = 'http://localhost/Web/tests/Dolce_Vita/src/api.tasks.service.php?action=delete&id=' + taskID;

        var ajaxOptions = {
            type: "GET",
            url: url,
            dataType: "text",
            processData: true,
            success: function (res) {
                let objActiveTask = jQuery(".mt-task.active");
                objActiveTask.remove();
                clearWindow()

                return res;
            },
            error: e => {
                console.log("ERROR!!");
                console.log(e);
            }
        };

        jQuery.ajax(ajaxOptions);

    }

    function onTaskClick() {

        let objTask = jQuery(this);
        let taskData = objTask.data("task");
        let objCurrentTaskWindow = jQuery(".mt-tasks-window-content.diaplay");
        let objAddNewTaskWindow = jQuery(".mt-tasks-window-content.add-new");

        if (objAddNewTaskWindow.hasClass("active")) {
            objAddNewTaskWindow.removeClass("active");
            objCurrentTaskWindow.addClass("active")
        }

        if (objTask.hasClass("active")) {
            objTask.removeClass("active");
            clearWindow()
        } else {
            let arrTasks = g_objMyTasksList.find(".mt-task");
            arrTasks.removeClass("active");
            objTask.addClass("active");
            updateWindow(taskData);
        }
    }

    function clearWindow() {
        jQuery("span.mt-window-time-start").html("- - -");
        jQuery("span.mt-window-time-end").html("- - -");
        jQuery(".mt-task-title").html("- - -");
        jQuery(".mt-task-description").html("- - -");
        jQuery("#datepicker").val("--");
        jQuery("#timepicker").val("--");
        jQuery(".mt-tasks-window").data("task", "- - -");
    }

    function updateWindow(taskData) {
        jQuery("span.mt-window-time-start").html(taskData.start_time);
        jQuery("span.mt-window-time-end").html(taskData.end_time);
        jQuery(".mt-task-title").html(taskData.title);
        jQuery(".mt-task-description").html(taskData.description);
        jQuery(".mt-task-datetime").html(taskData.datetime);
        jQuery(".mt-tasks-window").data("task", taskData);
    }

    function divClicked() {
        let objDiv = jQuery(this);
        let divHtml = objDiv.html();
        lastClickedDivClass = objDiv.attr('class');
        var editableText = jQuery("<textarea class='" + lastClickedDivClass + "'/>");
        editableText.val(divHtml);
        objDiv.replaceWith(editableText);
        editableText.focus();
        // setup the blur event for this new textarea
        editableText.blur(editableTextBlurred);
    }

    function editableTextBlurred() {

        let objEl = jQuery(this);
        var html = objEl.val();
        let className = objEl.attr('class');
        var viewableText = jQuery("<p class='" + className + "'/>");
        viewableText.html(html);
        jQuery(this).replaceWith(viewableText);
        // setup the click event for this new paragraph
        viewableText.click(divClicked);
    }

    function renderTasksList(tasks) {
        let html = "";

        jQuery.each(tasks, function (index, task) {

            let taskJSON = JSON.stringify(task);

            html += "<li class='mt-task' data-task='" + taskJSON + "'>";
            html += "<p class='mt-list-item mt-id'>" + task.id + "</p>";
            html += "<p class='mt-list-item mt-title'>" + task.title + "</p>";
            html += "<p class='mt-list-item mt-status'>" + task.status + "</p>";
            html += "<p class='mt-list-item mt-start'>" + task.start_time + "</p>";
            html += "<p class='mt-list-item mt-end'>" + task.end_time + "</p>";
            html += "</li>";
        })

        return html;
    }


    this.init = function (params) {
        init()
    }

}


jQuery(document).ready(function () {
    const main = new Main()
    main.init();
})