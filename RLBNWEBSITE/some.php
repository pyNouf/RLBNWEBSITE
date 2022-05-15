<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'loved':
                loved();
                break;
            case 'hated':
                hated();
                break;
        }
    }

    function loved() {
        echo "The love function is called.";
        exit;
    }

    function hated() {
        echo "The hate function is called.";
        exit;
    }
?>