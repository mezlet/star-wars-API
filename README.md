# Star-Wars-API

# Table of Contents

- [Installation](#installation)
    - [Windows Environment](#windows-environment)
    - [MacOS/Linux Environment](#mac-linux-environment)
- [Endpoints](#endpoints)
	- [Get Movies](#getmovies)
	- [Get Comments](#getcomments)
	- [Create Comment](#createcomment)
    - [Get Movie Characters](#getmoviecharacters)
- [Endpoints](#endpoints)
    -[Documentation](#documentation)


## Installation

```
clone the repository

create .env and paste the content of .env sample into it

run composer install
```

### Windows Environment
```
if you are in a windows environment install choco by following this discription
https://chocolatey.org/docs/installation

run choco install make

run "make start" to start the docker environment 
```

### MacOS/Linux Environment
```
run "make start"
```

## Getting Started
```
You can consume the API from https://start-wars-movies.appspot.com
```

## Endpoints

### Get Movies

#### Request
`GET /api/v1/movies?offset=0&limit=2`

##### URL Param
```
offset: int
limit: int
```

#### Response
```
{
    "success": true,
    "data": [
        {
            "opening_crawl": "It is a period of civil war.\r\nRebel spaceships, striking\r\nfrom a hidden base, have won\r\ntheir first victory against\r\nthe evil Galactic Empire.\r\n\r\nDuring the battle, Rebel\r\nspies managed to steal secret\r\nplans to the Empire's\r\nultimate weapon, the DEATH\r\nSTAR, an armored space\r\nstation with enough power\r\nto destroy an entire planet.\r\n\r\nPursued by the Empire's\r\nsinister agents, Princess\r\nLeia races home aboard her\r\nstarship, custodian of the\r\nstolen plans that can save her\r\npeople and restore\r\nfreedom to the galaxy....",
            "release_date": "1977-05-25",
            "url": "https://swapi.co/api/films/1/",
            "id": "1",
            "comment_count": 4
        },
        {
            "opening_crawl": "It is a dark time for the\r\nRebellion. Although the Death\r\nStar has been destroyed,\r\nImperial troops have driven the\r\nRebel forces from their hidden\r\nbase and pursued them across\r\nthe galaxy.\r\n\r\nEvading the dreaded Imperial\r\nStarfleet, a group of freedom\r\nfighters led by Luke Skywalker\r\nhas established a new secret\r\nbase on the remote ice world\r\nof Hoth.\r\n\r\nThe evil lord Darth Vader,\r\nobsessed with finding young\r\nSkywalker, has dispatched\r\nthousands of remote probes into\r\nthe far reaches of space....",
            "release_date": "1980-05-17",
            "url": "https://swapi.co/api/films/2/",
            "id": "2",
            "comment_count": 1
        }
    ],
    "message": ""
}

```

### Get Comments

#### Request
`GET api/v1/movies/1/comments?page=1`

####  Response
```
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 4,
                "ip": "172.31.0.1",
                "comment": "excellent",
                "movie_id": 1,
                "created_at": "2019-10-01 18:00:36",
                "updated_at": "2019-10-01 18:00:36"
            },
            {
                "id": 3,
                "ip": "172.31.0.1",
                "comment": "awesome",
                "movie_id": 1,
                "created_at": "2019-10-01 17:59:37",
                "updated_at": "2019-10-01 17:59:37"
            }
        ],
        "first_page_url": "http://localhost:5000/api/v1/movies/1/comments?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:5000/api/v1/movies/1/comments?page=1",
        "next_page_url": null,
        "path": "http://localhost:5000/api/v1/movies/1/comments",
        "per_page": 5,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    },
    "message": ""
}
```

### Create Comment

#### Request
`Post api/v1/movies/{movie_id}/comment`

#### Body
{
"comment": "dope"
}

####  Response
```
{
    "success": true,
    "data": {
        "comment": "dope",
        "ip": "::1",
        "movie_id": "1",
        "updated_at": "2019-10-01 07:49:24",
        "created_at": "2019-10-01 07:49:24",
        "id": 12
    },
    "message": "Comment created successfully."
}

```

### Get Movie Characters

#### Request
`GET api/v1/movies/1/characters?sort_param=name&filter_param=female`
##### URL Params
```
sort_param: string
filter_param: string
```

#### Response
```
{
    "success": true,
    "data": [
        {
            "character": [
                {
                    "name": "Beru Whitesun lars",
                    "gender": "female",
                    "height": "165",
                    "height(ft/inch)": "5'5"
                },
                {
                    "name": "Leia Organa",
                    "gender": "female",
                    "height": "150",
                    "height(ft/inch)":"4'11"
                }
            ],
            "realease_date": "1977-05-25",
            "total_character": 2
            "total_height": 315
            "total_height_in_ft: "10′ 4″
        }
    ],
    "message": ""
}
```
## Documentation 
```
https://documenter.getpostman.com/view/4259930/SVzuc2hn
```
