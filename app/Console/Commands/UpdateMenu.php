<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Meal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\CurlException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the menu';

    /**
     * @var Dom $dom
     */
    private $dom;

    /**
     * @var array $categories
     */
    private array $categories;

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws NotLoadedException
     * @throws StrictException
     */
    public function handle(): int
    {
        $this->info('Start command');

        $this->loadFile();
        $this->processCategories();
        $this->processMeals();

        $this->info('All done');

        return CommandAlias::SUCCESS;
    }

    /**
     * @return void
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws StrictException|CurlException
     */
    private function loadFile(): void
    {
        $this->info('Start file loading');

        $result = Http::withHeaders([
            'cookie' => '_gid=GA1.3.714885193.1682660789; SID=j95bgcl7tp9cstsqvrpch88be3; 3a8fc645a90f01c9b2e4c2ff48e13aab=cb84d9751e969afbffb44003f8e3e09fcebd9231a:4:{i:0;s:5:"17514";i:1;s:19:"Бойко+Ігор";i:2;i:28800;i:3;a:0:{}}; _ga_6QSKKWZLH0=GS1.1.1682666929.3.1.1682668863.60.0.0; _ga_ERTB6DCPBF=GS1.1.1682666929.9.1.1682668863.60.0.0; _ga=GA1.3.781830796.1668579372; _gat_gtag_UA_47221429_3=1'
        ])->get('https://orders.gudfood.com.ua/order');

        $resultBody = $result->body();
        if (strpos($resultBody, 'login')) {
            $this->error('Error auth');
            exit;
        }

        $this->dom = new Dom;
        $this->dom->load($resultBody);

        $this->info('File loading done');
    }

    /**
     * @return void
     * @throws ChildNotFoundException
     * @throws NotLoadedException
     */
    private function processCategories(): void
    {
        $this->info('Start categories');

        $navTabs = $this->dom->find('.nav-tabs')[0];
        $aList = $navTabs->find('a');
        foreach ($aList as $a) {
            $text = $a->text;

            $category = Category::query()
                ->where('name', $text)
                ->first();
            if (!$category) {
                $category = new Category();
                $category->name = $text;
                $category->is_active = true;
                $category->save();
            }

            $this->categories[$a->href] = $category->id;
        }

        $this->info('Categories done. Count: ' . count($this->categories));
    }

    /**
     * @return void
     * @throws ChildNotFoundException
     * @throws NotLoadedException
     */
    private function processMeals(): void
    {
        $this->info('Start meals');

        $count = 0;

        Meal::query()->update(['is_active' => false]);

        $tabList = $this->dom->find('.tab-pane');
        foreach ($tabList as $tab) {
            $categoryId = '#' . $tab->id;

            $headingList = $tab->find('.media-heading');
            foreach ($headingList as $heading) {
                $text = $heading->text;

                $meal = Meal::query()
                    ->where('name', $text)
                    ->first();
                if (!$meal) {
                    $meal = new Meal();
                    $meal->name = $text;
                    $meal->category_id = $this->categories[$categoryId];
                    $meal->is_ordered = false;
                    $meal->is_favorite = false;
                    $meal->is_unsuitable = false;
                }

                $meal->is_active = true;
                $meal->save();

                $count++;
            }
        }

        $this->info('Meals done. Count:' . $count);
    }
}
