<?php

$di = new \Phalcon\DI\FactoryDefault();

//Set up the database service
$di->set('db', function(){
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "asimov",
        "password" => "zeroth",
        "dbname" => "robotics"
    ));
});

//Create and bind the DI to the application
$app = new \Phalcon\Mvc\Micro($di);

$app->get('/', function() use ($app){

   echo "<h1>Willkommen</h1>";
});

$app->get("/affair", function() use($app){
    $affair = new stdClass();
    $affair -> titel ="Test Affair";
    $affair -> deponent = "Arthur Testbert";
    $affair -> date = new DateTime();

    echo json_encode($affair);
});

$app->get("/transcript", function() use($app){
    $string = file_get_contents("lines2.json");
    echo $string;
});

$app->get('/robots', function() use ($app) {

   /* $phql = "SELECT * FROM Robots ORDER BY name";
    $robots = $app->modelsManager->executeQuery($phql);

    $data = array();
    foreach ($robots as $robot) {
        $data[] = array(
            'id' => $robot->id,
            'name' => $robot->name,
        );
    }*/

    echo 1;
});

//Searches for robots with $name in their name
$app->get('/robots/search/{name}', function($name) use ($app) {

    $phql = "SELECT * FROM Robots WHERE name LIKE :name: ORDER BY name";
    $robots = $app->modelsManager->executeQuery($phql, array(
        'name' => '%' . $name . '%'
    ));

    $data = array();
    foreach ($robots as $robot) {
        $data[] = array(
            'id' => $robot->id,
            'name' => $robot->name,
        );
    }

    echo json_encode($data);

});

//Retrieves robots based on primary key
$app->get('/robots/{id:[0-9]+}', function($id) use ($app) {

    $phql = "SELECT * FROM Robots WHERE id = :id:";
    $robot = $app->modelsManager->executeQuery($phql, array(
        'id' => $id
    ))->getFirst();

    //Create a response
    $response = new Phalcon\Http\Response();

    if ($robot == false) {
        $response->setJsonContent(array('status' => 'NOT-FOUND'));
    } else {
        $response->setJsonContent(array(
            'status' => 'FOUND',
            'data' => array(
                'id' => $robot->id,
                'name' => $robot->name
            )
        ));
    }

    return $response;
});

//Adds a new robot
$app->post('/robots', function() use ($app) {

    $robot = $app->request->getJsonRawBody();

    $phql = "INSERT INTO Robots (name, type, year) VALUES (:name:, :type:, :year:)";

    $status = $app->modelsManager->executeQuery($phql, array(
        'name' => $robot->name,
        'type' => $robot->type,
        'year' => $robot->year
    ));

    //Create a response
    $response = new Phalcon\Http\Response();

    //Check if the insertion was successful
    if ($status->success() == true) {

        $robot->id = $status->getModel()->id;

        $response->setJsonContent(array('status' => 'OK', 'data' => $robot));

    } else {

        //Change the HTTP status
        $response->setStatusCode(500, "Internal Error");

        //Send errors to the client
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(array('status' => 'ERROR', 'messages' => $errors));
    }

    return $response;
});

//Updates robots based on primary key
$app->put('/robots/{id:[0-9]+}', function($id) use($app) {

    $robot = $app->request->getJsonRawBody();

    $phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";
    $status = $app->modelsManager->executeQuery($phql, array(
        'id' => $id,
        'name' => $robot->name,
        'type' => $robot->type,
        'year' => $robot->year
    ));

    //Create a response
    $response = new Phalcon\Http\Response();

    //Check if the insertion was successful
    if ($status->success() == true) {
        $response->setJsonContent(array('status' => 'OK'));
    } else {

        //Change the HTTP status
        $response->setStatusCode(500, "Internal Error");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(array('status' => 'ERROR', 'messages' => $errors));
    }

    return $response;
});

//Deletes robots based on primary key
$app->delete('/robots/{id:[0-9]+}', function($id) use ($app) {

    $phql = "DELETE FROM Robots WHERE id = :id:";
    $status = $app->modelsManager->executeQuery($phql, array(
        'id' => $id
    ));

    //Create a response
    $response = new Phalcon\Http\Response();

    if ($status->success() == true) {
        $response->setJsonContent(array('status' => 'OK'));
    } else {

        //Change the HTTP status
        $response->setStatusCode(500, "Internal Error");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(array('status' => 'ERROR', 'messages' => $errors));

    }

    return $response;
});

$app->handle();
