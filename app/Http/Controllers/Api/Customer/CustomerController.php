<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Domain\Customer\Actions\CreateCustomerAction;
use Domain\Customer\Actions\DeleteCustomerAction;
use Domain\Customer\Actions\UpdateCustomerAction;
use Domain\Customer\DataTransferObjects\CustomerData;
use Domain\Customer\DataTransferObjects\CustomerIndexFilterData;
use Domain\Customer\Models\Customer;
use Domain\Customer\Resources\CustomerIndexResource;
use Domain\Customer\Resources\CustomerShowResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CustomerController extends Controller
{
    public function index(CustomerIndexFilterData $customerIndexFilterData): AnonymousResourceCollection
    {
        $customers = Customer::query()
            ->whereLikeBusinessNameOrDocumentNameOrContactName($customerIndexFilterData->search)
            ->paginate(20);

        return CustomerIndexResource::collection($customers);
    }

    public function store(CustomerData $customerData, CreateCustomerAction $createCustomerAction): JsonResponse
    {
        $createCustomerAction($customerData);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(Customer $customer): CustomerShowResource
    {
        return CustomerShowResource::make($customer);
    }

    public function update(Customer $customer, CustomerData $customerData, UpdateCustomerAction $updateCustomerAction): JsonResponse
    {
        $updateCustomerAction($customer, $customerData);

        return response()->json([], Response::HTTP_OK);
    }

    public function destroy(Customer $customer, DeleteCustomerAction $deleteCustomerAction): JsonResponse
    {
        $deleteCustomerAction($customer);

        return response()->json([], Response::HTTP_OK);
    }

}
