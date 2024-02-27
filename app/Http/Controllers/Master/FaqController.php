<?php

namespace App\Http\Controllers\Master;

use App\DataTables\FaqDataTable;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Http\Resources\Resource\FaqResource;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FaqDataTable $datatables)
    {
        $data['pageTitle'] = 'Faq List';
        return $datatables->render('master.faqs.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request)
    {
        $faqs = Faq::create($request->all());

        $faqResource = FaqResource::make($faqs);

        return $this->sendResponse($faqResource, 'Insert Data Successfully');
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
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq->faq_name = $request->faq_name;
        $faq->faq_content = $request->faq_content;
        $faq->categories_id = $request->categories_id;
        $faq->save();

        return $this->sendResponse($faq, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
