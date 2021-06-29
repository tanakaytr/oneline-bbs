<?php
class Logic{
    private $data;
    private $errorData;
    private $request;
    private $view;
    private $db;
    
    public function execute($action){
        switch ($action){
            case "form" :
                $this->getPost();
                break;
            case "register" :
                $this->getPostParameters();
                if(! Validation::isRequired($this->data->getName())){
                    $this->errorData->addError("name", "名前は必須です");
                }
                if(! Validation::isRequired($this->data->getComment())){
                    $this->errorData->addError("comment", "コメントは必須です");
                }
                if($this->errorData->hasError()){
                    $this->getPost();
                    $this->request->setAction("form");
                } else {
                    $this->registerPost();
                }
                break;
            default :
                break;
        }
        $this->view->setBaseTemplate(VIEW_DIR . "base-template.php");
        $this->view->render($this->data, $this->errorData);
    }
    private function getPostParameters(){
        $vars = array_keys(get_object_vars($this->data));
        foreach($vars as $var){
            $this->data->$var = $this->request->getParameter($var);
        }
    }
    private function getPost(){
        $sql = "SELECT
                  id, name, comment
                FROM
                  posts
                ORDER BY created_at DESC";
        $this->data->setPosts($this->db->query($sql));
    }
    private function registerPost(){
        $sql = "INSERT INTO
                  posts
                  (name, comment, created_at)
                VALUES
                  (:name, :comment, NOW())";
        $params["name"] = $this->data->getName();
        $params["comment"] = $this->data->getComment();
        $this->db->execute($sql, $params);
    }
    public function setData($data){
        $this->data = $data;
    }
    public function setRequest($request){
        $this->request = $request;
    }
    public function setView($view){
        $this->view = $view;
    }
    public function setDB($db){
        $this->db = $db;
    }
    public function setErrorData($errorData){
        $this->errorData = $errorData;
    }
    
}