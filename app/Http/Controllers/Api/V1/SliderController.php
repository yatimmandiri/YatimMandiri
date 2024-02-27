<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\SliderCollection;
use App\Http\Resources\Resource\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Slider::query()
            ->when($request->group, function ($query) use ($request) {
                $query->where('slider_group', $request->group);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('slider_name', 'LIKE', '%' . $request->search . '%');
                $query->orWhere('slider_link', 'LIKE', '%' . $request->search . '%');
            });

        if ($request->per_page) {
            $slider = $query->paginate($request->per_page);
            $sliderResource = new SliderCollection($slider);
        } else {
            $slider = $query->get();
            $sliderResource = SliderResource::collection($slider);
        }

        return $this->sendResponse($sliderResource, 'Get Data Successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        $sliderResource = SliderResource::make($slider);

        return $this->sendResponse($sliderResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
