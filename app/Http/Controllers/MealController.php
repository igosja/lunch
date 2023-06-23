<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MealUpdateRequest;
use App\Models\Category;
use App\Models\Meal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class MealController
 * @package App\Http\Controllers
 */
class MealController extends AbstractController
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $sort = $request->query('sort', 'is_ordered');
        $order = 'ASC';
        if ('-' === $sort[0]) {
            $order = 'DESC';
            $sort = substr($sort, 1);
        }
        $query = Meal::query()
            ->where(['is_active' => true])
            ->whereBelongsTo(
                Category::query()
                    ->where(['is_active' => true])
                    ->get()
            );
        if ($request->query('id')) {
            $query->where('id', $request->query('id'));
        }
        if ($request->query('name')) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        $meals = $query
            ->orderBy($sort, $order)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('meal.index', [
            'meals' => $meals,
        ]);
    }

    /**
     * @param Meal $meal
     * @return Application|Factory|View
     */
    public function show(Meal $meal): View|Factory|Application
    {
        return view('meal.show', [
            'meal' => $meal,
        ]);
    }

    /**
     * @param Meal $meal
     * @return Application|Factory|View
     */
    public function edit(Meal $meal): View|Factory|Application
    {
        $categories = Category::query()->get();

        return view('meal.edit', [
            'categories' => $categories,
            'meal' => $meal,
        ]);
    }

    /**
     * @param MealUpdateRequest $request
     * @param Meal $meal
     * @return RedirectResponse
     */
    public function update(MealUpdateRequest $request, Meal $meal): RedirectResponse
    {
        $data = $request->validated();

        $meal->category_id = $data['category_id'];
        $meal->name = $data['name'];
        $meal->is_active = $data['is_active'];
        $meal->is_ordered = $data['is_ordered'];
        $meal->is_favorite = $data['is_favorite'];
        if (!$meal->save()) {
            return back();
        }

        return redirect()->route('meals.show', [
            'meal' => $meal,
        ]);
    }
}
