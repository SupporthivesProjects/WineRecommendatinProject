<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\TemplateController;
use App\Models\CheeseProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Template;



class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::latest()->get();

        return view(
            'admin.templates.index',
            compact('templates')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Template::create($validated);

        return redirect()
            ->route('admin.templates.index')
            ->with(
                'success',
                'Template created successfully.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        $template->load([
            'products',
            'cheeseProducts'
        ]);

        $templateProducts = $template->products()->get();
        $assignedProductIds = $templateProducts->pluck('id');
        $availableProducts = Product::whereNotIn('id',$assignedProductIds)
            ->orderBy('wine_name')
            ->get();

        $templateCheeseProducts = $template->cheeseProducts()->get();
        $assignedCheeseIds = $templateCheeseProducts->pluck('id');
        $availableCheeses = CheeseProduct::whereNotIn('id',$assignedCheeseIds)
            ->orderBy('name')
            ->get();


        return view(
            'admin.templates.show',
            compact(
                'template',
                'templateProducts',
                'availableProducts',
                'templateCheeseProducts',
                'availableCheeses'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addProducts(Request $request,Template $template)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);
    
        $template->products()
            ->syncWithoutDetaching(
                $request->product_ids
            );
    
        return back()->with(
            'success',
            'Products added successfully.'
        );
    }

    public function addCheeseProducts(Request $request,Template $template)
    {
        $request->validate([
            'cheese_ids' => 'required|array',
            'cheese_ids.*' => 'exists:cheese_products,id',
        ]);
    
        $template->cheeseProducts()
            ->syncWithoutDetaching(
                $request->cheese_ids
            );
    
        return back()->with(
            'success',
            'Cheese products added successfully.'
        );
    }

    public function removeProduct(Template $template,Product $product)
    {
        $template->products()->detach(
            $product->id
        );
    
        return back()->with('success','Product removed successfully.');
    }


    public function removeCheeseProduct(Template $template,CheeseProduct $cheese)
    {
        $template->cheeseProducts()->detach(
            $cheese->id
        );
    
        return back()->with(
            'success',
            'Cheese product removed successfully.'
        );
    }

}
