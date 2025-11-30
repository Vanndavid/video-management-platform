<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Listing;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoApiTest extends TestCase
{
    use RefreshDatabase; // 👈 ensures migrations run for every test
    public function test_can_create_video(): void
    {
        $listing = Listing::factory()->create();
        $fakeFile = UploadedFile::fake()->create('demo.mp4', 1000, 'video/mp4');
        $response = $this->postJson('/api/videos', [
            'listing_id' => $listing->id,
            'title' => 'Kitchen Tour',
            'file' => $fakeFile,
        ]);

        $response->assertCreated()
                 ->assertJsonPath('data.status', 'UPLOADED');
    }
}
