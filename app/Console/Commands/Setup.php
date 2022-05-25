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
        $this->clearCache();
        $this->setupDatabase();
        $this->setupMail();
        $this->setupStorage();
        $this->setupSite();
        $this->installTheme();
        $this->setupMode();
        $this->setupMisc();
        $this->clearCache();

        $this->migrate();
        $this->seed();

        if ($this->confirm("Create a root user?")) {
            if ($this->createRootUser()) {
                $this->info("Root user created successfully!");
            } else {
                $this->error("Root user could not be created!");
            }
        }

        $this->info("Mason CMS setup completed.");

        return 0;
    }

    protected function setupDatabase()
    {
        $this->info("Database setup...");

        $vars = [
            'DB_CONNECTION' => "Database connection",
            'DB_HOST' => "Database host",
            'DB_PORT' => "Database port",
            'DB_DATABASE' => "Database name",
            'DB_USERNAME' => "Database username",
            'DB_PASSWORD' => "Database password",
        ];

        foreach ($vars as $var => $label) {
            $this->setEnv([$var => $this->ask($label, env($var))]);
        }
    }

    protected function setupMail()
    {
        $this->info("Mail setup...");

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

        foreach ($vars as $var => $label) {
            $this->setEnv([$var => $this->ask($label, env($var))]);
        }
    }

    protected function setupStorage()
    {
        $this->info("Storage setup...");

        if ($filesystemDriver = $this->ask("Which filesystem driver do you want to use?", env('FILESYSTEM_DRIVER'))) {
            $this->setEnv(['FILESYSTEM_DRIVER' => $filesystemDriver]);

            switch ($filesystemDriver) {
                case 'local':
                    $this->info("Creating storage symlink...");
                    Artisan::call('storage:link');
                    break;
            }
        }
    }

    protected function setupSite()
    {
        $this->info("Site setup...");

        $this->setEnv([
            'SITE_NAME' => $this->ask("What will be the name of your site?", env('SITE_NAME')),
            'SITE_DESCRIPTION' => $this->ask("Short description of your site", env('SITE_DESCRIPTION')),
            'SITE_URL' => $this->ask("What will be the URL of your site (include http(s))?", env('SITE_URL')),
        ]);

        $this->setEnv([
            'SITE_ALLOW_USER_REGISTRATION' => $this->confirm("Do you want to allow user registration?", env('SITE_ALLOW_USER_REGISTRATION', false)),
        ]);

        if (env('SITE_ALLOW_USER_REGISTRATION')) {
            $this->setEnv([
                'SITE_RESTRICT_USER_EMAIL_DOMAIN' => $this->confirm("Do you want to put a restriction on the users' email domain (eg: myorganization.com)?", env('SITE_RESTRICT_USER_EMAIL_DOMAIN', false)),
            ]);

            if (env('SITE_RESTRICT_USER_EMAIL_DOMAIN')) {
                $this->setEnv([
                    'SITE_ALLOWED_USER_EMAIL_DOMAINS' => $this->ask("Please enter allowed domains (separated by a coma)", env('SITE_ALLOWED_USER_EMAIL_DOMAINS')),
                ]);
            }
        }
    }

    protected function installTheme()
    {
        $this->info("Installing theme...");

        if ($theme = env('SITE_THEME')) {
            if ( $output = shell_exec("composer require {$theme}") ) {
                $this->line($output);
            } else {
                $this->error("Could not install theme.");
            }
        } else {
            $this->error("No theme to install.");
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
            'APP_TIMEZONE' => "Please enter your timezone (choose from: https://www.php.net/manual/en/timezones.php)",
            'FONTAWESOME_KIT' => "Please enter your FontAwesome kit ID",
        ];

        foreach ($vars as $var => $label) {
            $this->setEnv([$var => $this->ask($label, env($var))]);
        }
    }

    protected function migrate()
    {
        $this->info("Running database migrations...");
        Artisan::call('migrate --force');
    }

    protected function seed()
    {
        $this->info("Seeding database...");
        Artisan::call('db:seed --force');
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

    protected function clearCache()
    {
        Artisan::call('config:clear');
    }

    protected function setEnv($data = [])
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            foreach ($data as $key => $value) {
                if (str_contains($value, " ")) {
                    $value = '"' . $value . '"';
                }

                file_put_contents($path, str_replace(
                    $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
                ));
            }
        }
    }
}
