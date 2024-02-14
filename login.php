<?php
require_once 'manager/prepared/prepared.php';

if (isset($_POST['submit'])) {
    $username = CHECK_INPUT(SANITIZE($_POST['username']));
    $tmpPassword = CHECK_INPUT(SANITIZE($_POST['password']));

    // Query
    $result = EXECUTE_QUERY(SELECT_WHERE("users", 'username', $username));
    if ($result) {
        foreach ($result as $row) {
            extract($row);
    
            if (DECRYPT($password, $tmpPassword) === true) {
                SET_SESSION('user', $user_id);
    
                if ($_GET['origin'] === 'r') {
                    $slug = $_GET['post'];
                    REDIRECT("read?post=$slug");
                } else {
                    REDIRECT('index');
                }
            } else {
                echo "<script>alert('Invalid credentials!')</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid credentials!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZatTV, Your Premier Destination for TV Enthusiasts! Dive into a world of captivating television with our blog. Explore show reviews, behind-the-scenes exclusives, breaking news, and binge-worthy recommendations. Immerse yourself in the ultimate hub for all things TV – ZatTV, where the best in television entertainment comes to life!">
    <meta name="keywords" content="ZatTV, ZatTv Reviews, Television Entertainment, Behind-the-Scenes Insights, Show Recommendations, Binge-Worthy Series, TV Enthusiasts, Breaking Industry News, Must-Watch Shows, Latest TV Trends, Exclusive TV Content, Television Blog, TV Discussions, On-Screen Entertainment, TV Insights, ZatTV Updates">
    <meta name="author" content="ZatTV">
    <link rel="canonical" href="https://www.zattv.com">
    <meta property="og:title" content="ZatTV - Your Ultimate TV Entertainment Hub">
    <meta property="og:description" content="ZatTV, Your Premier Destination for TV Enthusiasts! Dive into a world of captivating television with our blog. Explore show reviews, behind-the-scenes exclusives, breaking news, and binge-worthy recommendations. Immerse yourself in the ultimate hub for all things TV – ZatTV, where the best in television entertainment comes to life!">
    <meta property="og:image" content="URL_TO_YOUR_BLOG_IMAGE">
    <meta property="og:url" content="https://www.zattv.com">
    <meta property="og:type" content="website">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ZatTV - Your Ultimate TV Entertainment Hub">
    <meta name="twitter:description" content="ZatTV, Your Premier Destination for TV Enthusiasts! Dive into a world of captivating television with our blog. Explore show reviews, behind-the-scenes exclusives, breaking news, and binge-worthy recommendations. Immerse yourself in the ultimate hub for all things TV – ZatTV, where the best in television entertainment comes to life!">
    <meta name="twitter:image" content="URL_TO_YOUR_BLOG_IMAGE">

    <!-- Tailwind & Daisy Ui -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Aos -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/images/logo.jpeg" type="image/x-icon">
    <title>Zattv - Login</title>
</head>

<body class="bg-[#f2f2f2]">

    <main class="w-full px-10 lg:px-44 h-screen flex justify-center items-center">
        <form action="" method="post" class="lg:w-[40rem] bg-[#191919] p-10 shadow-lg rounded-lg">
            <a href="./" class="flex items-center gap-4 mb-10">
                <div class="logo w-20 h-20 flex overflow bg-[url('assets/images/logo.jpeg')] bg-cover bg-center rounded-full shadow-lg ring-1 ring-white"></div>
                <h2 class="text-xl font-bold text-white mt-2 uppercase">User Login</h2>
            </a>

            <input type="text" required name="username" placeholder="Enter username" class="p-3 w-full rounded-lg text-white mb-4 bg-[#141414] ring-1 ring-gray-700">
            <input type="password" required name="password" placeholder="Enter password" class="p-3 w-full rounded-lg text-white mb-4 bg-[#141414] ring-1 ring-gray-700">

            <button class="btn btn-neutral mt-3" type="submit" name="submit">Sign In</button>
            <p class="divider"></p>
            <div class="comments flex flex-col">
                <a href="signup" class="link btn bg-yellow-300 text-slate-800">Create account</a>
            </div>
        </form>
    </main>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Custom Js -->
    <script src="js/script.js"></script>

    <!-- Aos Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>