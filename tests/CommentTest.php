<?php

class CommentTest extends TestCase

{

    public function testShouldPostComments()
    {
        $res = $this->post('api/v1/movies/1/comments',["comment"=>"awsesome movie"]);
        $this->seeStatusCode(201);
        $this->seeJson(['success' => true]);
    }

    public function testShouldReturnMovieComents()
    {
        $res = $this->get('api/v1/movies/1/comments',[]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }
}