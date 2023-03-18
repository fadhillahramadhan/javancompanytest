<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Family;

// validate 
use Illuminate\Support\Facades\Validator;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        $family = Family::with([
            'children' => function ($query) {
                $query->with('children');
            }
        ])->where('parent_id', null);

        // if theres a name parameter in the request
        if ($request->name) {
            $family->where('name', 'like', '%' . $request->name . '%');
        }

        $results = $family->get();

        return response()->json([
            'status' => 'success',
            'data' => $results
        ]);
    }

    public function grandchildren(Request $request)
    {
        $family = Family::with([
            'children' => function ($query) {
                $query->with('children');
            }
        ])->where('parent_id', null);

        // if theres a name parameter in the request
        if ($request->name) {
            $family->where('name', 'like', '%' . $request->name . '%');
        }

        $results = $family->get();

        $grandchildren = [];

        foreach ($results as $result) {
            foreach ($result->children as $child) {
                foreach ($child->children as $grandchild) {
                    if ($request->gender) {
                        $gender = $request->gender;

                        if ($gender == 'L') {
                            if ($grandchild->gender == 'L') {
                                $grandchildren[] = $grandchild;
                            }
                        }

                        if ($gender == 'P') {
                            if ($grandchild->gender == 'P') {
                                $grandchildren[] = $grandchild;
                            }
                        }
                    } else {
                        $grandchildren[] = $grandchild;
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $grandchildren
        ]);
    }

    // create a new family member
    public function store(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required|in:L,P',
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }
        // if parent id exist then check if it is valid if not return error

        if ($request->parent_id) {
            $parent = Family::find($request->parent_id);

            if (!$parent) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid parent id'
                ]);
            }
        }

        $family = Family::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $family
        ]);
    }

    // update a family member

    public function update(Request $request, $id)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'nullable|in:L,P'
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        // if parent id exist then check if it is valid if not return error

        if ($request->parent_id) {
            $parent = Family::find($request->parent_id);

            if (!$parent) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid parent id'
                ]);
            }
        }

        // validate 

        $family = Family::find($id);

        if (!$family) {
            return response()->json([
                'status' => 'error',
                'message' => 'Family member not found'
            ]);
        }

        $family->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $family
        ]);
    }


    // delete a family member

    public function destroy($id)
    {
        $family = Family::find($id);

        if (!$family) {
            return response()->json([
                'status' => 'error',
                'message' => 'Family member not found'
            ]);
        }

        $family->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Family member deleted successfully'
        ]);
    }
}
