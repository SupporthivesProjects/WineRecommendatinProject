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
    public function edit(Template $template)
    {
        return view('admin.templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
    
        $template->update([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
        ]);
    
        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template updated successfully.');
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
        $this->mergeIdList($request, 'product_ids');

        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer',
        ]);

        // Only wines that exist (checked in one query, so large selections stay fast)
        $productIds = Product::whereIn('id', $request->product_ids)->pluck('id');

        $added = $template->products()->syncWithoutDetaching($productIds)['attached'];

        return back()->with(
            'success',
            count($added) . ' ' . (count($added) === 1 ? 'product' : 'products') . ' added successfully.'
        );
    }

    public function addCheeseProducts(Request $request,Template $template)
    {
        $this->mergeIdList($request, 'cheese_ids');

        $request->validate([
            'cheese_ids' => 'required|array',
            'cheese_ids.*' => 'integer',
        ]);

        $cheeseIds = CheeseProduct::whereIn('id', $request->cheese_ids)->pluck('id');

        $added = $template->cheeseProducts()->syncWithoutDetaching($cheeseIds)['attached'];

        return back()->with(
            'success',
            count($added) . ' cheese ' . (count($added) === 1 ? 'product' : 'products') . ' added successfully.'
        );
    }

    /**
     * The Add pop-ups send the ticked ids as one comma-separated field ("<field>_list"),
     * because one field per checkbox can exceed PHP's max_input_vars (1000) when hundreds
     * of wines are selected. Turn it back into the <field> array.
     */
    private function mergeIdList(Request $request, string $field): void
    {
        $list = $request->input($field . '_list');
        if (is_string($list) && trim($list) !== '') {
            $request->merge([
                $field => array_values(array_filter(array_map('trim', explode(',', $list)), 'strlen')),
            ]);
        }
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
