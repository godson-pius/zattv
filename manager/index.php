<?php
require_once 'prepared/prepared.php';
ACCESS_USING_SESSION('admin', 'login');

if ($_GET['category']) {
    $cat = $_GET['category'];
    $allPosts = EXECUTE_QUERY(SELECT_WHERE('posts', 'category', $cat));
} else {
    $allPosts = EXECUTE_QUERY(SELECT_ALL('posts', 'id'));
}

// DELETE POST
if (isset($_POST['deletepost'])) {
    $id = $_POST['postId'];

    $sql = "DELETE  FROM posts WHERE id = $id";
    $result = VALIDATE_QUERY($sql);

    if ($result === true) {
        echo "<script>alert('Post deleted!')</script>";
        if ($_GET['category']) {
            $cat = $_GET['category'];
            $allPosts = EXECUTE_QUERY(SELECT_WHERE('posts', 'category', $cat));
        } else {
            $allPosts = EXECUTE_QUERY(SELECT_ALL('posts', 'id'));
        }
    } else {
        echo "<script>alert('Failed to delete post!')</script>";
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
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin Zattv</title>
</head>

<body class="bg-[#141414]">

    <main>
        <!-- Menu -->
        <?php require_once 'includes/header.php'; ?>

        <!-- MAIN POSTS CONTAINER -->
        <section class="w-full flex-col md:flex-row py-10 px-10 lg:px-28">
            <!-- Categories -->
            <div class="links w-full flex items-center gap-4 overflow-x-auto no-scrollbar">
                <a href="index" class="btn px-16 ring-1 ring-gray-800 text-white text-sm <?php if (!$cat) : echo 'bg-yellow-500'; endif; ?>">All</a>
                <a href="index?category=Technology" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Technology') : echo 'bg-yellow-500'; endif; ?>">Technology</a>
                <a href="index?category=Education" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Education') : echo 'bg-yellow-500'; endif; ?>">Education</a>
                <a href="index?category=Lifestyle" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Lifestyle') : echo 'bg-yellow-500'; endif; ?>">Lifestyle</a>
                <a href="index?category=Politics" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Politics') : echo 'bg-yellow-500'; endif; ?>">Politics</a>
                <a href="index?category=Fashion" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Fashion') : echo 'bg-yellow-500'; endif; ?>">Fashion</a>
                <a href="index?category=Inspiration" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Inspiration') : echo 'bg-yellow-500'; endif; ?>">Inspiration</a>
                <a href="index?category=Entertainment" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Entertainment') : echo 'bg-yellow-500'; endif; ?>">Entertainment</a>
                <a href="index?category=Religion" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Religion') : echo 'bg-yellow-500'; endif; ?>">Religion</a>
                <a href="index?category=Health" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Health') : echo 'bg-yellow-500'; endif; ?>">Health</a>
                <a href="index?category=Sports" class="btn bg-[#141414] px-16 ring-1 ring-gray-800 text-gray-500 text-sm <?php if ($cat === 'Sports') : echo 'bg-yellow-500'; endif; ?>">Sports</a>
            </div>

            <!-- DIVIDER -->
            <p class="divider"></p>

            <!-- POSTS -->
            <div class="flex flex-col divide-y divide-gray-800 gap-5 py-10">

                <?php
                if ($allPosts) {
                    foreach ($allPosts as $post) {
                        extract($post);
                        $numOfLikes = GET_TOTAL_WHERE("likes", 'post_id', $id);
                        $numOfComments = GET_TOTAL_WHERE("comments", 'post_id', $id); ?>

                        <!-- Single Post -->
                        <div class="post flex flex-col md:flex-row items-start gap-6 md:gap-16 mt-4 md:mt-10 pt-6 md:pt-10" data-aos="zoom-in-up" data-aos-duration="1500" data-aos-once="false">
                            <div class="author w-96 flex gap-3 items-center">
                                <div class="image w-12 h-12 bg-cover bg-center shadow-lg rounded-full bg-[url('../assets/images/logo.jpeg')]">
                                </div>

                                <div>
                                    <h1 class="font-bold text-white text-sm">Zat Admin</h1>
                                    <p class="text-xs text-gray-500"><?= $category; ?></p>
                                </div>
                            </div>

                            <article class="w-full">
                                <p class="text-sm font-bold text-gray-500"><?= HUMAN_DATE($created_at); ?></p>
                                <h1 class="text-white font-bold text-lg mt-5"><?= $title; ?></h1>
                                <p class="text-gray-500"><?= $content; ?></p>

                                <!-- Like post & Read more -->
                                <div class="flex items-center justify-between mt-7">
                                    <div class="like flex gap-2 items-center">
                                        <div class="love flex items-center bg-[#191919] px-3 py-2 rounded-full gap-1">
                                            <ion-icon class="text-red-500" name="heart"></ion-icon>
                                            <p class="text-xs font-bold text-gray-500"><?= $numOfLikes; ?></p>
                                        </div>

                                        <a href="../read?post=<?= $slug; ?>" class="love flex items-center bg-[#191919] px-3 py-2 rounded-full gap-1">
                                            <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                            <p class="text-xs font-bold text-gray-500"><?= $numOfComments; ?></p>
                                        </a>

                                        <div class="love flex items-center bg-[#191919] px-3 py-2 rounded-full gap-1">
                                            <ion-icon name="share-social-outline"></ion-icon>
                                            <p class="text-xs font-bold text-gray-500">14k</p>
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <!-- read more -->
                                        <a href="edit?id=<?= $id; ?>" class="love flex bg-blue-500 text-white btn btn-sm ring-1 ring-gray-800 text-xs rounded-lg text-gray-500">
                                            Edit post
                                            <ion-icon class="-rotate-45 text-[#ffd119]" name="arrow-forward"></ion-icon>
                                        </a>
                                        <!-- delete post -->
                                        <form action="" method="post">
                                            <input type="hidden" name="postId" value="<?= $id; ?>">
                                            <button name="deletepost" type="submit" class="love flex bg-[#191919] btn btn-sm ring-1 ring-gray-800 text-xs rounded-lg text-gray-500 hover:bg-yellow-500 hover:text-slate-900">
                                                Delete post
                                                <ion-icon class="-rotate-45 text-red-600" name=""></ion-icon>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        </div>

                <?php }
                } else { echo "No posts yet!"; } ?>
            </div>

        </section>
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
</body>

</html>