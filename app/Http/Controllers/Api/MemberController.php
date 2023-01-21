<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\ImageUpload;
use App\Services\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
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
            $members = Member::with(['user','invoices'])->paginate($perPage);
            return $this->successResponse($members, 'Member Data get Successfully');
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
                    'name' => 'required|max:50',
                    'gender' => 'required',
                    'mobile_number' => 'required|unique:members,mobile_number|max:11',
                    'address' => 'nullable',
                    'image' => 'required',
                    'start_date' => 'nullable|date_format:Y-m-d',
                    'end_date' => 'nullable|date_format:Y-m-d',
                ]
            );
            if ($validateMember->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateMember->errors(),
                ], 422);
            }

            #image 
            if ($request->hasFile('image')) {
                $reImage = ImageUpload::upload($request, 'image', 'images/member');
            }

            $member = Member::create([
                'member_id' => uniqid(),
                'name' => $request->name,
                'gender' => $request->gender,
                'mobile_number' => $request->mobile_number,
                'blood' => $request->blood,
                'address' => $request->address,
                'image' => $reImage,
                'create_by' => auth()->id(),
            ]);

           
            $member->update([
                'member_id' => date('Y') . str_pad($member->id, 6, 0, STR_PAD_LEFT),
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
            $member = Member::with(['user','invoices'])->find($id);
            if (empty($member)) {
                return $this->errorResponse(null, 'This member is not found.', JsonResponse::HTTP_NOT_FOUND);
            }

            return $this->successResponse($member, 'member Deleted Successfully');

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
            $member = Member::find($id);
            if (!$member) {
                throw new Exception('This member is not found!');
            }

            $validateMember = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:50',
                    'gender' => 'required',
                    'mobile_number' => 'required|max:11|unique:members,mobile_number,' . $id,
                    'address' => 'nullable',
                    'start_date' => 'nullable|date_format:Y-m-d',
                    'end_date' => 'nullable|date_format:Y-m-d',
                ]
            );
            if ($validateMember->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateMember->errors(),
                ], 422);
            }


            #image 
            $old_image_path_exist = 'images/member/'.$member->image;
            if($request->hasFile('image')){
                if(File::exists($old_image_path_exist)){
                    File::delete($old_image_path_exist);
                }
                $reImage =  ImageUpload::upload($request,'image','images/member');
            }

            $member->update([
                'name' => $request->name,
                'gender' => $request->gender,
                'mobile_number' => $request->mobile_number,
                'blood' => $request->blood,
                'address' => $request->address,
                'image' => $reImage ? $reImage : $member->image,
                'create_by' => auth()->id(),
            ]);

            return $this->successResponse($member, 'Member Updated Successfully', JsonResponse::HTTP_CREATED);

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
            $member = Member::find($id);
            if (empty($member)) {
                return $this->errorResponse(null, 'This member is not found.', JsonResponse::HTTP_NOT_FOUND);
            }

            $deleted = $member->delete();

            if (!$deleted) {
                return $this->errorResponse(null, 'Failed To delete Member.', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->successResponse($member, 'member Deleted Successfully');

        } catch (Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}