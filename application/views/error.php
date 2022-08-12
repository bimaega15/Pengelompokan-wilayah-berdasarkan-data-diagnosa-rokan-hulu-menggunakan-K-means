<?php
$error = null;
if (validation_errors()) {
    $error = '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Failed!</strong> ' . validation_errors() . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    ';
}
echo $error;
