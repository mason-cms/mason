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
        $this->setupApp();
        $this->setupSite();
        $this->clearCache();
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

        $this->setEnv([
            'DB_CONNECTION' => $this->ask("Database connection", env('DB_CONNECTION')),
            'DB_HOST' => $this->ask("Database host", env('DB_HOST')),
            'DB_PORT' => $this->ask("Database port", env('DB_PORT')),
            'DB_DATABASE' => $this->ask("Database name", env('DB_DATABASE')),
            'DB_USERNAME' => $this->ask("Database username", env('DB_USERNAME')),
            'DB_PASSWORD' => $this->quote($this->ask("Database password", env('DB_PASSWORD'))),
        ]);
    }

    protected function setupMail()
    {
        $this->info("Mail setup...");

        $this->setEnv([
            'MAIL_MAILER' => $this->ask("Mailer", env('MAIL_MAILER')),
            'MAIL_HOST' => $this->ask("Mail host", env('MAIL_HOST')),
            'MAIL_PORT' => $this->ask("Mail port", env('MAIL_PORT')),
            'MAIL_USERNAME' => $this->ask("Mail username", env('MAIL_USERNAME')),
            'MAIL_PASSWORD' => $this->quote($this->ask("Mail password", env('MAIL_PASSWORD'))),
            'MAIL_ENCRYPTION' => $this->ask("Mail encryption", env('MAIL_ENCRYPTION')),
            'MAIL_FROM_ADDRESS' => $this->ask("Mail from address", env('MAIL_FROM_ADDRESS')),
            'MAIL_FROM_NAME' => $this->ask("Mail from name", env('MAIL_FROM_NAME')),
        ]);
    }

    protected function setupStorage()
    {
        $this->info("Storage setup...");

        if ($filesystemDriver = $this->ask("Which filesystem driver do you want to use?", env('FILESYSTEM_DRIVER'))) {
            $this->setEnv(['FILESYSTEM_DRIVER' => $filesystemDriver]);

            switch ($filesystemDriver) {
                case 'local':
                    $this->info("Creating storage symlink...");
                    Artisan::call('storage:link', [], $this->getOutput());
                    break;
            }
        }
    }

    protected function setupApp()
    {
        $this->info("App setup...");

        $this->setEnv([
            'APP_URL' => $this->ask("What will be the URL of your site (include http(s))?", env('APP_URL')),
            'APP_TIMEZONE' => $this->ask("Please enter your timezone (choose from: https://www.php.net/manual/en/timezones.php)", env('APP_TIMEZONE')),
        ]);
    }

    protected function setupSite()
    {
        $this->info("Site setup...");

        $this->setEnv([
            'SITE_NAME' => $this->quote($this->ask("What will be the name of your site?", env('SITE_NAME'))),
            'SITE_DESCRIPTION' => $this->quote($this->ask("Short description of your site", env('SITE_DESCRIPTION'))),
            'SITE_THEME' => $this->ask("Which theme do you want to use for your site?", env('SITE_THEME')),
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
                    'SITE_ALLOWED_USER_EMAIL_DOMAINS' => $this->quote($this->ask("Please enter allowed domains (separated by a coma)", env('SITE_ALLOWED_USER_EMAIL_DOMAINS'))),
                ]);
            }
        }
    }

    protected function installTheme()
    {
        $this->info("Installing theme...");

        if ($theme = env('SITE_THEME')) {
            Artisan::call("mason:theme:install --theme={$theme}", [], $this->getOutput());
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
        $this->setEnv([
            'FONTAWESOME_KIT' => $this->ask("Please enter your FontAwesome kit ID", env('FONTAWESOME_KIT')),
        ]);
    }

    protected function migrate()
    {
        $this->info("Running database migrations...");
        Artisan::call('migrate --force', [], $this->getOutput());
    }

    protected function seed()
    {
        $this->info("Seeding database...");
        Artisan::call('db:seed --force', [], $this->getOutput());
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
        Artisan::call('config:clear', [], $this->getOutput());
    }

    protected function setEnv($data = [], $forceQuote = false)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            foreach ($data as $key => $value) {
                if ($forceQuote || str_contains($value, " ")) {
                    $value = $this->quote($value);
                }

                file_put_contents($path, str_replace(
                    $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
                ));
            }
        }
    }

    protected function quote($string)
    {
        return strlen($string) > 0 ? '"' . $string . '"' : "";
    }
}
