<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase,InteractsWithDatabase,InteractsWithAuthentication;

    /**
     * Check if new user can be create
     * @test
     */
    public function check_if_new_user_can_be_create()
    {
        $user = \App\Models\User::factory()->create();

        $this->assertEquals(1, $user->id);
    }

    /**
     * Can create a roles
     * @test
     * @dataProvider getRoles
     * @param $role
     * @TODO to improve!
     */
    public function check_if_roles_can_be_create(int $role_id,string $role_title): void
    {

        \App\Models\Role::create(['title' => 'Admin']); //1
        \App\Models\Role::create(['title' => 'User']); //2

        $role = \App\Models\Role::find($role_id);

        $this->assertEquals($role_title, $role->title);
    }

    /**
     * Test if roles be assigned to users
     *
     * @dataProvider getRoles
     * @test
     */
    public function verify_if_roles_assigned_to_users (int $role_id, string $role_title) : void
    {
        $user = \App\Models\User::factory()->create();

        \App\Models\Role::create(['title' => 'Admin']); //1
        \App\Models\Role::create(['title' => 'User']); //2
        
        $user->roles()->attach($role_id);

        $this->assertEquals($role_title,$user->roles->first()->title);
    }

    /**
     * Data provider for roles
     * @return Array [role_id, role_title] 
     */
    public function getRoles() : array 
    {
        return [
            'admin'=> [1,'Admin'],
            'user'=> [2,'User']
        ];
    }

    /**
     * Test if user without role admin can see the user list    
     * @test   
     */
    public function verify_if_simple_user_dont_see_the_user_list() {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $this->get(route('users.index'))
        ->assertResponseStatus(403);    
    }


    /**
     * Test is route user.index is protected
     * @test
     */
    public function check_if_the_user_list_is_protected() {
        $this->assertGuest();

        $this->visit(route('users.index'))
        // ->assertResponseStatus(302);          
        ->see('Log in');
    }

    /**
     * Verify if user can be deleted for itself
     * @test
     */
    public function verify_if_user_can_be_deleted_for_itself() {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $this->delete(route('users.destroy',$user->id))
        ->assertResponseStatus(403);

        // $this->assertEquals(0, \App\Models\User::count());
    }

    
}