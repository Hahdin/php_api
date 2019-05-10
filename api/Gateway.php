<?php
//namespace api;

class Gateway {
  private $client = null;
  public function __construct($client)
  {
      $this->client = $client;
  }
  /**
   * Search for all records
   */
  public function search(){
    $params = [
      'index' => 'well',
      'type' => 'WELL',
      'body' => [
        'query' => [
          'match_all' => new \stdClass()
        ]
      ]
    ];
    try 
    {
      $response = $this->client->search($params);
      if ($response['hits'] && $response['hits']['hits'])
      {
        return json_encode($response['hits']['hits']);
      }
      else
      {
        return json_encode("No records found");
      } 
    } 
    catch (Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) 
    {
      return $e->getMessage();
    }
  }
  /**
   * Create a new record
   * data: associative array
   */
  public function create($data){
    $params = [
      'index' => 'well',
      'type' => 'WELL',
      //'id' => 'my_id', // allow autogenerate
      'body' => $data
    ];
    try
    {
      $response = $this->client->index($params);
    }
    catch(Exception $e)
    {
      return $e->getMessage();  
    }
    return json_encode($response);
  }
  /**
   * Read records from an account
   * accnt: string
   */
  public function read($accnt){
    $params = [
      'index' => 'well',
      'type' => 'WELL',
      'body' => [
        'query' => [
          'match' => [
            'account' => $accnt
          ]
        ]
      ]
    ];
    try 
    {
      $response = $this->client->search($params);
      if ($response['hits'] && $response['hits']['hits'])
      {
        return json_encode($response['hits']['hits']);
      }
      else
      {
        return "No records found for account $accnt";
      } 
    } 
    catch (Exception $e) 
    {
      return $e->getMessage();  
    }
  }
  /**
   * Update a record
   * data: associative array
   */
  public function update($data){
    $body = array_filter($data,function($val, $key){
      if ($key !== 'id')
      {
        return true;
      }
    }, ARRAY_FILTER_USE_BOTH );
    $params = [
      'index' => 'well',
      'type' => 'WELL',
      'id' => $data['id'],
      'body' => [
          'doc' => $body
      ]
    ];
    try
    {
      $response = $this->client->update($params);
    }
    catch(Exception $e)
    {
      return $e->getMessage();  
    }
    return json_encode($response);
  }
  /**
   * Delete a record
   * id: string
   */
  public function es_delete($id){
    $params = [
      'index' => 'well',
      'type' => 'WELL',
      'id' => $id
    ];
    try
    {
      $response = $this->client->delete($params); 
    }
    catch(Exception $e)
    {
        return $e->getMessage();  
    }
    return json_encode($response); 
  }
}