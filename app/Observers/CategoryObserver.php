<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the category "creating" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function creating(Category $category)
    {
        $category->slug = str_slug($category->name);
    }

    /**
     * Handle the category "updating" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function updating(Category $category)
    {
        $category->slug = str_slug($category->name);
    }

    /**
     * Handle the category "deleting" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function deleting(Category $category)
    {
        foreach ($category->articles()->get() as $article) {
            $article->delete();
        }
    }
}
