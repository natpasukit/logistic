<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once(__DIR__ . '/../vendor/autoload.php');
// init App
$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],
        'db' => [
          'host' => 'localhost',
          'user' => 'natpaphon',
          'pass' => 'sukitpaneenit',
          'dbname' => 'logistic',
        ],
    ],
];
$app = new Slim\App($config);
$container = $app->getContainer(); // container for future use
// Add dependency to container
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('api_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/', function (Request $request, Response $response) {
  $this->logger->addInfo("user access API index");
  $response->getBody()->write("Hello , This is logistic.io API for logistic based on slim framework");
  return $response;
});
// Client Info
$ip = $_SERVER['REMOTE_ADDR'];
// Depot API
$app->get('/depot' , function (Request $request , Response $response){
  $query = $this->db->prepare("SELECT * FROM depot");
  $query->execute();
  $result = $query->fetchAll();
  return $response->withJson($result); // WithJson is the slimframework way to return JSON
});

$app->get('/depot/{id}', function (Request $request, Response $response) {
  $depotId = $request->getAttribute('id');
  $query = $this->db->prepare("SELECT * FROM depot where depotNo = $depotId");
  $query->execute();
  $result = $query->fetchAll();
  return $response->withJson($result);
});
$app->get('/depot/search/{name}', function (Request $request, Response $response) {
  $depotname = $request->getAttribute('name');
  $query = $this->db->prepare("SELECT * FROM `depot` WHERE depotName LIKE '%$depotname%' ORDER BY depotName;");
  $query->execute();
  $result = $query->fetchAll();
  return $this->response->withJson($result);
});

$app->post('/depot' , function(Request $request, Response $response){
  //$postvar = $this->app->request->post();
  $input = $request->getParsedBody(); // getParsed **Body** slim way to parse data xml , json
  $depotName = $input['depotName'];
  $depotLoc = $input['depotLocation'];
  $query =  $this->db->prepare("INSERT INTO `depot`(`depotName`, `depotLocation`) VALUES ('$depotName','$depotLoc');");
  $query->execute();
  $input['depotNo'] = $this->db->lastInsertId();
  return $this->response->withJson($input);
});

$app->delete('/depot/{id}', function (Request $request) {
  $depotNo = $request->getAttribute('id');
  $query = $this->db->prepare("DELETE FROM depot WHERE depotNo = $depotNo;");
  $query->execute();
});

$app->put('/depot/{id}', function (Request $request, Response $response) {
  $depotNo = $request->getAttribute('id');
  $input = $request->getParsedBody();
  $depotName = $input['depotName'];
  $depotLoc = $input['depotLocation'];
  $query = $this->db->prepare("UPDATE `depot` SET `depotName`= '$depotName',`depotLocation`='$depotLoc' WHERE `depotNo` = $depotNo;");
  $query->execute();
  return $this->response->withJson($input);
 });
$app->run();
?>
