<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
	
	 public function testgetArticleWithoutAuth()
    {
			$response = $this->json('GET', '/api/getAllArticle',[]);							
			$response->assertStatus(401);
			$response->assertJson(['message' => "Unauthenticated."]);
			
			
        }
		
	public function testgetArticleWithAuth()
    {
			 $user = factory(\App\User::class)->create();
				
			$token = $user->createToken('MyApp')->accessToken;
			$header = [];
			$header['Accept'] = 'application/json';
			$header['Authorization'] = 'Bearer '.$token;
			
			$response = $this->json('GET', '/api/getAllArticle',[],$header);
			$response->assertStatus(200);			
			$response->assertJsonStructure(['data'=>[
					"total_article",
					"articleList"=>[
					'*'=>[
					 		'id',
                            'title',
                            'details',
                            'created_at',
                            'updated_at'
					]]
				
			]
			]);
			
        }
	 
}
