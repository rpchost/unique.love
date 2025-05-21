<?php

namespace App\Repositories\Interfaces;

interface UserProfileRepositoryInterface
{
    public function find($id);
    public function add(array $data);
    public function edit($id, array $data);
    public function delete($id);
}
