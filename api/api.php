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

// Package API
 $app->get('/pkg',function(Request $request, Response $response){
   $query = $this->db->prepare("SELECT * FROM package");
   $query->execute();
   $result = $query->fetchAll();
   return $response->withJson($result);
 });

 $app->get('/pkg/{id}',function(Request $request, Response $response){
   $pkgId = $request->getAttribute('id');
   $query = $this->db->prepare("SELECT * FROM package where packageId = $pkgId");
   $query->execute();
   $result = $query->fetchAll();
   return $response->withJson($result);
 });

  $app->get('/pkg/search/{name}',function(Request $request, Response $response){
    $pkgName = $request->getAttribute('name');
    $query = $this->db->prepare("SELECT * FROM `package` WHERE pkgName LIKE '%$pkgName%' ORDER BY pkgName;");
    $query->execute();
    $result = $query->fetchAll();
    return $this->response->withJson($result);
  });

  $app->post('/pkg' , function(Request $request, Response $response){
    $input = $request->getParsedBody();
    $pkgName = $input['pkgName'];
    $pkgXDimen = $input['pkgXDimen'];
    $pkgYDimen = $input['pkgYDimen'];
    $pkgZDimen = $input['pkgZDimen'];
    $pkgWeight = $input['pkgWeight'];
    $query =  $this->db->prepare("INSERT INTO `package`(`pkgName`, `pkgXDimen`,`pkgYDimen`,`pkgZDimen`,`pkgWeight`) VALUES ('$pkgName','$pkgXDimen','$pkgYDimen','$pkgZDimen','$pkgWeight');");
    $query->execute();
    $input['packageId'] = $this->db->lastInsertId();
    return $this->response->withJson($input);
  });

  $app->delete('/pkg/{id}', function (Request $request) {
    $pkgId = $request->getAttribute('id');
    $query = $this->db->prepare("DELETE FROM package WHERE packageId = $pkgId;");
    $query->execute();
  });

  $app->put('/pkg/{id}', function (Request $request, Response $response) {
    $pkgId = $request->getAttribute('id');
    $input = $request->getParsedBody();
    $pkgName = $input['pkgName'];
    $pkgXDimen = $input['pkgXDimen'];
    $pkgYDimen = $input['pkgYDimen'];
    $pkgZDimen = $input['pkgZDimen'];
    $pkgWeight = $input['pkgWeight'];
    $query = $this->db->prepare("UPDATE `package` SET `pkgName`= '$pkgName',`pkgXDimen`='$pkgXDimen',`pkgYDimen`='$pkgYDimen',`pkgZDimen`='$pkgZDimen',`pkgWeight`='$pkgWeight' WHERE `packageId` = $pkgId;");
    $query->execute();
    return $this->response->withJson($input);
   });

   // Car Type API
   $app->get('/cartype' , function (Request $request , Response $response){
     $query = $this->db->prepare("SELECT * FROM cartype");
     $query->execute();
     $result = $query->fetchAll();
     return $response->withJson($result);
   });

   $app->get('/cartype/{id}', function (Request $request, Response $response) {
     $carTypeId = $request->getAttribute('id');
     $query = $this->db->prepare("SELECT * FROM cartype where carTypeId = $carTypeId");
     $query->execute();
     $result = $query->fetchAll();
     return $response->withJson($result);
   });
   $app->get('/cartype/search/{name}', function (Request $request, Response $response) {
     $carTypeName = $request->getAttribute('name');
     $query = $this->db->prepare("SELECT * FROM `cartype` WHERE carTypeName LIKE '%$carTypeName%' ORDER BY carTypeName;");
     $query->execute();
     $result = $query->fetchAll();
     return $this->response->withJson($result);
   });

   $app->post('/cartype' , function(Request $request, Response $response){
     $input = $request->getParsedBody();
     $carTypeName = $input['carTypeName'];
     $x_dimen = $input['x_dimen'];
     $y_dimen = $input['y_dimen'];
     $z_dimen = $input['z_dimen'];
     $max_weight = $input['max_weight'];
     $query =  $this->db->prepare("INSERT INTO `cartype`(`carTypeName`, `x_dimen`,`y_dimen`,`z_dimen`,`max_weight`) VALUES ('$carTypeName','$x_dimen','$y_dimen','$z_dimen','$max_weight');");
     $query->execute();
     $input['carTypeId'] = $this->db->lastInsertId();
     return $this->response->withJson($input);
   });

   $app->delete('/cartype/{id}', function (Request $request) {
     $carTypeId = $request->getAttribute('id');
     $query = $this->db->prepare("DELETE FROM cartype WHERE carTypeId = $carTypeId;");
     $query->execute();
   });

   $app->put('/cartype/{id}', function (Request $request, Response $response) {
     $carTypeId = $request->getAttribute('id');
     $input = $request->getParsedBody();
     $carTypeName = $input['carTypeName'];
     $x_dimen = $input['x_dimen'];
     $y_dimen = $input['y_dimen'];
     $z_dimen = $input['z_dimen'];
     $max_weight = $input['max_weight'];
     $query = $this->db->prepare("UPDATE `cartype` SET `carTypeName`= '$carTypeName',`x_dimen`='$x_dimen',`y_dimen`='$y_dimen',`z_dimen`='$z_dimen',`max_weight`='$max_weight' WHERE `carTypeId` = $carTypeId;");
     $query->execute();
     return $this->response->withJson($input);
    });

    // customer API
    $app->get('/customer' , function (Request $request , Response $response){
      $query = $this->db->prepare("SELECT * FROM customer");
      $query->execute();
      $result = $query->fetchAll();
      return $response->withJson($result);
    });

    $app->get('/customer/{id}', function (Request $request, Response $response) {
      $customerId = $request->getAttribute('id');
      $query = $this->db->prepare("SELECT * FROM customer where customerId = $customerId");
      $query->execute();
      $result = $query->fetchAll();
      return $response->withJson($result);
    });
    $app->get('/customer/search/{name}', function (Request $request, Response $response) {
      $customerName = $request->getAttribute('name');
      $query = $this->db->prepare("SELECT * FROM `customer` WHERE customerName LIKE '%$customerName%' ORDER BY customerName;");
      $query->execute();
      $result = $query->fetchAll();
      return $this->response->withJson($result);
    });

    $app->post('/customer' , function(Request $request, Response $response){
      $input = $request->getParsedBody();
      $customerName = $input['customerName'];
      $contactDetail = $input['contactDetail'];
      $otherInfo = $input['otherInfo'];
      $query =  $this->db->prepare("INSERT INTO `customer`(`customerName`, `contactDetail`,`otherInfo`) VALUES ('$customerName','$contactDetail','$otherInfo');");
      $query->execute();
      $input['customerId'] = $this->db->lastInsertId();
      return $this->response->withJson($input);
    });

    $app->delete('/customer/{id}', function (Request $request) {
      $customerId = $request->getAttribute('id');
      $query = $this->db->prepare("DELETE FROM customer WHERE customerId = $customerId;");
      $query->execute();
    });

    $app->put('/customer/{id}', function (Request $request, Response $response) {
      $customerId = $request->getAttribute('id');
      $input = $request->getParsedBody();
      $customerName = $input['customerName'];
      $contactDetail = $input['contactDetail'];
      $otherInfo = $input['otherInfo'];
      $query = $this->db->prepare("UPDATE `customer` SET `customerName`= '$customerName',`contactDetail`='$contactDetail',`otherInfo`='$otherInfo' WHERE `customerId` = $customerId;");
      $query->execute();
      return $this->response->withJson($input);
     });

     // car API
     $app->get('/car' , function (Request $request , Response $response){
       $query = $this->db->prepare("SELECT * FROM car");
       $query->execute();
       $result = $query->fetchAll();
       return $response->withJson($result);
     });

     $app->get('/car/{id}', function (Request $request, Response $response) {
       $carId = $request->getAttribute('id');
       $query = $this->db->prepare("SELECT * FROM car where carId = $carId");
       $query->execute();
       $result = $query->fetchAll();
       return $response->withJson($result);
     });
     $app->get('/car/search/{name}', function (Request $request, Response $response) {
       $carName = $request->getAttribute('name');
       $query = $this->db->prepare("SELECT * FROM `car` WHERE carName LIKE '%$carName%' ORDER BY carName;");
       $query->execute();
       $result = $query->fetchAll();
       return $this->response->withJson($result);
     });

     $app->post('/car' , function(Request $request, Response $response){
       $input = $request->getParsedBody();
       $carName = $input['carName'];
       $carType = $input['carType'];
       $query =  $this->db->prepare("INSERT INTO `car`(`carName`, `carType`) VALUES ('$carName','$carType');");
       $query->execute();
       $input['carId'] = $this->db->lastInsertId();
       return $this->response->withJson($input);
     });

     $app->delete('/car/{id}', function (Request $request) {
       $carId = $request->getAttribute('id');
       $query = $this->db->prepare("DELETE FROM car WHERE carId = $carId;");
       $query->execute();
     });

     $app->put('/car/{id}', function (Request $request, Response $response) {
       $carId = $request->getAttribute('id');
       $input = $request->getParsedBody();
       $carName = $input['carName'];
       $carType = $input['carType'];
       $query = $this->db->prepare("UPDATE `car` SET `carName`= '$carName',`carType`='$carType' WHERE `carId` = $carId;");
       $query->execute();
       return $this->response->withJson($input);
      });

      // route API
      $app->get('/route' , function (Request $request , Response $response){
        $query = $this->db->prepare("SELECT * FROM route");
        $query->execute();
        $result = $query->fetchAll();
        return $response->withJson($result);
      });

      $app->get('/route/{id}', function (Request $request, Response $response) {
        $routeId = $request->getAttribute('id');
        $query = $this->db->prepare("SELECT * FROM route where carId = $routeId");
        $query->execute();
        $result = $query->fetchAll();
        return $response->withJson($result);
      });

      $app->post('/route' , function(Request $request, Response $response){
        $input = $request->getParsedBody();
        $status = $input['status'];
        $carId = $input['carId'];
        $query =  $this->db->prepare("INSERT INTO `route`(`status`, `carId`) VALUES ('$status','$carId');");
        $query->execute();
        $input['routeId'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
      });

      $app->delete('/route/{id}', function (Request $request) {
        $routeId = $request->getAttribute('id');
        $query = $this->db->prepare("DELETE FROM route WHERE routeId = $routeId;");
        $query->execute();
      });

      $app->put('/route/{id}', function (Request $request, Response $response) {
        $routeId = $request->getAttribute('id');
        $input = $request->getParsedBody();
        $status = $input['status'];
        $carId = $input['carId'];
        $query = $this->db->prepare("UPDATE `route` SET `status`= '$status',`carId`='$carId' WHERE `routeId` = $routeId;");
        $query->execute();
        return $this->response->withJson($input);
       });

       // transaction API
       $app->get('/transaction' , function (Request $request , Response $response){
         $query = $this->db->prepare("SELECT * FROM transaction");
         $query->execute();
         $result = $query->fetchAll();
         return $response->withJson($result);
       });

       $app->get('/transaction/{id}', function (Request $request, Response $response) {
         $transactionId = $request->getAttribute('id');
         $query = $this->db->prepare("SELECT * FROM transaction where transactionId = $transactionId");
         $query->execute();
         $result = $query->fetchAll();
         return $response->withJson($result);
       });

       $app->post('/transaction' , function(Request $request, Response $response){
         $input = $request->getParsedBody();
         $customerId = $input['customerId'];
         $latlong = $input['latlong'];
         $status = $input['status'];
         $routeId = $input['routeId'];
         $query =  $this->db->prepare("INSERT INTO `transaction`(`customerId`, `latlong`,`status`,`routeId`) VALUES ('$customerId','$latlong','$status','$routeId');");
         $query->execute();
         $input['transactionId'] = $this->db->lastInsertId();
         return $this->response->withJson($input);
       });

       $app->delete('/transaction/{id}', function (Request $request) {
         $transactionId = $request->getAttribute('id');
         $query = $this->db->prepare("DELETE FROM transaction WHERE transactionId = $transactionId;");
         $query->execute();
       });

       $app->put('/transaction/{id}', function (Request $request, Response $response) {
         $transactionId = $request->getAttribute('id');
         $input = $request->getParsedBody();
         $customerId = $input['customerId'];
         $latlong = $input['latlong'];
         $status = $input['status'];
         $routeId = $input['routeId'];
         $query = $this->db->prepare("UPDATE `transaction` SET `customerId`= '$customerId',`latlong`='$latlong',`status`='$status',`routeId`='$routeId' WHERE `transactionId` = $transactionId;");
         $query->execute();
         return $this->response->withJson($input);
        });

        // tg good API
        $app->get('/tg' , function (Request $request , Response $response){
          $query = $this->db->prepare("SELECT * FROM transactiongood");
          $query->execute();
          $result = $query->fetchAll();
          return $response->withJson($result);
        });

        $app->get('/tg/{id}', function (Request $request, Response $response) {
          $tgId = $request->getAttribute('id');
          $query = $this->db->prepare("SELECT * FROM transactiongood where tgId = $tgId");
          $query->execute();
          $result = $query->fetchAll();
          return $response->withJson($result);
        });

        $app->post('/tg' , function(Request $request, Response $response){
          $input = $request->getParsedBody();
          $transactionId = $input['transactionId'];
          $pkgId = $input['pkgId'];
          $qty = $input['qty'];
          $query =  $this->db->prepare("INSERT INTO `transactiongood`(`transactionId`, `pkgId`,`qty`) VALUES ('$transactionId','$pkgId','$qty');");
          $query->execute();
          $input['tgId'] = $this->db->lastInsertId();
          return $this->response->withJson($input);
        });

        $app->delete('/tg/{id}', function (Request $request) {
          $tgId = $request->getAttribute('id');
          $query = $this->db->prepare("DELETE FROM transactiongood WHERE tgId = $tgId;");
          $query->execute();
        });

        $app->put('/tg/{id}', function (Request $request, Response $response) {
          $tgId = $request->getAttribute('id');
          $input = $request->getParsedBody();
          $transactionId = $input['transactionId'];
          $pkgId = $input['pkgId'];
          $qty = $input['qty'];
          $query = $this->db->prepare("UPDATE `transactiongood` SET `transactionId`= '$transactionId',`pkgId`='$pkgId',`qty`='$qty' WHERE `tgId` = $tgId;");
          $query->execute();
          return $this->response->withJson($input);
         });
$app->run();
?>
