<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/5/2019
 * Time: 8:51 AM
 */

namespace JoyBusinessAcademy\Profile\Repositories;


class RegionRepository extends BaseRepository
{
    protected $request;

    public function __construct()
    {
        $model = config('jba-profile.models.region');

        parent::__construct(new $model());
    }

    public function all()
    {
        return $this->model->with('children')->get();
    }

    public function getAllSubRegions()
    {
        return $this->model->whereNotNull('parent_id')->get();
    }
}