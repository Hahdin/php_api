# PHP ElasticSearch API

## Setup
Currently this demo is connecting to an Elasticsearch NoSql database that is run locally. This was made with version 6.2.4 
- [The Elastic Stack](https://www.elastic.co/products/)

Dependencies are installed with [Composer](https://getcomposer.org/doc/01-basic-usage.md#composer-json-project-setup)

composer.json
```json
{
  "require": {
    "elasticsearch/elasticsearch": "^6.2.4"
  } 
}
```
## Endpoints
A basic CRUD RESTful api.

### Create 
method: POST

desc: create a new record

url: http://localhost:9000/api/create

body
```json
{
  "uwi": "11111111W400",
  "name": "wellname",
  "account": "1234567890"
}

```
### Read 
method: GET

desc: read records from specific account#

url: http://localhost:9000/api/read/1234567890

### Update 
method: POST

desc: update a record by id

url: http://localhost:9000/api/update

body
```json
{
  "uwi": "11111111W400",
  "name": "wellname",
  "account": "1234567890",
  "id": "aTlJo2oBu3wb5VBPH4Uj"
}

```
### Delete 
method: POST

desc: delete a record by id

url: http://localhost:9000/api/delete

body
```json
{
  "id": "aTlJo2oBu3wb5VBPH4Uj"
}

```

### Search 
method: GET

desc: read all records

url: http://localhost:9000/api/search


