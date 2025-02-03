// src/Command/ListUsersCommand.php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUsersCommand extends Command
{
    private $entityManager;

    // Inject EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected static $defaultName = 'app:list-users';

    protected function configure()
    {
        $this->setDescription('List all users in the system');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get all users
        $users = $this->entityManager->getRepository(User::class)->findAll();

        if (empty($users)) {
            $output->writeln('No users found.');
            return Command::SUCCESS;
        }

        foreach ($users as $user) {
            $output->writeln('ID: ' . $user->getId() . ' | Username: ' . $user->getUsername() . ' | Email: ' . $user->getEmail());
        }

        return Command::SUCCESS;
    }
}
