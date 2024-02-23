<?php
if (isset($_GET['id'])) {
    // Your endpoint URL to fetch user details
    $endpoint = 'https:yoururl/pdf_system/cert1api.php?id=' . $_GET['id'];

    // Fetch user details from the endpoint
    $userDetails = file_get_contents($endpoint);

    // Check if data was retrieved successfully
    if ($userDetails !== false) {
        // Decode the retrieved JSON data
        $userData = json_decode($userDetails, true);

        // Use the fetched user details to dynamically populate your HTML content
        // For example:
        $userFirstName = $userData['firstname'];
        $userLastName = $userData['lastname'];
        $userEmail = $userData['email'];
        $userGender = $userData['gender'];
        $userDob = $userData['dob'];
        // $userControl = $userData['control_no'];
 // Fetch a control number that is not used
 $controlNumbersEndpoint = 'https://yoururl/pdf_system/control.php';
 $controlNumbersJson = file_get_contents($controlNumbersEndpoint);
 $controlNumbersData = json_decode($controlNumbersJson, true);

 // Find the first control number that is not used
 $userControl = '';
 foreach ($controlNumbersData as $control) {
     if ($control['used'] == '0') {
         $userControl = $control['control_no'];
         // Update the control number as used
         $updateControlEndpoint = 'https://yoururl/pdf_system/control.php?id=' . $control['id'];
         $updateControlData = array('id' => $control['id'], 'used' => '1', 'control_no' => $userControl);
         $updateControlOptions = array(
             'http' => array(
                 'method' => 'PUT',
                 'header' => 'Content-Type: application/json',
                 'content' => json_encode($updateControlData)
             )
         );
         $updateControlContext = stream_context_create($updateControlOptions);
         $updateControlResult = file_get_contents($updateControlEndpoint, false, $updateControlContext);
         // Check if control number update was successful
         if ($updateControlResult === false) {
             // Handle error
             echo 'Failed to update control number.';
         }
         break; // Stop iterating after finding the first unused control number
     }
 }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving Licence</title>

</head>

<style>
    /* Import Poppins font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0px
    }

    /* Import Poppins font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    /* Apply Poppins font family to elements within .d_licence */
    label {
        font-size: 14px;
        font-weight: 600;

    }

    span {
        font-size: 14px;
        font-weight: 400;
    }

    .brac_txt {
        font-size: 12px;
        font-weight: 400;
    }

    input {
        border: none;
        border-bottom: 2px solid black
    }



    .d_licence,
    .d_licence * {
        font-family: 'Poppins', sans-serif;
    }

    .d_licence {
        border: 2px solid black;
        margin: 0px 10px;
        width: 1120px;
    }

    .dl_header {
        display: flex;

        justify-content: space-between;
    }

    .h_right,
    .h_left {
        width: 20%;

    }

    .h_center {
        width: 60%;

    }

    .h_right,
    .h_left,
    .h_center {
        text-align: center;
    }

    .h_right>p,
    .h_left>p {
        color: red;
    }

    .crt_purpose {
        text-align: center;
        color: #fff;
        background-color: #000;
        padding: 5px 0px;
        margin-top: 10px;
        border-left: 3px solid #666668;
        border-right: 3px solid #666668;
        border-radius: 2px;
    }

    .crs_name {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px;
        align-items: center;
        justify-content: space-between;
    }

    /* Style the checkboxes */

    /* Style the checkboxes without hiding them */
    .crs_name input[type="checkbox"],
    .btw_obs input[type="checkbox"],
    .btw_dash input[type="checkbox"],
    .prs_gdata input[type="checkbox"] {
        /* Your checkbox styles */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border: 1px solid #000000;
        border-radius: 0;
        outline: none;
        margin-right: 5px;
        cursor: pointer;
        position: relative;
    }

    /* Create the custom checkmark */
    .crs_name input[type="checkbox"]:checked::before,
    .btw_obs input[type="checkbox"]:checked::before,
    .btw_dash input[type="checkbox"]:checked::before,
    .prs_gdata input[type="checkbox"]:checked::before {
        content: "\2713";

        font-size: 14px;
        color: white;

        position: absolute;
        top: 0px;
        left: 3px;
    }

    /* Change background color of the checkbox only when checked */
    .crs_name input[type="checkbox"]:checked,
    .btw_obs input[type="checkbox"]:checked,
    .btw_dash input[type="checkbox"]:checked,
    .prs_gdata input[type="checkbox"]:checked {
        background-color: rgb(69, 69, 69);
        box-shadow: 2px 2px 0px 0px;
    }

    /* Reset background color when the checkbox is unchecked */
    .crs_name input[type="checkbox"]:not(:checked),
    .btw_obs input[type="checkbox"]:not(:checked),
    .btw_dash input[type="checkbox"]:not(:checked),
    .prs_gdata input[type="checkbox"]:not(:checked) {
        background-color: transparent;
        box-shadow: 2px 2px 0px 0px;
    }


    hr {
        border: none;
        /* Remove default borders */
        border-top: 3px solid black;
        /* Set the top border to 3px and black color */
        margin: 5px 0px;
    }

    .btw_obs input[type="checkbox"],
    .btw_dash input[type="checkbox"] {
        /* Your checkbox styles */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border: 1px solid #000000;
        border-radius: 0;
        outline: none;
        margin-right: 5px;
        cursor: pointer;
        position: relative;
    }

    .hrs_info {
        display: flex;
        gap: 10px;
        padding: 10px;
        justify-content: space-between;
    }

    .prs_names {
        display: flex;
        gap: 10px;
        align-items: baseline;
        width: 60%;
    }

    .underline-input1,
    .underline-input2 {
        width: 40%;
    }

    .underline-input3 {
        width: 20%;
    }

    .underline-input1 input,
    .underline-input2 input,
    .underline-input3 input {
        width: 100%;
    }

    .prs_info {
        display: flex;
        gap: 10px;
        padding: 10px;
        justify-content: space-between;
    }

    .prs_dmy {
        display: flex;
    }

    .date-input input {
        width: 50px;
    }



    /* .prs_gdata {
    display: flex;
    gap: 10px;
} */




    p.declaration_text {
        font-weight: 600;
        font-size: 18px;
        line-height: 22px;
        padding: 10px;
    }

    .signatures {
        display: flex;
        flex-direction: column;
        WIDTH: 33%;
    }

    .signature_fields {
        display: flex;
        gap: 10px;
        padding: 10px;
        justify-content: space-between;
    }

    .time_behind_wheel {
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        gap: 30px;
    }

    p.warning_text {
        text-align: left;
        padding: 10px;
    }

    .crt_footer h3 {
        text-align: center;
        padding: 10px;
        font-size: 24px;
    }

    .crt_footer p {
        padding: 10px;
        margin-top: -20px;
        text-align: end;
    }
</style>

<body>

    <section class="d_licence">
        <div class="dl_header">
            <div class="h_left">DPS COPY</div>
            <div class="h_center">
                <h2>TEXAS DRIVER EDUCATION CERTIFICATE</h2>
                <p>(Type or print legibly in black ink)</p>
            </div>
            <div class="h_right">
                <h3>CONTROL NO.</h3>
                <p><?php echo $userControl; ?></p>
            </div>
        </div>

        <div class="crt_purpose">
            <h3>FOR DRIVER LICENSE ONLY</h3>
        </div>

        <div class="crs_name">
            <div>
                <input type="checkbox" id="driver_education_school" name="course" value="Driver Education School">
                <label for="driver_education_school">Parent Taught Driver Education (PTDE) Course</label>
            </div>
            <div>
                <input type="checkbox" id="duplicate" name="course"
                    value="Duplicate (Original Control # ______________)">
                <label for="duplicate">Duplicate<span>(Original Control # PT<input type="text"
                            id="duplicate_control_number" placeholder="<?php echo $userControl; ?>" />)</span></label>
            </div>
        </div>

        <hr>

        <div class="hrs_info">
            <div class="btw_obs">
                <input type="checkbox" id="behind_the_wheel" name="btw_observation"
                    value="7 hours behind-the-wheel instruction and 7 hours in-car observation" class="styled-checkbox">
                <label for="behind_the_wheel">Concurrent Program <span class="brac_txt"> (classroom and laboratory
                        provided
                        simultaneously)</span></label>
            </div>

            <div class="btw_dash">
                <input type="checkbox" id="combined_options" name="btw_dash" value="combined_options"
                    class="styled-checkbox">
                <label for="combined_options">Block Program <span class="brac_txt">(entire classroom phase completed
                        before
                        laboratory begins)</span></label>
            </div>
        </div>

        <hr>

        <div class="prs_info">
            <div class="prs_names">
                <label for="firstName">Name:</label>
                <div class="underline-input1">
                    <input type="text" id="firstName" placeholder="<?php echo $userLastName; ?>" />
                    <span>Last</span>
                </div>

                <div class="underline-input2">
                    <input type="text" id="lastName" placeholder="<?php echo $userFirstName; ?>" />
                    <span>First</span>
                </div>
                <div class="underline-input3">
                    <input type="text" id="ml" placeholder="M.I." />
                    <span>Ml</span>
                </div>
            </div>

            <div class="prs_dob">
                <div class="prs_dmy">
                    <label for="month">Date Of Birth</label>
                    <div class="date-input">
                        <input type="text" id="month" maxlength="2" placeholder="<?php echo $userDob; ?>" />
                    </div>/

                    <div class="date-input">
                        <input type="text" id="date" maxlength="2" placeholder="DD" />
                    </div>/

                    <div class="date-input">
                        <input type="text" id="year" maxlength="4" placeholder="YYYY" />
                    </div>
                </div>
            </div>

            <div class="prs_gender">
                <div class="prs_gdata">
                    <input type="checkbox" id="male" name="gender" value="Male">
                    <label for="male">Male</label>

                    <input type="checkbox" id="female" name="gender" value="Female">
                    <label for="female">Female</label>
                </div>
            </div>
        </div>

        <div class="time_behind_wheel">
            <div class="prs_gdata">
                <input type="checkbox" id="class_c" name="class_c">
                <label for="class_c">Must take Class C - Road Rules and Class C - Signs examinations with the Department
                    of
                    Public Safety</label>
            </div>

            <div class="prs_gdata">
                <input type="checkbox" id="class_c_grade" name="class_c_grade">
                <label for="class_c_grade"> Has passed Class C - Road Rules and Class C - Signs examinations.
                    &nbsp;&nbsp;<b>Grade:</b> Road Rules:<input type="text" id="road_rules_grade"
                        placeholder="Passed" /> Road Signs <input type="text" id="road_signs_grade"
                        placeholder="Passed" /> and Must take vision exam with the Department of Public
                    Safety</label>
            </div>
        </div>

        <div>
            <p class="declaration_text"><em>I hereby certify that the person indicated has completed and passed both the
                    classroom and the laboratory phase of a driver education course approved by the Texas Department of
                    Licensing and Regulation.</em></p>
        </div>

        <div class="signature_fields">
            <div class="signatures">
                <input type="text" id="signatureOne" class="signature_input" placeholder="Instructor's Signature" />
                <span>Signature of PTDE Instructor</span>
            </div>
            <div class="signatures">
                <input type="text" id="signatureTwo" class="signature_input" placeholder="License Number" />
                <span>PTDE Instructor Driver License Number</span>
            </div>
            <div class="signatures">
                <input type="text" id="signatureThree" class="signature_input" placeholder="Course Name" />
                <span>PTDE Course Name</span>
            </div>
        </div>

        <div class="signature_fields">
            <div class="signatures">
                <input type="text" id="signatureFour" class="signature_input"
                    placeholder="Provider's Signature (Optional)" />
                <span>Signature (Optional) PTDE Course Provider</span>
            </div>
            <div class="signatures">
                <input type="text" id="signatureFive" class="signature_input" placeholder="Course Number" />
                <span>PTDE Course Number</span>
            </div>
            <div class="signatures">
                <input type="text" id="signatureSix" class="signature_input" placeholder="Date Issued" />
                <span>Date Issued</span>
            </div>
        </div>

        <div class="crt_purpose">
            <p class="warning_text"><u>WARNING</u>: You may commit a crime if you give this driver education certificate
                to
                the Department of Public Safety or to an insurance company and you did not complete the course of hours
                as
                indicated. You may also commit a crime if you put any information on this certificate that is not true.
            </p>
        </div>

        <div class="crt_footer">
            <h3>UNLAWFUL IF REPRODUCED OR ALTERED – INVALID IF STATE SEAL IS NOT VISIBLE</h3>
            <p>DE-964 (Rev. 9/1/15)</p>
        </div>
    </section>


</body>

</html>

<?php

} else {
    echo 'Failed to fetch user details from the endpoint.';
}
} else {
echo 'User ID not provided.';
}
?>