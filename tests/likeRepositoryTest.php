<?php

use App\Models\like;
use App\Repositories\likeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class likeRepositoryTest extends TestCase
{
    use MakelikeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var likeRepository
     */
    protected $likeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->likeRepo = App::make(likeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatelike()
    {
        $like = $this->fakelikeData();
        $createdlike = $this->likeRepo->create($like);
        $createdlike = $createdlike->toArray();
        $this->assertArrayHasKey('id', $createdlike);
        $this->assertNotNull($createdlike['id'], 'Created like must have id specified');
        $this->assertNotNull(like::find($createdlike['id']), 'like with given id must be in DB');
        $this->assertModelData($like, $createdlike);
    }

    /**
     * @test read
     */
    public function testReadlike()
    {
        $like = $this->makelike();
        $dblike = $this->likeRepo->find($like->id);
        $dblike = $dblike->toArray();
        $this->assertModelData($like->toArray(), $dblike);
    }

    /**
     * @test update
     */
    public function testUpdatelike()
    {
        $like = $this->makelike();
        $fakelike = $this->fakelikeData();
        $updatedlike = $this->likeRepo->update($fakelike, $like->id);
        $this->assertModelData($fakelike, $updatedlike->toArray());
        $dblike = $this->likeRepo->find($like->id);
        $this->assertModelData($fakelike, $dblike->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletelike()
    {
        $like = $this->makelike();
        $resp = $this->likeRepo->delete($like->id);
        $this->assertTrue($resp);
        $this->assertNull(like::find($like->id), 'like should not exist in DB');
    }
}
