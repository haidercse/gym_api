<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Services\ResponseTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
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
            $data = Expense::paginate($perPage);
            return $this->successResponse($data, 'All Expense Data get Successfully');
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
                    'title' => 'required|max:200',
                    'amount' => 'required',
                    'date' => 'required',
                    'type' => 'required',

                ]
            );
            if ($validateMember->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateMember->errors(),
                ], 422);
            }

            $member = Expense::create([
                'title' => $request->title,
                'create_by' => auth()->id(),
                'date' => $request->date,
                'amount' => $request->amount,
                'type' => $request->type
            ]);

            return $this->successResponse($member, 'Member Add Successfully', JsonResponse::HTTP_CREATED);
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
            $expense = Expense::find($id);
            if (empty($member)) {
                return $this->errorResponse(null, 'This expense is not found.', JsonResponse::HTTP_NOT_FOUND);
            }

            return $this->successResponse($expense, 'expense get Successfully');
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
            $expense = Expense::find($id);
            if (!$expense) {
                throw new Exception('This Expense is not found!');
            }

            $validateMember = Validator::make(
                $request->all(),
                [
                    'title' => 'required|max:200',
                    'amount' => 'required',
                    'date' => 'required',
                    'type' => 'required',
                ]
            );
            if ($validateMember->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateMember->errors(),
                ], 422);
            }



            $expense->update([
                'title' => $request->title,
                'create_by' => auth()->id(),
                'date' => $request->date,
                'amount' => $request->amount,
                'type' => $request->type
            ]);

            return $this->successResponse($expense, 'Expense Updated Successfully', JsonResponse::HTTP_CREATED);
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
            $expense = Expense::find($id);
            if (empty($expense)) {
                return $this->errorResponse(null, 'This expense is not found.', JsonResponse::HTTP_NOT_FOUND);
            }

            $deleted = $expense->delete();

            if (!$deleted) {
                return $this->errorResponse(null, 'Failed To delete expense.', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->successResponse($expense, 'Expense Deleted Successfully');
        } catch (Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
