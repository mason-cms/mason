<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial Mason CMS setup.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm("Are you sure you want to continue with the Mason CMS setup?")) {
            $this->generateAppKey();

            $this->line("Database setup");
            $this->setupDatabase();

            $this->line("Mail setup");
            $this->setupMail();

            $this->line("Storage setup");
            $this->setupStorage();

            $this->line("We have a few other questions");
            $this->setupMode();
            $this->setupMisc();

            $this->refreshConfig();

            $this->line("Site setup");
            $this->setupSiteInfo();

            $this->line("Setting up theme");
            $this->setupTheme();

            if ($this->confirm("Create a root user?")) {
                if ($this->createRootUser()) {
                    $this->info("Root user created successfully!");
                } else {
                    $this->error("Root user could not be created!");
                }
            }

            $this->line("User registration setup");
            $this->setupUserRegistration();

            $this->line("Database seeding");
            if ($this->seedDatabase()) {
                $this->info("Database seeded.");
            }

            $this->info("Mason CMS setup completed.");
        }

        return 0;
    }

    protected function generateAppKey()
    {
        if (! env('APP_KEY') || $this->confirm("Do you want to generate a new app key?")) {
            Artisan::call('key:generate');
            $this->info("New app key generated");
        }
    }

    protected function setupDatabase()
    {
        $vars = [
            'DB_CONNECTION' => "Database connection",
            'DB_HOST' => "Database host",
            'DB_PORT' => "Database port",
            'DB_DATABASE' => "Database name",
            'DB_USERNAME' => "Database username",
            'DB_PASSWORD' => "Database password",
        ];

        $env = [];

        foreach ($vars as $var => $label) {
            if ($value = $this->ask($label, env($var))) {
                $env[$var] = $value;
            }
        }

        $this->setEnv($env);
    }

    protected function setupMail()
    {
        $vars = [
            'MAIL_MAILER' => "Mailer",
            'MAIL_HOST' => "Mail host",
            'MAIL_PORT' => "Mail port",
            'MAIL_USERNAME' => "Mail username",
            'MAIL_PASSWORD' => "Mail password",
            'MAIL_ENCRYPTION' => "Mail encryption",
            'MAIL_FROM_ADDRESS' => "Mail from address",
            'MAIL_FROM_NAME' => "Mail from name",
        ];

        $env = [];

        foreach ($vars as $var => $label) {
            if ($value = $this->ask($label, env($var))) {
                $env[$var] = $value;
            }
        }

        $this->setEnv($env);
    }

    protected function setupStorage()
    {
        if ($filesystemDriver = $this->ask("Which filesystem driver do you want to use?", env('FILESYSTEM_DRIVER'))) {
            $this->setEnv(['FILESYSTEM_DRIVER' => $filesystemDriver]);

            switch ($filesystemDriver) {
                case 'local':
                    $this->line("Creating storage symlink...");
                    Artisan::call('storage:link');
                    $this->info("Symlink created");
                    break;
            }
        }
    }

    protected function setupMode()
    {
        if ($this->confirm("Is this site in production?", env('APP_ENV') === 'production')) {
            $this->setEnv([
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
            ]);
        } else {
            $this->setEnv([
                'APP_ENV' => 'local',
                'APP_DEBUG' => 'true',
            ]);
        }
    }

    protected function setupMisc()
    {
        $vars = [
            'APP_TIMEZONE' => "Please enter your timezone",
            'FONTAWESOME_KIT' => "Please enter your FontAwesome kit ID",
        ];

        $env = [];

        foreach ($vars as $var => $label) {
            if ($value = $this->ask($label, env($var))) {
                $env[$var] = $value;
            }
        }

        $this->setEnv($env);
    }

    protected function setupSiteInfo()
    {
        $settings = [
            'site_name' => "What will be the name of your site?",
            'site_description' => "Short description of your site",
            'site_url' => "What will be the URL of your site (include http(s))?",
            'site_default_locale' => "What is the default language of your site?",
            'site_theme' => "Select the theme you will be using for your site",
        ];

        foreach ($settings as $setting => $question) {
            if ($value = $this->ask($question, Setting::get($setting))) {
                Setting::set($setting, $value);
            }
        }
    }

    protected function setupTheme()
    {
        if ($theme = Setting::get('site_theme')) {
            if ( $output = shell_exec("composer require {$theme}") ) {
                $this->line($output);
            } else {
                $this->error("Could not setup theme.");
            }
        } else {
            $this->error("No theme to setup.");
        }
    }

    protected function createRootUser()
    {
        $rootUser = new User;
        $rootUser->is_root = true;
        $rootUser->name = $this->ask("What is your name?");
        $rootUser->email = $this->ask("What is your email?");
        $rootUser->password = Hash::make($this->askPassword());

        return $rootUser->save();
    }

    protected function askPassword()
    {
        $password = $this->secret("Please choose a password.");
        $passwordConfirmation = $this->secret("Please enter your password again.");

        if ($password === $passwordConfirmation) {
            return $password;
        } else {
            $this->error("The passwords don't match. Please try again.");
            return $this->askPassword();
        }
    }

    protected function setupUserRegistration()
    {
        $allowUserRegistration = $this->confirm("Do you want to allow user registration?", Setting::get('allow_user_registration') ?? false);
        Setting::set('allow_user_registration', $allowUserRegistration);

        if ($allowUserRegistration) {
            $restrictUserEmailDomain = $this->confirm("Do you want to put a restriction on the users' email domain (eg: myorganization.com)?", Setting::get('restrict_user_email_domain') ?? false);
            Setting::set('restrict_user_email_domain', $restrictUserEmailDomain);

            if ($restrictUserEmailDomain) {
                $allowedUserEmailDomains = $this->ask("Please enter allowed domains (separated by a coma)", implode(', ', Setting::get('allowed_user_email_domains') ?? []));
                Setting::set('allowed_user_email_domains', array_map('trim', explode(',', $allowedUserEmailDomains)));
            }
        }
    }

    protected function seedDatabase()
    {
        $seeder = new DatabaseSeeder;
        $seeder->run();
        return true;
    }

    protected function setEnv($data = [])
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            foreach ($data as $key => $value) {
                file_put_contents($path, str_replace(
                    $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
                ));
            }
        }
    }

    protected function refreshConfig()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }
}
