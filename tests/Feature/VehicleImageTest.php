<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VehicleImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_vehicle_images_are_streamed_from_the_public_disk(): void
    {
        Storage::fake('public');
        $image = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        Storage::disk('public')->put('documents/front.png', $image);
        Storage::disk('public')->put('documents/side.png', $image);
        $paths = ['documents/front.png', 'documents/side.png'];
        $vehicle = $this->createVehicle(User::factory()->create(), $paths);

        $this->get(route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 1]))
            ->assertOk()
            ->assertHeader('Content-Disposition', 'inline');

        $this->get(route('vehicles.show', $vehicle))
            ->assertOk()
            ->assertSee(route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 0]))
            ->assertSee(route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 1]));
    }

    public function test_pending_vehicle_images_are_only_visible_to_the_owner_or_an_admin(): void
    {
        Storage::fake('public');
        $image = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        Storage::disk('public')->put('documents/pending.png', $image);
        $owner = User::factory()->create();
        $vehicle = $this->createVehicle($owner, 'documents/pending.png', 'pending');

        $this->get(route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 0]))
            ->assertNotFound();

        $this->actingAs($owner)
            ->get(route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 0]))
            ->assertOk();

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->get(route('admin.documents.show', [
                'type' => 'vehicle',
                'id' => $vehicle->id,
                'field' => 'image_url',
                'index' => 0,
            ]))
            ->assertOk();
    }

    public function test_legacy_single_image_paths_are_normalized(): void
    {
        $vehicle = new Vehicle(['image_url' => 'documents/legacy.jpg']);

        $this->assertSame(['documents/legacy.jpg'], $vehicle->imagePaths());
    }

    private function createVehicle(User $owner, array|string $imagePaths, string $approvalStatus = 'approved'): Vehicle
    {
        return Vehicle::create([
            'user_id' => $owner->id,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2024,
            'license_plate' => 'GR 1234-25',
            'status' => 'available',
            'approval_status' => $approvalStatus,
            'image_url' => $imagePaths,
        ]);
    }
}
