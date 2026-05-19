<?php

namespace App\Http\Controllers;

class DemoController extends Controller
{
    public function index()
    {
        return view('demoindex');
    }

    public function index2()
    {
        $data = "Trần Anh Kiệt";
        return view('demoindex2', compact('data'));
    }
    public function index3()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'name' => 'Sản phẩm 1',
                'price' => 240000
            ]
        ]);
    }
    public function index4($id)
    {
        $data = "Trần Anh Kiệt";
        return view('demoindex4', compact('data', 'id'));
    }
    public function index5($id = null)
    {
        $data = "Trần Anh Kiệt";
        dump($id);
        return view('demoindex5', compact('data', 'id'));
    }
    public function index6($param1, $param2)
    {
        $data = "Trần Anh Kiệt";
        return view('demoindex6', compact('data', 'param1', 'param2'));
    }
}