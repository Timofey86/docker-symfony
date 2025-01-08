<?php

namespace App\Users\Infrastructure\Console;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Attribute\AsCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function PHPUnit\Framework\assertNotEmpty;

#[AsCommand(name: 'app:users:create-user', description: 'Create a new user')]
class CreateUser extends Command
{
    public function __construct(
        private readonly UserRepository$userRepository,
        private readonly UserFactory $userFactory,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('Email',
        null,
        function (?string $input) {
            Assert::assertNotEmpty($input, 'Email is not valid');

            return $input;
        });

        $password = $io->ask('Password', null, function (?string $input) {
            Assert:assertNotEmpty($input, 'Password is required');
            return $input;
        }
        );

        $user = $this->userFactory->create($email, $password);
        $this->userRepository->add($user);

        return Command::SUCCESS;
//        $io = new SymfonyStyle($input, $output);
//
//        $email = $io->ask('Email', null, function (?string $input) {
//            $errors = $this->validator->validate($input, [
//                new Assert\NotBlank(['message' => 'Email is required']),
//                new Assert\Email(['message' => 'Email is not valid']),
//            ]);
//
//            if (count($errors) > 0) {
//                $io->error((string) $errors);
//                return false; // Prevent the invalid input
//            }
//
//            return $input;
//        });
//
//        if (!$email) {
//            return Command::FAILURE; // Exit if the email validation failed
//        }
//
//        $password = $io->ask('Password', function (?string $input) {
//            $errors = $this->validator->validate($input, [
//                new Assert\NotBlank(['message' => 'Password is required']),
//                new Assert\Length(['min' => 6, 'minMessage' => 'Password must be at least {{ limit }} characters long']),
//            ]);
//
//            if (count($errors) > 0) {
//                $io->error((string) $errors);
//                return false; // Prevent the invalid input
//            }
//
//            return $input;
//        });
//
//        if (!$password) {
//            return Command::FAILURE; // Exit if the password validation failed
//        }
//
//        $user = $this->userFactory->create($email, $password);
//        $this->userRepository->add($user);
//
//        $io->success('User created successfully.');
//
//        return Command::SUCCESS;
    }

}