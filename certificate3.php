<?php
if (isset($_GET['id'])) {
    // Your endpoint URL to fetch user details
    $endpoint = 'https://hoolahoop.us/test/pdf_system/cert1api.php?id=' . $_GET['id'];

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
 $controlNumbersEndpoint = 'https://hoolahoop.us/test/pdf_system/control.php';
 $controlNumbersJson = file_get_contents($controlNumbersEndpoint);
 $controlNumbersData = json_decode($controlNumbersJson, true);

 // Find the first control number that is not used
 $userControl = '';
 foreach ($controlNumbersData as $control) {
     if ($control['used'] == '0') {
         $userControl = $control['control_no'];
         // Update the control number as used
         $updateControlEndpoint = 'https://hoolahoop.us/test/pdf_system/control.php?id=' . $control['id'];
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
      href="https://hoolahoop.us/test/pdf_system/global.css"
    />
    <title>Form-3</title>
  </head>
  <body style="margin-bottom: 10px">
    <main class="border max-w fit mx-auto mt form-1-bg">
      <header
        class="grid-box px"
        style="align-items: baseline"
      >
        <div class="w-max">
          <h4 class="uppercase">Dps/ insurance copy</h4>
        </div>
        <div class="flex-box-2 text-center">
          <h1 class="uppercase pb">Texas adult driver education certificate</h1>
          <p>(Type or print legibly in blank ink)</p>
        </div>
        <div class="fit">
          <h4
            class="uppercase"
            style="margin-right: 1.2rem"
          >
            control no.
            <?php echo $userControl ; ?>
          </h4>
        </div>
      </header>

      <!-- after top -->
      <section class="bg-black">
        <h2 class="uppercase text-white text-center">
          for learner licence only
        </h2>
      </section>

      <section
        class="grid-box-2 px py"
        style="gap: 1rem; align-items: baseline"
      >
        <!-- 1 -->
        <div class="flex">
          <input
            type="checkbox"
            name="des2"
            id="des2"
          />
          <label
            for="des2"
            class="capitalize"
            >Driver Education School</label
          >
        </div>
        <!-- 2 -->
        <div class="flex">
          <input
            type="checkbox"
            name="tdlrptc"
            id="tdlrptc"
          />
          <label
            for="tdlrptc"
            class="capitalize"
            >TDLR parent taught Course</label
          >
        </div>
        <!-- 3 -->
        <div class="flex">
          <input
            type="checkbox"
            name="docpt2"
            id="docpt2"
          />
          <label
            for="docpt2"
            class="capitalize"
            >Duplicate (original control # PT
            <span
              ><input
                type="text"
                class="text-box"
                placeholder="Enter Original Control #" /></span
            >)</label
          >
        </div>
        <!-- 4 -->
        <div class="flex">
          <input
            type="checkbox"
            name="tsbd"
            id="tsbd"
          />
          <label
            for="tsbd"
            class="capitalize"
            >Transfer (See back for details)</label
          >
        </div>
      </section>

      <!-- divider -->
      <div class="divider"></div>

      <!-- checkbox -->
      <section
        class="flex px py"
        style="flex-wrap: wrap; gap: 1rem"
      >
        <div
          class="flex"
          style="align-items: flex-start"
        >
          <input
            type="checkbox"
            name="labic"
            id="labic"
          />
          <label
            for="labic"
            class="capitalize"
          >
            32 hours classroom instruction concurrent with laboratory
          </label>
        </div>

        <div
          class="flex"
          style="align-items: flex-start"
        >
          <input
            type="checkbox"
            name="labic"
            id="labic"
          />
          <label
            for="labic"
            class="capitalize"
          >
            32 hours block classroom instruction
          </label>
        </div>

        <div
          class="flex"
          style="align-items: flex-start"
        >
          <input
            type="checkbox"
            name="labic"
            id="labic"
          />
          <label
            for="labic"
            class="capitalize"
          >
            Must take Class C-Road Rules, Class C-Signs and vision examinations
            with the Deparment of Public Safety
          </label>
        </div>

        <div
          class="flex"
          style="align-items: flex-start; gap: 1rem"
        >
          <div
            class="flex"
            style="align-items: flex-start"
          >
            <input
              type="checkbox"
              name="labic"
              id="labic"
              checked
            />
            <label
              for="labic"
              class="capitalize"
            >
              Has passed Class C-Road Rules and Class C-Signs examination.

              <p>Must take vision exam with the Department of Public Safety</p>
            </label>
          </div>

          <div>
            <label
              for=""
              style="font-weight: 500"
              >Grade: <span style="font-weight: 400">Road Rules:</span></label
            >
            <input
              class="text-box"
              type="text"
              style="width: 5rem"
              value="P"
            />

            <label for=""> Road Signs:</label>
            <input
              class="text-box"
              type="text"
              style="width: 5rem"
              value="P"
            />
            <span>and</span>
          </div>
        </div>

        <div
          class="flex"
          style="
            align-items: flex-start;
            justify-content: flex-start;
            flex-wrap: wrap;
          "
        >
          <input
            type="checkbox"
            name="labic"
            id="labic"
          />

          <label
            for="labic"
            class="capitalize"
          >
            Has passed Class C-Road Rules and Class C-Signs examination.
          </label>

          <label
            for=""
            style="font-weight: 500"
          >
            Grade:
            <span style="font-weight: 400"> Road Rules: </span>
            <input
              class="text-box"
              type="text"
              style="width: 5rem"
            />
          </label>

          <label for="rsccc">
            Road Signs:
            <input
              class="text-box"
              type="text"
              style="width: 5rem"
              name="rsccc"
            />
            and
          </label>
          <span style="margin-left: 1.8rem"> Has taken vision exam. </span>
          <p>Vision uncorrected:</p>
          <label
            for=""
            style="
              display: flex;
              align-items: center;
              justify-content: center;
              margin-right: 0.5rem;
            "
          >
            20 /
            <input
              class="text-box"
              style="width: 3rem"
              type="text"
              name=""
              id=""
            />
            R
          </label>
          <label
            for=""
            style="
              display: flex;
              align-items: center;
              justify-content: center;
              margin-right: 0.5rem;
            "
          >
            20 /
            <input
              class="text-box"
              style="width: 3rem"
              type="text"
              name=""
              id=""
            />
            L
          </label>
          <label
            for=""
            style="
              display: flex;
              align-items: center;
              justify-content: center;
              margin-right: 0.5rem;
            "
          >
            20 /
            <input
              class="text-box"
              style="width: 3rem"
              type="text"
              name=""
              id=""
            />
            B
          </label>
          <p>Vision corrected:</p>
          <label
            for=""
            style="
              display: flex;
              align-items: center;
              justify-content: center;
              margin-right: 0.5rem;
            "
          >
            20 /
            <input
              class="text-box"
              style="width: 3rem"
              type="text"
              name=""
              id=""
            />
            R
          </label>
          <label
            for=""
            style="
              display: flex;
              align-items: center;
              justify-content: center;
              margin-right: 0.5rem;
            "
          >
            20 /
            <input
              class="text-box"
              style="width: 3rem"
              type="text"
              name=""
              id=""
            />
            L
          </label>
          <label
            for=""
            style="display: flex; align-items: center; justify-content: center"
          >
            20 /
            <input
              class="text-box"
              style="width: 3rem"
              type="text"
              name=""
              id=""
            />
            B
          </label>
        </div>
      </section>

      <!-- divider -->
      <div class="divider"></div>

      <section class="px py">
        <!-- fill in the blanks name and such -->
        <p style="font-style: italic; font-size: 13px">
          * Under the concurrent program, If a student does not complete the
          required instruction, the instructor is required to complete Parent
          Taught Cancellations Form (DL-93) and send it to the License and
          Record Service at the Texas Deparment of Public Safety. The DPS may
          then revoke the student's learner license.
        </p>
        <br />
        <!-- name and such -->
        <div
          class="flex"
          style="flex-wrap: wrap; align-items: baseline; gap: 1rem"
        >
          <div
            style="
              display: flex;
              align-items: flex-start;
              justify-content: flex-start;
              gap: 0.5rem;
            "
          >
            <p>Name:</p>
            <div
              style="
                display: flex;
                align-items: flex-start;
                flex-direction: column;
              "
            >
              <input
                class="text-box"
                type="text"
                name="lnm"
                id="lnm"
                placeholder="last name"
                value="<?php echo $userLastName; ?>"
              />
              <label for="lnm">Last</label>
            </div>
            <div
              style="
                display: flex;
                align-items: flex-start;
                flex-direction: column;
              "
            >
              <input
                class="text-box"
                type="text"
                name="fnm"
                id="fnm"
                placeholder="first name"
                value="<?php echo $userFirstName; ?>"
              />
              <label for="fnm">First</label>
            </div>
            <div
              style="
                display: flex;
                align-items: flex-start;
                flex-direction: column;
              "
            >
              <input
                class="text-box"
                type="text"
                name="mnm"
                id="mnm"
                placeholder="middle name"
              />
              <label for="mnm">Middle</label>
            </div>
          </div>
          <div class="flex">
            <label
              for="hcc"
              class="flex"
              >Date of Birth
              <span
                ><input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                  name="month"
                  id="month"
                  placeholder="MM"
                  value="<?php echo $month; ?>"
                /> </span
              >/
              <span
                ><input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                  name="day"
                  placeholder="DD"
                  value="<?php echo $day; ?>"
                  id="day" /></span
              >/
              <span
                ><input
                  class="text-box"
                  style="width: 3rem"
                  type="text"
                  name="year"
                  placeholder="YYYY"
                  value="<?php echo $year; ?>"
                  id="year" /></span
            ></label>
          </div>
          <div
            class="flex"
            style="gap: 1rem"
          >
            <div
              class="flex"
              style="align-items: flex-start"
            >
              <input
                type="checkbox"
                name="male"
                <?php if ($userGender === 'male') echo 'checked'; ?>
              />
              <label for="male">Male</label>
            </div>
            <div
              class="flex"
              style="align-items: flex-start"
            >
              <input
                type="checkbox"
                name="female"
                <?php if ($userGender === 'female') echo 'checked'; ?>
              />
              <label for="female">Female</label>
            </div>
          </div>
        </div>
        <!-- hereby................. -->
        <p
          class="py"
          style="
            font-weight: 600;
            font-style: italic;
            font-size: 15px;
            text-align: justify;
          "
        >
          I hereby certify that the person indicated has completed and passed at
          lest six (6) hours of driver education traffic laws and is enrolled in
          a Parent Taught Driver Education course approved by the Texas
          Department of Licensing and Regulations.
        </p>

        <!-- checkbox incomingggg........ -->
        <section class="py grid-box">
          <!-- 1 -->
          <div
            class="flex"
            style="
              flex-direction: column;
              align-items: flex-start;
              row-gap: 1.5rem;
            "
          >
            <div
              class="flex fit"
              style="flex-direction: column; align-items: flex-start"
            >
              <img
              src="https://hoolahoop.us/test/pdf_system/signature.png"
              alt=""
              height="40"
              width="180"
            />
            <span
              ><hr
                width="340"
                style="height: 1.3px; background-color: black"
            /></span>
              <label
                for="signt"
                style="font-size: 12px"
                >Signature of Licensed Driver Education or TDLR PT
                Instructor</label
              >
            </div>
            <div
              class="flex"
              style="flex-direction: column; align-items: flex-start"
            >
              <img
              src="https://hoolahoop.us/test/pdf_system/signature.png"
              alt=""
              height="40"
              width="180"
            />
            <span
              ><hr
                width="340"
                style="height: 1.3px; background-color: black"
            /></span>
              <label
                for="signtcso"
                style="font-size: 12px"
                >Signature (or Signature Stamp) of Chief School Official or TDLR
                PT CP
              </label>
            </div>
          </div>
          <!-- 2 -->
          <div
            class="flex"
            style="
              class="flex"
          style="flex-direction: column; align-items: flex-start; row-gap: 3rem"
          >
            <div
              class="flex fit"
              style="flex-direction: column; align-items: flex-start"
            >
              <input
                class="text-box"
                type="text"
                name="tldrnum2"
                style="width: max-content; width: 18.2rem"
                placeholder="Number"
                value="8260"
              />
              <label
                for="tldr2"
                style="font-size: 12px"
                >TDLR Number or TDLR PT Instructor DL Number</label
              >
            </div>
            <div
              class="flex fit"
              style="flex-direction: column; align-items: flex-start"
            >
              <input
                class="text-box"
                type="text"
                name="desn2"
                style="width: max-content; width: 18.2rem"
                placeholder="Name"
                value="C2759"
              />
              <label
                for="desn2"
                style="font-size: 12px"
                >Driver Education School # or TDLR PT Course #
              </label>
            </div>
          </div>
          <!-- 3 -->
          <div
            class="flex"
            style="
              flex-direction: column;
              align-items: flex-start;
              row-gap: 1.5rem;
            "
          >
            <div
              class="flex fit"
              style="flex-direction: column; align-items: flex-start"
            >
              <input
                class="text-box"
                type="text"
                name="nos2"
                style="width: max-content; width: 18.2rem"
                placeholder="Name"
                value="Drive Safe Driving School"
              />
              <label
                for="nos2"
                style="font-size: 12px"
                >Name of School or TDLR PT Course Name
              </label>
            </div>
            <div
              class="flex fit"
              style="flex-direction: column; align-items: flex-start"
            >
              <input
                class="text-box"
                type="text"
                name="disd2"
                style="width: max-content; width: 18.2rem"
                placeholder="Date"
                value="<?php echo date("m/d/Y"); ?>"
              />
              <label
                for="disd2"
                style="font-size: 12px"
                >Date Issued</label
              >
            </div>
          </div>
        </section>
      </section>

      <!-- warning -->
      <section class="px py bg-black">
        <p
          class="text-white"
          style="font-size: 10px; text-align: justify"
        >
          <span
            class="text-white"
            style="text-decoration: underline"
            >WARNING:</span
          >
          You may commit a crime if you give this driver education certificate
          to the Department of Public Safety or to an insurance company and you
          did not complete the course of hours as indicated. You may also commit
          a crime if you put any information on this certificate that is not
          true.
        </p>
      </section>
      <!-- end part -->
      <section
        class="px fit"
        style="
          display: grid;
          grid-template-columns: repeat(2, auto);
          align-items: end;
          justify-content: center;
          gap: 10rem;
          margin-left: auto;
        "
      >
        <h1
          class="text-center fit"
          style="margin-right: 7rem"
        >
          UNLAWFUL IF REPRODUCED OR ALTERNATED
        </h1>
        <p
          class="fit"
          style="font-size: 12px; font-style: unset"
        >
          PT DE-964E
        </p>
      </section>
    </main>
    <!-- back part form-2 -->
    <section class="border max-w fit mx-auto mt">
      <!-- transfer -->
      <section class="px py">
        <p style="font-size: 13px; font-style: italic; text-align: justify">
          <span
            style="
              text-decoration: underline;
              font-weight: 700;
              font-style: normal;
            "
            >TRANSFER:</span
          >
          Fill out the applicable items on the front of this certificate before
          proceeding. Indicate the number of hours successfully completed in the
          spaces below. If the number of hours is nine or less, place a zero in
          front of the single digit number. (For Example, if four hours were
          completed, enter as 04)
        </p>
      </section>
      <!-- fill in the blanks -->
      <div
        class="px py flex"
        style="justify-content: space-between"
      >
        <div
          class="py"
          style="display: flex; align-items: start; justify-content: center"
        >
          <input
            class="text-box"
            type="text"
            name="clsr"
            style="width: 4rem"
          />
          <label
            for="clsr"
            class="capitalize"
            >classroom</label
          >
        </div>
        <div
          class="py"
          style="display: flex; align-items: start; justify-content: center"
        >
          <input
            class="text-box"
            type="text"
            name="btwi"
            style="width: 4rem"
          />
          <label
            for="btwi"
            class="capitalize"
            >BEHIND-THE-WHEEL INSTRUCTION</label
          >
        </div>
        <div
          class="py"
          style="display: flex; align-items: start; justify-content: center"
        >
          <input
            class="text-box"
            type="text"
            ame="icob"
            style="width: 4rem"
          />
          <label
            for="icob"
            class="capitalize"
          >
            IN-CAR OBSERVATION</label
          >
        </div>
        <div
          class="py"
          style="display: flex; align-items: start; justify-content: center"
        >
          <input
            class="text-box"
            type="text"
            name="siml"
            style="width: 4rem"
          />
          <label
            for="siml"
            class="capitalize"
          >
            SIMULATOR</label
          >
        </div>
        <div
          class="py"
          style="display: flex; align-items: start; justify-content: center"
        >
          <input
            class="text-box"
            type="text"
            name="mtc"
            style="width: 4rem"
          />
          <label
            for="mtc"
            class="capitalize"
          >
            MULTI-CAR</label
          >
        </div>
      </div>
      <!-- text -->
      <div class="px py">
        <p style="word-wrap: break-word; font-size: 18px; text-align: justify">
          Mail all transfer documentation to the school or parent/legal guardian
          indicated.
          <span style="text-decoration: underline"
            >Include copies of the student's instruction records verifying the
            number of hours completed.</span
          >
        </p>
      </div>
      <!-- transfer to -->
      <div class="px py">
        <div
          class=""
          style="
            display: grid;
            grid-template-columns: 1fr 2fr 4fr;
            align-items: baseline;
            justify-content: flex-start;
          "
        >
          <h2 class="fit">TRANSFERRING TO:</h2>
          <section
            class="flex"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="nosog"
              style="width: 100%"
              placeholder="Name"
            />
            <label for="nosog">Name of School or Parent/Guardian</label>
          </section>
          <section
            class="flex"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="addd"
              style="width: 40rem; margin-left: 1rem"
              placeholder="Address"
            />
            <label
              for="addd"
              style="margin-left: 1rem"
            >
              Address
            </label>
          </section>
        </div>
      </div>

      <!-- text again -->
      <section class="px py bg-black">
        <p
          class="text-white"
          style="font-size: 12px"
        >
          If you have reason to believe that the minimum requirements are not
          being met at this driving school, please contact Texas Department of
          Licensing and Regulation, PO Box 12157, Austin, TX 78711, or call
          (512) 463-6599. (All complaints must be in writing. You may request
          anonymity.)
        </p>
      </section>
      <!-- affitv -->
      <section class="px py">
        <p style="font-size: 15px; text-align: justify">
          <span style="text-decoration: underline; font-weight: 700"
            >AFFIDAVIT:</span
          >
          This portion of the Texas Driver Education Certificate is to be used
          only when it is impossible for the student to obtain the signature of
          the certified instructor of the driver education course because of the
          instructor leaving the school or death or serious illness. Fill out
          the front of this certificate showing work completed and the name(s)
          of the instructor(s).
        </p>
      </section>

      <!-- clarify -->
      <div
        class="px py"
        style="display: inline-flex; flex-direction: column"
      >
        <label
          for="resspc"
          style="font-size: 16px; line-height: 3rem"
        >
          This is to certify that the signature and license number of the
          instructor who would hae verified completion of the driver education
          course or the hours described hereon could not be obtained because
          <input
            class="text-box"
            type="text"
            name="resspc"
            style="width: 57%"
          />
        </label>
        <p
          style="
            font-size: 12px;
            margin-left: auto;
            margin-right: 6rem;
            line-height: 0.1rem;
          "
        >
          (Give specific reason why it it impossible for the actual instructor
          to sign)
        </p>
      </div>
      <!-- i therefore -->
      <br />
      <br />
      <div class="px py">
        <h2>
          I therefore affirm that the instruction described has been lawfully
          and satisfactorily completed as shown.
        </h2>
      </div>
      <br />

      <!-- lots of signature -->
      <section
        class="px py flex"
        style="font-size: 15px; justify-content: space-between"
      >
        <div
          class="flex"
          style="flex-direction: column; align-items: flex-start"
        >
          <input
            class="text-box placeholder-text"
            type="text"
            name="sign22"
            id=""
            style="width: 100%"
            placeholder="Signature"
          />
          <label for="sign22">
            Signature of Chief School Official or TDLR PT Course Provider
            (required)
          </label>
        </div>
        <div
          class="flex"
          style="flex-direction: column; align-items: flex-start"
        >
          <input
            class="text-box"
            type="text"
            name="des222"
            id=""
            style="width: 100%"
            placeholder="Signature"
          />
          <label for="des222">
            Driver Education School # or TDLR PT Course #
          </label>
        </div>
        <div
          class="flex"
          style="flex-direction: column; align-items: flex-start"
        >
          <input
            class="text-box"
            type="text"
            name="dsddd"
            id=""
            style="width: 100%"
            placeholder="MM/DD/YYYY"
            value="<?php echo date("m/d/Y"); ?>"
          />
          <label for="dsddd"> Date Issued </label>
        </div>
      </section>

      <div
        class="flex"
        style="padding-bottom: 1rem"
      >
        <div
          class="flex"
          style="flex-direction: column; align-items: flex-end"
        >
          <!-- sworn -->
          <div
            class="px py"
            style="font-size: 20px"
          >
            <label>
              Sworn to and subscribed before me this
              <input
                class="text-box placeholder-text"
                type="text"
                style="width: 5rem"
                placeholder="Day"
              />
            </label>
            <label for="">
              day of
              <input
                class="text-box placeholder-text"
                type="text"
                style="width: 15rem"
                placeholder="Month"
              />
            </label>
          </div>

          <!-- notary -->
          <section
            class="px py"
            style="font-size: 20px"
          >
            <label for=""
              >Notary Public
              <input
                class="text-box placeholder-text"
                type="text"
                style="width: 30rem"
                placeholder="Signature"
              />
            </label>
          </section>
        </div>

        <!-- seal -->
        <h1
          style="
            font-size: 30px;
            font-weight: 400;
            font-style: italic;
            margin-left: auto;
            margin-right: auto;
          "
        >
          SEAL
        </h1>
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