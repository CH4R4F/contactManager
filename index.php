<?php $title = "Home | Contacts"?>
<?php 
  session_start();
  include('./components/head.php');
  include('./includes/connect.php');
  include("./includes/userData.php");

  $conn = new Database();
  $conn = $conn->connect();
  $data = new UserData($conn, $_SESSION['user_id']);
  $data->getData();
  $profileImage = $data->getUserProfileImage();

  $contacts = $data->getContacts();
  
?>

<?php

  // redirect user if there is no session
  if(!(isset($_SESSION) && $_SESSION['user_id'])){
      header('Location: ./login/index.php');
      die();
  }

?>


<body>
  <header>
    <?php include "./components/navbar.php"?>
  </header>
  <main class="px-4 py-10 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between">
      <!-- greeting  -->
      <div>
        <button id="addContact" class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-purple-800 fixed right-5 bottom-5 flex justify-center items-center">
          <i class="fa-solid fa-plus text-white"></i>
        </button>
        <h1 class="font-semibold text-xl md:text-3xl">
          Contact List
        </h1>
        <span id="greeting"></span>, <?= " " . strtoupper($_SESSION['user_name'])?>
      </div>
      <!-- search bar -->
      <div class="pt-2 relative text-gray-600">
        <input class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-purple-600"
          type="search" name="search" placeholder="Search">
        <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
          <svg class="text-purple-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
            width="512px" height="512px">
            <path
              d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
          </svg>
        </button>
      </div>
    </div>
    <div id="contactContainer" class="mt-16 md:px-8">
      
    </div>
    <!-- contact form -->
    <div id="overlay" class="hidden fixed inset-0 bg-black/20"></div>
    <div id="contactModal" class="hidden fixed w-11/12 max-w-lg z-20 bg-white top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-10 rounded-md">
      <i id="closeModal" class="absolute top-5 right-10 text-2xl text-purple-600 fa-solid fa-times cursor-pointer"></i>
      <form method="POST" id="contactForm" class="pt-5">
        <!-- select avatar image as radio input -->
        <!--
        <div class="relative z-0 mb-6 w-full group">
          <div class="flex items-center">
            <div class="flex flex-col items-center">
              <input type="radio" name="avatar" id="avatar1" value="avatar1" class="hidden peer" checked>
              <label for="avatar1" class="w-16 h-16 m-auto peer-checked:border-2 peer-checked:border-red-500">
                <img src="./assets/images/avatar-1.png" alt="avatar1" class="w-16 h-16">
              </label>
            </div>
            <div class="flex flex-col items-center">
              <input type="radio" name="avatar" id="avatar2" value="avatar2" class="hidden peer">
              <label for="avatar2" class="w-16 h-16 m-auto peer-checked:border-4 peer-checked:border-purple-600 peer-checked:rounded-full overflow-hidden">
                <img src="./assets/images/avatar-2.png" alt="avatar2" class="w-16 h-16">
              </label>
            </div>
            <div class="flex flex-col items-center">
              <input type="radio" name="avatar" id="avatar3" value="avatar3" class="hidden peer">
              <label for="avatar3" class="w-16 h-16 m-auto peer-checked:border-4 peer-checked:border-purple-600 peer-checked:rounded-full overflow-hidden">
                <img src="./assets/images/avatar-3.png" alt="avatar3" class="w-16 h-16">
              </label>
            </div>
            <div class="flex flex-col items-center">
              <input type="radio" name="avatar" id="avatar4" value="avatar4" class="hidden peer">
              <label for="avatar4" class="w-16 h-16 m-auto peer-checked:border-4 peer-checked:border-purple-600 peer-checked:rounded-full overflow-hidden">
                <img src="./assets/images/avatar-4.png" alt="avatar4" class="w-16 h-16">
              </label>
            </div>
          </div> 
        </div>
        -->
        <div class="grid xl:grid-cols-2 xl:gap-6">
          <div class="relative z-0 mb-6 w-full group">
              <input type="text" name="fname" id="fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-purple-600 focus:outline-none focus:ring-0 peer" placeholder=" " required />
              <label for="fname" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-purple-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
          </div>
          <div class="relative z-0 mb-6 w-full group">
              <input type="text" name="lname" id="lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-purple-600 focus:outline-none focus:ring-0 peer" placeholder=" " required />
              <label for="lname" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-purple-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
          </div>
        </div>
        <div class="relative z-0 mb-6 w-full group">
            <input type="tel" name="phone" id="phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-purple-600 focus:outline-none focus:ring-0 peer" placeholder=" " required />
            <label for="phone" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-purple-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
        </div>
        <div class="relative z-0 mb-6 w-full group">
            <input type="email" id="email" name="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-purple-600 focus:outline-none focus:ring-0 peer" placeholder=" " required />
            <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-purple-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
        </div>
        <div class="relative z-0 mb-6 w-full group">
            <textarea name="address" id="address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-purple-600 focus:outline-none focus:ring-0 peer resize-none" rows="5" placeholder=" " required></textarea>
            <label for="address" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-purple-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Address</label>
        </div>
        <input type="hidden" name="mode" id="mode">
        <button name="contact" type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
      </form>
    </div>
  </main>
  <script src="/contactManager/assets/js/toggleProfile.js">
  </script>
  <script src="/contactManager/assets/js/crud.js"></script>
  <script>

    // print good morning, good afternoon, or good evening based on date
    function greeting() {
      var today = new Date();
      var hour = today.getHours();
      if (hour < 12) {
        document.getElementById("greeting").innerHTML = "Good Morning";
      } else if (hour < 18) {
        document.getElementById("greeting").innerHTML = "Good Afternoon";
      } else {
        document.getElementById("greeting").innerHTML = "Good Evening";
      }
    }

    document.addEventListener("DOMContentLoaded", greeting);

  </script>
</body>
</html>