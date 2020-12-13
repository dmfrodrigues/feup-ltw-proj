<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, HEAD');

require_once __DIR__ . '/api_main.php';
require_once API_DIR . '/rest-lib/rest-lib.php';
require_once API_DIR . '/root/root.php';
require_once API_DIR . '/login/login.php';
require_once API_DIR . '/user/user.php';
require_once API_DIR . '/shelter/shelter.php';
require_once API_DIR . '/pet/pet.php';
require_once API_DIR . '/comment/comment.php';
require_once API_DIR . '/adoptionRequest/adoptionRequest.php';
require_once API_DIR . '/adoptionMessages/adoptionMessages.php';

session_start();

$tree = [
    null                        => new ResourceHandlers($root_GET            , null, null                 , null                    ),
    'login'                     => new ResourceHandlers($login_GET           , null, null                 , null                    ),
    'user' => [null             => new ResourceHandlers(null                 , null, $user_PUT            , null                    ),
        'new'                   => new ResourceHandlers($user_new_GET        , null, null                 , null                    ),
        '[a-zA-Z0-9]+' => [null => new ResourceHandlers($user_id_GET         , null, $user_id_PUT         , $user_id_DELETE         ),
            'photo'             => new ResourceHandlers($user_id_photo_GET   , null, $user_id_photo_PUT   , $user_id_photo_DELETE   ),
            'password' => [
                'change'        => new ResourceHandlers($user_id_password_change_GET, null, null          , null                    )
            ],
            'edit'              => new ResourceHandlers($user_id_edit_GET    , null, null                 , null                    ),
            'adopted'           => new ResourceHandlers($user_id_adopted_GET , null, null                 , null                    ),
            'myproposals'       => new ResourceHandlers($user_id_myproposals_GET, null, null              , null                    ),
            'notifications'     => new ResourceHandlers($user_id_notifications_GET, null, null            , null                    ),
            'proposalstome'     => new ResourceHandlers($user_id_proposalstome_GET, null, null            , null                    ),
            'invitations'       => new ResourceHandlers($user_id_invitations_GET, null, null              , null                    ),
            'previouslyOwned'   => new ResourceHandlers($user_id_previouslyOwned_GET, null, null          , null                    )
        ]
    ],
    'shelter' => [null          => new ResourceHandlers($shelter_GET         , null, null                , null                    ),
        'propose'               => new ResourceHandlers($shelter_propose_GET , null, null                , null                    ),
        'potential'             => new ResourceHandlers($shelter_potential_GET, null, null               , null                    )
    ],
    'pet' => [null              => new ResourceHandlers($pet_GET             , null, null                 , null                    ),
        'new'                   => new ResourceHandlers($pet_new_GET         , null, null                 , null                    ),
        'adopted'               => new ResourceHandlers($pet_adopted_GET     , null, null                 , null                    ),
        '[0-9]+' => [null       => new ResourceHandlers($pet_id_GET          , null, null                 , $pet_id_DELETE          ),
            'comments'          => new ResourceHandlers($pet_id_comments_GET , null, null                 , null                    ),
            'edit'              => new ResourceHandlers($pet_id_edit_GET     , null, null                 , null                    ),
            'photo'             => new ResourceHandlers($pet_id_photo_GET    , null, null                 , null                    ),
            'adopt'             => new ResourceHandlers($pet_id_adopt_GET    , null, null                 , null                    )
        ]
    ],
    'comment' => [null          => new ResourceHandlers(null                 , null, $comment_PUT         , null                    ),
        'photo'                 => new ResourceHandlers(null                 , null, $comment_photo_PUT   , null                    ),
        '[0-9]+' => [null       => new ResourceHandlers($comment_id_GET      , null, $comment_id_PUT      , $comment_id_DELETE      ),
            'photo'             => new ResourceHandlers($comment_id_photo_GET, null, $comment_id_photo_PUT, $comment_id_photo_DELETE)
        ]
    ],
    'adoptionRequest' => [
        '[0-9]+' => [
            'messages'          => new ResourceHandlers($adoptionRequest_id_messages_GET, null, null      , null                    )
        ]
    ],
    'adoptionMessage' => [null  => new ResourceHandlers(null                 , null, null                 , null                    ),
        '[0-9]+'                => new ResourceHandlers($adoptionMsg_GET     , null, null                 , null                    )
    ]
];

$server = new RestServer($tree);

$url = $_GET['url'];
$server->serve($url);
