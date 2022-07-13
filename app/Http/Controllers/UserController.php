<?php

namespace App\Http\Controllers;

use App\Filters\UserSearchFilter;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Contracts\DeletesUsers;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $entities = QueryBuilder::for(User::class)
            ->defaultSort('-id')
            ->allowedSorts([
                'id',
                'name',
                'email',
                'created_at',
            ])
            ->allowedFilters(['name', 'email', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render("Users/Index", [
            'entities' => $entities,
        ])->table(function (InertiaTable $table) {
            $table
                ->withGlobalSearch(__('Search') . "...")
                ->column(key: 'id', label: 'ID', sortable: true)
                ->column(key: 'name', label: __('Name'), sortable: true, searchable: true)
                ->column(key: 'email', label: __('Email'), sortable: true, searchable: true)
                ->column(key: 'created_at', label: __('Created'), sortable: true)
                ->column('actions', __('Actions'));
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render("Users/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        $input['email'] = mb_strtolower($input['email']);

        $validated = Validator::make($input, [
            'name' => "required|string|max:255",
            'email' => "required|email|max:255|unique:users",
            'password' => ['required', 'string', new Password],
        ])->validate();

        DB::transaction(static function () use ($validated) {
            $validated['password'] = Hash::make($validated['password']);

            tap(User::create($validated), static function (User $user) {
                $user->ownedTeams()->save(Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => explode(' ', $user->name, 2)[0] . "'s Team",
                    'personal_team' => true,
                ]));
                $user->forceFill([
                    'email_verified_at' => now(),
                ])->save();
            });
        });

        return Redirect::route("users.index")->with('success', "User created");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        return Inertia::render("Users/Edit", [
            'entity' => $user->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $input = $request->all();
        $input['email'] = mb_strtolower($input['email']);

        $validated = Validator::make($input, [
            'name' => "required|string|max:255",
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user),
            ],
        ])->validate();

        $user->forceFill($validated)->save();

        return Redirect::route("users.index")->with('success', "User updated");
    }

    /**
     * Change user password.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return RedirectResponse
     */
    public function changePassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', new Password],
        ]);

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return Redirect::route("users.index")->with("success", "Password changed successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        app(DeletesUsers::class)->delete($user);

        return Redirect::route("users.index")->with("success", "User deleted");
    }
}
