<?php
namespace Sanakey\Mnotify;

class Message{
  
    private $sender_id;
    private $title;
    private $message;

    /**
     * Set title for the message
     * @param String $title
     * @return Message
     */
    public function title(String $title):Message
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set sender Id for the message
     * @param String $id
     * @return Message
     */
    public function sender_id(String $id):Message
    {
        if(strlen($id) > 11){
            throw new \Exception("Invalid Sender ID. Sender ID must not be more than 11 Characters. Characters include white space", 1);
        }
        $parttern = "/[^a-zA-Z0-9. ]+/";
        if(preg_match_all($parttern,$id) > 0){
            throw new \Exception("Invalid Sender ID. Special characters are not allowed.", 1);
        }

        $this->sender_id = $id;
        return $this;
    }

    /**
     * Set the body for the message
     * @param String $message
     * @return Message
     */
    public function message(String $message):Message
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Returns message properties in an array
     * @return array
     */
    public function toArray():array
    {
        return ["sender_id"=>$this->sender_id,"title"=>$this->title,"message"=>$this->message];
    }
    
}