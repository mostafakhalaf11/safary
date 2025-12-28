<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $query = User::where('is_deleted', false)
            ->where('is_active', true)
            ->where('type', '!=', 'super-admin'); // Exclude super-admin users

        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request()->get('name') . '%');
        }
        if (request()->has('email')) {
            $query->where('email', 'like', '%' . request()->get('email') . '%');
        }
        if (request()->has('phone_number')) {
            $query->where('phone_number', 'like', '%' . request()->get('phone_number') . '%');
        }
        if (request()->has('type')) {
            $query->where('type', request()->get('type'));
        }
        $users = $query->paginate(25);

        if (!$users || $users->isEmpty()) {
            return $this->error('No users found', 404);
        }

        return $this->success($users);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'required|string|max:15|unique:users',
                'type' => 'required|string|in:customer,driver',
                'password' => 'required|string|min:8|confirmed',
                'profile_photo_path' => 'nullable|string|max:255',
                'is_verified' => 'boolean',
                'is_active' => 'boolean',
                'is_deleted' => 'boolean',
                'email_verified_at' => 'nullable|date',
            ]);
            $data['password'] = Hash::make($data['password']);

            DB::beginTransaction();
            $user = User::create($data);
            $role = $data['type'] === 'driver' ? 'driver' : 'customer';
            $user->assignRole($role);
            DB::commit();

            return $this->success($user, 'User created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('User creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Check if user exists
        if (! $user || $user->is_deleted) {
            return $this->error('User not found', 404);
        }
        // Check if user is deleted or inactive
        if (!$user->is_active) {
            return $this->error('Your account is disabled. Please contact support.', 403);
        }
        return $this->success($user);
    }
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        if (! $user || $user->is_deleted) {
            return $this->error('User not found', 404);
        }
        try {
            $data = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => [
                    'sometimes',
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                'phone_number' => [
                    'sometimes',
                    'string',
                    'max:15',
                    Rule::unique('users', 'phone_number')->ignore($user->id),
                ],
                'type' => 'sometimes|string|in:customer,driver',
                'password' => 'sometimes|string|min:8|confirmed',
                'profile_photo_path' => 'nullable|string|max:255',
                'is_verified' => 'boolean',
                'is_active' => 'boolean',
                'is_deleted' => 'boolean',
                'email_verified_at' => 'nullable|date',
            ]);

            if ($request->has('name')) {
                $data['name'] = $request->name;
            }
            if ($request->has('email')) {
                $data['email'] = $request->email;
            }
            if ($request->has('password')) {
                $data['password'] = Hash::make($request->password);
            }
            DB::beginTransaction();
            $user->update($data);
            // Update role if type is changed
            if ($request->has('type')) {
                $role = $data['type'] === 'driver' ? 'driver' : 'customer';
                $user->syncRoles([$role]);
            }
            DB::commit();

            return $this->success($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Validation failed: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if (! $user || $user->is_deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }
        try {
            DB::beginTransaction();
            // Soft delete the user
            $user->update([
                'is_active' => false,
                'is_deleted' => true,
            ]);
            // detach all roles
            $user->roles()->detach();
            // permissions detachment if any
            $user->permissions()->detach();
            DB::commit();
            return $this->success($user, 'User soft deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('User deletion failed: ' . $e->getMessage(), 500);
        }
    }
}
