<?php
require_once 'prepared/prepared.php';
ACCESS_USING_SESSION('admin', 'login');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = EXECUTE_QUERY(SELECT_WHERE('posts', 'id', $id));
    foreach ($result as $post) {
        extract($post);
    }
}

if (isset($_POST['submit'])) {
    $title = ALLOW_SAFE_SYMBOLS(CHECK_INPUT(SANITIZE($_POST['title'])));
    $category = CHECK_INPUT(SANITIZE($_POST['category']));
    $content = ALLOW_SAFE_SYMBOLS(CHECK_INPUT(SANITIZE($_POST['content'])));
    $slug = str_replace(' ', '-', strtolower($title));

    $sql = "UPDATE posts SET title = '$title', slug = '$slug',  category = '$category', content = '$content' WHERE id = '$id'";
    $result = VALIDATE_QUERY($sql);

    if ($result === true) {
        echo "<script>alert('Post Updated!')</script>";
    } else {
        echo "<script>alert('Failed to add post!')</script>";
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
    <meta property="og:image" content="../assets/images/logo.jpeg">
    <meta property="og:url" content="https://www.zattv.com">
    <meta property="og:type" content="website">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ZatTV - Your Ultimate TV Entertainment Hub">
    <meta name="twitter:description" content="ZatTV, Your Premier Destination for TV Enthusiasts! Dive into a world of captivating television with our blog. Explore show reviews, behind-the-scenes exclusives, breaking news, and binge-worthy recommendations. Immerse yourself in the ultimate hub for all things TV – ZatTV, where the best in television entertainment comes to life!">
    <meta name="twitter:image" content="../assets/images/logo.jpeg">

    <!-- Tailwind & Daisy Ui -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Aos -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/logo.jpeg" type="image/x-icon">
    <title>Zattv - New Post</title>
</head>

<body class="bg-[#141414] h-screen">

    <main>
        <!-- Menu -->
        <?php require_once 'includes/header.php'; ?>

        <h2 class="ml-10 md:ml-28 py-10 text-4xl font-bold text-white">Edit Post</h2>
        <!-- POST FORM -->
        <form action="" class="w-full px-10 md:px-28 bg-[#191919] p-10" method="post">
            <input type="text" name="title" placeholder="Enter title" class="p-3 w-full rounded-lg text-white mb-6 bg-[#141414] border-2" value="<?= $title; ?>">

            <select name="category" class="p-3 w-full rounded-lg text-white bg-[#141414] border-2 mb-1">
                <option value="" disabled>Select category</option>
                <option value="Technology">Technology</option>
                <option value="Education">Education</option>
                <option value="Lifestyle">Lifestyle</option>
                <option value="Fashion">Fashion</option>
                <option value="Inspiration">Inspiration</option>
                <option value="Beauty">Beauty</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Religion">Religion</option>
                <option value="News">News</option>
            </select>
            <p class="text-gray-500 mb-6 text-sm">Selected category: <?= $category; ?></p>

            <textarea name="content" class="p-3 w-full rounded-lg text-white mb-6 bg-[#141414] border-2 h-80" placeholder="Some content"><?= $content; ?></textarea>

            <button class="btn btn-neutral mt-1" name="submit" type="submit">Update post</button>
        </form>

    </main>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Custom Js -->
    <script src="../js/script.js"></script>

    <!-- Aos Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });
    </script>
</body>

</html>