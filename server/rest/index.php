<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR . '/connection.php';
define('API_DIR', SERVER_DIR . '/rest');
include_once API_DIR . '/rest-lib/rest-lib.php';
include_once API_DIR . '/print.php';
include_once API_DIR . '/user/user.php';
include_once API_DIR . '/pet/pet.php';
include_once API_DIR . '/comment/comment.php';

$tree = [
    'user' => [null             => new ResourceHandlers(null                , null, null                 , null                    ),
        '[a-zA-Z0-9]+' => [null => new ResourceHandlers(null                , null, null                 , null                    ),
            'photo'             => new ResourceHandlers($user_id_photo_GET  , null, $user_id_photo_PUT   , $user_id_photo_DELETE   )
        ]
    ],
    'pet' => [null              => new ResourceHandlers(null                , null, null                 , null                    ),
        '[0-9]+' => [null       => new ResourceHandlers(null                , null, null                 , null                    ),
            'comments'          => new ResourceHandlers($pet_id_comments_GET, null, null                 , null                    )
        ]
    ],
    'comment' => [null          => new ResourceHandlers(null                , null, $comment_PUT         , null                    ),
        'photo'                 => new ResourceHandlers(null                , null, $comment_photo_PUT   , null                    ),
        '[0-9]+' => [null       => new ResourceHandlers($comment_id_GET     , null, $comment_id_PUT      , null                    ),
            'photo'             => new ResourceHandlers(null                , null, $comment_id_photo_PUT, $comment_id_photo_DELETE)
        ]
    ]
];

$server = new RestServer($tree);

$url = $_GET['url'];
$server->serve($url);
