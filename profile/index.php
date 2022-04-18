<?php 
  $title = 'Profile';
  include("../components/head.php");
  include("../includes/connect.php");
  include("../includes/userData.php");

  session_start();

  if(!isset($_SESSION['user_id'])){
      header('Location: ../login/index.php');
      die();
  }
  // connect to data base
  $conn = new Database();
  $conn = $conn->connect();
  // get user data
  $user_id = $_SESSION['user_id'];
  $userData = new UserData($conn, $user_id);
  $userData->getData();

  $firstName = $userData->getUserFirstName();
  $lastName = $userData->getUserLastName();
  $email = $userData->getUserEmail();
  $profileImage = $userData->getUserProfileImage();
  $signupDate = $userData->getUserSignupDate();
  $contacts = $userData->getContacts();
  $contactsCount = $userData->getContactsCount();

  
  
?>
  <body>
    <header>
      <?php include "../components/navbar.php"?>
    </header>
    <main class="flex justify-center items-center pt-10">
      <section class="w-full max-w-3xl flex flex-col md:flex-row items-center md:items-start gap-28">
        <div class="text-center flex-1">
          <div class="mx-auto w-[150px] h-[150px] bg-gray-500 rounded-full flex justify-center items-center text-6xl overflow-hidden">
            <?php
              echo picture($profileImage);
            ?>
          </div>
          <h1 class="text-2xl font-bold text-gray-800">
            <?php echo $firstName . " " . $lastName; ?>
          </h1>
          <p class="text-gray-600">
            <?php echo $email; ?>
          </p>
          <button class="p-3 bg-purple-600 rounded-md mt-4 text-white">
            edit profile
          </button>
        </div>
        <div class="w-4/5 space-y-7">
          <!-- number of contacts -->
          <div class="bg-white rounded-lg shadow-lg p-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800">
              <?php echo $contactsCount ?>
            </h2>
            <p class="text-gray-600">
              Contacts
            </p>
          </div>
          <!-- signup date -->
          <div class="bg-white rounded-lg shadow-lg p-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800">
              Signup Date
            </h2>
            <p class="text-gray-600">
              <?php 
                echo $signupDate;
              ?>
            </p>
          </div>
          <!-- last login date -->
          <div class="bg-white rounded-lg shadow-lg p-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800">
              Last Login
            </h2>
            <p class="text-gray-600">
              <?php 
                echo $_SESSION['login_date'];
              ?>
            </p>
          </div>
        </div>
      </section>

      <script src="/contactManager/assets/js/toggleProfile.js"></script>
    </main>
  </body>
</html>