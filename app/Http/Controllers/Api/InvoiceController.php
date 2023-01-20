<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->page ? $request->page : 10;
        try {
            $data = Invoice::with(['user','member'])->paginate($perPage);
            return $this->successResponse($data, 'All Invoice Data get Successfully');
        } catch (Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Invoice::with(['user','member'])->find($id);
            if (empty($data)) {
                return $this->errorResponse(null, 'This data is not found.', JsonResponse::HTTP_NOT_FOUND);
            }

            return $this->successResponse($data, 'data Get Successfully');

        } catch (Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
