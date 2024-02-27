<?php

namespace App\Http\Controllers\Master;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Http\Resources\Resource\SliderResource;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $datatables)
    {
        $data['pageTitle'] = 'Slider List';
        return $datatables->render('master.sliders.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        if ($request->hasFile('slider_featureimage') && $request->file('slider_featureimage')->isValid()) {
            $slider_featureimage = $request->file('slider_featureimage')->store('uploads', 'public');
        } else {
            $slider_featureimage = null;
        }

        $defaultValue = [
            'slider_featureimage' => $slider_featureimage,
        ];

        $sliders = Slider::create(array_merge($request->all(), $defaultValue));
        $sliderResource = SliderResource::make($sliders);

        return $this->sendResponse($sliderResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        $slidersResource = SliderResource::make($slider);

        return $this->sendResponse($slidersResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $slider->slider_name = $request->slider_name;
        $slider->slider_link = $request->slider_link;
        $slider->slider_group = $request->slider_group;

        if ($request->hasFile('slider_featureimage') && $request->file('slider_featureimage')->isValid()) {
            if ($slider->slider_featureimage != null || $slider->slider_featureimage != '') {
                Storage::disk('public')->delete($slider->slider_featureimage);
            }

            $paths = $request->file('slider_featureimage')->store('uploads', 'public');
            $slider->slider_featureimage = $paths;
        }

        $slider->save();

        $slidersResource = SliderResource::make($slider);

        return $this->sendResponse($slidersResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
