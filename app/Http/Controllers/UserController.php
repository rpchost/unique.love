<?php

namespace App\Http\Controllers;

use App\Services\UserSearchService;
use App\Services\UserProfileService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $profileService;
    protected $searchService;

    public function __construct(
        UserProfileService $profileService,
        UserSearchService $searchService
    ) {
        $this->profileService = $profileService;
        $this->searchService = $searchService;
    }

    public function search(Request $request)
    {
        $this->authorize('search', \App\Models\User::class);
        $criteria = $request->only(['name', 'email', 'gender', 'age_min', 'age_max']);
        $users = $this->searchService->searchUsers($criteria);

        return view('users.index', compact('users'));
    }

    // public function index()
    // {
    //     $users = $this->userService->getAllUsers();
    //     return view('users.index', compact('users'));
    // }

    // public function show($id)
    // {
    //     $user = $this->userService->getUserById($id);
    //     return view('users.show', compact('user'));
    // }

    // public function create()
    // {
    //     return view('users.create');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:8',
    //         'gender' => 'nullable|string',
    //         'age' => 'nullable|integer|min:18',
    //     ]);

    //     $user = $this->userService->addUser($validated);

    //     return redirect()->route('users.show', $user->id)
    //         ->with('success', 'User created successfully');
    // }

    // public function edit($id)
    // {
    //     $user = $this->userService->getUserById($id);
    //     return view('users.edit', compact('user'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $id,
    //         'password' => 'nullable|min:8',
    //         'gender' => 'nullable|string',
    //         'age' => 'nullable|integer|min:18',
    //     ]);

    //     $this->userService->editUser($id, $validated);

    //     return redirect()->route('users.show', $id)
    //         ->with('success', 'User updated successfully');
    // }

    // public function destroy($id)
    // {
    //     $this->userService->deleteUser($id);

    //     return redirect()->route('users.index')
    //         ->with('success', 'User deleted successfully');
    // }
}
