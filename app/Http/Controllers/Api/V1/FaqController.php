<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\FaqCollection;
use App\Http\Resources\Resource\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faq::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('faq_name', 'LIKE', '%' . $request->search . '%');
            })
            ->when($request->categories_id, function ($query) use ($request) {
                $query->where('categories_id', $request->categories_id);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('faq_status', $request->status);
            });

        if ($request->per_page) {
            $faqs = $query->paginate($request->per_page);
            $faqsResource = new FaqCollection($faqs);
        } else {
            $faqs = $query->get();
            $faqsResource = FaqResource::collection($faqs);
        }

        return $this->sendResponse($faqsResource, 'Get Data Successfully');
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
    public function show(Faq $faq)
    {
        $faqsResource = FaqResource::make($faq);
        return $this->sendResponse($faqsResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        //
    }

    public function restore($id)
    {
        Faq::withTrashed()->find($id)->restore();
        return $this->sendResponse([], 'Restore Data Successfully');
    }

    public function status(Faq $faq)
    {
        $faqs = Faq::find($faq->id);

        if ($faqs->faq_status == 'Y') {
            $faqs->faq_status = 'N';
        } else {
            $faqs->faq_status = 'Y';
        }

        $faqs->save();
        $faqsResource = FaqResource::make($faq);

        return $this->sendResponse($faqsResource, 'Update Status Successfully');
    }
}
