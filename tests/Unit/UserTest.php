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

        $this->get(route('users.index'))
        ->assertResponseStatus(403);          
        // ->see('Log in');
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


   
    /**
     * Test if user admin can see the user list       
     * @test
     */
    public function verify_if_user_admin_can_see_user_list() {
        $permission_name = "user_access";
        $user = \App\Models\User::factory()->create();
        $role = \App\Models\Role::create(['title' => 'Admin']);
        $user->roles()->attach($role->id);
        $permission = \App\Models\Permission::create(['title' => $permission_name]);
        $role->permissions()->sync($permission->id); 

        $this->actingAs($user);

        $this->get(route('users.index'))
        ->see('Users List')           
        ->assertResponseStatus(200);
    }

     /**
     * Verify if user admin can be change the role of user
     * @test
     */
    public function verify_if_user_admin_can_change_the_role_of_user() {
        $permission_name = "user_access";
        $userAdmin = \App\Models\User::factory()->create();
        $role = \App\Models\Role::create(['title' => 'Admin']);
        $userAdmin->roles()->attach($role->id);
        $permission = \App\Models\Permission::create(['title' => $permission_name]);
        $role->permissions()->sync($permission->id); 

        $this->actingAs($userAdmin);

        $userToChangeRole = \App\Models\User::factory()->create();
        $role = \App\Models\Role::create(['title' => 'User']);
        $userToChangeRole->roles()->attach($role->id);

        $this->put(route('users.update',$userToChangeRole->id),['roles' => ['role_id' => $role->id]])
            ->assertResponseStatus(302);

        $this->assertEquals('User', $userToChangeRole->roles->first()->title);
    }    


    /**
     * Verify if user can be deleted for admin
     * @test
     */
    public function verify_if_user_can_be_deleted_for_admin() {
        $permission_name = "user_access";
        $userAdmin = \App\Models\User::factory()->create();
        $role = \App\Models\Role::create(['title' => 'Admin']);
        $userAdmin->roles()->attach($role->id);
        $permission = \App\Models\Permission::create(['title' => $permission_name]);
        $role->permissions()->sync($permission->id); 

        $this->actingAs($userAdmin);

        $userToDelete = \App\Models\User::factory()->create();
        $this->delete(route('users.destroy',$userToDelete->id))
        ->assertResponseStatus(302);

        $this->assertEquals(1, \App\Models\User::count());
    } 

 
    
    /**
     * Test if role admin can change user data
     * @test
     */
    public function verify_if_admin_can_to_change_user_data() {
        $permission_name = "user_access"; //access admin
        $user = \App\Models\User::factory()->create();
        $role = \App\Models\Role::create(['title' => 'Admin']);
        $user->roles()->attach($role->id);
        $permission = \App\Models\Permission::create(['title' => $permission_name]);
        $role->permissions()->sync($permission->id); 
        $this->actingAs($user);

        $newName = 'John Lennon';
        $userChangeName = \App\Models\User::factory()->create();
        $this->put(route('users.update',$userChangeName->id),
                [
                    'name' => $newName,
                    'email' => $userChangeName->email,
                    'password' => $userChangeName->password,
                    'roles' => ['role_id' => $role->id]
                ]);  

        $userChangedName = \App\Models\User::find($userChangeName->id);
        $this->assertEquals($newName, $userChangedName->name);
    }

    /*
    * The admin user can view access logs
    * @test
    */
    public function verify_if_only_admin_can_see_view_access_logs()
    {
        $permission_name = "session_access";
        $user = \App\Models\User::factory()->create();
        $role = \App\Models\Role::create(['title' => 'Admin']);
        $user->roles()->attach($role->id);
        $permission = \App\Models\Permission::create(['title' => $permission_name]);
        $role->permissions()->sync($permission->id); 

        $this->actingAs($user);

        $this->get(route('session.liveSessions'))
        ->see('Browser Sessions')           
        ->assertResponseStatus(200);
    }  
    
}