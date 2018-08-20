<?php

namespace Tests\Unit\Models;

use App\Models\Laboratory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaboratoryTest extends TestCase
{
    use RefreshDatabase;

    private $laboratory;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->laboratory = create(Laboratory::class);
    }

    /** @test */
    public function a_laboratory_can_generate_its_own_unique_code()
    {
        $laboratory = create(Laboratory::class);
        $this->assertNotNull($laboratory->chcode);
    }
}
