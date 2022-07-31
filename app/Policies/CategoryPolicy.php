<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any Categories.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return  $user->hasPermissionTo('Categories list');
    }

    /**
     * Determine whether the user can view the Category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function show(User $user, Category $category)
    {
        return  $user->hasPermissionTo('Categories show');
    }

    /**
     * Determine whether the user can create Categories.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return  $user->hasPermissionTo('Categories create');
    }

    /**
     * Determine whether the user can update the Category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        return  $user->hasPermissionTo('Categories update');
    }

    /**
     * Determine whether the user can update the type of the Category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function updateType(User $user, Category $category)
    {
        return  $user->hasPermissionTo('Categories update');
    }

    /**
     * Determine whether the user can delete the Category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        return  $user->hasPermissionTo('Categories delete');
    }
}
