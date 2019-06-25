<?php

namespace App\Observers;

use App\Models\Article;

class ArticleObserver
{
    /**
     * Handle the article "creating" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function creating(Article $article)
    {
        $article->slug = str_slug($article->title);
    }

    /**
     * Handle the article "updating" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function updating(Article $article)
    {
        $article->slug = str_slug($article->title);
    }

    /**
     * Handle the article "deleting" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function deleting(Article $article)
    {
        $article->comments()->delete();
    }
}
