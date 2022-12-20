<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\RandomMenuService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class SiteController
 * @package App\Http\Controllers
 */
class SiteController extends AbstractController
{
    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $menu = (new RandomMenuService())->getRandomMenu();

        return view('site.index', [
            'menu' => $menu,
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function logout(Request $request): Redirector|RedirectResponse|Application
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('home');
    }
}
