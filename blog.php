<?php
$username = 'root';
$password = '*****';
try {
    $conn = new PDO('mysql:host=localhost;dbname=epic_db', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


?>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
    <div>
        <form enctype="multipart/form-data" action="" method="post">
        <div>
            <label>Slug</label><input type="text" name="slug" />
        </div>
        <div>
            <label>Title</label><input type="text" name="title" />
        </div>
        <div>
            <textarea cols="25" rows="20" name="content"></textarea>
        </div>
        <div>
            <input type="submit" value="GoGo!" />
        </div>
        </form>
    </div>

</body>
</html>
<?php
$postsString = file_get_contents('posts.txt');
if (!empty($_POST['title']) && !empty($_POST['content'])) {
    $post = ['slug' => !empty($_POST['slug']) ? $_POST['slug'] : '', 'title' => !empty($_POST['title']) ? $_POST['title'] : '', 'content' => !empty($_POST['content']) ? $_POST['content'] : '', ];
    $postsString.= implode(';', $post) . "\n\n";
    file_put_contents('posts.txt', $postsString);



$stmt = $conn->prepare('INSERT INTO hw_posts (title) VALUES(:title)');
$stmt->bindParam(':title', $title);

$title = 'Justin Bieber plus+';
$stmt->execute();

// Affected Rows?
echo $stmt->rowCount(); // 1


//    header("Location: /blog.php");
}

$sth = $conn->prepare("SELECT id, title FROM hw_posts");
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
print_r($result);

//while($row = $conn->fetch(PDO::FETCH_ASSOC))
//{
//    print_r($row);
//}

echo "string";
//$posts = explode("\n", $postsString);
//foreach ($posts as $post) {
//    if (!empty($post)) {
//        $postParts = explode(";", $post);
//        echo "<h2>" . htmlentities($postParts[1]) . "</h2>";
//        echo "<p>" . htmlentities($postParts[2]) . "</p>";
//    }
//}


?>
