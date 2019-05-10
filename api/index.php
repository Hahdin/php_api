<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('elastic_client.php');

spl_autoload_register(function ($class_name) {
  include $class_name . '.php';
});
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$requestMethod = $_SERVER["REQUEST_METHOD"];
// all of our endpoints start with /api
// everything else results in a 404 Not Found
if ($uri[1] !== 'api') {
  header("HTTP/1.1 404 Not Found");
  exit();
}
$endpoint = 'search';
if (isset($uri[2])){
  $endpoint = $uri[2];
}
$gateway = new Gateway($client);

if ($requestMethod === 'GET')
{
  switch ($endpoint) 
  {
    case 'read':
      if (isset($uri[3]))
      {
        $response = $gateway->read($uri[3]);
      }
      else
      {
        $response = "Missing account number";
      }
    break;
    case 'search':
    default:
      $response = $gateway->search();
    break;
  }
}
if ($requestMethod === 'POST')
{
  $data = json_decode(file_get_contents('php://input'), true);
  switch ($endpoint) 
  {
    case 'create':
    case 'update':
    {
      if (empty($data['uwi']))
      {
        $response = json_encode('Missing uwi');
      }
      else if (empty($data['name']))
      {
        $response = json_encode('Missing name');
      }
      else if (empty($data['account']))
      {
        $response = json_encode('Missing account');
      }
      else{
        if ($endpoint === "create")
        {
          $response = $gateway->create($data);
        }
        if ($endpoint === "update")
        {
          if (empty($data['id']))
          {
            $response = json_encode('Missing id');
          }
          else
          {
            $response = $gateway->update($data);
          }
        }
      }
    }
    break;
    case 'delete':
    {
      if (empty($data['id'])){
        $response = json_encode('Missing id');
      }
      else
      {
        $response = $gateway->es_delete($data['id']);
      }
    }
    break;
    default:
      $response = "Failed on $requestMethod";
    break;
  }
}

echo $response;


