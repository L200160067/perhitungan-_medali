<?php

namespace Tests\Feature;

use App\Imports\RegistrationImport;
use App\Models\Event;
use App\Models\TournamentCategory;
use App\Models\Registration;
use App\Models\Participant;
use App\Models\Contingent;
use App\Models\Dojang;
use App\Enums\ParticipantGender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Row;
use Tests\TestCase;
use Mockery;

class RegistrationImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_on_row_creates_registration_with_indonesian_headers()
    {
        // Setup Data
        $event = Event::factory()->create(['name' => 'Kejuaraan Test']);
        $category = TournamentCategory::factory()->create([
            'event_id' => $event->id,
            'name' => 'Kyorugi Pemula',
        ]);

        // Mock Row
        $rowArray = [
            'nama_pertandingan' => 'Kejuaraan Test',
            'nama_kategori' => 'Kyorugi Pemula',
            'nama_peserta' => 'Budi Santoso',
            'nama_kontingen' => 'Kontingen A',
            'nama_dojang' => 'Dojang X',
            'jenis_kelamin' => 'L', // Laki-laki
        ];

        // Simulate Row Object (Mocking strictly is hard because Row is final or complex, 
        // but we can just instantiate Import and call logic if we extract it, 
        // OR we can mock the Row object if Maatwebsite allows it. 
        // Actually, Row takes an array and index in constructor normally? 
        // Let's check Maatwebsite source or just try to mock it.
        // Row is a class wrapper. Let's try to mock it.
        
        $rowMock = Mockery::mock(Row::class);
        $rowMock->shouldReceive('getIndex')->andReturn(2);
        $rowMock->shouldReceive('toArray')->andReturn($rowArray);

        // Execute Import
        $import = new RegistrationImport();
        $import->onRow($rowMock);

        // Assertions
        $this->assertDatabaseHas('participants', [
            'name' => 'Budi Santoso',
            'gender' => ParticipantGender::Male,
        ]);

        $this->assertDatabaseHas('dojangs', ['name' => 'Dojang X']);
        $this->assertDatabaseHas('contingents', ['name' => 'Kontingen A']);
        
        $participant = Participant::where('name', 'Budi Santoso')->first();
        $this->assertDatabaseHas('registrations', [
            'category_id' => $category->id,
            'participant_id' => $participant->id,
        ]);
    }

    public function test_on_row_handles_female_gender_mapping()
    {
         // Setup Data
         $event = Event::factory()->create(['name' => 'Kejuaraan Test']);
         $category = TournamentCategory::factory()->create([
             'event_id' => $event->id,
             'name' => 'Kyorugi Putri',
         ]);
 
         // Mock Row
         $rowArray = [
             'nama_pertandingan' => 'Kejuaraan Test',
             'nama_kategori' => 'Kyorugi Putri',
             'nama_peserta' => 'Siti Aminah',
             'nama_kontingen' => 'Kontingen B',
             'nama_dojang' => 'Dojang Y',
             'jenis_kelamin' => 'P', // Perempuan
         ];
 
         $rowMock = Mockery::mock(Row::class);
         $rowMock->shouldReceive('getIndex')->andReturn(3);
         $rowMock->shouldReceive('toArray')->andReturn($rowArray);
 
         // Execute Import
         $import = new RegistrationImport();
         $import->onRow($rowMock);
 
         // Assertions
         $this->assertDatabaseHas('participants', [
             'name' => 'Siti Aminah',
             'gender' => ParticipantGender::Female, // Should match 'P' mapping
         ]);
    }
}
