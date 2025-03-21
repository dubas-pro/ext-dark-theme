<?php

include dirname(__DIR__, 2) . '/site/bootstrap.php';

/**
 * EspoCRM might set up the admin user with a different ID in different environments.
 * We need to find out the ID of the admin user to use it in fixtures.
 */
$app = new \Espo\Core\Application();
$app->setupSystemUser();

$adminUserId = $app
    ->getContainer()
    ->getByClass(\Espo\ORM\EntityManager::class)
    ->getRDBRepositoryByClass(\Espo\Entities\User::class)
    ->where([
        'userName' => 'admin',
    ])
    ->select(['id'])
    ->findOne()
    ?->getId(); // null-safe operator, returns null if the user is not found

return [
    'entities' => [
        'User' => [
            [
                'id' => $adminUserId,
                'userName' => 'admin',
                'password' => '1',
                'type' => 'admin',
                'firstName' => 'Espo',
                'lastName' => 'Admin',
                'emailAddress' => 'admin@example.com',
            ],
            [
                'id' => 'user1',
                'userName' => 'user1',
                'password' => '1',
                'type' => 'regular',
                'firstName' => 'User',
                'lastName' => 'Regular 1',
                'emailAddress' => 'user1@example.com',
            ],
            [
                'id' => 'user2',
                'userName' => 'user2',
                'password' => '1',
                'type' => 'regular',
                'firstName' => 'User',
                'lastName' => 'Regular 2',
                'emailAddress' => 'user2@example.com',
            ],
        ],
        'Team' => [
            [
                'id' => 'team1',
                'name' => 'Default Team',
                'positionList' => [],
                'usersIds' => [
                    'user1',
                    'user2',
                ],
            ]
        ],
        'Role' => [
            [
                'id' => 'role1',
                'name' => 'Role Regular',
                'usersIds' => [
                    'user1',
                ],
                'data' => [
                    'Task' => [
                        'create' => 'yes',
                        'read' => 'all',
                        'edit' => 'yes',
                        'delete' => 'no',
                        'stream' => 'no',
                    ]
                ],
            ],
        ],
        'Account' => [
            [
                'id' => 'account1',
                'name' => 'Wayne Enterprises',
                'description' => '',
                'emailAddress' => 'account1@site.local',
                'assignedUserId' => 'user1',
                'teamsIds' => ['team1'],
                'createdById' => 'system',
            ],
            [
                'id' => 'account2',
                'name' => 'Ace Chemicals',
                'description' => '',
                'emailAddress' => 'account2@site.local',
                'billingAddressStreet' => 'Clay Street',
                'billingAddressCity' => 'Gotham City',
                'billingAddressState' => 'New Jersey',
                'billingAddressCountry' => 'United States',
                'billingAddressPostalCode' => '07001-0001',
                'assignedUserId' => 'user1',
                'teamsIds' => ['team1'],
                'createdById' => 'system',
            ],
            [
                'id' => 'account3',
                'name' => 'Iceberg Lounge',
                'description' => '',
                'emailAddress' => 'account3@site.local',
                'teamsIds' => ['team1'],
                'assignedUserId' => '1',
            ],
        ],
        'Contact' => [
            [
                'id' => 'contact1',
                'emailAddress' => 'contact3@site.local',
                'firstName' => 'Bruce',
                'lastName' => 'Wayne',
                'title' => 'Owner',
                'accountsIds' => ['account1'],
                'accountId' => 'account1',
            ],
            [
                'id' => 'contact2',
                'emailAddress' => 'contact4@site.local',
                'firstName' => 'Lucius',
                'lastName' => 'Fox',
                'title' => 'CEO',
                'accountsIds' => ['account1'],
                'accountId' => 'account1',
            ],
            [
                'id' => 'contact3',
                'emailAddress' => 'contact5@site.local',
                'firstName' => 'Oswald',
                'lastName' => 'Cobblepot',
                'title' => 'Owner',
                'accountsIds' => ['account3'],
                'accountId' => 'account3',
            ],
            [
                'id' => 'contact4',
                'emailAddress' => 'contact6@site.local',
                'firstName' => 'Mark',
                'lastName' => 'Cheung',
                'title' => 'Systems Operator',
                'accountsIds' => ['account2'],
                'accountId' => 'account2',
            ],
        ],
        'Opportunity' => [
            [
                'id' => 'opportunity1',
                'name' => 'Opportunity 1',
                'accountId' => 'account2',
                'contactsIds' => ['contact6'],
                'amount' => 30000,
                'closeDate' => '2031-01-01',
                'assignedUserId' => 'user1',
                'teamsIds' => ['team1'],
                'createdById' => 'system',
            ],
        ],
        'Attachment' => [
            [
                'id' => 'attachment1',
                'name' => 'a1.jpg',
                'type' => 'image/jpeg',
                'role' => 'Attachment',
                'contents' => file_get_contents(__DIR__ . '/attachments/stephanie-cook-0yHhzZi2wPI-unsplash.jpg'),
            ],
            [
                'id' => 'attachment2',
                'name' => 'a2.jpg',
                'type' => 'image/jpeg',
                'role' => 'Attachment',
                'contents' => file_get_contents(__DIR__ . '/attachments/val-tievsky-J4itE356ie0-unsplash.jpg'),
            ],
            [
                'id' => 'attachment3',
                'name' => 'a3.pdf',
                'type' => 'application/pdf',
                'role' => 'Attachment',
                'contents' => file_get_contents(__DIR__ . '/attachments/convention_eng.pdf'),
            ],
        ],
        'Task' => [
            [
                'id' => 'task1',
                'name' => 'Task 1',
                'attachmentsIds' => ['attachment1', 'attachment2'],
                'assignedUserId' => 'user1',
            ],
            [
                'id' => 'task2',
                'name' => 'Task 2',
                'attachmentsIds' => ['attachment3'],
                'assignedUserId' => 'user1',
            ],
        ],
    ],
];
