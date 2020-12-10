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
    public function get   (){ return $this->_get   ; }
    public function post  (){ return $this->_post  ; }
    public function put   (){ return $this->_put   ; }
    public function delete(){ return $this->_delete; }
}

class RestServer {
    private $_tree;
    public function __construct(array $tree){ $this->_tree = $tree; }
    public function serve(string $uri) : void {
        if(substr($uri, -1) != '/') $uri = $uri.'/';

        $tree = $this->_tree;
        $args = [];
        while($uri != ''){
            $matched = false;
            foreach($tree as $regex => $subtree){
                if($regex == '') continue;
                if(preg_match("/({$regex})\/(.*)/", $uri, $matches)){
                    $matched = true;
                    $args[] = $matches[1];
                    $uri = $matches[2];
                    $tree = $subtree;
                    break;
                }
            }
            if(!$matched){
                http_response_code(400);
                die();
            }
        }

        $resourceHandlers = (gettype($tree) == 'array' ? $tree[''] : $tree);

        switch($_SERVER['REQUEST_METHOD']){
            case 'GET'   : $handler = $resourceHandlers->get   (); break;
            case 'POST'  : $handler = $resourceHandlers->post  (); break;
            case 'PUT'   : $handler = $resourceHandlers->put   (); break;
            case 'DELETE': $handler = $resourceHandlers->delete(); break;
        }

        if($handler == null){
            http_response_code(405);
            die();
        }

        $handler($args);
    }
}
