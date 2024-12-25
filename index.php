<?php

// start session
session_start();

if (isset($_POST['add']) && $_POST['add'] == 'Add List') {

    // list for task
    if (isset($_POST['task_list']) && $_POST['task_list'] !== "") {
        if (!isset($_SESSION['task_list']) && !is_array($_SESSION['task_list'])) {
            $_SESSION['task_list'] = array();
        }

        // check if value already available in list or not if value found then return lists
        in_array($_POST['task_list'], $_SESSION['task_list'], true) ? $_POST['task_list'] : null;

        // find task list values and merge value to existing array
        if (count($_SESSION['task_list']) == 0) {
            $_SESSION['task_list'][] = $_POST['task_list'];
        } else {
            if (!in_array($_POST['task_list'], $_SESSION['task_list'])) {
                array_push($_SESSION['task_list'], $_POST['task_list']);
            }
        }
    }
    
}

if (isset($_POST['delete_list']) && $_POST['delete_list'] == 'Delete List') {

    $task_ary = $_SESSION['task_list'];

    // find value which need to be delete
    if (in_array($_POST['task_list'], $task_ary)) {

        // need to find key of array value using array_keys and unset the value from array
        $key = array_keys($task_ary, $_POST['task_list']);
        
        // remove selected task list array values
        foreach ($task_ary as $tsk) {
            if ($tsk == $_POST['task_list']) {
                unset($_SESSION['task'][$_POST['task_list']]);
            }
        }

        unset($task_ary[$key['0']]);
        $_SESSION['task_list'] = $task_ary;
        
    }

}

if (isset($_POST['delete_task']) && $_POST['delete_task'] == 'Delete Task') {

    $tasks = $_SESSION['task'];
    $delete_val = explode("_",$_POST['task_item']);

    foreach ($tasks as $i => $v) {
        foreach ($v as $keyd => $value) {
            if ($delete_val[0] == $i) {
                unset($tasks[$i][$keyd]);
                $array = array_values($tasks);
                $_SESSION['task'] = $tasks;
                break;
            }
        }
    }
    
}

if (isset($_POST['add']) && $_POST['add'] == 'Add Task') {

    if (isset($_POST['task']) && $_POST['task'] !== "") {
        $_SESSION['category_tasklist'] = $_POST['category_tasklist'];
        
        if (!isset($_SESSION['task'][$_SESSION['category_tasklist']]) && !is_array($_SESSION['task'][$_SESSION['category_tasklist']])) {
            $_SESSION['task'][$_SESSION['category_tasklist']] = array();
        }

        // find task list values and merge value to existing array
        if (count($_SESSION['task']) == 0) {
            $_SESSION['task'] = array($_SESSION['category_tasklist'] => array($_POST['task']));
        } else {
            if (!in_array($_POST['task'], $_SESSION['task'][$_SESSION['category_tasklist']])) {
                array_push($_SESSION['task'][$_SESSION['category_tasklist']], $_POST['task']);
            }
        }
    }

}

if (isset($_POST['clear']) && $_POST['clear'] == 'Clear all') {

    // destroy session for task list
    unset($_SESSION['task_list']);
    unset($_SESSION['task']);
    unset($_SESSION['task'][$_SESSION['category_tasklist']]);
    session_destroy();

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
    <style type="text/css">
        .selection {
            color:#FFA500;
            font-size:15px;
            font-weight:bold;
        }
        .right-border {
            border-right:1px solid #ddd;
        }
        .selected {
            color:#0047AB;
            font-weight:bold;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#list_selection").on("change", function() {
            var id_list = $(this).val();
            $(".selected").text(id_list);
            $("#category_tasklist").val(id_list);
        });
    });
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mt-3">

                <div class="card overflow-hidden">
                    <div class="row mt-3">

                        <div class="col-lg-1">&nbsp;</div>
                            <div class="col-lg-10 mb-5">

                                <div class="head row">

                                    <div class="col-lg-6">
                                        <h3 class="text-left"> Task List Manager </h3>
                                        <p> Add a new list to be managed </p>
                                    </div>

                                </div>

                                <hr>

                                <div class="col-lg-12 col-md-12">
                                    <div class="row pb-2">

                                        <div class="col-lg-12 pb-2">Add Task List</div>

                                        <div class="col-lg-6 right-border">
                                            <form method="post" name="addtask">
                                                <input type="text" name="task_list" id="task_list" placeholder="Add Task List" class="form-control" required /> 
                                                <br>
                                                <input type="submit" class="btn btn-primary" name="add" value="Add List" />
                                                <input type="submit" class="btn btn-danger text-white" name="clear" value="Clear all" onclick="return confirm('Are you sure want to delete all sessions');" />
                                            </form>
                                        </div>

                                        <div class="col-lg-6">
                                            <?php
                                            if (!empty($_SESSION['task_list'])) {
                                                $tasklist = $_SESSION['task_list'];
                                            ?>
                                            <form method="post" name="delete">
                                                <select class="form-control" name="task_list" required>
                                                    <option value="">--Select List--</option>
                                                    <?php
                                                    foreach ($tasklist as $list) {
                                                    ?>
                                                        <option value="<?php echo $list;?>"><?php echo $list;?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select> <br>
                                                <input type="submit" class="btn btn-primary text-white" name="delete_list" value="Delete List">
                                            </form>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>

                                    <hr style="border:1.5px dashed #ddd;">

                                    <div class="clear pt-2"></div>

                                    <div class="row">
                                        <div class="col-lg-12 pb-2">Add Task</div>
                                        <?php
                                        if (!empty($_SESSION['task_list'])) {
                                            $tasklist = $_SESSION['task_list'];
                                        ?>
                                            <div class="col-lg-6 right-border">
                                                <form method="post" name="task">
                                                    <select class="form-control" name="list_selection" id="list_selection" required>
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        foreach ($tasklist as $task) {
                                                        ?>
                                                            <option value="<?php echo $task;?>"><?php echo $task;?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                
                                                    <div class="pt-1"></div>
                                                
                                                    <input type="hidden" name="category_tasklist" id="category_tasklist" value="<?php if (!empty($_SESSION['category_tasklist'])) { echo $_SESSION['category_tasklist']; } ?>">
                                                    <input type="text" placeholder="Add Task" name="task" id="task" class="form-control" required />
                                                    <br>
                                                    <input type="submit" class="btn btn-primary" name="add" value="Add Task" />
                                                </form>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php
                                                if (!empty($_SESSION['task'])) {
                                                    $task_list = $_SESSION['task'];
                                                ?>
                                                <form method="post" name="deletetask">
                                                    <select class="form-control" name="task_item" required>
                                                        <option value="">--Select Task--</option>
                                                        <?php
                                                        foreach ($task_list as $key => $task) {
                                                            foreach ($task as $val) {
                                                            ?>
                                                                <option value="<?php echo $key.'_'.$val;?>"><?php echo $key.' -- '.$val;?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select> <br>
                                                    <input type="submit" class="btn btn-primary text-white" name="delete_task" value="Delete Task">
                                                </form>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                        <span> There are no task lists </span>
                                        <div class="selected pt-2"></div>
                                        <?php
                                        }
                                        ?>

                                    </div>

                                </div>
                                
                            </div>
                        <div class="col-lg-1">&nbsp;</div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
