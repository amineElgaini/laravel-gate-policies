# Gates

A **Gate** is a simple authorization rule. Use it when the rule is small and not tied to one model too much

Example:

- only admins can access dashboard

### Where to define a gate

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post;
use App\Policies\PostPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('is-admin', function (User $user) {
            return $user->isAdmin();
        });
    }
}

```

### How to use a gate

```php
// first method
public function index()
{
    if (! Gate::allows('access-admin')) {
        abort(403);
    }

    return view('admin.dashboard');
}

// cleaner method
public function index()
{
    $this->authorize('access-admin');

    return view('admin.dashboard');
}

// in blade
@can('access-admin')
    <a href="/admin">Admin Panel</a>
@endcan
@cannot('access-admin')
    <p>You are not allowed.</p>
@endcannot
```

# Policies

A **Policy** is a class that organizes authorization logic for a specific model.

Use Policy when you have actions like:

- view post
- create post
- update post
- delete post

for a model like `Post`, `Course`, `Order`, etc.

So if Gates are simple rules, Policies are more structured and better for model-related authorization.

### How to define a policy

1- run this command: `php artisan make:policy PostPolicy --model=Post`

2- define rules:

```php
namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
```

3- register a policy: In modern Laravel versions, Laravel can often auto-discover policies if naming is standard.

### How to use a policy

```php
public function update(Request $request, Post $post)
{
    $this->authorize('update', $post);

    $post->update($request->all());

    return response()->json(['message' => 'Post updated']);
}

// blade
@can('update', $post)
    <button>Edit</button>
@endcan

@can('delete', $post)
    <button>Delete</button>
@endcan
```

## Additional Info

Common policy methods

```php
public function viewAny(User $user): bool
public function view(User $user, Post $post): bool
public function create(User $user): bool
public function update(User $user, Post $post): bool
public function delete(User $user, Post $post): bool
public function restore(User $user, Post $post): bool
public function forceDelete(User $user, Post $post): bool
```

full example policy

```php
namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'writer' || $user->role === 'admin';
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }
}
```

How to use gate and policies in middlware

```php
//gate
Route::get('/admin', function () {
    return 'Admin page';
})->middleware('can:access-admin');

// policy
Route::put('/posts/{post}', [PostController::class, 'update'])
    ->middleware('can:update,post');
```

different ways to use gates and policies

```php
// gate
if (Gate::allows('access-admin')) {
    // allowed
}
if (Gate::denies('access-admin')) {
    abort(403);
}
$this->authorize('access-admin');

// policy
Gate::allows('update', $post);
Gate::denies('update', $post);
$this->authorize('update', $post);
```
