<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\UefaService;
use Illuminate\Contracts\View\View;

/**
 * Class SiteController
 * @package App\Http\Controllers
 */
class UefaController extends AbstractController
{
    /**
     * @param UefaService $service
     * @return View
     */
    public function index(UefaService $service): View
    {
        $data = $service->getData();

        return view('uefa.index', [
            'data' => $data,
        ]);
    }
}
