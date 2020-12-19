<?php

class ResourceHandlers {
    private $_get;
    private $_post;
    private $_put;
    private $_delete;
    public function __construct(
        ?callable $get,
        ?callable $post,
        ?callable $put,
        ?callable $delete
    ){
        $this->_get    = $get   ;
        $this->_post   = $post  ;
        $this->_put    = $put   ;
        $this->_delete = $delete;
    }
    public function get   () : ?callable { return $this->_get   ; }
    public function post  () : ?callable { return $this->_post  ; }
    public function put   () : ?callable { return $this->_put   ; }
    public function delete() : ?callable { return $this->_delete; }
}

class RestServer {
    private $_tree;
    public function __construct(array $tree){ $this->_tree = $tree; }
    public function serve(string $uri) : void {

        if(substr($uri, -1) != '/') $uri = $uri.'/';
        if($uri === '/') $uri = '';

        $tree = $this->_tree;
        $args = [];
        while($uri != ''){
            $matched = false;
            foreach($tree as $regex => $subtree){
                if($regex == '') continue;
                if(preg_match("/^({$regex})\/(.*)$/", $uri, $matches)){
                    $matched = true;
                    $args[] = $matches[1];
                    $uri = $matches[2];
                    $tree = $subtree;
                    break;
                }
            }
            if(!$matched){
                my_response_code(400);
                die();
            }
        }

        $resourceHandlers = (gettype($tree) == 'array' ? $tree[''] : $tree);

        switch($_SERVER['REQUEST_METHOD']){
            case 'GET'   :
            case 'HEAD'  : $handler = $resourceHandlers->get   (); break;
            case 'POST'  : $handler = $resourceHandlers->post  (); break;
            case 'PUT'   : $handler = $resourceHandlers->put   (); break;
            case 'DELETE': $handler = $resourceHandlers->delete(); break;
        }

        if($handler == null){
            my_response_code(405);
            die();
        }

        $handler($args);
    }
}
