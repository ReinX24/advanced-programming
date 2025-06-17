<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Don't forget to import the User model

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase; // Resets the database for each test to ensure a clean state

    /**
     * Test that the profile index page loads correctly with user data.
     *
     * @return void
     */
    public function test_profile_index_loads_with_user_data()
    {
        // 1. Arrange: Create a user with ID 1
        // Since your controller specifically finds user with ID 1, we must create one.
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            // Add other necessary user attributes based on your User model's fillable properties
        ]);

        // 2. Act: Make a GET request to the profile index route
        // Assuming your route is something like /profile or /users/profile
        // You should replace '/profile' with your actual route for the ProfileController's index method.
        // If your route requires authentication, you'd use ->actingAs($user) here.
        // Example: $response = $this->actingAs($user)->get('/profile');
        $response = $this->get('/profile'); // Adjust this to your actual route

        // 3. Assert: Check the response
        $response->assertStatus(200); // Assert that the page loads successfully (HTTP 200 OK)

        // Assert that the view 'profile.index' is returned
        $response->assertViewIs('profile.index');

        // Assert that the view receives the 'user' variable
        $response->assertViewHas('user');

        // Assert that the 'user' variable passed to the view is the one we created
        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id === $user->id &&
                $viewUser->name === $user->name &&
                $viewUser->email === $user->email;
        });

        // Optionally, assert that specific text from the user's data is present on the page
        $response->assertSeeText($user->name);
        $response->assertSeeText($user->email);
    }

    /**
     * Test that the profile index handles the case where user ID 1 is not found.
     *
     * IMPORTANT: Your current controller method `User::findOrFail(1)->first()` will throw a ModelNotFoundException
     * if user with ID 1 does not exist. If you want to test graceful handling of no user,
     * you might need to modify your controller method to something like `User::find(1)` and then
     * check if the user exists, e.g., `User::find(1) ?? new User(['name' => 'Guest User'])`.
     *
     * As your current method uses findOrFail, this test expects an exception if no user with ID 1 exists.
     * To properly test this, we would expect a 404 response.
     */
    public function test_profile_index_returns_404_if_user_not_found()
    {
        // Act: Make a GET request to the profile index route
        // No user with ID 1 is created, so findOrFail will throw an exception.
        $response = $this->get('/profile'); // Adjust this to your actual route

        // Assert: Expect a 404 Not Found response due to findOrFail failing
        $response->assertStatus(404);
    }
}
