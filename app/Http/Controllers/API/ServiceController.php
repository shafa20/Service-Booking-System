<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\ServiceService;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends BaseController
{
    protected $serviceService;
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    // List all services (for customer)
    public function index()
    {
        $services = $this->serviceService->list();
        return $this->sendResponse(ServiceResource::collection($services), 'Service list.');
    }

    // Admin: create service
    public function store(Request $request)
    {
        $service = $this->serviceService->create($request->all());
        return $this->sendResponse(new ServiceResource($service), 'Service created.');
    }

    // Admin: update service
    public function update(Request $request, Service $service)
    {
        $service = $this->serviceService->update($service, $request->all());
        return $this->sendResponse(new ServiceResource($service), 'Service updated.');
    }

    // Admin: delete service
    public function destroy(Service $service)
    {
        $this->serviceService->delete($service);
        return $this->sendResponse([], 'Service deleted.');
    }
}