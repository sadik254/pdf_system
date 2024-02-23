<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create User</title>
</head>

<body>
    <h1>Create User</h1>

    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="control_no">Control Number:</label>
        <input type="text" id="control_no" name="control_no" required><br><br>

        <label for="wp_id">WP ID:</label>
        <input type="text" id="wp_id" name="wp_id" required><br><br>

        <input type="submit" value="Create User">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'dob' => $_POST['dob'],
            'control_no' => $_POST['control_no'],
            'wp_id' => $_POST['wp_id']
        ];

        // API Endpoint
        $apiEndpoint = 'http://localhost/pdf_system/cert1api.php';

        // Create a new user using cURL
        $ch = curl_init($apiEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        // Execute the cURL request
        $response = curl_exec($ch);
        curl_close($ch);

        // Display the HTML response
        echo $response;
    }
    ?>
</body>

</html>
