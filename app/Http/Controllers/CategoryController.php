<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Apply middleware to ensure only admins can manage categories
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::withCount('campaigns')
                             ->ordered()
                             ->paginate(20);
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Generate unique slug
        $validated['slug'] = Category::generateUniqueSlug($validated['name']);
        
        $category = Category::create($validated);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        $campaigns = $category->campaigns()
                             ->with(['user', 'categories'])
                             ->latest()
                             ->paginate(12);
        
        return view('admin.categories.show', compact('category', 'campaigns'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        // Check if category has campaigns
        if ($category->campaigns()->count() > 0) {
            return redirect()->route('admin.categories.index')
                           ->with('error', 'Cannot delete category that has campaigns. Please reassign campaigns first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category deleted successfully!');
    }

    /**
     * Toggle category active status
     */
    public function toggleStatus(Category $category)
    {
        $category->update([
            'is_active' => !$category->is_active
        ]);

        $status = $category->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
                        ->with('success', "Category {$status} successfully!");
    }
}
