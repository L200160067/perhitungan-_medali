<?php

namespace Tests\Feature;

use App\Models\Dojang;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ParticipantPhotoTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles if not already seeded by RefreshDatabase (usually manual)
        // Assuming RoleSeeder runs or we manually create
        $role = Role::firstOrCreate(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    public function test_participant_can_be_created_with_photo()
    {
        Storage::fake('public');
        $dojang = Dojang::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg', 450, 600);

        $response = $this->actingAs($this->admin)->post(route('participants.store'), [
            'name' => 'John Doe',
            'dojang_id' => $dojang->id,
            'gender' => 'M',
            'birth_date' => '2000-01-01',
            'photo' => $file,
        ]);

        $response->assertRedirect(route('participants.index'));
        $participant = Participant::first();
        $this->assertNotNull($participant->photo);
        Storage::disk('public')->assertExists($participant->photo);
    }

    public function test_participant_photo_validation_format()
    {
        Storage::fake('public');
        $dojang = Dojang::factory()->create();

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($this->admin)->post(route('participants.store'), [
            'name' => 'John Doe',
            'dojang_id' => $dojang->id,
            'gender' => 'M',
            'birth_date' => '2000-01-01',
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_participant_photo_validation_ratio()
    {
        Storage::fake('public');
        $dojang = Dojang::factory()->create();

        // 100x100 is 1:1, should fail 3:4 (0.75)
        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100);

        $response = $this->actingAs($this->admin)->post(route('participants.store'), [
            'name' => 'John Doe',
            'dojang_id' => $dojang->id,
            'gender' => 'M',
            'birth_date' => '2000-01-01',
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_participant_photo_can_be_updated()
    {
        Storage::fake('public');
        $dojang = Dojang::factory()->create();
        $oldFile = UploadedFile::fake()->image('old.jpg', 450, 600);
        
        $participant = Participant::factory()->create([
            'dojang_id' => $dojang->id,
            'photo' => $oldFile->store('participants-photos', 'public'),
        ]);

        $newFile = UploadedFile::fake()->image('new.jpg', 450, 600);

        $response = $this->actingAs($this->admin)->put(route('participants.update', $participant), [
            'name' => 'Jane Doe',
            'dojang_id' => $dojang->id,
            'gender' => 'F',
            'birth_date' => '2000-01-01',
            'photo' => $newFile,
        ]);

        $response->assertRedirect(route('participants.index'));
        
        $participant->refresh();
        Storage::disk('public')->assertExists($participant->photo);
        Storage::disk('public')->assertMissing($oldFile->hashName('participants-photos'));
    }

    public function test_participant_photo_deleted_on_destroy()
    {
        Storage::fake('public');
        $dojang = Dojang::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg', 450, 600);
        
        $participant = Participant::factory()->create([
            'dojang_id' => $dojang->id,
            'photo' => $file->store('participants-photos', 'public'),
        ]);

        $path = $participant->photo;
        Storage::disk('public')->assertExists($path);

        $this->actingAs($this->admin)->delete(route('participants.destroy', $participant));

        Storage::disk('public')->assertMissing($path);
    }
}
