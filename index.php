<?php

use phpDocumentor\Reflection\Types\Resource_;

session_start();

require_once __DIR__ . '/server.php';

header('Access-Control-Allow-Origin: https://fonts.gstatic.com');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, HEAD');



// REST
require_once API_DIR . '/rest-lib/rest-lib.php';
require_once API_DIR . '/root/root.php';
require_once API_DIR . '/login/login.php';
require_once API_DIR . '/passwordReset/passwordReset.php';
require_once API_DIR . '/user/user.php';
require_once API_DIR . '/shelter/shelter.php';
require_once API_DIR . '/pet/pet.php';
require_once API_DIR . '/comment/comment.php';
require_once API_DIR . '/adoptionRequest/adoptionRequest.php';
require_once API_DIR . '/notification/notification.php';

$rest_GET = function(array $args) : void {
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/rest.php';
};

$tree = [
    null                        => new ResourceHandlers($root_GET                       , null, null                            , null                          ),
    'rest'                      => new ResourceHandlers($rest_GET                       , null, null                            , null                          ),
    'login'                     => new ResourceHandlers($login_GET                      , null, null                            , null                          ),
    'passwordReset'             => new ResourceHandlers($passwordReset_GET              , null, $passwordReset_PUT              , null                          ),
    'user' => [null             => new ResourceHandlers(null                            , null, $user_PUT                       , null                          ),
        'new'                   => new ResourceHandlers($user_new_GET                   , null, null                            , null                          ),
        '[a-zA-Z0-9]+' => [null => new ResourceHandlers($user_id_GET                    , null, $user_id_PUT                    , $user_id_DELETE               ),
            'photo'             => new ResourceHandlers($user_id_photo_GET              , null, $user_id_photo_PUT              , $user_id_photo_DELETE         ),
            'password' => [null => new ResourceHandlers(null                            , null, $user_id_password_PUT           , null                          ),
                'change'        => new ResourceHandlers($user_id_password_change_GET    , null, null                            , null                          )
            ],
            'edit'              => new ResourceHandlers($user_id_edit_GET               , null, null                            , null                          ),
            'favorite' => [null => new ResourceHandlers(null                            , null, $user_id_favorite_PUT           , null                          ),
                '[0-9]+'        => new ResourceHandlers(null                            , null, null                            , $user_id_favorite_id_DELETE   ),
            ],
            'adopted'           => new ResourceHandlers($user_id_adopted_GET            , null, null                            , null                          ),
            'myproposals'       => new ResourceHandlers($user_id_myproposals_GET        , null, null                            , null                          ),
            'notifications'     => new ResourceHandlers($user_id_notifications_GET      , null, null                            , $notification_id_DELETE       ),
            'proposalstome'     => new ResourceHandlers($user_id_proposalstome_GET      , null, null                            , null                          ),
            'invitations'       => new ResourceHandlers($user_id_invitations_GET        , null, null                            , null                          ),
            'previouslyOwned'   => new ResourceHandlers($user_id_previouslyOwned_GET    , null, null                            , null                          )
        ]
    ],
    'shelter' => [null          => new ResourceHandlers($shelter_GET                    , null, null                            , null                          ),
        '[a-zA-Z0-9]+' => [
            'potential'         => new ResourceHandlers($shelter_potential_GET          , null, null                            , null                          ),
            'propose' => [
                '[a-zA-Z0-9]+'  => new ResourceHandlers($shelter_id_propose_userId_GET  , null, null                            , null                          )
            ],
            'invitations'       => new ResourceHandlers($shelter_id_invitations_GET     , null, null                            , null                          )
        ],
    ],
    'pet' => [null              => new ResourceHandlers($pet_GET                        , null, null                            , null                          ),
        'new'                   => new ResourceHandlers($pet_new_GET                    , null, null                            , null                          ),
        'adopted'               => new ResourceHandlers($pet_adopted_GET                , null, null                            , null                          ),
        '[0-9]+' => [null       => new ResourceHandlers($pet_id_GET                     , null, null                            , $pet_id_DELETE                ),
            'comments'          => new ResourceHandlers($pet_id_comments_GET            , null, null                            , null                          ),
            'edit'              => new ResourceHandlers($pet_id_edit_GET                , null, null                            , null                          ),
            'photo'             => new ResourceHandlers($pet_id_photo_GET               , null, null                            , null                          ),
            'adopt'             => new ResourceHandlers($pet_id_adopt_GET               , null, null                            , null                          ),
            'proposals'         => new ResourceHandlers($pet_id_proposals_GET           , null, null                            , null                          )
        ]
    ],
    'comment' => [null          => new ResourceHandlers(null                            , null, $comment_PUT                    , null                          ),
        'photo'                 => new ResourceHandlers(null                            , null, $comment_photo_PUT              , null                          ),
        '[0-9]+' => [null       => new ResourceHandlers($comment_id_GET                 , null, $comment_id_PUT                 , $comment_id_DELETE            ),
            'photo'             => new ResourceHandlers($comment_id_photo_GET           , null, $comment_id_photo_PUT           , $comment_id_photo_DELETE      )
        ]
    ],
    'adoptionRequest' => [
        '[0-9]+' => [
            'message'           => new ResourceHandlers($adoptionRequest_id_message_GET , null, $adoptionRequest_id_message_PUT , null                          )
        ]
    ],
    'notification'              => new ResourceHandlers(null                            , null, $notification_id_PUT            , null                          )
];

$server = new RestServer($tree);

$url = $_GET['url'];
$server->serve($url);
