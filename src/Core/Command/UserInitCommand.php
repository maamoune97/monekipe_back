<?php

namespace App\Core\Command;

use App\Core\Entity\User\User;
use App\Core\Entity\User\UserTypeReference;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user-init',
    description: 'Add a short description for your command',
)]
class UserInitCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
        parent::__construct();
    }

    const array USER_TYPES = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'organizer' => 'Organisateur',
        'customer' => 'Client',
    ];

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = microtime(true);
        $io = new SymfonyStyle($input, $output);

        $io->title('Running ...');

        $this->insertUserTypes();

        $this->entityManager->flush();

        $this->initSuperAdmins();

        $this->entityManager->flush();

        $io->writeln('Total execution time: ' . (microtime(true) - $start));
        $io->success('Done.');

        return Command::SUCCESS;
    }

    private function insertUserTypes(): void
    {
        foreach (self::USER_TYPES as $code => $name) {
            $userType = new UserTypeReference();
            $userType->setValue($code)
                    ->setLabel($name);

            $this->entityManager->persist($userType);
        }
    }

    private function initSuperAdmins(): void
    {
        $superAdmins = [
            [
                'email' => 'maamoune@sbq.com',
                'password' => 'maa123sbq',
                'firstname' => 'Maamoune',
                'lastname' => 'Hassane',
            ]
        ];

        foreach ($superAdmins as $superAdmin) {
            $user = new User();
            $user->setEmail($superAdmin['email'])
                ->setPassword($this->passwordHasher->hashPassword($user, $superAdmin['password']))
                ->setFirstname($superAdmin['firstname'])
                ->setLastname($superAdmin['lastname'])
                ->setUserTypeReference($this->entityManager->getRepository(UserTypeReference::class)->findOneBy(['value' => 'super_admin']));

            $this->entityManager->persist($user);
        }
    }
}
