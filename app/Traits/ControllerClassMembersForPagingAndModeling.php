<?php

namespace App\Traits;

trait ControllerClassMembersForPagingAndModeling
{
    /**
     * Repository Instance Variable
     *
     * @var Repository
     */
    protected $repository;

    /**
     * Page Size For Get All
     *
     * @var Int
     */
    protected $per_page;

}