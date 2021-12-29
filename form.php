<?php

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

if (!empty($name) || !empty($email) || !empty($subject) || !empty($message)) {
    $host = "box2367.bluehost.com";
    $dbUsername = "benswens_bens";
    $dbPassword = "andrew77";
    $dbname = "benswens_bens";

    // create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT email FROM form1 WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO form1 (name, email, subject, message) VALUES(?,?,?,?)";

        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            $stmt->execute();
            echo "<script>alert('New record inserted successfully.');document.location='index.html'</script>";
        } else {
            echo "<script type= 'text/javascript'>alert('Someone already registered using this email');</script>";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All field are required";
    die();
}

?>