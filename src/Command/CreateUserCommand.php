<?php

namespace App\Command;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsCommand(
    name: 'create:user',
    description: 'Creates a new user in the system',
)]
class CreateUserCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    // Inject EntityManagerInterface and PasswordEncoder
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $$passwordHasher;
    }

    protected function configure()
    {
        $this->setDescription('Add a new user to the system')
             ->addArgument('email', InputArgument::REQUIRED, 'User email')
        ->addArgument('username', InputArgument::REQUIRED, 'User name')
            ->addArgument('password', InputArgument::REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $email = $input->getArgument('email');
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        // Create a new user
        $user = new Users();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setRoles(['ROLE_USER']);

        // Encrypt the password
        $encodedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($encodedPassword);

        // Persist the user to the database
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('User added successfully.');

        return Command::SUCCESS;
    }
}
