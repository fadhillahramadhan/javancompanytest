<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\User;
use Datatables;

class FamiliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Family::select('id', 'name', 'gender', 'created_at'))
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i'); // format date time
                })
                ->addColumn('action', 'families.families-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        $families = Family::with([
            'children' => function ($query) {
                $query->with('children');
            }
        ])->where('parent_id', null)->get();

        return view('families.families', compact('families'));
    }

    public function family()
    {
        $families = Family::all();

        return Response()->json($families);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productId = $request->id;

        $request->validate([
            'name' => 'required',
        ]);

        $product = Family::updateOrCreate(
            [
                'id' => $productId
            ],
            [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'gender' => $request->gender
            ]
        );

        return Response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $product  = Family::where($where)->first();

        return Response()->json($product);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Family::where('id', $request->id)->delete();

        return Response()->json($product);
    }
}
