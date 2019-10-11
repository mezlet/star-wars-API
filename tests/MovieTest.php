<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Exception\RequestException;

class MovieTest extends TestCase

{
    // private $mockRedis;
    // public function setUp(): void
    // {
    //     parent::setUp();


    //     // try{
    //     //     $redis=Redis::connect('127.0.0.1',3306);
    //     //     echo ('redis working');
    //     // }catch(\Predis\Connection\ConnectionException $e){
    //     //     echo ('error connection redis');
    //     // }

    //     // $this->redis = Redis::connection();
    // }

    public function testShouldReturnMovieDetails()
    {
        $res = $this->get('api/v1/movies',[]);
        dd($res);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }
}