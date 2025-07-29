<?php
namespace App\Services;

use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;


class ServiceService
{
    public function list()
    {
        return Service::where('status', 'active')->get();
    }

    public function create($data)
    {
        return Service::create($data);
    }

    public function update(Service $service, $data)
    {
        $service->update($data);
        return $service;
    }

    public function delete(Service $service)
    {
        $service->delete();
    }

    
}
