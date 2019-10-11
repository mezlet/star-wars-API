---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_b233704ed225faba38f0fcffbefd2c8a -->
## Get movie list

> Example request:

```bash
curl -X GET -G "/api/v1/movies" 
```

```javascript
const url = new URL("/api/v1/movies");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET /api/v1/movies`


<!-- END_b233704ed225faba38f0fcffbefd2c8a -->

<!-- START_7c8da4d0f4c2bf61930faee2d7fd9e81 -->
## Get commment

> Example request:

```bash
curl -X GET -G "/api/v1/movies/1/comments" 
```

```javascript
const url = new URL("/api/v1/movies/1/comments");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET /api/v1/movies/{movie_id}/comments`


<!-- END_7c8da4d0f4c2bf61930faee2d7fd9e81 -->

<!-- START_2c9f19d53d60c9c396f3efba5f41e885 -->
## Get movie characters by their movie id

> Example request:

```bash
curl -X GET -G "/api/v1/movies/1/characters" 
```

```javascript
const url = new URL("/api/v1/movies/1/characters");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
null
```

### HTTP Request
`GET /api/v1/movies/{movie_id}/characters`


<!-- END_2c9f19d53d60c9c396f3efba5f41e885 -->

<!-- START_2069c24f3ab192f78c6f0ee7eff704d6 -->
## Add comment

> Example request:

```bash
curl -X POST "/api/v1/movies/1/comments" 
```

```javascript
const url = new URL("/api/v1/movies/1/comments");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /api/v1/movies/{movie_id}/comments`


<!-- END_2069c24f3ab192f78c6f0ee7eff704d6 -->


