<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 8/15/2019
 * Time: 9:08 AM
 */

namespace JoyBusinessAcademy\Profile\Repositories;


interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}