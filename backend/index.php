<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/./vendor/autoload.php';

use Medoo\Medoo;

$database = new Medoo([
    'type' => 'sqlite',
    'database' => 'database.db'
]);

$database->create("account", [
    "id" => [
        "INTEGER",
        "PRIMARY KEY"
    ],
    "name" => [
        "VARCHAR(50)",
        "NOT NULL",
        "UNIQUE"
    ],
    "score" => [
        "INTEGER",
        "NOT NULL"
    ]
]);

$app = AppFactory::create();

$app->post('/score', function (Request $request, Response $response, array $args) use ($database) {
    try {
        $parsedBody = $request->getParsedBody();
        $database->insert("account", [
            "name" => $parsedBody['name'],
            "score" => $parsedBody['score']
        ]);
        $response->getBody()->write("New record created successfully");
    } catch (Exception $e) {
        $response->getBody()->write($e->getMessage());
        return $response->withStatus(400);
    }
    return $response;
});

$app->get('/score/{id}', function (Request $request, Response $response, array $args) use ($database) {
    try {
        $id = $args['id'];
        $data = $database->select("account", "*", ["name" => $id]);
        if ($data) {
            $response->getBody()->write(json_encode($data));
        } else {
            throw new Exception("No record found for id: " . $id);
        }
    } catch (Exception $e) {
        $response->getBody()->write($e->getMessage());
        return $response->withStatus(400);
    }
    return $response;
});
$app->run();