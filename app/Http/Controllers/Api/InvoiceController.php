<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->page ? $request->page : 10;
        try {
            $data = Invoice::with('user', 'member')->paginate($perPage);
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
        try {
            $validateMember = Validator::make(
                $request->all(),
                [
                    'member_id' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'amount' => 'required',
                    'fee_type' => 'required',
                    'payment_type' => 'required',

                ]
            );
            if ($validateMember->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateMember->errors(),
                ], 422);
            }

            $invoice = Invoice::create([
                'member_id' => $request->member_id,
                'create_by' => auth()->id(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'amount' => $request->amount,
                'fee_type' => $request->fee_type,
                'payment_type' => $request->payment_type
            ]);

            return $this->successResponse($invoice, 'Invoice Add Successfully', JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
            $data = Invoice::with('member')->find($id);
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
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) {
                throw new Exception('This invoice is not found!');
            }

            $validateMember = Validator::make(
                $request->all(),
                [
                    'member_id' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'amount' => 'required',
                    'fee_type' => 'required',
                    'payment_type' => 'required',
                ]
            );
            if ($validateMember->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateMember->errors(),
                ], 422);
            }



            $invoice->update([
                'member_id' => $request->member_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'amount' => $request->amount,
                'fee_type' => $request->fee_type,
                'payment_type' => $request->payment_type
            ]);

            return $this->successResponse($invoice, 'invoice Updated Successfully', JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $invoice = Invoice::find($id);
            if (empty($invoice)) {
                return $this->errorResponse(null, 'This invoice is not found.', JsonResponse::HTTP_NOT_FOUND);
            }

            $deleted = $invoice->delete();

            if (!$deleted) {
                return $this->errorResponse(null, 'Failed To delete invoice.', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->successResponse($invoice, 'invoice Deleted Successfully');
        } catch (Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
