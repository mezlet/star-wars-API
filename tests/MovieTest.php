<?php

class MovieTest extends TestCase

{

    public function testShouldReturnAllMovies()
    {
        $res = $this->get('api/v1/movies',[]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }

    public function testShouldReturnMovieCharacters()
    {
        $res = $this->get('api/v1/movies/1/characters',[]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }

    public function testShouldReturnErrorIfPageNotFound()
    {
        $res = $this->get('api/v1/movie/1/characters',[]);
        $this->seeJson(['success' => false]);
        $this->seeJson(['status' => 404]);

    }

    public function testShouldReturnErrorIfWrongParams()
    {
        $res = $this->get('api/v1/movies/bvjbchjdnjk/characters',[]);
        $this->seeStatusCode(400);
        $this->seeJson(['success' => false]);
    }

    public function testShouldReturnErrorIfMovieNotFound()
    {
        $res = $this->get('api/v1/movies/100/characters',[]);
        $this->seeStatusCode(404);
        $this->seeJson(['success' => false]);
    }

    public function testShouldReturnErrorIfWrongSortParam()
    {
        $res = $this->get('api/v1/movies/1/characters?sort_param=movie',[]);
        $this->seeStatusCode(400);
        $this->seeJson(['success' => false]);
    }

    public function testShouldSortCharacters()
    {
        $res = $this->get('api/v1/movies/1/characters?sort_param=name',[]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }
}