<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Companies;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function it_can_create_a_company()
    {
        $file = UploadedFile::fake()->image('logo.jpg', 100, 100);
    
        $response = $this->post('/companies', [
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'website' => 'http://test.com',
            'logo' => $file,
        ]);
    
        $company = Companies::first();
        
        $response->assertRedirect('/companies');
        $response->assertSessionHas('success', 'Success Create Companies');
        
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'website' => 'http://test.com',
        ]);

        Storage::disk('public')->assertExists($company->logo);
    }

    /** @test */
    public function it_can_update_a_company()
    {
        $company = Companies::factory()->create([
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'website' => 'http://test.com',
            'logo' => 'images/logo/old_logo.jpg'
        ]);
        Storage::disk('public')->put($company->logo, 'fake image content');

        $file = UploadedFile::fake()->image('new_logo.jpg', 200, 200);

        $response = $this->put(route('companies.update', $company->id), [
            'name' => 'Updated Company',
            'email' => 'updated@example.com',
            'logo' => $file,
            'website' => 'https://updated-example.com',
        ]);

        $updatedCompany = Companies::find($company->id);

        $response->assertRedirect('/companies');
        $response->assertSessionHas('success', 'Success Edit Companies');

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'Updated Company',
            'email' => 'updated@example.com',
            'website' => 'https://updated-example.com',
        ]);

        Storage::disk('public')->assertMissing($company->logo);
        
        Storage::disk('public')->assertExists($updatedCompany->logo);
    }

    /** @test */
    public function it_can_delete_a_company()
    {
        $company = Companies::factory()->create([
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'website' => 'http://test.com',
            'logo' => 'images/logo/test_logo.jpg'
        ]);
        
        Storage::disk('public')->put($company->logo, 'fake image content');

        $response = $this->delete(route('companies.destroy', $company->id));

        $response->assertRedirect('/companies');
        $response->assertSessionHas('success', 'Success Delete Companies');

        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
        Storage::disk('public')->assertMissing($company->logo);
    }

    /** @test */
    public function it_can_show_a_company()
    {
        $company = Companies::factory()->create([
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'website' => 'http://test.com',
            'logo' => 'images/logo/test_logo.jpg'
        ]);

        $response = $this->get(route('companies.show', $company->id));

        $response->assertOk();
        $response->assertViewIs('admin.companies.show');
        $response->assertViewHas('companie', function($viewCompany) use ($company) {
            return $viewCompany->id === $company->id;
        });
    }

    /** @test */
    public function it_validates_logo_dimensions()
    {
        $file = UploadedFile::fake()->image('logo.jpg', 50, 50); // Too small

        $response = $this->post('/companies', [
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'website' => 'http://test.com',
            'logo' => $file,
        ]);

        $response->assertSessionHasErrors('logo');
    }
}