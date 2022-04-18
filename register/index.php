<?php $title = 'Register'?>
<?php 
    session_start();
    include_once("../components/head.php");
    include_once('../includes/connect.php');
    include_once('../includes/user.php');

    if(isset($_SESSION['user_id'])){
        header('Location: ../index.php');
        die();
    }

    $conn = new Database();
    $conn = $conn->connect();

    // checks if the form is submited with an existing email 
    if(isset($_GET['error'])) {
        $error = "Oops, this email is already registered!";
    } else {
        unset($error);
    }

    //  checks if the form is submited
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // check if the email is already taken
        $fname = htmlspecialchars($_POST['first_name']);
        $lname = htmlspecialchars($_POST['last_name']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password = hash('sha256', $password);

        // check if user is already exist
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            header("Location: ./index.php?error=email_taken");
        } else {
            // insert the user into the database
            $user = new User($fname, $lname, $email, $password);
            $user->insert($conn);
            header('Location: ../login/index.php?success=registration_success');
        }
    }
    
    
?>

<body class="from-[#5f72be] to-purple-600 bg-gradient-to-br min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
    <header class="max-w-lg mx-auto">
        <h1 class="text-4xl font-bold text-white text-center">Create A New Account</h1>
    </header>
    <!-- alert box -->
    <?php if (isset($error)) {?>
        <div class="alert-box w-full max-w-lg mx-auto text-center mb-6">
            <div class="alert-box__content bg-red-600 text-white p-4 rounded-lg">
                <p class="mb-2">
                    <?php echo $error; ?>
                </p>
            </div>
        </div>
    <?php }?>
    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Welcome to contact Manager</h3>
            <p class="text-gray-600 pt-2">Create your account</p>
        </section>

        <section class="mt-10">
            <form class="flex flex-col" method="POST">
                <div class="mb-6 pt-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="firstName">First Name</label>
                    <input name="first_name" type="text" id="firstName" class="rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="lastName">Last Name</label>
                    <input name="last_name" type="text" id="lastName" class="rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                    <input name="email" type="email" id="email" class="rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <input name="password" type="password" id="password" class="rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" class="rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>

                <button class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Create Account</button>
            </form>
        </section>
    </main>

    <div class="max-w-lg mx-auto text-center mt-12 mb-6">
        <p class="text-white">Already have an account? <a href="../login/index.php" class="font-bold hover:underline">Login</a>.</p>
    </div>

    <footer class="max-w-lg mx-auto flex justify-center text-white">
        <a href="#" class="hover:underline">Contact</a>
        <span class="mx-3">•</span>
        <a href="#" class="hover:underline">Privacy</a>
    </footer>

    <script>
      let fname = document.getElementById('firstName')
      let lname = document.getElementById('lastName')
      let email = document.getElementById('email')
      let password = document.getElementById('password')
      let confirmPassword = document.getElementById('confirmPassword')
      let form = document.querySelector('form')
      let allInputes = document.querySelectorAll('input')

      // delete the paragraph sibling of the input when the user start typing in the input
        allInputes.forEach(input => {
            input.addEventListener('input', () => {
                if (input.nextElementSibling) {
                    input.nextElementSibling.remove()
                }
            })
        })


      function deleteMessage(sibling) {
          if(sibling.parentElement.querySelector('p')) {
            sibling.parentElement.querySelector('p').remove()
          }
      }

      form.addEventListener('submit', function(e) {
        let errorMessage = document.createElement('p')
        errorMessage.className = 'text-red-500 mt-4 text-sm'
        errorMessage.innerHTML = "<i class='fa-solid fa-circle-info'></i> "
        // validate the firstname input
        if(!/^[a-z]{3,}$/gi.test(fname.value)) {
            e.preventDefault()
            errorMessage.innerHTML += "first name must include atleast 3 characters and no symboles";
            deleteMessage(fname)
            fname.parentElement.append(errorMessage)
            scrollTo(fname);
            return;
        } else {
            deleteMessage(fname)
        }
        // validate the last name 
        if(!/^[a-z]{3,}$/gi.test(lname.value)) {
            e.preventDefault()
            errorMessage.innerHTML += " last name must include atleast 3 characters and no symboles";
            deleteMessage(lname)
            lname.parentElement.append(errorMessage);
            scrollTo(lname);
            return;
        } else {
            deleteMessage(lname)
        }
        // validate the email
        if(!/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/gi.test(email.value)) {
            e.preventDefault()
            errorMessage.innerHTML += " please enter a valid email address";
            deleteMessage(email)
            email.parentElement.append(errorMessage)
            scrolTo(email);
            return;
        } else {
            deleteMessage(email)
        }

        // validate the password 
        if(!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/gi.test(password.value)) {
            e.preventDefault()
            errorMessage.innerHTML += " Your password must have at least 8 characters, one uppercase, one lowercase, one number and one special character";
            deleteMessage(password)
            password.parentElement.append(errorMessage)
            scrollTo(password);
            return;
        } else {
            deleteMessage(password)
        }
        // check if confirm password is the same as the password
        if(password.value !== confirmPassword.value) {
            e.preventDefault()
            errorMessage.innerHTML += " Your password does not match";
            deleteMessage(confirmPassword)
            confirmPassword.parentElement.append(errorMessage)
            scrollTo(confirmPassword);
            return;
        } else {
            deleteMessage(confirmPassword)
        }
      })

    //   scroll into an element
    function scrollTo(element) {
        window.scroll({
            behavior: 'smooth',
            left: 0,
            top: element.offsetTop - 100
        })
    }

        
    </script>
</body>
</html>

