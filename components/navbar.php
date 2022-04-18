<?php 

function picture($profileImage = null) {


  if (!isset($profileImage) && !file_exists('/assets/uploads/'.$profileImage)) {
    $fullName = $_SESSION['user_name'];
    $fullName = explode(" ", $fullName);
    $firstLetter = strtoupper($fullName[0][0]);
    $lastLetter = strtoupper( $fullName[1][0]);
      return "<span class='select-none text-white font-bold'>$firstLetter $lastLetter</span>";
  } else {
    return "<img class='h-8 w-8 rounded-full' src='/contactManager/assets/uploads/$profileImage' alt='profile image'>";
  }
}

?>


<nav class="bg-purple-800 w-full px-3">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
        <div class="logo overflow-hidden w-28">
          <a href="/contactManager/index.php">
            <img src="/contactManager/assets/images/logo.png" alt="logo" class="w-28">
          </a>
        </div>

        <!-- Profile dropdown -->
        <div class="ml-3 relative z-10">
          <div>
            <button type="button" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="sr-only">Open user menu</span>
              <div class="w-8 h-8 rounded-full flex justify-center items-center">
              <?php
                echo picture($profileImage);
              ?>
              </div>
            </button>
          </div>

          <div class="transition-all duration-150 origin-top-right scale-0 absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-0 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <!-- Active: "bg-gray-100", Not Active: "" -->
            <a href="/contactManager/profile/index.php" class="px-4 py-2 text-sm text-gray-700 flex space-x-4 items-center" role="menuitem" tabindex="-1" id="user-menu-item-0"><i class="fa-solid fa-user"></i> <span>Profile</span></a>
            <a href="/contactManager/settings.index.php" class="px-4 py-2 text-sm text-gray-700 flex space-x-4 items-center" role="menuitem" tabindex="-1" id="user-menu-item-1"><i class="fa-solid fa-sliders"></i> <span>Settings</span></a>
            <a href="/contactManager/logout/index.php" class="px-4 py-2 text-sm text-gray-700 flex space-x-4 items-center" role="menuitem" tabindex="-1" id="user-menu-item-2"><i class="fa-solid fa-arrow-right-from-bracket"></i> <span>Sign out</span></a>
          </div>
        </div>
    </div>
  </div>


</nav>