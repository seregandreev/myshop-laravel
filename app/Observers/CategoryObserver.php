<?php

namespace App\Observers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $user = Auth::user();
        $timeNow = Carbon::now()->toDateTimeString();
        Log::info("{$timeNow}: {$user->name}, CATEGORY_CREATED {$category->name}");
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        $user = Auth::user();
        $timeNow = Carbon::now()->toDateTimeString();
        $selectedUpdate = implode(',', $category->getDirty());
        //dd($selectedUpdate);
        Log::info("{$timeNow}: {$user->name}, CATEGORY_UPDATED {$selectedUpdate}");
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $user = Auth::user();
        $timeNow = Carbon::now()->toDateTimeString();
        Log::info("{$timeNow}: {$user->name}, CATEGORY_DELETED {$category->name}");
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}