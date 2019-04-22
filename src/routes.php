<?php
///to pass a parameter to the url do something like this

//   $router->respond('GET','/about/{any:id}', function($id) {
//     return $this->template->render('about-us.html');
//   });

//   $router->respond('GET','/about/{int:youCanNameThisAnyThingYouWant}', function($youCanNameThisAnyThingYouWant) {
//     return $this->template->render('about-us.html');
//   });

//{any:id} this stands as a parameter to be passed via the url and the ->any<- represents any string to be passed to url e.g the url parameter can contain -,0-9,A-Za-z characters
//{int:id} this allows the url parameters to take only integers

// the the variable passed to the function can be named any thing and let it be == {any:this}; like it should be same name with what you placed in the {any:id} after the colon;

$router->respond('GET','/', function() {
    $directory = "./storage/contents/";
    $ziki = new Ziki\Core\Document($directory);
    $post = $ziki->get();
    // Render our view
    echo "index page";
    return $this->template->render('index.html', ['posts' => $post] );
});

$router->respond('GET','/blog-details', function() {
    $ziki = [
        [ 'name'          => 'Adroit' ],
        [ 'name'          => 'Olu' ],
        [ 'name'          => 'Amuwo' ],
    ];
    echo "blog the details";
    return $this->template->render('blog-details.html', ['ziki' => $ziki] );
});

// $router->get('/', function($request) {
//     $directory = "./storage/contents/";
//     $ziki = new Ziki\Core\Document($directory);
//     $post = $ziki->get();
//     // Render our view
//     return $this->template->render('index.html', ['posts' => $post] );
// });

// $router->get('/blog-details', function($request) {
//     $ziki = [
//         [ 'name'          => 'Adroit' ],
//         [ 'name'          => 'Olu' ],
//         [ 'name'          => 'Amuwo' ],
//     ];
//     return $this->template->render('blog-details.html', ['ziki' => $ziki] );
// });

// $router->get('/timeline', function($request) {
//     $directory = "./storage/contents/";
//     $ziki = new Ziki\Core\Document($directory);
//     $post = $ziki->get();
//     return $this->template->render('timeline.html', ['posts' => $post] );
// });

// $router->post('/timeline', function($request) {
//     $directory = "./storage/contents/";
//     $body = $_POST['postVal'];
//     var_dump($body); die();
//     $ziki = new Ziki\Core\Document($directory);
//     $result = $ziki->create($body);
//     var_dump($result); die();
//     return $this->template->render('timeline.html', ['ziki' => $result]);
// });

// $router->get('/contact-us', function($request) {
//     $ziki = [
//         [ 'name'          => 'Adroit' ],
//         [ 'name'          => 'Twig' ],
//     ];

//     return $this->template->render('contact-us.html', ['ziki' => $ziki] );
// });

// $router->get('/published-posts', function($request) {
//     return $this->template->render('published-posts.html');
// });

// $router->get('/themes', function($request) {
//     return $this->template->render('themes.html');
// });

// $router->get('/profile', function($request) {
//     return $this->template->render('profile.html');
// });

// $router->get('/subscriptions', function($request) {
//     return $this->template->render('subscriptions.html');
// });

// $router->get('/subscribers', function($request) {
//     return $this->template->render('subscribers.html');
// });

// $router->get('/editor', function($request) {
//   return $this->template->render('editor.html');
// });

// $router->get('/404', function($request) {
//     return $this->template->render('404.html');
//   });

//   $router->get('/drafts', function($request) {
//     return $this->template->render('drafts.html');
//   });
//   $router->get('/about', function($request) {
//     return $this->template->render('about-us.html');
//   });
