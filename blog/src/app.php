<?php

//###Простой блог с фреймворком SILEX 
//Полезно почитать: http://habrahabr.ru/post/118011/
/*
Финальный проект: epic-blog-silex
*/

//Задаем требуемые пространство имен

use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\FormServiceProvider;

//Создаем инстанс приложения

$app = new Silex\Application();

//Пока оставляем включенный *режим отладки*

$app['debug'] = true;

//Используем шаблонизатор Twig

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

//Doctrine - для работы с базой данных
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'epic_blog',
            'user'      => 'root',
            'password'  => '****',
            'charset'   => 'utf8',
        ),
    )
);

//Нам понадобятся формы и валитдация данных
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));
//Защитим при помощи http-авторизации путь */admin*
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
));
$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'http' => true,
        'users' => array(
            // ;-) raw password is foo
            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
);

//*Роуты :-) или маршрутизация*

//Основной путь приложения - вывод перечня постов
$app->get('/', function() use ($app) {
    $sql = "SELECT * FROM posts";
    $posts = $app['db']->fetchAll($sql);
//Рендерим ответ твигом
    return $app['twig']->render('index.html.twig', [
        'posts' => $posts,
    ]);
});
//Выводим конкретный пост
$app->get('/post/{id}', function($id) use ($app) {
    $sql = "
        SELECT * 
        FROM posts p
        WHERE p.id = :id
    ";
    $post = $app['db']->fetchAssoc($sql, [
        ':id' => $id,
    ]);
//Не забываем про комменты
    $sql = "
        SELECT * 
        FROM comments c
        WHERE c.post_id = :id
    ";
    $comments = $app['db']->fetchAll($sql, [
        ':id' => $id,
    ]);

    return $app['twig']->render('post.html.twig', [
        'post' => $post,
        'comments' => $comments,
    ]);
});

//Защищенный паролем вход для добавления поста
//>Используем формочку
$app->match('/admin/add', function() use ($app) {
    $form = $app['form.factory']->createBuilder('form')
        ->add('title')
        ->add('content', 'textarea')
        ->getForm();
    

    $form->handleRequest($app['request']);

    if ($form->isValid()) {
        $data = $form->getData();

//#####А это - *домашнее задание !*        
        var_dump($data);
        // do something with the data
      //  $sql = "INSERT ...";
$sql = "
        INSERT INTO posts (title, description)
         VALUES (:title, :content)
             ";

$stmt = $app['db']->prepare($sql);
$stmt->bindValue(":title", $data['title']);
$stmt->bindValue(":content", $data['content']);
$stmt->execute();

//redirect somewhere
return $app->redirect('/blog/web');
    }
    return $app['twig']->render(
        'add.html.twig', [
            'form' => $form->createView()
        ]);
});

//Дальше понятно, но не успел...

//Эксперименты с phpDocumentor не удались - он хотел документироватьь и Сайлекс))

//*phpDocumentor* хорош для случаев, когда создается много классов и их надо визуализировать

//DOCCO - наше все ;-) http://jashkenas.github.io/docco/

$app->get('/admin/edit/{id}', function($id) use ($app) {
    return '';
});

$app->get('/admin/delete/{id}/', function($id) use ($app) {
    return '';
});

$app->get('/add-comment', function() use ($app) {
    return '';
});

$app->get('/edit-comment/{id}', function($id) use ($app) {
    return '';
});

$app->get('/delete-comment/{id}', function($id) use ($app) {
    return '';
});


return $app;