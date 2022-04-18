<?php $title = 'Sign In'?>
<?php include("../components/head.php")?>

<?php
    session_start();

    include ("../includes/connect.php");
    include ("../includes/auth.php");

    // redirect if there is a session
    if(isset($_SESSION['user_id'])){
        header('Location: ../index.php');
        die();
    }

    if(isset($_GET['success']) && $_GET['success'] == 'registration_success') {
        $success = "You have successfully registered!";
    } else {
        unset($success);
    }
    
    // check if form is submitted and do authentication
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // check if the email is already taken
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password = hash('sha256', $password);

        $conn = new Database();
        $conn = $conn->connect();
        $auth = new Auth($conn, $email, $password);
        if($auth->login()) {
            header('Location: ../index.php');
        } else {
            $error = "Wrong email or password";
        }
    }

?>

<body class="from-[#5f72be] to-purple-600 bg-gradient-to-br min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
    <header class="max-w-lg mx-auto">
        <h1 class="text-4xl font-bold text-white text-center">Login to see your contacts</h1>
    </header>
    <!-- alert box -->
    <?php if (isset($error) || isset($success)) {?>
        <div class="transition-all duration-700 alert-box w-full max-w-lg mx-auto text-center mb-6 mt-4">
            <div class="alert-box__content <?php echo $success ? "bg-green-400" : "bg-red-600"?> text-white p-4 rounded-lg">
                <p class="mb-2">
                    <?php echo isset($error) ? $error : $success; ?>
                </p>
            </div>
        </div>
    <?php }?>

    <main class="transition-all duration-300 bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Welcome to Contact Manager</h3>
            <p class="text-gray-600 pt-2">Sign in to your account.</p>
        </section>

        <section class="mt-10">
            <form class="flex flex-col" method="POST">
                <div class="mb-6 pt-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                    <input name="email" type="email" id="email" class="caret-purple-600 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <div class="flex relative">
                        <input name="password" type="password" id="password" class="caret-purple-600 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3 pr-10">
                        <i id="passwordVisibility" class="fa-solid fa-eye-slash absolute top-1/2 -translate-y-2/3 right-3 text-gray-600 cursor-pointer"></i>
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700 hover:underline mb-6">Forgot your password?</a>
                </div>
                <button class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Login</button>
            </form>
        </section>
    </main>

    <div class="max-w-lg mx-auto text-center mt-12 mb-6">
        <p class="text-white">Don't have an account? <a href="../register/index.php" class="font-bold hover:underline">Sign up</a>.</p>
    </div>

    <footer class="max-w-lg mx-auto flex justify-center text-white">
        <a href="#" class="hover:underline">Contact</a>
        <span class="mx-3">•</span>
        <a href="#" class="hover:underline">Privacy</a>
    </footer>
</body>

<script>
    // alert box
    const alertBox = document.querySelector('.alert-box');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.opacity = 0;
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 500);
        }, 3000);
    }

    // password visibility
    const passwordVisibility = document.querySelector('#passwordVisibility');
    const password = document.querySelector('#password');
    passwordVisibility.addEventListener('click', () => {
        if (password.type === 'password') {
            password.type = 'text';
            passwordVisibility.classList.remove('fa-eye-slash');
            passwordVisibility.classList.add('fa-eye');
        } else {
            password.type = 'password';
            passwordVisibility.classList.remove('fa-eye');
            passwordVisibility.classList.add('fa-eye-slash');
        }
    });
</script>
</html>

