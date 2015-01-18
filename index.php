<?php
ob_start();
session_start();


require_once 'persona.php';

$login_button = '<button onclick="persona_login()" class="persona-button" ><span>Sign in/ Sign up with Email</span></button>';
$logout_button = '<button onclick="persona_logout()" class="persona-button" ><span>Sign out</span></button>';

$email = $body_button = $message = NULL;

if( isset($_SESSION['user_email']) && !empty($_SESSION['user_email']) )
{
    $body_button = $logout_button; 
    $message = "<p>Logged In as <span style='border-bottom: 1px dotted #000; text-decoration: none;'>".$_SESSION['user_email']."</span></p>";
    $email = $_SESSION['user_email'];
}
else
{
    $body_button = $login_button;
}



?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
<link rel="stylesheet" type="text/css" href="persona-buttons.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>

<?php
echo $message;
echo $body_button; 
?>
    
<!--==============================scripts==============================-->
<script src="https://login.persona.org/include.js"></script>
    
<script>
var currentUser = <?php echo $email ? "'$email'" : 'null' ?>;

navigator.id.watch({
  loggedInUser: currentUser,
  onlogin: function(assertion) {
    // A user has logged in! Here you need to:
    // 1. Send the assertion to your backend for verification and to create a session.
    // 2. Update your UI.
    $.ajax({ /* <-- This example uses jQuery, but you can use whatever you'd like */
      type: 'POST',
      url: 'login.php', // This is a URL on your website.
      data: {assertion: assertion},
      success: function(res, status, xhr) { window.location.reload(); },
      error: function(xhr, status, err) {
        navigator.id.logout();
        alert("Login failure: " + err);
      }
    });
  },
  onlogout: function() {
    // A user has logged out! Here you need to:
    // Tear down the user's session by redirecting the user or making a call to your backend.
    // Also, make sure loggedInUser will get set to null on the next page load.
    // (That's a literal JavaScript null. Not false, 0, or undefined. null.)
    $.ajax({
      type: 'POST',
      url: 'login.php', // This is a URL on your website.
      data: {logout: 'logout'},    
      success: function(res, status, xhr) { window.location.reload(); },
      error: function(xhr, status, err) { alert("Logout failure: " + err); }
    });
  }
});
</script>

<script>
function persona_login()
{
 navigator.id.request(); 
}

function persona_logout()
{
 navigator.id.logout(); 
}
</script>
    
    
<!--==============================scripts==============================-->
</body>

</html>
