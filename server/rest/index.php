<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, HEAD');

require_once __DIR__ . '/api_main.php';
require_once API_DIR . '/rest-lib/rest-lib.php';
require_once API_DIR . '/user/user.php';
require_once API_DIR . '/pet/pet.php';
require_once API_DIR . '/comment/comment.php';
require_once API_DIR . '/adoptionMessages/adoptionMessages.php';

session_start();

$tree = [
    'user' => [null             => new ResourceHandlers(null                 , null, $user_PUT            , null                    ),
        '[a-zA-Z0-9]+' => [null => new ResourceHandlers($user_id_GET         , null, $user_id_PUT         , $user_id_DELETE         ),
            'photo'             => new ResourceHandlers($user_id_photo_GET   , null, $user_id_photo_PUT   , $user_id_photo_DELETE   )
        ]
    ],
    'pet' => [null              => new ResourceHandlers(null                 , null, null                 , null                    ),
        '[0-9]+' => [null       => new ResourceHandlers($pet_id_GET          , null, null                 , $pet_id_DELETE          ),
            'comments'          => new ResourceHandlers($pet_id_comments_GET , null, null                 , null                    )
        ]
    ],
    'comment' => [null          => new ResourceHandlers(null                 , null, $comment_PUT         , null                    ),
        'photo'                 => new ResourceHandlers(null                 , null, $comment_photo_PUT   , null                    ),
        '[0-9]+' => [null       => new ResourceHandlers($comment_id_GET      , null, $comment_id_PUT      , $comment_id_DELETE      ),
            'photo'             => new ResourceHandlers($comment_id_photo_GET, null, $comment_id_photo_PUT, $comment_id_photo_DELETE)
        ]
    ],
    'adoptionMessage' => [null  => new ResourceHandlers(null                 , null, null                 , null                    ),
        '[0-9]+'                => new ResourceHandlers($adoptionMsg_GET     , null, null                 , null                    )
    ]
];

$server = new RestServer($tree);

$url = $_GET['url'];
$server->serve($url);
