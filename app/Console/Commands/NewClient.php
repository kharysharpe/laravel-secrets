<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Crypto\Rsa\KeyPair;

class NewClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new client';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Client\'s name');
        $email = $this->ask('Client\'s email address?');
        $password = $this->secret('Enter a password for the client');

        $this->line('Generating private and public keys...');
        $this->newLine(1);

        [$privateKey, $publicKey] = (new KeyPair())->generate();

        $user = User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(
                    $password,
                    [
                        'rounds' => 16,
                    ]
                ),
                'private_key' => $privateKey,
            ]
        );

        $token = $user->createToken(Str::slug($name));

        $this->line('Public key (please store, this will not be shown again):');
        $this->newLine(1);
        $this->info($publicKey);

        $this->line('Token (please store, this will not be shown again):');
        $this->info($token->plainTextToken);

        return Command::SUCCESS;
    }
}
