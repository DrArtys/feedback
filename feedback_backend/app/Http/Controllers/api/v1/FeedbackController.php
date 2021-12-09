<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Factories\FeedbackFactory;
use App\Models\Feedback;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // * get all params from request
        $params = $request->all();
        // * validate params by Model rules
        $validator = Validator::make($params, Feedback::$rules);
        // * check validator fails
        if (!$validator->fails()) {
            try {
                // * create FeedBackFactory instance and send into chosen db
                $feedbackFactory = new FeedbackFactory();
                $result = $feedbackFactory->sendTo(env('CURRENT_DB'), $validator->validated());
                // $result = $feedbackFactory->sendTo('mysql', $validator->validated());
                // $result = $feedbackFactory->sendTo('mysql2', $validator->validated());
            } catch (Exception $e) {
                // * return error incorrect db type
                return response()->json(['errors' => $e->getMessage()]);
            }
            return response()->json($result);
        }
        // * return validator errors
        return response()->json(['errors' => $validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
