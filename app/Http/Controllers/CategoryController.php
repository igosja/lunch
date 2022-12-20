<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class v
 * @package App\Http\Controllers
 */
class CategoryController extends AbstractController
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $sort = $request->query('sort', 'id');
        $order = 'ASC';
        if ('-' === $sort[0]) {
            $order = 'DESC';
            $sort = substr($sort, 1);
        }
        $query = Category::query()
            ->where(['is_active' => true]);
        if ($request->query('id')) {
            $query->where('id', $request->query('id'));
        }
        if ($request->query('name')) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        $categories = $query
            ->orderBy($sort, $order)
            ->paginate(20);

        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function show(Category $category): View|Factory|Application
    {
        return view('category.show', [
            'category' => $category,
        ]);
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category): View|Factory|Application
    {
        return view('category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        $category->name = $data['name'];
        $category->is_active = $data['is_active'];
        if (!$category->save()) {
            return back();
        }

        return redirect()->route('categories.show', [
            'category' => $category,
        ]);
    }
}
