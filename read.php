<?php
require_once 'manager/prepared/prepared.php';

$recentPost = EXECUTE_QUERY(SELECT_ALL_LIMIT("posts", 'id', 0, 1));
$user_id = $_SESSION['user'];

if (isset($_GET['post'])) {
    $slug = $_GET['post'];

    $result = EXECUTE_QUERY(SELECT_WHERE('posts', 'slug', $slug));
    foreach ($result as $post) {
        extract($post);

        $numOfLikes = GET_TOTAL_WHERE("likes", 'post_id', $id);
        $numOfComments = GET_TOTAL_WHERE("comments", 'post_id', $id);
        $allComments = EXECUTE_QUERY(SELECT_WHERE("comments", "post_id", $id));
    }
}

// POST COMMENT
if (isset($_POST['submit'])) {
    $comment = CHECK_INPUT(SANITIZE($_POST['comment']));

    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES ($id, $user_id, '$comment')";
    $result = VALIDATE_QUERY($sql);

    if ($result === true) {
        echo "<script>alert('Comment Added!')</script>";
        $allComments = EXECUTE_QUERY(SELECT_WHERE("comments", "post_id", $id));
        $numOfLikes = GET_TOTAL_WHERE("likes", 'post_id', $id);
        $numOfComments = GET_TOTAL_WHERE("comments", 'post_id', $id);
    } else {
        echo "<script>alert('Failed to add comment!')</script>";
    }
}

