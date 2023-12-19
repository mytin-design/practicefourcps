<?php

//===============================|||||||||||||||||||||||||||||||||||
require('./connect.php');

// Function to sanitize user inputs
function sanitize_input($input) {
    return htmlspecialchars(trim($input));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['emailpass']) ? sanitize_input($_POST['emailpass']) : '';

    // Validating email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //echo "<div><p>Invalid email format.</p></div>";
        // echo "<script>
        //         alert('Please use a valid email.');
        //     </script>";
        echo "<div><p>Please use a valid email.</p>";

        exit; // Stop execution if email format is invalid
    }

    if ($email) {
        $stmt = $connect->prepare("SELECT * FROM users WHERE emailpass = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(32));

            $update_stmt = $connect->prepare("UPDATE users SET reset_token = ? WHERE emailpass = ?");
            $update_stmt->bind_param('ss', $token, $email);
            $update_stmt->execute();

            // Display the password reset link on the screen for the user
            $reset_link = "http://localhost/practicecpsthree/reset_password.php?email=$email&token=$token";
            echo "<div><p>A password reset link has been generated:</p>";
            echo "<p><a href='$reset_link'>$reset_link</a></p></div>";
    //        echo '<script>
    //     var resetLink = "' . $reset_link . '";
    //     var confirmation = confirm("A password reset link has been generated. Click OK to proceed.\n\n" + resetLink);
    //     if (confirmation) {
    //         window.open(resetLink, "_self");
    //     }
    //   </script>';
        } else {
            echo "<div><p>Email not found in our records.</p></div>";
            // echo "<script>
            //         alert('Email not found in our records.');
            //     </script>";
            exit;
                
        }

        $stmt->close();
        $update_stmt->close();
    } else {
        echo 'Email is required';
        // echo "<script>
        //     alert('Email is required.');
        // </script>";

    }
}

$connect->close();



?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESET: TEACHER SYSTEM</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./logerstyles.css">

</head>
<body>
    <form id="studentRegbox" class="stdmainbx hbox" method="post" action="./reset.php" >
        <p class="studentRegTitle stdmaintitle">Reset Page</p>
        <hr>
        <div class="studentRegIn stdmainin">
            <p class="studentInTitle stdmainintitle">Reset password</p>
            <div class="studentDetails stdgdatabx">
                <aside class="stda stdaside">
                    
                    <div class="firsttnamebx sflex">
                        <p class="studentNamenm">Email:</p>
                        <input type="text" id="firsttnameinput" name="emailpass" class="sflexinp" placeholder="">
                    </div>
                    
                </aside>
                
            </div>
                  
            </div>
                <p class="notif" id="regNotif"></p>

            <hr color="lightgray">
            <div class="stdActbtns">
                <div class="stdActbtnsIn">
                    <button  type="submit" class="stdinfobtn">Reset</button>
                    <div class="stdinfobta">
                        <a href="./login.php">Login</a>
                    </div>
                </div>                
            </div>
        </div>
    </form>
</body>
</html>