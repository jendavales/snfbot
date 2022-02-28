<?php

function vd() {
    foreach (func_get_args() as $var) {
        var_dump($var);
    }
    echo'<br>';
}

function vdx() {
    call_user_func_array('vd', func_get_args());
    exit();
}
