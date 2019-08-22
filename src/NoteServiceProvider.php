<?php

namespace Note;

use Illuminate\Support\ServiceProvider;

class NoteServiceProvider extends ServiceProvider {
    /**
     * ----------------------------------------------------
     * define the boot method and the register method here
     * ----------------------------------------------------
     * @return void
     */
    public function boot() {
        /**
         * ------------------------------
         * load the migrations here
         * ------------------------------
         */
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        /**
         * ---------------------------
         * load configuration file
         * ---------------------------
         */
        $this->mergeConfigFrom(
            __DIR__ . '/config/note.php', 'notification'
        );

        /**
         * ---------------------------
         * publishing the config file
         * ---------------------------
         */
        $this->publishes([
            __DIR__ . '/config/note.php' => config_path('note.php'),
        ], 'config');

        /**
         * ---------------------------------------------
         * publish the migrations to the developer side
         * here
         * ---------------------------------------------
         */
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'migrations');


        /**
         * -------------------
         * publish model here
         * -------------------
         */
        $this->publishes([
            __DIR__ . '/Models' => base_path('app'),
        ], 'model');
    }


    /**
     * ------------------------------
     * Register here for any service
     * like the facades here
     * ------------------------------
     * @return void
     */
    public function register() {
        $this->app->bind('Note', function () {
            return new Note();
        });
    }
}
