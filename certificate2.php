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
    <title>Forms</title>
  </head>
  <body style="margin-bottom: 2rem">
    <!-- top form -->
    <main class="border max-w fit mx-auto mt form-1-bg">
      <header class="grid-box px py">
        <div class="text-bottom w-max items-end">
          <h4 class="uppercase">Dps copy</h4>
        </div>
        <div class="flex-box-2 text-center">
          <h1 class="uppercase pb">Texas adult driver education certificate</h1>
          <p>(Type or print legibly in blank ink)</p>
        </div>
        <div class="fit">
          <h4 class="uppercase pl">control no.</h4>
          <h3 class="uppercase"><?php echo $userControl; ?></h3>
        </div>
      </header>
      <!-- after top -->
      <section class="bg-black">
        <h2 class="uppercase text-white text-center">
          Driver education course exclusively for adults
        </h2>
      </section>
      <!-- checkboxes -->
      <section class="grid-box-2 px py">
        <!-- 1 -->
        <div class="flex">
          <input
            type="checkbox"
            name="des"
            id="des"
            checked
          />
          <label
            for="des"
            class="capitalize"
            >Driver Education School</label
          >
        </div>
        <!-- 2 -->
        <div class="flex">
          <input
            type="checkbox"
            name="pps"
            id="pps"
          />
          <label
            for="pps"
            class="capitalize"
            >parochial/private school</label
          >
        </div>
        <!-- 3 -->
        <div class="flex">
          <input
            type="checkbox"
            name="docpt"
            id="docpt"
          />
          <label
            for="docpt"
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
            name="ps"
            id="ps"
          />
          <label
            for="ps"
            class="capitalize"
            >Public school</label
          >
        </div>
        <!-- 5 -->
        <div class="flex">
          <input
            type="checkbox"
            name="escc"
            id="escc"
          />
          <label
            for="escc"
            class="capitalize"
            >education service center</label
          >
        </div>
        <!-- 6 -->
        <div class="flex">
          <input
            type="checkbox"
            name="cuor"
            id="cuor"
          />
          <label
            for="cuor"
            class="capitalize"
            >College/University</label
          >
        </div>
      </section>

      <!-- divider -->
      <div class="divider"></div>

      <!-- another checkbox section -->
      <section
        class="px py"
        style="display: flex; flex-wrap: wrap; gap: 0.5rem"
      >
        <div class="flex">
          <input
            type="checkbox"
            name="hcc"
            id="hcc"
            checked
          />
          <label
            for="hcc"
            class="flex"
            >6 hours classroom course (Completion:
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="month"
                id="month"
                placeholder="MM"
                value="<?php echo date("m");?>"
              /> </span
            >/
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="day"
                placeholder="DD"
                value="<?php echo date("d");?>"
                id="day" /></span
            >/
            <span
              ><input
                class="text-box"
                style="width: 3rem"
                type="text"
                name="year"
                placeholder="YYYY"
                value="<?php echo date("y");?>"
                id="year" /></span
            >)</label
          >
        </div>
        <!-- 2 -->
        <div class="flex">
          <input
            type="checkbox"
            name="hoc"
            id="hoc"
            checked
          />
          <label
            for="hoc"
            class="flex"
            >6 hours online course (Completion:
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="month"
                id="month"
                placeholder="MM"
              /> </span
            >/
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="day"
                placeholder="DD"
                id="day" /></span
            >/
            <span
              ><input
                class="text-box"
                style="width: 3rem"
                type="text"
                name="year"
                placeholder="YYYY"
                id="year" /></span
            >)</label
          >
        </div>
        <!-- 3 -->
        <div
          class="flex"
          style="align-items: flex-start"
        >
          <input
            type="checkbox"
            name="crr"
            id="crr"
            checked
          />
          <label
            for="crr"
            class=""
            >Has taken and passed Class C-Road Rules and Class C-Road Signs
            examinaton
            <p style="font-weight: bold">
              Please indicate Grade with a "P" for pass or numeric grade:
              <span style="font-weight: 500; margin-left: 1rem">
                <label for="grading">Road Rules</label>
                <input
                  style="width: 4rem"
                  name="grading"
                  type="text"
                  class="text-box placeholder-text"
                  placeholder="Pass"
                  value="P"
                />
              </span>
              <span
                class=""
                style="font-weight: 500; margin-left: 1rem"
              >
                <label for="signs">Road Signs</label>
                <input
                  style="width: 4rem"
                  name="signs"
                  type="text"
                  class="text-box placeholder-text"
                  placeholder="Pass"
                  value="P"
                />
              </span>
            </p>
          </label>
        </div>
        <!-- 4 -->
        <div
          class="flex"
          style="align-items: flex-start"
        >
          <input
            type="checkbox"
            name="visex"
            id="visex"
          />
          <label
            for="visex"
            class=""
          >
            Has taken vision exam:
            <span>
              Vision uncorrected:
              <span style="margin-right: 0.5rem"
                >20/<input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                />R</span
              >
              <span style="margin-right: 0.5rem"
                >20/<input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                />L</span
              >
              <span
                >20/<input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                />B</span
              >
            </span>
            <span style="margin-left: 1rem">
              Vision corrected:
              <span>
                <span style="margin-right: 0.5rem"
                  >20/<input
                    class="text-box"
                    style="width: 2rem"
                    type="text"
                  />R</span
                >
                <span style="margin-right: 0.5rem"
                  >20/<input
                    class="text-box"
                    style="width: 2rem"
                    type="text"
                  />L</span
                >
                <span
                  >20/<input
                    class="text-box"
                    style="width: 2rem"
                    type="text"
                  />B</span
                >
              </span>
            </span>
          </label>
        </div>
        <!-- 5 -->
        <div class="flex">
          <input
            type="checkbox"
            name="mcc"
            id="mcc"
          />
          <label
            for="mcc"
            class=""
            >Must tale Class C-Road Rules and Class C-Road Signs exam,inations
            at the Department of Public Safety</label
          >
        </div>
        <!-- 6 -->
        <div class="flex">
          <input
            type="checkbox"
            name="mve"
            id="mve"
            checked
          />
          <label
            for="mve"
            class="capitalize"
            >Must take vision examinations at the Department of Public
            Safety</label
          >
        </div>
      </section>

      <!-- divider -->
      <div class="divider"></div>
      <!-- names and such -->
      <section class="px py">
        <!-- upper part -->
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
                placeholder="<?php echo $userLastName; ?>"
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
                placeholder="<?php echo $userFirstName; ?>"
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
                  id="day"
                  value="<?php echo $day; ?>"
                   /></span
              >/
              <span
                ><input
                  class="text-box"
                  style="width: 3rem"
                  type="text"
                  name="year"
                  placeholder="YYYY"
                  id="year"
                  value="<?php echo $year; ?>"
                   /></span
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
        <!-- hereby.... -->
        <p
          class="py"
          style="
            font-weight: 600;
            font-style: italic;
            font-size: 15px;
            text-align: justify;
          "
        >
          I hereby certify that the person indicated has completed and passed
          both the classroom and the laboratory phase of a driver education
          course approved by the Texas Department of Licensing and Regulation.
        </p>
      </section>
      <!-- somany boxess -->
      <section class="px py grid-box">
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
              >Signature of Licensed Driver Education Instructor</label
            >
          </div>
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
              for="signtcso"
              style="font-size: 12px"
              >Signature (or Signature Stamp) of Chief School Officialr</label
            >
          </div>
        </div>
        <!-- 2 -->
        <div
          class="flex"
          style="flex-direction: column; align-items: flex-start; row-gap: 3rem"

        >
          <div
            class="flex fit"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="tldrnum"
              style="width: max-content; width: 18.2rem"
              placeholder="Number"
              value="8260"
            />
            <label
              for="tldr"
              style="font-size: 12px"
              >TDLR Number</label
            >
          </div>
          <div
            class="flex fit"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="desn"
              style="width: max-content; width: 18.2rem"
              placeholder="Number"
              value="C2759"
            />
            <label
              for="desn"
              style="font-size: 12px"
              >Driver Eductaion School Number</label
            >
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
              name="nos"
              style="width: max-content; width: 18.2rem"
              placeholder="Name"
              value="Drive Safe Driving School"
            />
            <label
              for="nos"
              style="font-size: 12px"
              >Name of School</label
            >
          </div>
          <div
            class="flex fit"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="disd"
              style="width: max-content; width: 18.2rem"
              placeholder="Date"
              value="<?php echo date("m/d/Y"); ?>"
            />
            <label
              for="disd"
              style="font-size: 12px"
              >Date Issued</label
            >
          </div>
        </div>
      </section>
      <h3
        class="px py capitalize"
        style="font-weight: 400"
      >
        customer service phone number :
      </h3>
      <!-- warning -->
      <section class="px py bg-black">
        <h2
          class="text-white"
          style="text-align: justify"
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
        </h2>
      </section>
      <!-- end of form 1 -->
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
          style="margin-right: 4rem"
        >
          UNLAWFUL IF REPRODUCED OR ALTERNATED
        </h1>
        <p
          class="fit"
          style="font-size: 12px; font-style: unset"
        >
          ADEE-1317(9-1-15)
        </p>
      </section>
    </main>

    <!-- bottom form -->
    <main class="border max-w fit mx-auto mt form-1-bg">
      <header class="grid-box px py">
        <div class="text-bottom w-max items-end">
          <h4 class="uppercase">Student copy</h4>
        </div>
        <div class="flex-box-2 text-center">
          <h1 class="uppercase pb">Texas adult driver education certificate</h1>
          <p>(Type or print legibly in blank ink)</p>
        </div>
        <div class="fit">
          <h4 class="uppercase pl">control no.</h4>
          <h3 class="uppercase">adee</h3>
        </div>
      </header>
      <!-- after top -->
      <section class="bg-black">
        <h2 class="uppercase text-white text-center py">
          Driver education course exclusively for adults
        </h2>
      </section>
      <!-- checkboxes -->
      <section class="grid-box-2 px py">
        <!-- 1 -->
        <div class="flex">
          <input
            type="checkbox"
            name="des"
            id="des"
            checked
          />
          <label
            for="des"
            class="capitalize"
            >Driver Education School</label
          >
        </div>
        <!-- 2 -->
        <div class="flex">
          <input
            type="checkbox"
            name="pps"
            id="pps"
          />
          <label
            for="pps"
            class="capitalize"
            >parochial/private school</label
          >
        </div>
        <!-- 3 -->
        <div class="flex">
          <input
            type="checkbox"
            name="docpt"
            id="docpt"
          />
          <label
            for="docpt"
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
            name="ps"
            id="ps"
          />
          <label
            for="ps"
            class="capitalize"
            >Public school</label
          >
        </div>
        <!-- 5 -->
        <div class="flex">
          <input
            type="checkbox"
            name="escc"
            id="escc"
          />
          <label
            for="escc"
            class="capitalize"
            >education service center</label
          >
        </div>
        <!-- 6 -->
        <div class="flex">
          <input
            type="checkbox"
            name="cuor"
            id="cuor"
          />
          <label
            for="cuor"
            class="capitalize"
            >College/University</label
          >
        </div>
      </section>

      <!-- divider -->
      <div class="divider"></div>

      <!-- another checkbox section -->
      <section
        class="px py"
        style="display: flex; flex-wrap: wrap; gap: 0.5rem"
      >
        <div class="flex">
          <input
            type="checkbox"
            name="hcc"
            id="hcc"
            checked
          />
          <label
            for="hcc"
            class="flex"
            >6 hours classroom course (Completion:
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="month"
                id="month"
                placeholder="MM"
                value="<?php echo date("m");?>"
              /> </span
            >/
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="day"
                placeholder="DD"
                value="<?php echo date("d");?>"
                id="day" /></span
            >/
            <span
              ><input
                class="text-box"
                style="width: 3rem"
                type="text"
                name="year"
                placeholder="YYYY"
                value="<?php echo date("y");?>"
                id="year" /></span
            >)</label
          >
        </div>
        <!-- 2 -->
        <div class="flex">
          <input
            type="checkbox"
            name="hoc"
            id="hoc"
          />
          <label
            for="hoc"
            class="flex"
            >6 hours online course (Completion:
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="month"
                id="month"
                placeholder="MM"
              /> </span
            >/
            <span
              ><input
                class="text-box"
                style="width: 2rem"
                type="text"
                name="day"
                placeholder="DD"
                id="day" /></span
            >/
            <span
              ><input
                class="text-box"
                style="width: 3rem"
                type="text"
                name="year"
                placeholder="YYYY"
                id="year" /></span
            >)</label
          >
        </div>
        <!-- 3 -->
        <div
          class="flex"
          style="align-items: flex-start"
        >
          <input
            type="checkbox"
            name="crr"
            id="crr"
            checked
          />
          <label
            for="crr"
            class=""
            >Has taken and passed Class C-Road Rules and Class C-Road Signs
            examinaton
            <p style="font-weight: bold">
              Please indicate Grade with a "P" for pass or numeric grade:
              <span style="font-weight: 500; margin-left: 1rem">
                <label for="grading">Road Rules</label>
                <input
                  style="width: 4rem"
                  name="grading"
                  type="text"
                  class="text-box placeholder-text"
                  placeholder="P"
                  value="P"
                />
              </span>
              <span
                class=""
                style="font-weight: 500; margin-left: 1rem"
              >
                <label for="signs">Road Signs</label>
                <input
                  style="width: 4rem"
                  name="signs"
                  type="text"
                  class="text-box placeholder-text"
                  placeholder="P"
                  value="P"
                />
              </span>
            </p>
          </label>
        </div>
        <!-- 4 -->
        <div
          class="flex"
          style="align-items: flex-start"
        >
          <input
            type="checkbox"
            name="visex"
            id="visex"
          />
          <label
            for="visex"
            class=""
          >
            Has taken vision exam:
            <span>
              Vision uncorrected:
              <span style="margin-right: 0.5rem"
                >20/<input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                />R</span
              >
              <span style="margin-right: 0.5rem"
                >20/<input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                />L</span
              >
              <span
                >20/<input
                  class="text-box"
                  style="width: 2rem"
                  type="text"
                />B</span
              >
            </span>
            <span style="margin-left: 1rem">
              Vision corrected:
              <span>
                <span style="margin-right: 0.5rem"
                  >20/<input
                    class="text-box"
                    style="width: 2rem"
                    type="text"
                  />R</span
                >
                <span style="margin-right: 0.5rem"
                  >20/<input
                    class="text-box"
                    style="width: 2rem"
                    type="text"
                  />L</span
                >
                <span
                  >20/<input
                    class="text-box"
                    style="width: 2rem"
                    type="text"
                  />B</span
                >
              </span>
            </span>
          </label>
        </div>
        <!-- 5 -->
        <div class="flex">
          <input
            type="checkbox"
            name="mcc"
            id="mcc"
          />
          <label
            for="mcc"
            class=""
            >Must tale Class C-Road Rules and Class C-Road Signs exam,inations
            at the Department of Public Safety</label
          >
        </div>
        <!-- 6 -->
        <div class="flex">
          <input
            type="checkbox"
            name="mve"
            id="mve"
            checked
          />
          <label
            for="mve"
            class="capitalize"
            >Must take vision examinations at the Department of Public
            Safety</label
          >
        </div>
      </section>

      <!-- divider -->
      <div class="divider"></div>
      <!-- names and such -->
      <section class="px py">
        <!-- upper part -->
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
            <label for="nm">Name:</label>
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
                name="nm"
                id="nm"
                placeholder="last name"
                value="<?php echo $userLastName; ?>"
              />
              <span>Last</span>
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
                name="nm"
                id="nm"
                placeholder="first name"
                value="<?php echo $userFirstName; ?>"
              />
              <span>First</span>
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
                name="nm"
                id="nm"
                placeholder="middle name"
              />
              <span>Middle</span>
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
        <p
          class="py"
          style="
            font-weight: 600;
            font-style: italic;
            font-size: 15px;
            text-align: justify;
          "
        >
          I hereby certify that the person indicated has completed and passed
          both the classroom and the laboratory phase of a driver education
          course approved by the Texas Department of Licensing and Regulation.
        </p>
      </section>
      <section class="px py grid-box">
        <!-- 1 -->
        <div
          class="flex"
          style="
            flex-direction: column;
            align-items: flex-start;
            row-gap: 0.5rem;
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
              >Signature of Licensed Driver Education Instructor</label
            >
          </div>
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
              for="signtcso"
              style="font-size: 12px"
              >Signature (or Signature Stamp) of Chief School Officialr</label
            >
          </div>
        </div>
        <!-- 2 -->
        <div
           class="flex"
          style="flex-direction: column; align-items: flex-start; row-gap: 3rem"

        >
          <div
            class="flex fit"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="tldrnum"
              style="width: max-content; width: 18.2rem"
              placeholder="Number"
              value="8260"
            />
            <label
              for="tldr"
              style="font-size: 12px"
              >TDLR Number</label
            >
          </div>
          <div
            class="flex fit"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="desn"
              style="width: max-content; width: 18.2rem"
              placeholder="Number"
              value="C2759"
            />
            <label
              for="desn"
              style="font-size: 12px"
              >Driver Eductaion School Number</label
            >
          </div>
        </div>
        <!-- 3 -->
        <div
          class="flex"
          style="
            flex-direction: column;
            align-items: flex-start;
            row-gap: 0.5rem;
          "
        >
          <div
            class="flex fit"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="nos"
              style="width: max-content; width: 18.2rem"
              placeholder="Name"
              value="Drive Safe Driving School"
            />
            <label
              for="nos"
              style="font-size: 12px"
              >Name of School</label
            >
          </div>
          <div
            class="flex fit"
            style="flex-direction: column; align-items: flex-start"
          >
            <input
              class="text-box"
              type="text"
              name="disd"
              style="width: max-content; width: 18.2rem"
              placeholder="Date"
              value="<?php echo date("m/d/Y"); ?>"
            />
            <label
              for="disd"
              style="font-size: 12px"
              >Date Issued</label
            >
          </div>
        </div>
      </section>
      <h3
        class="px py capitalize"
        style="font-weight: 400"
      >
        customer service phone number :
      </h3>
      <section class="px py bg-black">
        <h2
          class="text-white"
          style="text-align: justify"
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
        </h2>
      </section>
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
          style="margin-right: 4rem"
        >
          UNLAWFUL IF REPRODUCED OR ALTERNATED
        </h1>
        <p
          class="fit"
          style="font-size: 12px; font-style: unset"
        >
          ADEE-1317(9-1-15)
        </p>
      </section>
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