// LIKE POST
if (isset($_POST['likepost'])) {
    if (CHECK_MULTIPLE_DUPLICATE("likes", 'post_id', $id, 'user_id', $user_id) === true) {
        echo "<script>alert('Cannot like post twice!')</script>";
    } else {
        $sql = "INSERT INTO likes (post_id, user_id) VALUES ($id, $user_id)";
        $result = VALIDATE_QUERY($sql);

        if ($result === true) {
            $allComments = EXECUTE_QUERY(SELECT_WHERE("comments", "post_id", $id));
            $numOfLikes = GET_TOTAL_WHERE("likes", 'post_id', $id);
            $numOfComments = GET_TOTAL_WHERE("comments", 'post_id', $id);
        } else {
            echo "<script>alert('Failed to like post!')</script>";
        }
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
    <meta property="og:image" content="assets/images/logo.jpeg">
    <meta property="og:url" content="https://www.zattv.com">
    <meta property="og:type" content="website">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ZatTV - Your Ultimate TV Entertainment Hub">
    <meta name="twitter:description" content="ZatTV, Your Premier Destination for TV Enthusiasts! Dive into a world of captivating television with our blog. Explore show reviews, behind-the-scenes exclusives, breaking news, and binge-worthy recommendations. Immerse yourself in the ultimate hub for all things TV – ZatTV, where the best in television entertainment comes to life!">
    <meta name="twitter:image" content="assets/images/logo.jpeg">

    <!-- Tailwind & Daisy Ui -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Aos -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


    <title>Zattv - Read Post</title>
</head>

<body class="bg-[#141414]">
    <main>
        <!-- HEADER SECTION -->
        <?php require_once 'incs/header.php'; ?>

        <!-- HERO SECTION -->
        <section class="w-full hero flex flex-col items-start py-16 md:py-44 px-10 lg:px-28 bg-[url('./assets/images/hero2.jpg')] bg-cover bg-center">
            <h1 class="text-4xl lg:text-6xl text-white font-bold" data-aos="fade-right" id="headline"><?= $title; ?></h1>
            <p class="text-gray-500 mt-3"><?= $content; ?></p>
        </section>

        <!-- DIVIDER -->
        <!-- <p class="divider"></p> -->

        <!-- RECENT POSTS -->
        <section class="w-full flex flex-col">
            <div class="w-full flex flex-col md:flex-row py-16 lg:py-32 px-10 lg:px-28 items-start gap-3 md:gap-12">
                <div class="w-96 h-72 flex overflow bg-[url('https://images.unsplash.com/photo-1466611653911-95081537e5b7?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGNsaW1hdGV8ZW58MHx8MHx8fDA%3D')] bg-cover bg-center rounded-lg shadow-lg">
                </div>


                <div class="w-full content mt-6">
                    <h1 class="text-2xl font-bold text-white"><?= $title; ?></h1>
                    <p class="mt-5 text-gray-500"><?= $content; ?></p>

                    <div class="details w-full flex mt-10 text-sm gap-10">
                        <div class="flex flex-col">
                            <h4 class="text-gray-500">Category</h4>
                            <p class="text-white font-bold"><?= $category; ?></p>
                        </div>

                        <div class="flex flex-col">
                            <h4 class="text-gray-500">Publication Date</h4>
                            <p class="text-white font-bold"><?= HUMAN_DATE($created_at); ?></p>
                        </div>

                        <div class="flex flex-col">
                            <h4 class="text-gray-500">Author</h4>
                            <p class="text-white font-bold">ZatTv Admin</p>
                        </div>
                    </div>

                    <!-- Like post & Read more -->
                    <div class="flex items-center justify-between mt-7">
                        <div class="like flex gap-2 items-center">
                            <form action="" method="post">
                                <button type="submit" name="likepost" class="love flex items-center bg-[#191919] px-3 py-2 rounded-full gap-1">
                                    <ion-icon name="<?php if (CHECK_MULTIPLE_DUPLICATE("likes", 'post_id', $id, 'user_id', $user_id) === true) {
                                                        echo 'heart';
                                                    } else {
                                                        echo 'heart-outline';
                                                    } ?>" class="<?php if (CHECK_MULTIPLE_DUPLICATE("likes", 'post_id', $id, 'user_id', $user_id) === true) : echo 'text-red-500';
                                                                                                                                                                                                        endif; ?>"></ion-icon>
                                    <p class="text-xs font-bold text-gray-500"><?= $numOfLikes; ?></p>
                                </button>
                            </form>

                            <div class="love flex items-center bg-[#191919] px-3 py-2 rounded-full gap-1">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                <p class="text-xs font-bold text-gray-500"><?= $numOfComments; ?></p>
                            </div>
                        </div>

                        <!-- read more -->
                        <a href="#" class="love flex bg-[#191919] text-gray-500 btn btn-sm ring-1 ring-gray-800 text-xs rounded-lg">
                            Share Post
                        </a>
                    </div>
                </div>
            </div>



            <!-- Comments -->
            <div class="w-full px-10 md:px-28 py-10 comments flex flex-col">
                <h2 class="text-3xl font-bold mb-4">Comments</h2>
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <?php
                    if ($allComments) {
                        foreach ($allComments as $comment) {
                            extract($comment); ?>
                            <div class="chat chat-start">
                                <div class="chat-image avatar">
                                    <div class="w-10 rounded-full">
                                        <img alt="Tailwind CSS chat bubble component" src="https://images.unsplash.com/photo-1567446537708-ac4aa75c9c28?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlciUyMGljb258ZW58MHx8MHx8fDA%3D" />
                                    </div>
                                </div>
                                <div class="chat-header">
                                    <time class="text-xs opacity-50 text-gray-500"><?= HUMAN_DATE_TIME($created_at); ?></time>
                                </div>
                                <div class="chat-bubble w-full"><?= $comment; ?></div>
                                <div class="chat-footer opacity-50">
                                    User
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="w-full comments flex flex-col">
                            <p class="divider"></p>
                            <h2 class="text-xl font-bold text-red-300">No comments yet!</h2>
                            <p class="text-sm text-yellow-300 animate-pulse">Be the first to comment</p>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php
            if ($_SESSION['user']) { ?>
                <div class="w-full px-10 md:px-28 comments flex flex-col">
                    <form action="" method="post" class="w-full py-5">
                        <textarea required class="w-full p-3 rounded-lg h-44 bg-transparent ring-1 ring-gray-500" name="comment" id="comment" placeholder="Write comment..."></textarea>
                        <button type="submit" name="submit" class="btn btn-neutral mt-3">Post comment</button>
                    </form>
                </div>
            <?php } else { ?>
                <div class="w-96 px-10 md:px-28 py-10 comments flex flex-col">
                    <a href="login?origin=r&post=<?= $slug; ?>" class="link btn bg-slate-900">Login to comment</a>
                </div>
            <?php } ?>
        </section>

        <!-- ADVERT -->
        <section class="w-full flex flex-col md:flex-row py-16 lg:py-32 px-10 lg:px-28 items-center bg-[#191919] justify-between">
            <div class="flex flex-col md:flex-row items-center gap-5">
                <div class="optional__image w-44 h-44 rounded-t-full md:rounded-l-full bg-[#141414] bg-[url('/assets/images/worldbrain.png')] bg-cover bg-center shadow-lg">
                </div>

                <div class="flex flex-col text-center md:text-left items-center md:items-start md:items-left">
                    <div class="bg-[#141414] p-2 px-5 text-white rounded w-max">
                        <p>Learn any programming language</p>
                    </div>
                    <h1 class="text-4xl mt-3 text-white font-bold">World Brain Technology Limited.</h1>
                </div>
            </div>

            <!-- Advert link -->
            <a href="" class="w-full md:w-max mt-10 md:mt-0 h-14 md:h-10 bg-[#141414] flex items-center px-3 py-2 gap-1 ring-1 ring-gray-800 rounded-lg justify-center md:justify-start">
                <p class="text-xs font-bold text-gray-500">View All News</p>
                <ion-icon class="-rotate-45 text-[#ffd119]" name="arrow-forward"></ion-icon>
            </a>
        </section>

        <!-- DIVIDER -->
        <p class="divider"></p>

        <!-- ADVERT -->
        <section class="w-full flex flex-col md:flex-row py-16 lg:py-32 px-10 lg:px-28 items-center bg-[#191919] justify-between">
            <div class="flex flex-col md:flex-row items-center gap-5">
                <div class="optional__image w-44 h-44 rounded-t-full md:rounded-l-full bg-[#141414] bg-[url('/assets/images/trapbite.png')] bg-cover bg-center shadow-lg" data-aos="flip-right" data-aos-duration="1500">
                </div>

                <div class="flex flex-col text-center md:text-left items-center md:items-start md:items-left">
                    <div class="bg-[#141414] p-2 px-5 text-white rounded w-max">
                        <p>Have you had a teste of trapbite's shawarma?</p>
                    </div>
                    <h1 class="text-4xl mt-3 text-white font-bold">TrapBite Got Ya!</h1>
                </div>
            </div>

            <!-- Advert link -->
            <a href="" class="w-full md:w-max mt-10 md:mt-0 h-14 md:h-10 bg-[#141414] flex items-center px-3 py-2 gap-1 ring-1 ring-gray-800 rounded-lg justify-center md:justify-start text-gray-500">
                <p class="text-xs font-bold">Order Now</p>
                <ion-icon class="-rotate-45 text-[#ffd119]" name="arrow-forward"></ion-icon>
            </a>
        </section>

        <!-- DIVIDER -->
        <p class="divider px-10 md:px-28"></p>

        <!-- FOOTER -->
        <footer class="flex flex-col md:flex-row gap-2 md:gap-0 items-center justify-between px-10 lg:px-28 pb-5 text-sm">
            <div class="flex gap-1 divide-x divide-gray-800">
                <a href="" class="p-1 text-gray-500">Terms & Conditions</a>
                <a href="" class="p-1 text-gray-500">Privacy Policy</a>
            </div>

            <!-- social media -->
            <div class="flex gap-2 divide-x divide-gray-800">
                <ion-icon class="text-white" size="small" name="logo-twitter"></ion-icon>
                <ion-icon class="text-white" size="small" name="logo-linkedin"></ion-icon>
                <ion-icon class="text-white" size="small" name="logo-whatsapp"></ion-icon>
                <ion-icon class="text-white" size="small" name="logo-facebook"></ion-icon>
            </div>

            <p class=" text-gray-500">© 2024 ZatTv. All rights reserved.</p>
        </footer>


    </main>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Custom Js -->
    <script src="./js/script.js"></script>

    <!-- Aos Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- Toastify Js -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>