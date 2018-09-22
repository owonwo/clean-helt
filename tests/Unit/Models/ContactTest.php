<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    private $contact;

    protected function setUp()
    {
        parent::setUp();
        $this->contact = create(Contact::class);
    }

    /** @test */
    public function a_contact_has_a_valid_owner()
    {
        $this->assertNotNull($this->contact->owner);
    }

    /** @test */
    public function a_contact_model_contains_a_valid_contact()
    {
        $this->assertNotNull($this->contact->contact);
    }
}
