<?php
ob_start();
session_start();

require_once 'persona.php';

if( isset($_POST['assertion']) && !empty($_POST['assertion']) )
{
    $persona = new Persona();
    $result = $persona->verifyAssertion($_POST['assertion']);
    
    if($result->status == 'okay')
    {
        $_SESSION['user_email'] = $result->email;
    }
    else
    {
        unset($_SESSION['user_email']);
        $_SESSION['error'] = $result->reason;
    }
}

if( isset($_POST['logout']) && !empty($_POST['logout']) )
{
    unset($_SESSION['user_email']);
}


?>