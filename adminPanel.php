<?
    // Подключаем библиотку RedBeanPHP
    require_once './db/libs/rb-mysql.php';

    // Подключаемся к бд
    require_once './db/db.php';

    // Если пользователь не авторизован, редиректим его на страницу авторизации
    require_once "./db/redirect.php";

    $title = "Weekend | Admin panel";

    $show_posts = isset($_GET['posts']) ? $_GET['posts'] : false; 

    if ($_SESSION['logged_user']->id != 7) {
        header("Location: /");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Подключаем общие теги в head -->
    <?require_once './views/partials/head.php';?>
    <link rel="stylesheet" href="./css/adminPanel.css">
</head>
<body>
    <main>
        <!-- Подключаем боковое меню aside -->
        <?require_once './views/partials/aside.php';?>

        <section class="all-users">
            <h2 class="all-user__header">Admin panel</h2>

            <div class="edit">
                <?
                    if ($_GET['id']) {
                        // id пользователя, информацию к-го будем редактировать
                        $id = $_GET['id'];

                        $user = R::findOne("users", "id=?", [$id]);

                        echo "
                        <h3 class='edit__header'>Editable user</h3>
                        <div class='edit__user'>
                            <p>id user: $user[id]</p>
                            <p>User ava:<img class='edit__ava' src='$user[ava]' alt='User avatar'></p>
                            <h3 class='edit__name'>name: $user[name]</h3>
                            <h3 class='edit__name'>surname: $user[surname]</h3>
                            <p class='edit__status'>status: $user[status]</p>
                        </div>

                        <form action='./db/editUserInfo.php' method='POST'>
                            <h3>Edit user info</h3>
                            <input type='hidden' name='id' value='$id'>
                            <input type='text' name='name' value='$user[name]' placeholder='Edit name'>
                            <input type='text' name='surname' value='$user[surname]' placeholder='Edit surname'>
                            <input type='text' name='status' value='$user[status]' placeholder='Edit status'>
                            <input type='text' name='ava' value='$user[ava]' placeholder='Edit avatar'>
                            <button>Save</button>
                        </form>
                        ";
                    }
                ?>
            </div>

            <div class="posts">
                <?
                    if ($show_posts) {
                        $sql = "SELECT *, posts.id AS 'post_id' 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id";

                        $posts = R::getAll($sql);
    
                        echo "<h3>Posts</h3>";
                        foreach ($posts as $post) {
                            echo "
                            <transition appear name='custom-classes-transition' enter-active-class='animated bounceIn' leave-active-class='animated bounceOut'>
                            <div class='post'>
                                <a href='./Profile.php?id=$id'><img class='post__ava' src='$post[ava]' alt='Картинка'></a>
                                <div class='post__container'>
                                    <div class='post__head'>
                                        <div class='post__author-data'>
                                            <h5 class='post__author'><a href='#'>$post[name] $post[surname]</a></h5>
                                            <time class='post__data'>$post[date]</time>
                                        </div>
                        
                                        <div class='post__edit'>
                                            <div class='kebab'>
                                                <div class='circle'></div>
                                                <div class='circle'></div>
                                                <div class='circle'></div>
                                            </div>
                        
                                            <img src='./img/iconEdit.svg' alt='Редактировать'>
                                            <a href='./db/deletePost.php?id=$post[post_id]'><img src='./img/close.svg' class='close' alt='Удалить'></a>
                                        </div>
                                    </div>
    
                                    <div class='post__content'>
                                        <p>
                                            $post[text]
                                        </p>
                                    </div>
                        
                                    <hr>
                        
                                    <div class='post__actions'>
                                        <div class='likes action'>
                                            <img src='./img/heart.svg' alt='&#9825;'>
                                            <span class='count-likes'>$post[likes]</span>
                                        </div>
                        
                                        <div class='reposts action'>
                                            <img src='./img/repost.svg' alt='&#8617;'>
                                            <span class='count-reposts'>$post[reposts]</span>
                                        </div>
                        
                                        <div class='comments action'>
                                            <img src='./img/comment.svg' alt='&#9993;'>
                                            <span class='count-comments'>$post[comments]</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                            ";
                    }
                }
                ?>
            </div>

            <div class="all-users__users">
                <?
                    $users = R::findAll("users");

                    foreach ($users as $user) {
                        echo "
                        <transition appear name='custom-classes-transition' enter-active-class='animated bounceIn' leave-active-class='animated bounceOut'>
                        <div class='user__container' v-show='user'>
                            <div class='user__info'>
                                <a href='./Profile.php?id=$user[id]'>
                                    <img src='$user[ava]' alt='' class='user__ava'>
                                </a>
                                <div>
                                    <p class='user__name'>
                                        <a href='./Profile.php?id=$user[id]' class='user__link-name'>
                                            $user[name] $user[surname]
                                        </a>
                                    </p>
                
                                    <p class='user__online-status'>
                                        $user[online]
                                    </p>
                                </div>
                            </div>  
                            
                            <div class='user__actions'>
                                <a href='./adminPanel.php?id=$user[id]'>
                                    <img src='./img/iconEdit.svg' alt='Edit user info' title='Edit user info'>
                                </a>

                                <a href='./db/deleteUser.php?id=$user[id]'>
                                    <img src='./img/close.svg' alt='Delete user' title='Delete user'>
                                </a>
                            </div>
                        </div>
                        </transition>
                        ";
                    }
                ?>
            </div>
        </section>

        <section class="right-side">
            <h2>Posts</h2>

            <a href="./adminPanel.php?posts=true">View all posts</a>
        </section>
    </main>

    <script src="./js/admin.js"></script>
</body>
</html>