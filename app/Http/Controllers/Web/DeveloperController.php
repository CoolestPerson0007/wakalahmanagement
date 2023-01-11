<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Developer;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $migrated = Developer::select('migration')->get()->toArray();
        $migrated = array_column($migrated, 'migration');
        
        $migrations = glob(database_path('migrations/*'));
        $files = [];
        $unique = [];

        foreach($migrations as $file)
        {
            $filename = explode('/', $file);
            $filename = end($filename);
            $files[] = substr($filename, 0, -4);
        }

        if (count($migrated) < count($files))
        {
            $unique = array_diff($files, $migrated);
        }

        return view('developer.list', compact('unique'));
    }

    /**
     * Optimize framework bootstrap
     *
     * @return \Illuminate\Http\Response
     */
    public function optimize()
    {
        \Artisan::call('optimize');
        return redirect(route('developer.index'))->withSuccess(trans('dev.optimize_success'));
    }

    /**
     * Route cached
     *
     * @return \Illuminate\Http\Response
     */
    public function route()
    {
        \Artisan::call('route:cache');
        return redirect(route('developer.index'))->withSuccess(trans('dev.route_success'));
    }

    /**
     * Route clear
     *
     * @return \Illuminate\Http\Response
     */
    public function routeClear()
    {
        \Artisan::call('route:clear');
        return redirect(route('developer.index'))->withSuccess(trans('dev.route_clear_success'));
    }

    /**
     * Config cached
     *
     * @return \Illuminate\Http\Response
     */
    public function config()
    {
        \Artisan::call('config:cache');
        return redirect(route('developer.index'))->withSuccess(trans('dev.config_success'));
    }

    /**
     * Config clear
     *
     * @return \Illuminate\Http\Response
     */
    public function configClear()
    {
        \Artisan::call('config:clear');
        return redirect(route('developer.index'))->withSuccess(trans('dev.config_clear_success'));
    }

    /**
     * Debugbar clear
     *
     * @return \Illuminate\Http\Response
     */
    public function debugbar()
    {
        \Artisan::call('debugbar:clear');
        return redirect(route('developer.index'))->withSuccess(trans('dev.debugbar_success'));
    }

    /**
     * Migrate all pending migration.
     *
     * @return \Illuminate\Http\Response
     */
    public function migrate()
    {
        \Artisan::call('migrate', ['--force' => true]);
        return redirect(route('developer.index'))->withSuccess(trans('dev.migrate_success'));
    }

    /**
     * Rollback one step migration.
     *
     * @return \Illuminate\Http\Response
     */
    public function rollback()
    {
        \Artisan::call('migrate:rollback', ['--force' => true]);
        return redirect(route('developer.index'))->withSuccess(trans('dev.migrate_rollback_success'));
    }
}
