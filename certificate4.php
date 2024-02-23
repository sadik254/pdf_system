<?php
if (isset($_GET['id'])) {
    // Your endpoint URL to fetch user details
    $endpoint = 'https://yoururl/pdf_system/cert1api.php?id=' . $_GET['id'];

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
        
        $dateParts = explode('-', $userDob);

// Extract year, month, and day from the array
$year = $dateParts[0];
$month = $dateParts[1];
$day = $dateParts[2];

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
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <link
      rel="stylesheet"
      href="https://yoururl/pdf_system/global.css"
    />
    <title>Form-4</title>
  </head>
  <body style="margin-bottom: 10px">
    <!-- court copy -->
    <main
      class="box fit mx-auto mt flex"
      style="
        align-items: center;
        justify-content: center;
        max-width: 1250px;
        gap: 0;
      "
    >
      <!-- main block -->
      <div class="form-4-bg">
        <header
          style="
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin-top: 1rem;
          "
        >
          <div class="fit">
            <img
              src="texas-logo.png"
              alt=""
              width="150px"
              height="auto"
            />
          </div>
          <div style="line-height: 1.9rem">
            <h1
              class="text-center"
              style="font-size: 35px"
            >
              STATE OF TEXAS DRIVING SAFETY COURSE
            </h1>
            <h2
              class="text-center"
              style="font-size: 25px"
            >
              UNIFORM CERTIFICATE OF COMPLETION
            </h2>
            <h2
              class="text-center stroke-text"
              style="font-size: 30px"
            >
              COURT COPY
            </h2>
          </div>
        </header>
        <div class="px-2 py">
          <p class="font-20px">
            This certifies that the student named herein has successfully
            completed a six (6) hour driving safety course that is approved and
            regulated by the Texas Department of Licensing and Regulation.
          </p>
          <br />
          <p class="font-20px">
            This certificate's
            <span style="text-decoration: underline">
              validity can be verified within 5 days
            </span>
            of the issuance date at
            <span
              ><a
                style="color: blue"
                href="www.tdlr.texas.gov/DESSearch"
                >www.tdlr.texas.gov/DESSearch</a
              ></span
            >
          </p>
          <br />
          <p class="font-20px">
            Under penalty of perjury, I certify that I have received six (6)
            hours of instruction
          </p>
        </div>
        <br />
        <br />
        <div
          class="px-2 py"
          style="
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
          "
        >
          <input
            name="signaturestu"
            class="text-box"
            type="text"
            style="width: 40rem"
          />
          <label
            class="font-20px"
            for="signaturestu"
            style="margin-left: 15rem; font-weight: 700"
          >
            Student's Signature
          </label>
        </div>
        <div class="px-2 py">
          <p class="font-20px">
            If you have reason to believe this certificate is not valid or the
            driving safety course taken did not meet the requirements in Texas
            Administrative Code Chapter 84 or Texas Education Code Chapter 1001,
            please file a complaint with TDLR at
            <span
              ><a
                style="color: blue"
                href="www.tdlr.texas.gov/complaints"
                >www.tdlr.texas.gov/complaints
              </a></span
            >
            or mail to 920 Colorado St, Austin, TX 78701.
          </p>
        </div>

        <div class="px-2 py">
          <h1>Court Information:</h1>
          <p
            class="font-20px"
            style="margin-left: 5rem"
          >
            Municipal, City of Flower Mound, DENTON
          </p>
        </div>

        <br />

        <div class="px-2 py">
          <h1>Student Name and Mailing Address:</h1>
          <br />
          <br />
          <input
            name="signaturestu"
            class="text-box"
            type="text"
            style="width: 40rem"
          />
          <br />
          <br />
        </div>

        <div
          class="bg-black px py"
          style="
            border-radius: 15px;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
          "
        >
          <p class="text-white">
            <span
              class="text-white"
              style="text-decoration: underline"
            >
              WARNING:
            </span>
            Altering, tampering, forgery or misuse of the certificate may result
            in criminal fines up to $10,000 and/or up to 5 years imprisonment
            under the Texas Penal Code and Texas Education Code.
          </p>
        </div>
      </div>

      <!-- side panel -->
      <div>
        <div
          class="py px"
          style="
            border: 6px solid black;
            /* padding-right: 10rem; */
            height: 10rem;
            border-top: 1px solid black;
          "
        >
          <br />
          <div class="flex">
            <h1 style="font-size: 20px">CERTIFICATE#</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
        </div>
        <div
          class="py px"
          style="
            border: 6px solid black;
            border-top: 10px solid black;
            /* padding-right: 1rem; */
            height: 16rem;
          "
        >
          <br />
          <br />

          <div class="flex">
            <h1 style="font-size: 18px">Student Name:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo $userFirstName . ' ' . $userLastName; ?>"
            />
          </div>
          <br />
          <br />

          <div class="flex">
            <h1 style="font-size: 18px">Student DL No:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
          <br />
          <div class="flex">
            <h1 style="font-size: 18px">Student DOB:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo $userDob ; ?>"
            />
          </div>
          <br />
        </div>
        <div
          class="py px"
          style="
            border: 6px solid black;
            border-top: 10px solid black;
            border-bottom: 14px solid black;
            /* padding-right: 1rem; */
            height: fit-content;
          "
        >
          <br />
          <br />
          <div class="flex">
            <h1 style="font-size: 18px">Provider:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
          <br />
          <div class="flex">
            <h1 style="font-size: 16px">Completion Date:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo date("m/d/Y"); ?>"
            />
          </div>
          <br />
          <br />
          <div class="flex">
            <h1 style="font-size: 18px">Issue Date:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo date("m/d/Y"); ?>"
            />
          </div>
          <br />
          <br />

          <div class="flex">
            <h1 style="font-size: 18px">Reason:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
          <br />
          <br />
        </div>
      </div>
    </main>
    <div class="mx-auto fit">
      ----------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </div>
    <!-- insurance copy -->
    <main
      class="box fit mx-auto flex"
      style="
        align-items: center;
        justify-content: center;
        max-width: 1250px;
        gap: 0;
      "
    >
      <!-- main block -->
      <div
        class="form-4-bg"
        style="margin-left: 1px"
      >
        <header
          style="
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin-top: 1rem;
          "
        >
          <div class="fit">
            <img
              src="texas-logo.png"
              alt=""
              width="150px"
              height="auto"
            />
          </div>
          <div style="line-height: 1.9rem">
            <h1
              class="text-center"
              style="font-size: 35px"
            >
              STATE OF TEXAS DRIVING SAFETY COURSE
            </h1>
            <h2
              class="text-center"
              style="font-size: 25px"
            >
              UNIFORM CERTIFICATE OF COMPLETION
            </h2>
            <h2
              class="text-center stroke-text"
              style="font-size: 30px"
            >
              INSURANCE COPY
            </h2>
          </div>
        </header>
        <div class="px-2 py">
          <p class="font-20px">
            This certifies that the student named herein has successfully
            completed a six (6) hour driving safety course that is approved and
            regulated by the Texas Department of Licensing and Regulation.
          </p>
          <br />
          <p class="font-20px">
            This certificate's
            <span style="text-decoration: underline">
              validity can be verified within 5 days
            </span>
            of the issuance date at
            <span
              ><a
                style="color: blue"
                href="www.tdlr.texas.gov/DESSearch"
                >www.tdlr.texas.gov/DESSearch</a
              ></span
            >
          </p>
          <br />
          <p class="font-20px">
            Under penalty of perjury, I certify that I have received six (6)
            hours of instruction
          </p>
        </div>
        <br />
        <br />
        <div
          class="px-2 py"
          style="
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
          "
        >
          <input
            name="signaturestu"
            class="text-box"
            type="text"
            style="width: 40rem"
          />
          <label
            class="font-20px"
            for="signaturestu"
            style="margin-left: 15rem; font-weight: 700"
          >
            Student's Signature
          </label>
        </div>
        <div class="px-2 py">
          <p class="font-20px">
            If you have reason to believe this certificate is not valid or the
            driving safety course taken did not meet the requirements in Texas
            Administrative Code Chapter 84 or Texas Education Code Chapter 1001,
            please file a complaint with TDLR at
            <span
              ><a
                style="color: blue"
                href="www.tdlr.texas.gov/complaints"
                >www.tdlr.texas.gov/complaints
              </a></span
            >
            or mail to 920 Colorado St, Austin, TX 78701.
          </p>
        </div>
        <br />
        <br />
        <br />
        <br />
        <div class="px-2 py">
          <h1>Student Name and Mailing Address:</h1>
          <br />
          <br />
          <br />
          <input
            name="signaturestu"
            class="text-box"
            type="text"
            style="width: 40rem"
          />

          <br />
          <br />
        </div>

        <div
          class="bg-black px py"
          style="
            border-radius: 15px;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
          "
        >
          <p class="text-white">
            <span
              class="text-white"
              style="text-decoration: underline"
            >
              WARNING:
            </span>
            Altering, tampering, forgery or misuse of the certificate may result
            in criminal fines up to $10,000 and/or up to 5 years imprisonment
            under the Texas Penal Code and Texas Education Code.
          </p>
        </div>
      </div>

      <!-- side panel -->
      <div>
        <div
          class="py px"
          style="
            border: 6px solid black;
            border-top: 1px solid black;
            border-right: 0;
            /* padding-right: 10rem; */
            height: 10rem;
            margin-right: 3px;
          "
        >
          <br />
          <h1></h1>
          <div
            class="flex"
            style="padding-right: 1rem"
          >
            <h1 style="font-size: 18px">CERTIFICATE#</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
        </div>
        <div
          class="py px"
          style="
            border: 6px solid black;
            border-top: 10px solid black;
            padding-right: 1rem;
            height: 15rem;
          "
        >
          <br />
          <div class="flex">
            <h1 style="font-size: 18px">Student Name:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo $userFirstName . ' ' . $userLastName; ?>"
            />
          </div>
          <br />
          <br />

          <div class="flex">
            <h1 style="font-size: 18px">Student DL No:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
          <br />
          <div class="flex">
            <h1 style="font-size: 18px">Student DOB:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo $userDob ; ?>"
            />
          </div>
          <br />
        </div>
        <div
          class="py px"
          style="
            border: 6px solid black;
            border-top: 10px solid black;
            border-bottom: 10px solid black;
            border-right: 0;
            padding-right: 1rem;
            height: fit-content;
            margin-right: 3px;
          "
        >
          <br />

          <div class="flex">
            <h1 style="font-size: 18px">Provider:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
          <br />
          <div class="flex">
            <h1 style="font-size: 18px">Completion Date:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo date("m/d/Y"); ?>"
            />
          </div>
          <br />
          <br />

          <div class="flex">
            <h1 style="font-size: 18px">Issue Date:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
              value="<?php echo date("m/d/Y"); ?>"
            />
          </div>
          <br />
          <br />
          <div class="flex">
            <h1 style="font-size: 18px">Reason:</h1>
            <input
              name="signaturestu"
              class="text-box"
              type="text"
            />
          </div>
          <br />
          <br />
        </div>
      </div>
    </main>
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